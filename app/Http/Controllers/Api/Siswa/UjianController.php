<?php

namespace App\Http\Controllers\Api\Siswa;

use App\Http\Controllers\Controller;
use App\Models\JawabanSiswa;
use App\Models\SesiUjian;
use App\Models\SoalUjian;
use App\Models\Ujian;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UjianController extends Controller
{
    private function getSiswa()
    {
        $siswa = Auth::user()->siswa;
        abort_if(! $siswa, 403, 'Akun Anda tidak terhubung dengan data siswa.');
        return $siswa;
    }

    /**
     * GET /api/siswa/ujian
     * Daftar ujian aktif untuk kelas siswa.
     */
    public function index(): JsonResponse
    {
        $siswa = $this->getSiswa();

        $selesaiMap = SesiUjian::where('siswa_id', $siswa->id)
            ->whereIn('status', ['selesai', 'habis_waktu'])
            ->select('ujian_id', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('ujian_id')
            ->pluck('jumlah', 'ujian_id')
            ->toArray();

        $nilaiTertinggiMap = SesiUjian::where('siswa_id', $siswa->id)
            ->whereIn('status', ['selesai', 'habis_waktu'])
            ->select('ujian_id', DB::raw('MAX(nilai_akhir) as nilai_tertinggi'))
            ->groupBy('ujian_id')
            ->pluck('nilai_tertinggi', 'ujian_id')
            ->toArray();

        $ujian = Ujian::with(['mataPelajaran', 'guru'])
            ->where('kelas_id', $siswa->kelas_id)
            ->where('is_active', true)
            ->orderBy('tanggal')->orderBy('jam_mulai')
            ->paginate(15);

        $ujian->getCollection()->transform(function ($u) use ($siswa, $selesaiMap, $nilaiTertinggiMap) {
            $percobaan          = $selesaiMap[$u->id] ?? 0;
            $u->boleh_ikut      = $percobaan < ($u->maks_percobaan ?? 1);
            $u->percobaan_ke    = $percobaan;
            $u->nilai_tertinggi = $nilaiTertinggiMap[$u->id] ?? null;
            $u->sesi_aktif      = SesiUjian::where('siswa_id', $siswa->id)
                ->where('ujian_id', $u->id)
                ->where('status', 'berlangsung')
                ->latest()->first();
            return $u;
        });

        return response()->json([
            'success' => true,
            'data'    => ['ujian' => $ujian],
        ]);
    }

    /**
     * GET /api/siswa/ujian/riwayat
     * Riwayat sesi ujian yang sudah selesai.
     */
    public function riwayat(): JsonResponse
    {
        $siswa = $this->getSiswa();

        $sesiList = SesiUjian::with(['ujian.mataPelajaran', 'ujian.guru'])
            ->where('siswa_id', $siswa->id)
            ->whereIn('status', ['selesai', 'habis_waktu'])
            ->orderByDesc('selesai_pada')
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data'    => ['sesi_list' => $sesiList],
        ]);
    }

    /**
     * GET /api/siswa/ujian/{ujian}/info
     * Info ujian sebelum memulai (konfirmasi).
     */
    public function info(Ujian $ujian): JsonResponse
    {
        $siswa = $this->getSiswa();

        abort_if($ujian->kelas_id !== $siswa->kelas_id, 403, 'Ujian ini bukan untuk kelas Anda.');
        abort_if(! $ujian->is_active, 403, 'Ujian ini tidak aktif.');
        abort_if($ujian->sudahBerakhir(), 422, 'Waktu ujian sudah habis.');
        abort_if(! $ujian->bolehIkut($siswa->id), 422, 'Anda sudah mencapai batas percobaan untuk ujian ini.');

        $ujian->load(['mataPelajaran', 'guru', 'kelas']);
        $totalSoal = $ujian->soal()->count();

        $sesiAktif = SesiUjian::where('siswa_id', $siswa->id)
            ->where('ujian_id', $ujian->id)
            ->where('status', 'berlangsung')
            ->latest()->first();

        if ($sesiAktif && $sesiAktif->isHabisWaktu()) {
            $sesiAktif->selesaikan(habisWaktu: true);
            $sesiAktif = null;
        }

        $percobaanKe = SesiUjian::where('siswa_id', $siswa->id)
            ->where('ujian_id', $ujian->id)
            ->whereIn('status', ['selesai', 'habis_waktu'])->count();

        $nilaiTertinggi = SesiUjian::where('siswa_id', $siswa->id)
            ->where('ujian_id', $ujian->id)
            ->whereIn('status', ['selesai', 'habis_waktu'])
            ->max('nilai_akhir');

        return response()->json([
            'success' => true,
            'data'    => [
                'ujian'          => $ujian,
                'total_soal'     => $totalSoal,
                'sesi_aktif'     => $sesiAktif,
                'sisa_detik'     => $sesiAktif?->sisa_detik,
                'percobaan_ke'   => $percobaanKe,
                'nilai_tertinggi'=> $nilaiTertinggi,
            ],
        ]);
    }

    /**
     * POST /api/siswa/ujian/{ujian}/start
     * Buat sesi ujian baru atau lanjutkan sesi aktif.
     */
    public function start(Request $request, Ujian $ujian): JsonResponse
    {
        $siswa = $this->getSiswa();

        abort_if($ujian->kelas_id !== $siswa->kelas_id, 403, 'Ujian ini bukan untuk kelas Anda.');
        abort_if(! $ujian->is_active, 403, 'Ujian ini tidak aktif.');
        abort_if($ujian->sudahBerakhir(), 422, 'Waktu ujian sudah habis.');
        abort_if(! $ujian->bolehIkut($siswa->id), 422, 'Anda sudah mencapai batas percobaan untuk ujian ini.');

        $sesiAktif = SesiUjian::where('siswa_id', $siswa->id)
            ->where('ujian_id', $ujian->id)
            ->where('status', 'berlangsung')
            ->latest()->first();

        if ($sesiAktif) {
            if ($sesiAktif->isHabisWaktu()) {
                $sesiAktif->selesaikan(habisWaktu: true);
            } else {
                return response()->json([
                    'success' => true,
                    'message' => 'Melanjutkan sesi ujian yang sedang berlangsung.',
                    'data'    => ['sesi' => $sesiAktif, 'lanjut' => true],
                ]);
            }
        }

        DB::transaction(function () use ($ujian, $siswa) {
            $sesi = SesiUjian::create([
                'siswa_id' => $siswa->id,
                'ujian_id' => $ujian->id,
                'status'   => 'berlangsung',
            ]);
            $sesi->mulai();
        });

        $sesiAktif = SesiUjian::where('siswa_id', $siswa->id)
            ->where('ujian_id', $ujian->id)
            ->where('status', 'berlangsung')
            ->latest()->first();

        $percobaanKe = SesiUjian::where('siswa_id', $siswa->id)
            ->where('ujian_id', $ujian->id)
            ->whereIn('status', ['selesai', 'habis_waktu'])->count() + 1;

        return response()->json([
            'success' => true,
            'message' => "Percobaan ke-{$percobaanKe} dimulai. Selamat mengerjakan!",
            'data'    => ['sesi' => $sesiAktif, 'percobaan_ke' => $percobaanKe],
        ], 201);
    }

    /**
     * GET /api/siswa/ujian/{ujian}/kerjakan
     * Soal ujian beserta jawaban yang tersimpan.
     */
    public function kerjakan(Ujian $ujian): JsonResponse
    {
        $siswa = $this->getSiswa();

        $sesi = SesiUjian::where('siswa_id', $siswa->id)
            ->where('ujian_id', $ujian->id)
            ->where('status', 'berlangsung')
            ->latest()->first();

        if (! $sesi) {
            $sesiSelesai = SesiUjian::where('siswa_id', $siswa->id)
                ->where('ujian_id', $ujian->id)
                ->whereIn('status', ['selesai', 'habis_waktu'])
                ->latest('selesai_pada')->first();

            if ($sesiSelesai) {
                return response()->json([
                    'success'  => false,
                    'message'  => 'Ujian sudah selesai.',
                    'redirect' => 'hasil',
                ], 422);
            }

            return response()->json([
                'success'  => false,
                'message'  => 'Silakan mulai ujian terlebih dahulu.',
                'redirect' => 'info',
            ], 422);
        }

        if ($sesi->isHabisWaktu()) {
            $sesi->selesaikan(habisWaktu: true);
            return response()->json([
                'success'     => false,
                'habis_waktu' => true,
                'message'     => 'Waktu ujian telah habis. Ujian diselesaikan otomatis.',
                'redirect'    => 'hasil',
            ], 422);
        }

        $ujian->load(['mataPelajaran', 'guru']);

        $soalQuery = $ujian->soal()->with('pilihan');
        $soalList  = $ujian->acak_soal
            ? $soalQuery->get()->shuffle($sesi->id)
            : $soalQuery->orderBy('nomor_soal')->orderBy('id')->get();

        $jawabanTersimpan = JawabanSiswa::where('sesi_ujian_id', $sesi->id)
            ->get(['soal_ujian_id', 'pilihan_jawaban_id', 'jawaban_essay'])
            ->keyBy('soal_ujian_id');

        return response()->json([
            'success' => true,
            'data'    => [
                'ujian'             => $ujian,
                'sesi'              => $sesi,
                'soal_list'         => $soalList,
                'jawaban_tersimpan' => $jawabanTersimpan,
            ],
        ]);
    }

    /**
     * POST /api/siswa/ujian/{ujian}/soal/{soal}/jawab
     * Simpan/update jawaban satu soal (AJAX).
     * Body: { "pilihan_jawaban_id": int|null, "jawaban_essay": string|null }
     */
    public function jawab(Request $request, Ujian $ujian, SoalUjian $soal): JsonResponse
    {
        $siswa = $this->getSiswa();

        if ($soal->ujian_id !== $ujian->id) {
            return response()->json(['success' => false, 'message' => 'Soal tidak valid.'], 422);
        }

        $sesi = SesiUjian::where('siswa_id', $siswa->id)
            ->where('ujian_id', $ujian->id)
            ->where('status', 'berlangsung')
            ->latest()->first();

        if (! $sesi) {
            return response()->json(['success' => false, 'message' => 'Sesi ujian tidak ditemukan.'], 404);
        }

        if ($sesi->isHabisWaktu()) {
            $sesi->selesaikan(habisWaktu: true);
            return response()->json([
                'success'     => false,
                'habis_waktu' => true,
                'message'     => 'Waktu ujian habis.',
            ], 422);
        }

        $request->validate([
            'pilihan_jawaban_id' => ['nullable', 'integer', 'exists:pilihan_jawaban,id'],
            'jawaban_essay'      => ['nullable', 'string', 'max:5000'],
        ]);

        try {
            $jawaban = JawabanSiswa::updateOrCreate(
                ['sesi_ujian_id' => $sesi->id, 'soal_ujian_id' => $soal->id],
                [
                    'pilihan_jawaban_id' => $request->pilihan_jawaban_id ?? null,
                    'jawaban_essay'      => $request->jawaban_essay ?? null,
                ]
            );

            return response()->json([
                'success'    => true,
                'jawaban_id' => $jawaban->id,
                'sisa_detik' => $sesi->fresh()->sisa_detik,
            ]);
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan jawaban: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan jawaban.'], 500);
        }
    }

    /**
     * POST /api/siswa/ujian/{ujian}/selesai
     * Selesaikan ujian secara manual.
     */
    public function selesai(Request $request, Ujian $ujian): JsonResponse
    {
        $siswa = $this->getSiswa();

        $sesi = SesiUjian::where('siswa_id', $siswa->id)
            ->where('ujian_id', $ujian->id)
            ->where('status', 'berlangsung')
            ->latest()->first();

        if (! $sesi) {
            $sesiSelesai = SesiUjian::where('siswa_id', $siswa->id)
                ->where('ujian_id', $ujian->id)
                ->whereIn('status', ['selesai', 'habis_waktu'])
                ->latest('selesai_pada')->first();

            if ($sesiSelesai) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ujian sudah selesai sebelumnya.',
                ], 422);
            }

            return response()->json(['success' => false, 'message' => 'Sesi ujian tidak ditemukan.'], 404);
        }

        $sesi->selesaikan(habisWaktu: false);

        return response()->json([
            'success' => true,
            'message' => 'Ujian berhasil dikumpulkan!',
        ]);
    }

    /**
     * GET /api/siswa/ujian/{ujian}/hasil
     * Hasil ujian dengan nilai tertinggi.
     */
    public function hasil(Ujian $ujian): JsonResponse
    {
        $siswa = $this->getSiswa();

        $sesi = SesiUjian::where('siswa_id', $siswa->id)
            ->where('ujian_id', $ujian->id)
            ->whereIn('status', ['selesai', 'habis_waktu'])
            ->orderByDesc('nilai_akhir')
            ->orderByDesc('selesai_pada')
            ->first();

        if (! $sesi) {
            $sesiAktif = SesiUjian::where('siswa_id', $siswa->id)
                ->where('ujian_id', $ujian->id)
                ->where('status', 'berlangsung')
                ->latest()->first();

            if ($sesiAktif) {
                return response()->json([
                    'success'  => false,
                    'message'  => 'Ujian Anda masih berlangsung.',
                    'redirect' => 'kerjakan',
                ], 422);
            }

            return response()->json([
                'success' => false,
                'message' => 'Anda belum pernah mengerjakan ujian ini.',
            ], 404);
        }

        $ujian->load(['mataPelajaran', 'guru']);

        $soalList = $ujian->soal()
            ->with('pilihan')
            ->orderBy('nomor_soal')->orderBy('id')
            ->get();

        $jawabanMap = JawabanSiswa::where('sesi_ujian_id', $sesi->id)
            ->get(['soal_ujian_id', 'pilihan_jawaban_id', 'jawaban_essay', 'adalah_benar', 'poin_didapat'])
            ->keyBy('soal_ujian_id');

        $isBenarMap = [];
        foreach ($soalList as $soal) {
            $jawaban = $jawabanMap[$soal->id] ?? null;
            $isBenarMap[$soal->id] = ($jawaban !== null && isset($jawaban['adalah_benar']))
                ? (bool) $jawaban['adalah_benar']
                : null;
        }

        $semuaSesi = SesiUjian::where('siswa_id', $siswa->id)
            ->where('ujian_id', $ujian->id)
            ->whereIn('status', ['selesai', 'habis_waktu'])
            ->orderBy('selesai_pada')
            ->get(['id', 'nilai_akhir', 'status', 'selesai_pada', 'total_benar', 'total_salah', 'total_kosong', 'lulus']);

        return response()->json([
            'success' => true,
            'data'    => [
                'ujian'           => $ujian,
                'sesi'            => $sesi,
                'soal_list'       => $ujian->tampilkan_nilai ?? true ? $soalList : [],
                'jawaban_map'     => $ujian->tampilkan_nilai ?? true ? $jawabanMap : [],
                'is_benar_map'    => $ujian->tampilkan_nilai ?? true ? $isBenarMap : [],
                'tampilkan_nilai' => $ujian->tampilkan_nilai ?? true,
                'semua_sesi'      => $semuaSesi,
            ],
        ]);
    }
}