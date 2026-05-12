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
    // ── Helper ────────────────────────────────────────────────────

    private function getSiswa()
    {
        $siswa = Auth::user()->siswa;
        abort_if(! $siswa, 403, 'Akun Anda tidak terhubung dengan data siswa.');
        return $siswa;
    }

    private function selesaikanJikaHabisWaktu(SesiUjian $sesi): bool
    {
        if ($sesi->isHabisWaktu()) {
            $sesi->selesaikan(habisWaktu: true);
            return true;
        }
        return false;
    }

    // ── INDEX ─────────────────────────────────────────────────────
    // GET /api/siswa/ujian

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
            ->withCount('soal')
            ->where('kelas_id', $siswa->kelas_id)
            ->where('is_active', true)
            ->orderBy('tanggal')
            ->orderBy('jam_mulai')
            ->paginate(15);

        $ujian->getCollection()->transform(function ($u) use ($siswa, $selesaiMap, $nilaiTertinggiMap) {
            $percobaan          = $selesaiMap[$u->id] ?? 0;
            $u->boleh_ikut      = $percobaan < ($u->maks_percobaan ?? 1);
            $u->percobaan_ke    = $percobaan;
            $u->nilai_tertinggi = $nilaiTertinggiMap[$u->id] ?? null;

            $sesiAktif = SesiUjian::where('siswa_id', $siswa->id)
                ->where('ujian_id', $u->id)
                ->where('status', 'berlangsung')
                ->latest()
                ->first();

            if ($sesiAktif && $this->selesaikanJikaHabisWaktu($sesiAktif)) {
                $sesiAktif = null;
            }

            $u->sesi_aktif = $sesiAktif ? [
                'id'         => $sesiAktif->id,
                'sisa_detik' => $sesiAktif->sisa_detik,
            ] : null;

            return $u;
        });

        return response()->json(['success' => true, 'data' => $ujian]);
    }

    // ── RIWAYAT ───────────────────────────────────────────────────
    // GET /api/siswa/ujian/riwayat

    public function riwayat(): JsonResponse
    {
        $siswa = $this->getSiswa();

        $sesiList = SesiUjian::with(['ujian.mataPelajaran', 'ujian.guru'])
            ->where('siswa_id', $siswa->id)
            ->whereIn('status', ['selesai', 'habis_waktu'])
            ->orderByDesc('selesai_pada')
            ->paginate(15);

        return response()->json(['success' => true, 'data' => $sesiList]);
    }

    // ── INFO ──────────────────────────────────────────────────────
    // GET /api/siswa/ujian/{ujian}/info

    public function info(Ujian $ujian): JsonResponse
    {
        $siswa = $this->getSiswa();

        if ($ujian->kelas_id !== $siswa->kelas_id) {
            return response()->json(['success' => false, 'message' => 'Ujian ini bukan untuk kelas Anda.'], 403);
        }
        if (! $ujian->is_active) {
            return response()->json(['success' => false, 'message' => 'Ujian ini tidak aktif.'], 403);
        }
        if ($ujian->sudahBerakhir()) {
            return response()->json(['success' => false, 'message' => 'Waktu ujian sudah habis.'], 422);
        }
        if (! $ujian->bolehIkut($siswa->id)) {
            return response()->json(['success' => false, 'message' => 'Anda sudah mencapai batas percobaan.'], 422);
        }

        $ujian->load(['mataPelajaran', 'guru', 'kelas']);
        $totalSoal = $ujian->soal()->count();

        $sesiAktif = SesiUjian::where('siswa_id', $siswa->id)
            ->where('ujian_id', $ujian->id)
            ->where('status', 'berlangsung')
            ->latest()
            ->first();

        if ($sesiAktif && $this->selesaikanJikaHabisWaktu($sesiAktif)) {
            $sesiAktif = null;
        }

        $percobaanKe = SesiUjian::where('siswa_id', $siswa->id)
            ->where('ujian_id', $ujian->id)
            ->whereIn('status', ['selesai', 'habis_waktu'])
            ->count();

        $nilaiTertinggi = SesiUjian::where('siswa_id', $siswa->id)
            ->where('ujian_id', $ujian->id)
            ->whereIn('status', ['selesai', 'habis_waktu'])
            ->max('nilai_akhir');

        return response()->json([
            'success' => true,
            'data'    => [
                'ujian'           => $ujian,
                'total_soal'      => $totalSoal,
                'percobaan_ke'    => $percobaanKe,
                'nilai_tertinggi' => $nilaiTertinggi,
                'sesi_aktif'      => $sesiAktif ? [
                    'id'         => $sesiAktif->id,
                    'sisa_detik' => $sesiAktif->sisa_detik,
                ] : null,
            ],
        ]);
    }

    // ── START ─────────────────────────────────────────────────────
    // POST /api/siswa/ujian/{ujian}/start

    public function start(Request $request, Ujian $ujian): JsonResponse
    {
        $siswa = $this->getSiswa();

        if ($ujian->kelas_id !== $siswa->kelas_id) {
            return response()->json(['success' => false, 'message' => 'Ujian ini bukan untuk kelas Anda.'], 403);
        }
        if (! $ujian->is_active) {
            return response()->json(['success' => false, 'message' => 'Ujian ini tidak aktif.'], 403);
        }
        if ($ujian->sudahBerakhir()) {
            return response()->json(['success' => false, 'message' => 'Waktu ujian sudah habis.'], 422);
        }
        if (! $ujian->bolehIkut($siswa->id)) {
            return response()->json(['success' => false, 'message' => 'Anda sudah mencapai batas percobaan.'], 422);
        }

        $sesiAktif = SesiUjian::where('siswa_id', $siswa->id)
            ->where('ujian_id', $ujian->id)
            ->where('status', 'berlangsung')
            ->latest()
            ->first();

        if ($sesiAktif) {
            if ($this->selesaikanJikaHabisWaktu($sesiAktif)) {
                // waktu habis, lanjut buat sesi baru di bawah
            } else {
                return response()->json([
                    'success' => true,
                    'message' => 'Melanjutkan sesi ujian yang sedang berlangsung.',
                    'data'    => [
                        'sesi_id'    => $sesiAktif->id,
                        'sisa_detik' => $sesiAktif->sisa_detik,
                    ],
                ]);
            }
        }

        $percobaanKe = SesiUjian::where('siswa_id', $siswa->id)
            ->where('ujian_id', $ujian->id)
            ->whereIn('status', ['selesai', 'habis_waktu'])
            ->count() + 1;

        /** @var SesiUjian $sesi */
        $sesi = DB::transaction(function () use ($ujian, $siswa): SesiUjian {
            $sesi = SesiUjian::create([
                'siswa_id' => $siswa->id,
                'ujian_id' => $ujian->id,
                'status'   => 'berlangsung',
            ]);
            $sesi->mulai();
            return $sesi;
        });

        return response()->json([
            'success' => true,
            'message' => "Percobaan ke-{$percobaanKe} dimulai. Selamat mengerjakan!",
            'data'    => [
                'sesi_id'    => $sesi->id,
                'sisa_detik' => $sesi->fresh()->sisa_detik,
            ],
        ], 201);
    }

    // ── KERJAKAN ──────────────────────────────────────────────────
    // GET /api/siswa/ujian/{ujian}/kerjakan

    public function kerjakan(Ujian $ujian): JsonResponse
    {
        $siswa = $this->getSiswa();

        $sesi = SesiUjian::where('siswa_id', $siswa->id)
            ->where('ujian_id', $ujian->id)
            ->where('status', 'berlangsung')
            ->latest()
            ->first();

        if (! $sesi) {
            $sesiSelesai = SesiUjian::where('siswa_id', $siswa->id)
                ->where('ujian_id', $ujian->id)
                ->whereIn('status', ['selesai', 'habis_waktu'])
                ->latest('selesai_pada')
                ->first();

            return response()->json([
                'success'  => false,
                'message'  => $sesiSelesai ? 'Ujian sudah selesai.' : 'Silakan mulai ujian terlebih dahulu.',
                'redirect' => $sesiSelesai ? 'hasil' : 'info',
            ], 422);
        }

        if ($this->selesaikanJikaHabisWaktu($sesi)) {
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
            ? $soalQuery->get()->shuffle((int) $sesi->id)
            : $soalQuery->orderBy('nomor_soal')->orderBy('id')->get();

        $jawabanTersimpan = JawabanSiswa::where('sesi_ujian_id', $sesi->id)
            ->get(['soal_ujian_id', 'pilihan_jawaban_id', 'jawaban_essay'])
            ->keyBy('soal_ujian_id');

        return response()->json([
            'success' => true,
            'data'    => [
                'ujian'             => $ujian,
                'sesi_id'           => $sesi->id,
                'sisa_detik'        => $sesi->sisa_detik,
                'soal_list'         => $soalList,
                'jawaban_tersimpan' => $jawabanTersimpan,
            ],
        ]);
    }

    // ── JAWAB ─────────────────────────────────────────────────────
    // POST /api/siswa/ujian/{ujian}/soal/{soal}/jawab

    public function jawab(Request $request, Ujian $ujian, SoalUjian $soal): JsonResponse
    {
        $siswa = $this->getSiswa();

        if ($soal->ujian_id !== $ujian->id) {
            return response()->json(['success' => false, 'message' => 'Soal tidak valid.'], 422);
        }

        $sesi = SesiUjian::where('siswa_id', $siswa->id)
            ->where('ujian_id', $ujian->id)
            ->where('status', 'berlangsung')
            ->latest()
            ->first();

        if (! $sesi) {
            return response()->json(['success' => false, 'message' => 'Sesi ujian tidak ditemukan.'], 404);
        }

        if ($this->selesaikanJikaHabisWaktu($sesi)) {
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

    // ── SELESAI ───────────────────────────────────────────────────
    // POST /api/siswa/ujian/{ujian}/selesai

    public function selesai(Request $request, Ujian $ujian): JsonResponse
    {
        $siswa = $this->getSiswa();

        $sesi = SesiUjian::where('siswa_id', $siswa->id)
            ->where('ujian_id', $ujian->id)
            ->where('status', 'berlangsung')
            ->latest()
            ->first();

        if (! $sesi) {
            $sesiSelesai = SesiUjian::where('siswa_id', $siswa->id)
                ->where('ujian_id', $ujian->id)
                ->whereIn('status', ['selesai', 'habis_waktu'])
                ->latest('selesai_pada')
                ->first();

            if ($sesiSelesai) {
                return response()->json(['success' => true, 'message' => 'Ujian sudah selesai sebelumnya.']);
            }

            return response()->json(['success' => false, 'message' => 'Sesi ujian tidak ditemukan.'], 404);
        }

        $sesi->selesaikan(habisWaktu: false);

        return response()->json(['success' => true, 'message' => 'Ujian berhasil dikumpulkan!']);
    }

    // ── HASIL ─────────────────────────────────────────────────────
    // GET /api/siswa/ujian/{ujian}/hasil

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
                ->latest()
                ->first();

            return response()->json([
                'success'  => false,
                'message'  => $sesiAktif ? 'Ujian Anda masih berlangsung.' : 'Anda belum pernah mengerjakan ujian ini.',
                'redirect' => $sesiAktif ? 'kerjakan' : 'index',
            ], 422);
        }

        $ujian->load(['mataPelajaran', 'guru']);

        $soalList = $ujian->soal()
            ->with('pilihan')
            ->orderBy('nomor_soal')
            ->orderBy('id')
            ->get();

        $jawabanMap = JawabanSiswa::where('sesi_ujian_id', $sesi->id)
            ->get(['soal_ujian_id', 'pilihan_jawaban_id', 'jawaban_essay', 'adalah_benar', 'poin_didapat'])
            ->keyBy('soal_ujian_id');

        $isBenarMap = $soalList->mapWithKeys(function ($soal) use ($jawabanMap) {
            $j = $jawabanMap[$soal->id] ?? null;
            return [$soal->id => $j ? (bool) $j->adalah_benar : null];
        });

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
                'soal_list'       => $soalList,
                'jawaban_map'     => $jawabanMap,
                'is_benar_map'    => $isBenarMap,
                'semua_sesi'      => $semuaSesi,
                'tampilkan_nilai' => $ujian->tampilkan_nilai ?? true,
            ],
        ]);
    }
}