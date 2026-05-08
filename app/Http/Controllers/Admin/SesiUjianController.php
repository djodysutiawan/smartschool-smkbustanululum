<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JawabanSiswa;
use App\Models\SesiUjian;
use App\Models\Ujian;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SesiUjianExport;

/**
 * SesiUjianController
 *
 * Menangani DUA peran berbeda yang dipisahkan dengan jelas:
 *
 * ── ADMIN / GURU ──────────────────────────────────────────────────────────────
 *   indexAdmin()       — Lihat semua sesi pengerjaan siswa untuk satu ujian
 *   showAdmin()        — Detail sesi satu siswa (admin view)
 *   exportPdf()        — Export hasil seluruh siswa ke PDF
 *   exportExcel()      — Export hasil seluruh siswa ke Excel
 *
 * ── SISWA ─────────────────────────────────────────────────────────────────────
 *   index()     — Daftar ujian aktif milik kelas siswa
 *   mulai()     — Halaman konfirmasi sebelum mulai ujian
 *   start()     — POST: buat sesi baru & mulai timer
 *   kerjakan()  — Halaman mengerjakan soal
 *   jawab()     — POST/AJAX: simpan satu jawaban
 *   selesai()   — POST: kumpulkan ujian
 *   hasil()     — Halaman hasil / nilai siswa
 */
class SesiUjianController extends Controller
{
    /*
    |==========================================================================
    | ADMIN / GURU SECTION
    |==========================================================================
    */

    /**
     * Daftar semua sesi pengerjaan siswa untuk satu ujian.
     * Route: GET admin/ujian/{ujian}/sesi  → admin.ujian.sesi.index-admin
     */
    public function indexAdmin(Ujian $ujian)
    {
        $sesiList = $ujian->sesi()
            ->with('siswa')
            ->orderByDesc('mulai_pada')
            ->paginate(30);

        $stats = [
            'total_peserta'  => $ujian->sesi()->distinct('siswa_id')->count('siswa_id'),
            'sudah_selesai'  => $ujian->siswaSelesai()->distinct('siswa_id')->count('siswa_id'),
            'sedang_berlangsung' => $ujian->sesi()->where('status', 'berlangsung')->count(),
            'rata_nilai'     => round(
                $ujian->sesi()->whereNotNull('nilai_akhir')->avg('nilai_akhir') ?? 0,
                2
            ),
            'lulus'          => $ujian->sesi()->where('lulus', true)->count(),
            'tidak_lulus'    => $ujian->siswaSelesai()->where('lulus', false)->count(),
        ];

        return view('admin.ujian.sesi.index', compact('ujian', 'sesiList', 'stats'));
    }

    /**
     * Detail sesi satu siswa (admin view).
     * Route: GET admin/ujian/{ujian}/sesi/{sesi}  → admin.ujian.sesi.show-admin
     */
    public function showAdmin(Ujian $ujian, SesiUjian $sesi)
    {
        abort_if($sesi->ujian_id !== $ujian->id, 404, 'Sesi tidak ditemukan untuk ujian ini.');

        $sesi->load([
            'siswa',
            'jawaban.soal.pilihan',
            'jawaban.pilihan',
        ]);

        // Pisahkan jawaban essay yang belum dikoreksi
        $essayBelumKoreksi = $sesi->jawaban
            ->filter(fn($j) => $j->soal->jenis_soal === 'essay' && is_null($j->poin_didapat))
            ->count();

        return view('admin.ujian.sesi.show', compact('ujian', 'sesi', 'essayBelumKoreksi'));
    }

    /**
     * Export hasil seluruh siswa ke PDF.
     * Route: GET admin/ujian/{ujian}/export/pdf  → admin.ujian.sesi.export.pdf
     */
    public function exportPdf(Ujian $ujian)
    {
        $sesiList = $ujian->sesi()
            ->with(['siswa', 'jawaban'])
            ->whereIn('status', ['selesai', 'habis_waktu'])
            ->orderByDesc('nilai_akhir')
            ->get();

        $pdf = Pdf::loadView('admin.ujian.sesi-export-pdf', compact('ujian', 'sesiList'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('hasil-ujian-' . $ujian->id . '-' . now()->format('YmdHis') . '.pdf');
    }

    /**
     * Export hasil seluruh siswa ke Excel.
     * Route: GET admin/ujian/{ujian}/export/excel  → admin.ujian.sesi.export.excel
     */
    public function exportExcel(Ujian $ujian)
    {
        return Excel::download(
            new SesiUjianExport($ujian),
            'hasil-ujian-' . $ujian->id . '-' . now()->format('YmdHis') . '.xlsx'
        );
    }

    /*
    |==========================================================================
    | SISWA SECTION
    |==========================================================================
    */

    /**
     * Helper: ambil ID siswa dari user yang login.
     * Hanya dipakai untuk method siswa.
     */
    private function getSiswaId(): int
    {
        $siswa = Auth::user()->siswa;
        abort_if(!$siswa, 403, 'Akun Anda tidak terhubung dengan data siswa.');
        return $siswa->id;
    }

    /**
     * Daftar ujian aktif untuk kelas siswa.
     * Route: GET admin/ujian  (diakses siswa) → admin.ujian.sesi.index
     */
    public function index()
    {
        $siswaId = $this->getSiswaId();
        $siswa   = Auth::user()->siswa;

        $ujians = Ujian::aktif()
            ->where('kelas_id', $siswa->kelas_id)
            ->with(['mataPelajaran', 'guru'])
            ->get()
            ->map(function ($u) use ($siswaId) {
                $u->sesi_saya  = $u->getSesiSiswa($siswaId);
                $u->boleh_ikut = $u->bolehIkut($siswaId);
                return $u;
            });

        return view('siswa.ujian.index', compact('ujians'));
    }

    /**
     * Halaman konfirmasi sebelum mulai ujian.
     * Route: GET admin/ujian/{ujian}/mulai → admin.ujian.sesi.mulai
     */
    public function mulai(Ujian $ujian)
    {
        $siswaId = $this->getSiswaId();
        $this->authorizeUjian($ujian, $siswaId);

        $sesi = $ujian->getSesiSiswa($siswaId);

        // Jika sudah ada sesi aktif yang belum habis waktu, langsung ke kerjakan
        if ($sesi && $sesi->status === 'berlangsung' && !$sesi->isHabisWaktu()) {
            return redirect()->route('admin.ujian.sesi.kerjakan', $ujian);
        }

        return view('siswa.ujian.mulai', compact('ujian', 'sesi'));
    }

    /**
     * POST: Buat sesi baru dan mulai timer.
     * Route: POST admin/ujian/{ujian}/start → admin.ujian.sesi.start
     */
    public function start(Request $request, Ujian $ujian)
    {
        $siswaId = $this->getSiswaId();
        $this->authorizeUjian($ujian, $siswaId);

        // Cek apakah sudah ada sesi berlangsung yang belum habis waktu
        $sesiAktif = $ujian->sesi()
            ->where('siswa_id', $siswaId)
            ->where('status', 'berlangsung')
            ->first();

        if ($sesiAktif && !$sesiAktif->isHabisWaktu()) {
            return redirect()->route('admin.ujian.sesi.kerjakan', $ujian);
        }

        DB::transaction(function () use ($ujian, $siswaId) {
            $sesi = SesiUjian::create([
                'ujian_id' => $ujian->id,
                'siswa_id' => $siswaId,
                'status'   => 'belum_mulai',
            ]);
            $sesi->mulai();
        });

        return redirect()->route('admin.ujian.sesi.kerjakan', $ujian)
            ->with('info', 'Ujian dimulai. Waktu berjalan!');
    }

    /**
     * Halaman mengerjakan soal.
     * Route: GET admin/ujian/{ujian}/kerjakan → admin.ujian.sesi.kerjakan
     */
    public function kerjakan(Ujian $ujian)
    {
        $siswaId = $this->getSiswaId();
        $sesi    = $ujian->getSesiSiswa($siswaId);

        if (!$sesi || $sesi->status === 'belum_mulai') {
            return redirect()->route('admin.ujian.sesi.mulai', $ujian);
        }

        if (in_array($sesi->status, ['selesai', 'habis_waktu'])) {
            return redirect()->route('admin.ujian.sesi.hasil', $ujian);
        }

        // Auto-selesaikan jika waktu habis
        if ($sesi->isHabisWaktu()) {
            $sesi->selesaikan(habisWaktu: true);
            return redirect()->route('admin.ujian.sesi.hasil', $ujian)
                ->with('warning', 'Waktu habis. Ujian diselesaikan secara otomatis.');
        }

        $soals = $ujian->soal()->with('pilihan')->get();

        if ($ujian->acak_soal) {
            // Gunakan seed dari sesi agar urutan konsisten jika refresh
            $seed = $sesi->id;
            $soals = $soals->shuffle(/* seed tidak didukung Laravel Collection, pakai sort manual */);
        }

        $jawabanMap = $sesi->jawaban()
            ->pluck('pilihan_jawaban_id', 'soal_ujian_id')
            ->toArray();

        return view('siswa.ujian.kerjakan', compact('ujian', 'sesi', 'soals', 'jawabanMap'));
    }

    /**
     * POST/AJAX: Simpan satu jawaban siswa.
     * Route: POST admin/ujian/{ujian}/soal/{soal}/jawab → admin.ujian.sesi.soal.jawab
     */
    public function jawab(Request $request, Ujian $ujian, int $soalId)
    {
        $siswaId = $this->getSiswaId();
        $sesi    = $ujian->getSesiSiswa($siswaId);

        if (!$sesi || $sesi->status !== 'berlangsung') {
            return response()->json(['error' => 'Sesi ujian tidak aktif.'], 422);
        }

        if ($sesi->isHabisWaktu()) {
            $sesi->selesaikan(habisWaktu: true);
            return response()->json(['error' => 'Waktu ujian telah habis.'], 422);
        }

        $request->validate([
            'pilihan_jawaban_id' => ['nullable', 'exists:pilihan_jawaban,id'],
            'jawaban_essay'      => ['nullable', 'string', 'max:5000'],
        ], [
            'pilihan_jawaban_id.exists' => 'Pilihan jawaban tidak valid.',
            'jawaban_essay.max'         => 'Jawaban essay maksimal 5000 karakter.',
        ]);

        $jawaban = JawabanSiswa::updateOrCreate(
            [
                'sesi_ujian_id' => $sesi->id,
                'soal_ujian_id' => $soalId,
            ],
            [
                'pilihan_jawaban_id' => $request->pilihan_jawaban_id,
                'jawaban_essay'      => $request->jawaban_essay,
            ]
        );

        return response()->json([
            'success'    => true,
            'jawaban_id' => $jawaban->id,
            'sisa_detik' => $sesi->fresh()->sisa_detik,
        ]);
    }

    /**
     * POST: Kumpulkan / selesaikan ujian.
     * Route: POST admin/ujian/{ujian}/selesai → admin.ujian.sesi.selesai
     */
    public function selesai(Request $request, Ujian $ujian)
    {
        $siswaId = $this->getSiswaId();
        $sesi    = $ujian->getSesiSiswa($siswaId);

        if (!$sesi || $sesi->status !== 'berlangsung') {
            return redirect()->route('admin.ujian.sesi.index');
        }

        $sesi->selesaikan();

        return redirect()->route('admin.ujian.sesi.hasil', $ujian)
            ->with('success', 'Ujian berhasil dikumpulkan!');
    }

    /**
     * Halaman hasil / nilai siswa.
     * Route: GET admin/ujian/{ujian}/hasil → admin.ujian.sesi.hasil
     */
    public function hasil(Ujian $ujian)
    {
        $siswaId = $this->getSiswaId();
        $sesi    = $ujian->getSesiSiswa($siswaId);

        if (!$sesi || $sesi->status === 'berlangsung') {
            return redirect()->route('admin.ujian.sesi.kerjakan', $ujian);
        }

        $sesi->load(['jawaban.soal.pilihan', 'jawaban.pilihan']);

        // Cek apakah ada essay yang belum dikoreksi
        $essayBelumKoreksi = $sesi->jawaban
            ->filter(fn($j) => $j->soal->jenis_soal === 'essay' && is_null($j->poin_didapat))
            ->count();

        return view('siswa.ujian.hasil', compact('ujian', 'sesi', 'essayBelumKoreksi'));
    }

    /*
    |==========================================================================
    | PRIVATE HELPERS
    |==========================================================================
    */

    /**
     * Validasi hak siswa mengikuti ujian.
     */
    private function authorizeUjian(Ujian $ujian, int $siswaId): void
    {
        $siswa = Auth::user()->siswa;

        abort_if($ujian->kelas_id !== $siswa->kelas_id,  403, 'Ujian ini bukan untuk kelas Anda.');
        abort_if(!$ujian->is_active,                      403, 'Ujian tidak aktif.');
        abort_if(!$ujian->sudahDimulai(),                 403, 'Ujian belum dibuka.');
        abort_if($ujian->sudahBerakhir(),                 403, 'Ujian sudah berakhir.');
        abort_if(!$ujian->bolehIkut($siswaId),            403, 'Anda sudah melebihi batas percobaan untuk ujian ini.');
    }
}