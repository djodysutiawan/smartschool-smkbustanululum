<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\JawabanSiswa;
use App\Models\SesiUjian;
use App\Models\SoalUjian;
use App\Models\Ujian;
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

    // ── INDEX ─────────────────────────────────────────────────────
    // GET /ujian

    public function index()
    {
        $siswa = $this->getSiswa();

        // Hitung percobaan selesai per ujian
        $selesaiMap = SesiUjian::where('siswa_id', $siswa->id)
            ->whereIn('status', ['selesai', 'habis_waktu'])
            ->select('ujian_id', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('ujian_id')
            ->pluck('jumlah', 'ujian_id')
            ->toArray();

        // Nilai tertinggi per ujian
        $nilaiTertinggiMap = SesiUjian::where('siswa_id', $siswa->id)
            ->whereIn('status', ['selesai', 'habis_waktu'])
            ->select('ujian_id', DB::raw('MAX(nilai_akhir) as nilai_tertinggi'))
            ->groupBy('ujian_id')
            ->pluck('nilai_tertinggi', 'ujian_id')
            ->toArray();

        $ujian = Ujian::with(['mataPelajaran', 'guru'])
            ->where('kelas_id', $siswa->kelas_id)
            ->where('is_active', true)
            ->orderBy('tanggal')
            ->orderBy('jam_mulai')
            ->paginate(15);

        $ujian->getCollection()->transform(function ($u) use ($siswa, $selesaiMap, $nilaiTertinggiMap) {
            $percobaan            = $selesaiMap[$u->id] ?? 0;
            $u->boleh_ikut        = $percobaan < ($u->maks_percobaan ?? 1);
            $u->percobaan_ke      = $percobaan;
            $u->nilai_tertinggi   = $nilaiTertinggiMap[$u->id] ?? null;
            $u->sesi_aktif        = SesiUjian::where('siswa_id', $siswa->id)
                ->where('ujian_id', $u->id)
                ->where('status', 'berlangsung')
                ->latest()
                ->first();
            return $u;
        });

        return view('siswa.ujian.index', compact('ujian'));
    }

    // ── RIWAYAT ───────────────────────────────────────────────────
    // GET /ujian/riwayat

    public function riwayat()
    {
        $siswa = $this->getSiswa();

        $sesiList = SesiUjian::with(['ujian.mataPelajaran', 'ujian.guru'])
            ->where('siswa_id', $siswa->id)
            ->whereIn('status', ['selesai', 'habis_waktu'])
            ->orderByDesc('selesai_pada')
            ->paginate(15);

        return view('siswa.ujian.riwayat', compact('sesiList'));
    }

    // ── MULAI (GET — halaman konfirmasi) ──────────────────────────
    // GET /ujian/{ujian}/mulai

    public function mulai(Ujian $ujian)
    {
        $siswa = $this->getSiswa();

        abort_if($ujian->kelas_id !== $siswa->kelas_id, 403, 'Ujian ini bukan untuk kelas Anda.');
        abort_if(! $ujian->is_active, 403, 'Ujian ini tidak aktif.');
        abort_if($ujian->sudahBerakhir(), 422, 'Waktu ujian sudah habis.');
        abort_if(! $ujian->bolehIkut($siswa->id), 422, 'Anda sudah mencapai batas percobaan untuk ujian ini.');

        $ujian->load(['mataPelajaran', 'guru', 'kelas']);
        $totalSoal = $ujian->soal()->count();

        // Cek sesi berlangsung yang masih valid
        $sesiAktif = SesiUjian::where('siswa_id', $siswa->id)
            ->where('ujian_id', $ujian->id)
            ->where('status', 'berlangsung')
            ->latest()
            ->first();

        // Jika sesi aktif tapi waktunya habis, selesaikan otomatis
        if ($sesiAktif && $sesiAktif->isHabisWaktu()) {
            $sesiAktif->selesaikan(habisWaktu: true);
            $sesiAktif = null;
        }

        $sisaDetik    = $sesiAktif?->sisa_detik ?? null;

        // Info percobaan
        $percobaanKe  = SesiUjian::where('siswa_id', $siswa->id)
            ->where('ujian_id', $ujian->id)
            ->whereIn('status', ['selesai', 'habis_waktu'])
            ->count();

        $nilaiTertinggi = SesiUjian::where('siswa_id', $siswa->id)
            ->where('ujian_id', $ujian->id)
            ->whereIn('status', ['selesai', 'habis_waktu'])
            ->max('nilai_akhir');

        return view('siswa.ujian.mulai', compact(
            'ujian', 'totalSoal', 'sesiAktif', 'sisaDetik',
            'percobaanKe', 'nilaiTertinggi'
        ));
    }

    // ── START (POST — buat sesi baru) ─────────────────────────────
    // POST /ujian/{ujian}/start

    public function start(Request $request, Ujian $ujian)
    {
        $siswa = $this->getSiswa();

        abort_if($ujian->kelas_id !== $siswa->kelas_id, 403, 'Ujian ini bukan untuk kelas Anda.');
        abort_if(! $ujian->is_active, 403, 'Ujian ini tidak aktif.');
        abort_if($ujian->sudahBerakhir(), 422, 'Waktu ujian sudah habis.');
        abort_if(! $ujian->bolehIkut($siswa->id), 422, 'Anda sudah mencapai batas percobaan untuk ujian ini.');

        // Cek apakah ada sesi berlangsung yang masih valid
        $sesiAktif = SesiUjian::where('siswa_id', $siswa->id)
            ->where('ujian_id', $ujian->id)
            ->where('status', 'berlangsung')
            ->latest()
            ->first();

        if ($sesiAktif) {
            if ($sesiAktif->isHabisWaktu()) {
                // Selesaikan sesi yang habis waktu, lalu buat sesi baru di bawah
                $sesiAktif->selesaikan(habisWaktu: true);
            } else {
                // Sesi masih valid, lanjutkan
                return redirect()->route('siswa.ujian.kerjakan', $ujian->id)
                    ->with('info', 'Melanjutkan sesi ujian yang sedang berlangsung.');
            }
        }

        // Buat sesi baru (percobaan baru)
        DB::transaction(function () use ($ujian, $siswa) {
            $sesi = SesiUjian::create([
                'siswa_id' => $siswa->id,
                'ujian_id' => $ujian->id,
                'status'   => 'berlangsung',
            ]);
            $sesi->mulai();
        });

        $percobaanKe = SesiUjian::where('siswa_id', $siswa->id)
            ->where('ujian_id', $ujian->id)
            ->whereIn('status', ['selesai', 'habis_waktu'])
            ->count() + 1; // +1 karena sesi baru belum selesai

        return redirect()->route('siswa.ujian.kerjakan', $ujian->id)
            ->with('info', "Percobaan ke-{$percobaanKe} dimulai. Selamat mengerjakan!");
    }

    // ── KERJAKAN (GET) ────────────────────────────────────────────
    // GET /ujian/{ujian}/kerjakan

    public function kerjakan(Ujian $ujian)
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
                return redirect()->route('siswa.ujian.hasil', $ujian->id)
                    ->with('info', 'Ujian sudah selesai. Berikut hasil ujian Anda.');
            }

            return redirect()->route('siswa.ujian.mulai', $ujian->id)
                ->with('warning', 'Silakan mulai ujian terlebih dahulu.');
        }

        if ($sesi->isHabisWaktu()) {
            $sesi->selesaikan(habisWaktu: true);
            return redirect()->route('siswa.ujian.hasil', $ujian->id)
                ->with('warning', 'Waktu ujian telah habis. Ujian diselesaikan otomatis.');
        }

        $ujian->load(['mataPelajaran', 'guru']);

        $soalQuery = $ujian->soal()->with('pilihan');

        $soalList = $ujian->acak_soal
            // Seed dari sesi ID agar urutan konsisten per percobaan
            ? $soalQuery->get()->shuffle($sesi->id)
            : $soalQuery->orderBy('nomor_soal')->orderBy('id')->get();

        $jawabanTersimpan = JawabanSiswa::where('sesi_ujian_id', $sesi->id)
            ->get(['soal_ujian_id', 'pilihan_jawaban_id', 'jawaban_essay'])
            ->keyBy('soal_ujian_id')
            ->toArray();

        return view('siswa.ujian.kerjakan', compact(
            'ujian', 'sesi', 'soalList', 'jawabanTersimpan',
        ));
    }

    // ── JAWAB (POST — AJAX) ───────────────────────────────────────
    // POST /ujian/{ujian}/soal/{soal}/jawab

    public function jawab(Request $request, Ujian $ujian, SoalUjian $soal)
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

        if ($sesi->isHabisWaktu()) {
            $sesi->selesaikan(habisWaktu: true);
            return response()->json(['success' => false, 'habis_waktu' => true, 'message' => 'Waktu ujian habis.']);
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

    // ── SELESAI (POST) ────────────────────────────────────────────
    // POST /ujian/{ujian}/selesai

    public function selesai(Request $request, Ujian $ujian)
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
                return redirect()->route('siswa.ujian.hasil', $ujian->id)
                    ->with('info', 'Ujian sudah selesai sebelumnya.');
            }

            abort(404, 'Sesi ujian tidak ditemukan.');
        }

        $sesi->selesaikan(habisWaktu: false);

        return redirect()->route('siswa.ujian.hasil', $ujian->id)
            ->with('success', 'Ujian berhasil dikumpulkan!');
    }

    // ── HASIL (GET — tampilkan nilai TERTINGGI) ───────────────────
    // GET /ujian/{ujian}/hasil

    public function hasil(Ujian $ujian)
    {
        $siswa = $this->getSiswa();

        // Ambil sesi dengan nilai tertinggi (bukan sesi terakhir)
        $sesi = SesiUjian::where('siswa_id', $siswa->id)
            ->where('ujian_id', $ujian->id)
            ->whereIn('status', ['selesai', 'habis_waktu'])
            ->orderByDesc('nilai_akhir')   // ← nilai tertinggi
            ->orderByDesc('selesai_pada')  // ← tiebreaker: paling baru
            ->first();

        if (! $sesi) {
            $sesiAktif = SesiUjian::where('siswa_id', $siswa->id)
                ->where('ujian_id', $ujian->id)
                ->where('status', 'berlangsung')
                ->latest()
                ->first();

            if ($sesiAktif) {
                return redirect()->route('siswa.ujian.kerjakan', $ujian->id)
                    ->with('warning', 'Ujian Anda masih berlangsung.');
            }

            return redirect()->route('siswa.ujian.index')
                ->with('warning', 'Anda belum pernah mengerjakan ujian ini.');
        }

        $ujian->load(['mataPelajaran', 'guru']);

        $soalList = $ujian->soal()
            ->with('pilihan')
            ->orderBy('nomor_soal')
            ->orderBy('id')
            ->get();

        $jawabanMap = JawabanSiswa::where('sesi_ujian_id', $sesi->id)
            ->get(['soal_ujian_id', 'pilihan_jawaban_id', 'jawaban_essay', 'adalah_benar', 'poin_didapat'])
            ->keyBy('soal_ujian_id')
            ->toArray();

        $isBenarMap = [];
        foreach ($soalList as $soal) {
            $jawaban = $jawabanMap[$soal->id] ?? null;
            $isBenarMap[$soal->id] = ($jawaban !== null && isset($jawaban['adalah_benar']))
                ? (bool) $jawaban['adalah_benar']
                : null;
        }

        // Semua sesi siswa untuk ujian ini (riwayat percobaan)
        $semuaSesi = SesiUjian::where('siswa_id', $siswa->id)
            ->where('ujian_id', $ujian->id)
            ->whereIn('status', ['selesai', 'habis_waktu'])
            ->orderBy('selesai_pada')
            ->get(['id', 'nilai_akhir', 'status', 'selesai_pada', 'total_benar', 'total_salah', 'total_kosong', 'lulus']);

        $tampilkanNilai = $ujian->tampilkan_nilai ?? true;

        return view('siswa.ujian.hasil', compact(
            'ujian', 'sesi', 'soalList', 'jawabanMap',
            'isBenarMap', 'tampilkanNilai', 'semuaSesi',
        ));
    }
}