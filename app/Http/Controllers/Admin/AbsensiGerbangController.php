<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AbsensiGerbang;
use App\Models\BarcodeGerbang;
use App\Models\Kelas;
use App\Models\SesiGerbang;
use App\Models\Siswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AbsensiGerbangExport;
use App\Exports\RekapAbsensiGerbangExport;

class AbsensiGerbangController extends Controller
{
    // ── index ─────────────────────────────────────────────────────────────────

    /**
     * Daftar log scan absensi gerbang.
     * Filter: tanggal, kelas, tipe (masuk|pulang), status scan.
     */
    public function index(Request $request): View
    {
        // Default: tampilkan hari ini
        $tanggal = $request->input('tanggal', now()->toDateString());

        $query = AbsensiGerbang::with([
                'siswa.kelas',
                'sesiGerbang',
                'inputOleh:id,name',
            ])
            ->where('tanggal_scan', $tanggal);

        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('kelas_id')) {
            $query->whereHas('siswa', fn ($q) =>
                $q->where('kelas_id', $request->kelas_id)
            );
        }

        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function ($q) use ($cari) {
                $q->where('kode_scan', 'like', "%{$cari}%")
                  ->orWhereHas('siswa', fn ($sq) =>
                      $sq->where('nama_lengkap', 'like', "%{$cari}%")
                         ->orWhere('nis', 'like', "%{$cari}%")
                  );
            });
        }

        $scanList  = $query->orderByDesc('waktu_scan')->paginate(30)->withQueryString();
        $kelasList = Kelas::aktif()->orderBy('tingkat')->orderBy('nama_kelas')->get();

        // Statistik untuk tanggal yang dipilih
        $statistik = $this->hitungStatistikHarian($tanggal);

        // Sesi aktif hari ini (untuk tombol input manual)
        $sesiAktif = SesiGerbang::sesiAktifSekarang();

        return view('admin.absensi-gerbang.index', compact(
            'scanList',
            'kelasList',
            'statistik',
            'sesiAktif',
            'tanggal',
        ));
    }

    // ── show ──────────────────────────────────────────────────────────────────

    /**
     * Detail satu record scan.
     */
    public function show(AbsensiGerbang $absensiGerbang): View
    {
        $absensiGerbang->load([
            'siswa.kelas',
            'sesiGerbang.dibukaOleh',
            'barcodeGerbang',
            'inputOleh:id,name',
            'koreksiDari.siswa',
            'hasilKoreksi.siswa',
        ]);

        return view('admin.absensi-gerbang.show', compact('absensiGerbang'));
    }

    // ── destroy ───────────────────────────────────────────────────────────────

    /**
     * Hapus record scan (soft delete).
     * Biasanya digunakan untuk menghapus scan tidak dikenal / kesalahan alat.
     */
    public function destroy(AbsensiGerbang $absensiGerbang): RedirectResponse
    {
        // Tolak hapus jika record ini sudah memiliki koreksi aktif
        if ($absensiGerbang->hasilKoreksi()->exists()) {
            return back()->with('error', 'Record ini sudah dikoreksi, tidak bisa dihapus langsung.');
        }

        $absensiGerbang->delete();

        return back()->with('success', 'Record scan berhasil dihapus.');
    }

    // ── koreksi ───────────────────────────────────────────────────────────────

    /**
     * Koreksi tipe scan (masuk → pulang atau sebaliknya).
     * Membuat record baru bertipe 'koreksi', record lama tetap tersimpan.
     */
    public function koreksi(Request $request, AbsensiGerbang $absensiGerbang): RedirectResponse
    {
        $request->validate([
            'tipe_baru' => ['required', 'in:masuk,pulang', 'different:' . $absensiGerbang->tipe],
            'catatan'   => ['nullable', 'string', 'max:500'],
        ], [
            'tipe_baru.different' => 'Tipe baru harus berbeda dengan tipe saat ini.',
        ]);

        // Cek apakah record ini sudah pernah dikoreksi
        if ($absensiGerbang->hasilKoreksi()->exists()) {
            return back()->with('error', 'Record ini sudah dikoreksi sebelumnya.');
        }

        /** @var \App\Models\User $authUser */
        $authUser = Auth::user();

        try {
            $koreksi = $absensiGerbang->koreksi(
                inputOleh: $authUser->id,
                tipeBaru:  $request->tipe_baru,
                catatan:   $request->catatan,
            );
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal melakukan koreksi: ' . $e->getMessage());
        }

        return redirect()
            ->route('admin.absensi-gerbang.show', $koreksi)
            ->with('success', 'Koreksi berhasil disimpan.');
    }

    // ── rekap ─────────────────────────────────────────────────────────────────

    /**
     * Rekap kehadiran per siswa / per kelas / per periode.
     */
    public function rekap(Request $request): View
    {
        // Default: bulan ini
        $dari    = $request->input('dari', now()->startOfMonth()->toDateString());
        $sampai  = $request->input('sampai', now()->toDateString());
        $kelasId = $request->input('kelas_id');
        $tipe    = $request->input('tipe', 'masuk'); // rekap masuk lebih relevan

        // Total hari sekolah di periode ini (berdasarkan sesi yang sudah ditutup)
        $totalHariSekolah = SesiGerbang::where('tipe', $tipe)
            ->whereBetween('tanggal', [$dari, $sampai])
            ->where('status', 'ditutup')
            ->distinct('tanggal')
            ->count('tanggal');

        // Query siswa + hitung hari hadir
        $siswaQuery = Siswa::aktif()
            ->with('kelas')
            ->withCount([
                'absensiGerbang as hari_hadir' => fn ($q) =>
                    $q->where('tipe', $tipe)
                      ->whereBetween('tanggal_scan', [$dari, $sampai])
                      ->whereIn('status', ['normal', 'manual', 'koreksi'])
                      ->distinct('tanggal_scan'),
            ]);

        if ($kelasId) {
            $siswaQuery->where('kelas_id', $kelasId);
        }

        if ($request->filled('cari')) {
            $cari = $request->cari;
            $siswaQuery->where(function ($q) use ($cari) {
                $q->where('nama_lengkap', 'like', "%{$cari}%")
                  ->orWhere('nis', 'like', "%{$cari}%");
            });
        }

        $rekapList = $siswaQuery
            ->orderBy('nama_lengkap')
            ->paginate(30)
            ->withQueryString();

        // Hitung persentase untuk tiap siswa
        $rekapList->getCollection()->transform(function ($siswa) use ($totalHariSekolah) {
            $siswa->hari_tidak_hadir = max(0, $totalHariSekolah - $siswa->hari_hadir);
            $siswa->persentase       = $totalHariSekolah > 0
                ? round(($siswa->hari_hadir / $totalHariSekolah) * 100, 1)
                : 0;
            return $siswa;
        });

        $kelasList = Kelas::aktif()->orderBy('tingkat')->orderBy('nama_kelas')->get();

        return view('admin.absensi-gerbang.rekap', compact(
            'rekapList',
            'kelasList',
            'totalHariSekolah',
            'dari',
            'sampai',
            'tipe',
        ));
    }

    // ── belumHadir ────────────────────────────────────────────────────────────

    /**
     * Daftar siswa yang belum scan masuk hari ini.
     * Filter: kelas.
     */
    public function belumHadir(Request $request): View
    {
        $tanggal = $request->input('tanggal', now()->toDateString());

        // ID siswa yang sudah scan masuk valid pada tanggal ini
        $sudahHadirIds = AbsensiGerbang::where('tipe', 'masuk')
            ->where('tanggal_scan', $tanggal)
            ->whereIn('status', ['normal', 'manual', 'koreksi'])
            ->whereNotNull('siswa_id')
            ->pluck('siswa_id');

        $query = Siswa::aktif()
            ->with('kelas')
            ->whereNotIn('id', $sudahHadirIds);

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function ($q) use ($cari) {
                $q->where('nama_lengkap', 'like', "%{$cari}%")
                  ->orWhere('nis', 'like', "%{$cari}%");
            });
        }

        $belumHadirList = $query->orderBy('nama_lengkap')->paginate(30)->withQueryString();
        $kelasList      = Kelas::aktif()->orderBy('tingkat')->orderBy('nama_kelas')->get();

        $totalSiswaAktif = Siswa::aktif()
            ->when($request->kelas_id, fn ($q) => $q->where('kelas_id', $request->kelas_id))
            ->count();

        $statistik = [
            'total_siswa'    => $totalSiswaAktif,
            'sudah_hadir'    => $sudahHadirIds->count(),
            'belum_hadir'    => $belumHadirList->total(),
            'persentase'     => $totalSiswaAktif > 0
                ? round(($sudahHadirIds->count() / $totalSiswaAktif) * 100, 1)
                : 0,
        ];

        return view('admin.absensi-gerbang.belum-hadir', compact(
            'belumHadirList',
            'kelasList',
            'statistik',
            'tanggal',
        ));
    }

    // ── inputManual ───────────────────────────────────────────────────────────

    /**
     * Form input manual — jika alat rusak atau siswa lupa bawa ID.
     */
    public function inputManual(Request $request): View
    {
        $sesiAktif = SesiGerbang::sesiAktifSekarang();

        // Untuk autocomplete siswa di form
        $kelasList = Kelas::aktif()->orderBy('tingkat')->orderBy('nama_kelas')->get();

        return view('admin.absensi-gerbang.input-manual', compact('sesiAktif', 'kelasList'));
    }

    // ── storeManual ───────────────────────────────────────────────────────────

    /**
     * Simpan input manual absensi gerbang.
     */
    public function storeManual(Request $request): RedirectResponse
    {
        $request->validate([
            'sesi_gerbang_id' => ['required', 'exists:sesi_gerbang,id'],
            'siswa_id'        => ['required', 'exists:siswa,id'],
            'tipe'            => ['nullable', 'in:masuk,pulang'],
            'catatan'         => ['nullable', 'string', 'max:500'],
        ]);

        $sesi  = SesiGerbang::findOrFail($request->sesi_gerbang_id);
        $siswa = Siswa::findOrFail($request->siswa_id);

        // Cek sesi masih aktif
        if ($sesi->status !== 'aktif') {
            return back()->with('error', 'Sesi yang dipilih sudah ditutup.')->withInput();
        }

        // Cek apakah siswa sudah scan manual/normal di sesi ini dengan tipe yang sama
        $tipe        = $request->tipe ?? $sesi->tipe;
        $sudahAbsen  = AbsensiGerbang::where('sesi_gerbang_id', $sesi->id)
            ->where('siswa_id', $siswa->id)
            ->where('tipe', $tipe)
            ->whereIn('status', ['normal', 'manual', 'koreksi'])
            ->exists();

        if ($sudahAbsen) {
            return back()
                ->with('error', "Siswa {$siswa->nama_lengkap} sudah tercatat {$tipe} di sesi ini.")
                ->withInput();
        }

        /** @var \App\Models\User $authUser */
        $authUser = Auth::user();

        AbsensiGerbang::inputManual(
            sesi:      $sesi,
            siswa:     $siswa,
            inputOleh: $authUser->id,
            catatan:   $request->catatan,
            tipe:      $tipe,
        );

        return back()->with('success', "Absensi manual {$siswa->nama_lengkap} berhasil disimpan.");
    }

    // ── exportPdf ─────────────────────────────────────────────────────────────

    /**
     * Export log scan ke PDF (satu halaman per tanggal).
     */
    public function exportPdf(Request $request)
    {
        $tanggal = $request->input('tanggal', now()->toDateString());

        $query = AbsensiGerbang::with(['siswa.kelas', 'sesiGerbang', 'inputOleh:id,name'])
            ->where('tanggal_scan', $tanggal)
            ->whereIn('status', ['normal', 'manual', 'koreksi']);

        if ($request->filled('tipe'))     $query->where('tipe', $request->tipe);
        if ($request->filled('kelas_id')) {
            $query->whereHas('siswa', fn ($q) => $q->where('kelas_id', $request->kelas_id));
        }

        $scanList  = $query->orderBy('tipe')->orderBy('waktu_scan')->get();
        $statistik = $this->hitungStatistikHarian($tanggal, $request->kelas_id);

        /** @var \App\Models\User $authUser */
        $authUser = Auth::user();

        $filter = [
            'tanggal'      => $tanggal,
            'tipe'         => $request->tipe,
            'kelas_id'     => $request->kelas_id,
            'kelas_label'  => $request->kelas_id ? Kelas::find($request->kelas_id)?->nama_kelas : null,
            'dicetak_pada' => now()->isoFormat('D MMMM Y, HH:mm'),
            'dicetak_oleh' => $authUser->name,
        ];

        $pdf = Pdf::loadView('admin.absensi-gerbang.export-pdf', compact('scanList', 'statistik', 'filter'))
                  ->setPaper('a4', 'portrait');

        return $pdf->download('absensi-gerbang-' . $tanggal . '.pdf');
    }

    // ── exportExcel ───────────────────────────────────────────────────────────

    /**
     * Export log scan ke Excel.
     */
    public function exportExcel(Request $request)
    {
        $fileName = 'absensi-gerbang-' . $request->input('tanggal', now()->toDateString()) . '.xlsx';

        return Excel::download(new AbsensiGerbangExport($request->all()), $fileName);
    }

    // ── exportRekapPdf ────────────────────────────────────────────────────────

    /**
     * Export rekap kehadiran per siswa ke PDF.
     */
    public function exportRekapPdf(Request $request)
    {
        $dari    = $request->input('dari', now()->startOfMonth()->toDateString());
        $sampai  = $request->input('sampai', now()->toDateString());
        $kelasId = $request->input('kelas_id');
        $tipe    = $request->input('tipe', 'masuk');

        $totalHariSekolah = SesiGerbang::where('tipe', $tipe)
            ->whereBetween('tanggal', [$dari, $sampai])
            ->where('status', 'ditutup')
            ->distinct('tanggal')
            ->count('tanggal');

        $siswaQuery = Siswa::aktif()
            ->with('kelas')
            ->withCount([
                'absensiGerbang as hari_hadir' => fn ($q) =>
                    $q->where('tipe', $tipe)
                      ->whereBetween('tanggal_scan', [$dari, $sampai])
                      ->whereIn('status', ['normal', 'manual', 'koreksi'])
                      ->distinct('tanggal_scan'),
            ]);

        if ($kelasId) $siswaQuery->where('kelas_id', $kelasId);

        $rekapList = $siswaQuery->orderBy('nama_lengkap')->get()->map(function ($siswa) use ($totalHariSekolah) {
            $siswa->hari_tidak_hadir = max(0, $totalHariSekolah - $siswa->hari_hadir);
            $siswa->persentase       = $totalHariSekolah > 0
                ? round(($siswa->hari_hadir / $totalHariSekolah) * 100, 1)
                : 0;
            return $siswa;
        });

        /** @var \App\Models\User $authUser */
        $authUser = Auth::user();

        $filter = [
            'dari'         => $dari,
            'sampai'       => $sampai,
            'tipe'         => $tipe,
            'kelas_label'  => $kelasId ? Kelas::find($kelasId)?->nama_kelas : 'Semua Kelas',
            'dicetak_pada' => now()->isoFormat('D MMMM Y, HH:mm'),
            'dicetak_oleh' => $authUser->name,
        ];

        $pdf = Pdf::loadView('admin.absensi-gerbang.rekap-export-pdf', compact(
            'rekapList',
            'totalHariSekolah',
            'filter',
        ))->setPaper('a4', 'portrait');

        return $pdf->download('rekap-absensi-gerbang-' . $dari . '-sd-' . $sampai . '.pdf');
    }

    // ── exportRekapExcel ──────────────────────────────────────────────────────

    /**
     * Export rekap kehadiran per siswa ke Excel.
     */
    public function exportRekapExcel(Request $request)
    {
        $fileName = 'rekap-absensi-gerbang-' . now()->format('Ymd') . '.xlsx';

        return Excel::download(new RekapAbsensiGerbangExport($request->all()), $fileName);
    }

    // ── exportBelumHadirPdf ───────────────────────────────────────────────────

    /**
     * Export daftar siswa belum hadir ke PDF.
     */
    public function exportBelumHadirPdf(Request $request)
    {
        $tanggal = $request->input('tanggal', now()->toDateString());

        $sudahHadirIds = AbsensiGerbang::where('tipe', 'masuk')
            ->where('tanggal_scan', $tanggal)
            ->whereIn('status', ['normal', 'manual', 'koreksi'])
            ->whereNotNull('siswa_id')
            ->pluck('siswa_id');

        $query = Siswa::aktif()->with('kelas')->whereNotIn('id', $sudahHadirIds);

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        $belumHadirList = $query->orderBy('nama_lengkap')->get();

        /** @var \App\Models\User $authUser */
        $authUser = Auth::user();

        $filter = [
            'tanggal'      => $tanggal,
            'kelas_label'  => $request->kelas_id ? Kelas::find($request->kelas_id)?->nama_kelas : 'Semua Kelas',
            'dicetak_pada' => now()->isoFormat('D MMMM Y, HH:mm'),
            'dicetak_oleh' => $authUser->name,
        ];

        $pdf = Pdf::loadView('admin.absensi-gerbang.belum-hadir-export-pdf', compact('belumHadirList', 'filter'))
                  ->setPaper('a4', 'portrait');

        return $pdf->download('belum-hadir-' . $tanggal . '.pdf');
    }

    // ── ajaxLive ──────────────────────────────────────────────────────────────

    /**
     * JSON untuk live monitor — polling dari frontend setiap N detik.
     * Mengembalikan scan terbaru di sesi aktif + statistik ringkas.
     *
     * Query param: last_id (int) — hanya kembalikan scan setelah ID ini
     *              sesi_id (int) — filter ke sesi tertentu (opsional)
     */
    public function ajaxLive(Request $request): JsonResponse
    {
        $sesiAktif = SesiGerbang::sesiAktifSekarang();

        if (! $sesiAktif) {
            return response()->json([
                'ada_sesi_aktif' => false,
                'sesi'           => null,
                'scan_baru'      => [],
                'statistik'      => null,
                'timestamp'      => now()->format('H:i:s'),
            ]);
        }

        // Hanya ambil scan baru sejak last_id terakhir (untuk polling efisien)
        $lastId = (int) $request->input('last_id', 0);

        $scanBaru = AbsensiGerbang::with(['siswa:id,nama_lengkap,nis,kelas_id', 'siswa.kelas:id,nama_kelas'])
            ->where('sesi_gerbang_id', $sesiAktif->id)
            ->where('id', '>', $lastId)
            ->orderByDesc('id')
            ->limit(20)
            ->get()
            ->map(fn ($scan) => [
                'id'           => $scan->id,
                'nama_siswa'   => $scan->siswa?->nama_lengkap ?? 'Tidak Dikenal',
                'nis'          => $scan->siswa?->nis ?? '-',
                'kelas'        => $scan->siswa?->kelas?->nama_kelas ?? '-',
                'tipe'         => $scan->tipe,
                'label_tipe'   => $scan->label_tipe,
                'status'       => $scan->status,
                'label_status' => $scan->label_status,
                'is_manual'    => $scan->is_manual,
                'dikenal'      => $scan->dikenal,
                'waktu_scan'   => $scan->waktu_scan->format('H:i:s'),
                'kode_scan'    => $scan->kode_scan,
            ]);

        // Statistik sesi aktif
        $statistik = [
            'total_masuk'   => $sesiAktif->absensiGerbang()->where('tipe', 'masuk')
                                          ->whereIn('status', ['normal', 'manual', 'koreksi'])->count(),
            'total_pulang'  => $sesiAktif->absensiGerbang()->where('tipe', 'pulang')
                                          ->whereIn('status', ['normal', 'manual', 'koreksi'])->count(),
            'duplikat'      => $sesiAktif->absensiGerbang()->where('status', 'duplikat')->count(),
            'tidak_dikenal' => $sesiAktif->absensiGerbang()->whereNull('siswa_id')->count(),
            'last_id'       => $sesiAktif->absensiGerbang()->max('id') ?? 0,
        ];

        return response()->json([
            'ada_sesi_aktif' => true,
            'sesi'           => [
                'id'          => $sesiAktif->id,
                'tipe'        => $sesiAktif->tipe,
                'label_tipe'  => $sesiAktif->label_tipe,
                'dibuka_pada' => $sesiAktif->dibuka_pada->format('H:i'),
            ],
            'scan_baru'      => $scanBaru,
            'statistik'      => $statistik,
            'timestamp'      => now()->format('H:i:s'),
        ]);
    }

    // ── Private Helpers ───────────────────────────────────────────────────────

    /**
     * Hitung statistik ringkas untuk satu hari tertentu.
     * Dipakai di index() dan exportPdf().
     */
    private function hitungStatistikHarian(string $tanggal, ?int $kelasId = null): array
    {
        $base = AbsensiGerbang::where('tanggal_scan', $tanggal);

        if ($kelasId) {
            $base->whereHas('siswa', fn ($q) => $q->where('kelas_id', $kelasId));
        }

        $totalSiswa = Siswa::aktif()->when($kelasId, fn ($q) => $q->where('kelas_id', $kelasId))->count();

        $masukIds  = (clone $base)->where('tipe', 'masuk')
                                   ->whereIn('status', ['normal', 'manual', 'koreksi'])
                                   ->whereNotNull('siswa_id')
                                   ->pluck('siswa_id')
                                   ->unique();

        return [
            'total_masuk'      => $masukIds->count(),
            'total_pulang'     => (clone $base)->where('tipe', 'pulang')
                                                ->whereIn('status', ['normal', 'manual', 'koreksi'])
                                                ->whereNotNull('siswa_id')
                                                ->distinct('siswa_id')->count('siswa_id'),
            'belum_hadir'      => max(0, $totalSiswa - $masukIds->count()),
            'scan_manual'      => (clone $base)->where('is_manual', true)->count(),
            'scan_duplikat'    => (clone $base)->where('status', 'duplikat')->count(),
            'tidak_dikenal'    => (clone $base)->whereNull('siswa_id')->count(),
            'total_siswa'      => $totalSiswa,
            'persentase_hadir' => $totalSiswa > 0
                ? round(($masukIds->count() / $totalSiswa) * 100, 1)
                : 0,
        ];
    }
}