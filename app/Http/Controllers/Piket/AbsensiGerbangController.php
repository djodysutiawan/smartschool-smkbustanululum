<?php

namespace App\Http\Controllers\Piket;

use App\Http\Controllers\Controller;
use App\Models\AbsensiGerbang;
use App\Models\Kelas;
use App\Models\SesiGerbang;
use App\Models\Siswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AbsensiGerbangController extends Controller
{
    // ── live ──────────────────────────────────────────────────────────────────

    /**
     * Halaman live monitor — tampilan real-time scan masuk & pulang.
     * Ini adalah halaman utama piket saat berjaga di pos gerbang.
     *
     * Render awal sudah berisi data scan terbaru (SSR), setelah itu
     * JS melakukan polling ke ajaxLive() setiap beberapa detik.
     */
    public function live(): View
    {
        $sesiAktif    = SesiGerbang::sesiAktifSekarang();
        $scanTerakhir = collect();

        if ($sesiAktif) {
            $scanTerakhir = $sesiAktif->absensiGerbang()
                ->with([
                    'siswa:id,nama_lengkap,nis,kelas_id',
                    'siswa.kelas:id,nama_kelas',
                    'guru:id,nama_lengkap,nip',
                ])
                ->orderByDesc('id')
                ->limit(30)
                ->get();
        }

        $statistik = $this->hitungStatistikHarian(now()->toDateString());

        // Semua sesi hari ini (untuk tombol ganti sesi / tutup sesi dari live monitor)
        $sesiHariIni = SesiGerbang::hariIni()
            ->with('dibukaOleh:id,name')
            ->orderByDesc('dibuka_pada')
            ->get();

        return view('piket.absensi-gerbang.live', compact(
            'sesiAktif',
            'scanTerakhir',
            'statistik',
            'sesiHariIni',
        ));
    }

    // ── rekap ─────────────────────────────────────────────────────────────────

    /**
     * Rekap kehadiran harian — siapa saja yang sudah / belum scan.
     * Filter: tanggal, tipe (masuk|pulang), kelas, pencarian nama/NIS.
     */
    public function rekap(Request $request): View
    {
        $tanggal = $request->input('tanggal', now()->toDateString());

        // Validasi format tanggal agar tidak bisa inject nilai aneh
        if (! preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal)) {
            $tanggal = now()->toDateString();
        }

        $query = AbsensiGerbang::with([
                'siswa.kelas',
                'guru',
                'sesiGerbang',
                'inputOleh:id,name',
            ])
            ->where('tanggal_scan', $tanggal);

        if ($request->filled('tipe') && in_array($request->tipe, ['masuk', 'pulang'])) {
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
                  )
                  ->orWhereHas('guru', fn ($sq) =>
                      $sq->where('nama_lengkap', 'like', "%{$cari}%")
                         ->orWhere('nip', 'like', "%{$cari}%")
                  );
            });
        }

        $scanList  = $query->orderByDesc('waktu_scan')->paginate(30)->withQueryString();
        $kelasList = Kelas::aktif()->orderBy('tingkat')->orderBy('nama_kelas')->get();
        $statistik = $this->hitungStatistikHarian(
            $tanggal,
            $request->filled('kelas_id') ? (int) $request->kelas_id : null
        );
        $sesiAktif = SesiGerbang::sesiAktifSekarang();

        return view('piket.absensi-gerbang.rekap', compact(
            'scanList',
            'kelasList',
            'statistik',
            'sesiAktif',
            'tanggal',
        ));
    }

    // ── belumHadir ────────────────────────────────────────────────────────────

    /**
     * Daftar siswa yang belum scan masuk hari ini.
     * Piket menggunakan ini untuk mendata ketidakhadiran & menghubungi wali kelas.
     */
    public function belumHadir(Request $request): View
    {
        $tanggal = $request->input('tanggal', now()->toDateString());

        if (! preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal)) {
            $tanggal = now()->toDateString();
        }

        $sudahHadirIds = AbsensiGerbang::where('tipe', 'masuk')
            ->where('tanggal_scan', $tanggal)
            ->whereIn('status', ['normal', 'manual', 'koreksi'])
            ->whereNotNull('siswa_id')
            ->pluck('siswa_id');

        $query = Siswa::aktif()
            ->with('kelas')
            ->whereNotIn('id', $sudahHadirIds);

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', (int) $request->kelas_id);
        }

        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function ($q) use ($cari) {
                $q->where('nama_lengkap', 'like', "%{$cari}%")
                  ->orWhere('nis', 'like', "%{$cari}%");
            });
        }

        $belumHadirList = $query->orderBy('nama_lengkap')->paginate(30)->withQueryString();

        $kelasList = Kelas::aktif()->orderBy('tingkat')->orderBy('nama_kelas')->get();

        $totalSiswaAktif = Siswa::aktif()
            ->when($request->filled('kelas_id'), fn ($q) => $q->where('kelas_id', (int) $request->kelas_id))
            ->count();

        $jumlahSudahHadir = $request->filled('kelas_id')
            ? AbsensiGerbang::where('tipe', 'masuk')
                ->where('tanggal_scan', $tanggal)
                ->whereIn('status', ['normal', 'manual', 'koreksi'])
                ->whereNotNull('siswa_id')
                ->whereHas('siswa', fn ($q) => $q->where('kelas_id', (int) $request->kelas_id))
                ->distinct('siswa_id')->count('siswa_id')
            : $sudahHadirIds->count();

        $statistik = [
            'total_siswa' => $totalSiswaAktif,
            'sudah_hadir' => $jumlahSudahHadir,
            'belum_hadir' => $belumHadirList->total(),
            'persentase'  => $totalSiswaAktif > 0
                ? round(($jumlahSudahHadir / $totalSiswaAktif) * 100, 1)
                : 0,
        ];

        return view('piket.absensi-gerbang.belum-hadir', compact(
            'belumHadirList',
            'kelasList',
            'statistik',
            'tanggal',
        ));
    }

    // ── scanManual ────────────────────────────────────────────────────────────

    /**
     * Form scan manual — input NIS / nama siswa tanpa alat scanner.
     * Digunakan saat alat rusak, siswa lupa bawa kartu, atau kartu rusak.
     */
    public function scanManual(): View
    {
        $sesiAktif = SesiGerbang::sesiAktifSekarang();
        $kelasList = Kelas::aktif()->orderBy('tingkat')->orderBy('nama_kelas')->get();

        // Sesi hari ini untuk pilihan manual jika tidak ada sesi aktif
        $sesiHariIni = SesiGerbang::hariIni()
            ->orderByDesc('dibuka_pada')
            ->get();

        return view('piket.absensi-gerbang.scan-manual', compact(
            'sesiAktif',
            'kelasList',
            'sesiHariIni',
        ));
    }

    // ── prosesScanManual ──────────────────────────────────────────────────────

    /**
     * Simpan input manual absensi gerbang oleh piket.
     * Hanya untuk siswa — input manual guru tidak ada di fitur ini.
     */
    public function prosesScanManual(Request $request): RedirectResponse
    {
        $request->validate([
            'sesi_gerbang_id' => ['required', 'exists:sesi_gerbang,id'],
            'siswa_id'        => ['required', 'exists:siswa,id'],
            'tipe'            => ['nullable', 'in:masuk,pulang'],
            'catatan'         => ['nullable', 'string', 'max:500'],
        ]);

        $sesi  = SesiGerbang::findOrFail($request->sesi_gerbang_id);
        $siswa = Siswa::findOrFail($request->siswa_id);

        if ($sesi->status !== 'aktif') {
            return back()
                ->with('error', 'Sesi yang dipilih sudah ditutup. Pilih sesi aktif atau buka sesi baru.')
                ->withInput();
        }

        $tipe = $request->filled('tipe') ? $request->tipe : $sesi->tipe;

        $sudahAbsen = AbsensiGerbang::where('sesi_gerbang_id', $sesi->id)
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

        return back()->with('success', "Absensi manual {$siswa->nama_lengkap} ({$tipe}) berhasil disimpan.");
    }

    // ── edit ──────────────────────────────────────────────────────────────────

    /**
     * Form koreksi / edit data scan.
     * Piket bisa mengedit scan jika ada kesalahan (mis. siswa scan di sesi salah).
     */
    public function edit(AbsensiGerbang $absensiGerbang): View
    {
        $absensiGerbang->load([
            'siswa.kelas',
            'guru',
            'sesiGerbang',
            'inputOleh:id,name',
            'hasilKoreksi.siswa',
        ]);

        return view('piket.absensi-gerbang.edit', compact('absensiGerbang'));
    }

    // ── update ────────────────────────────────────────────────────────────────

    /**
     * Simpan perubahan catatan scan.
     * Piket hanya bisa mengubah catatan — perubahan tipe/siswa harus lewat koreksi().
     */
    public function update(Request $request, AbsensiGerbang $absensiGerbang): RedirectResponse
    {
        $request->validate([
            'catatan' => ['nullable', 'string', 'max:500'],
        ]);

        $absensiGerbang->update(['catatan' => $request->catatan]);

        return redirect()
            ->route('piket.absensi-gerbang.rekap', ['tanggal' => $absensiGerbang->tanggal_scan->toDateString()])
            ->with('success', 'Catatan scan berhasil diperbarui.');
    }

    // ── destroy ───────────────────────────────────────────────────────────────

    /**
     * Hapus record scan.
     *
     * Piket boleh menghapus jika:
     *  - Scan manual (is_manual = true), ATAU
     *  - Kode tidak dikenal (siswa_id = null DAN guru_id = null)
     *
     * Scan dari alat yang sudah teridentifikasi → hanya admin.
     * Scan yang sudah dikoreksi → tidak bisa dihapus siapapun (integritas data).
     */
    public function destroy(AbsensiGerbang $absensiGerbang): RedirectResponse
    {
        if ($absensiGerbang->hasilKoreksi()->exists()) {
            return back()->with('error', 'Record ini sudah dikoreksi dan tidak bisa dihapus.');
        }

        $bolehHapus = $absensiGerbang->is_manual
            || ($absensiGerbang->siswa_id === null && $absensiGerbang->guru_id === null);

        if (! $bolehHapus) {
            return back()->with('error',
                'Scan dari alat yang sudah teridentifikasi hanya bisa dihapus oleh admin. '
                . 'Gunakan fitur Koreksi jika ada kesalahan tipe scan.'
            );
        }

        $absensiGerbang->delete();

        return back()->with('success', 'Record scan berhasil dihapus.');
    }

    // ── koreksi ───────────────────────────────────────────────────────────────

    /**
     * Koreksi tipe scan (masuk → pulang atau sebaliknya).
     *
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

        if ($absensiGerbang->hasilKoreksi()->exists()) {
            return back()->with('error', 'Record ini sudah dikoreksi sebelumnya.');
        }

        /** @var \App\Models\User $authUser */
        $authUser = Auth::user();

        try {
            $absensiGerbang->koreksi(
                inputOleh: $authUser->id,
                tipeBaru:  $request->tipe_baru,
                catatan:   $request->catatan,
            );
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal melakukan koreksi: ' . $e->getMessage());
        }

        return redirect()
            ->route('piket.absensi-gerbang.rekap', ['tanggal' => $absensiGerbang->tanggal_scan->toDateString()])
            ->with('success', 'Koreksi tipe scan berhasil disimpan.');
    }

    // ── exportPdf ─────────────────────────────────────────────────────────────

    /**
     * Export log scan harian ke PDF — untuk arsip laporan piket.
     * Piket hanya bisa export per tanggal (bukan rekap multi-bulan).
     */
    public function exportPdf(Request $request): mixed
    {
        $tanggal = $request->input('tanggal', now()->toDateString());

        if (! preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal)) {
            $tanggal = now()->toDateString();
        }

        $query = AbsensiGerbang::with([
                'siswa.kelas',
                'guru',
                'sesiGerbang',
                'inputOleh:id,name',
            ])
            ->where('tanggal_scan', $tanggal)
            ->whereIn('status', ['normal', 'manual', 'koreksi']);

        if ($request->filled('tipe') && in_array($request->tipe, ['masuk', 'pulang'])) {
            $query->where('tipe', $request->tipe);
        }

        if ($request->filled('kelas_id')) {
            $query->whereHas('siswa', fn ($q) => $q->where('kelas_id', (int) $request->kelas_id));
        }

        $scanList  = $query->orderBy('tipe')->orderBy('waktu_scan')->get();
        $statistik = $this->hitungStatistikHarian(
            $tanggal,
            $request->filled('kelas_id') ? (int) $request->kelas_id : null
        );

        /** @var \App\Models\User $authUser */
        $authUser = Auth::user();

        $kelasLabel = 'Semua Kelas';
        if ($request->filled('kelas_id')) {
            $kelas = Kelas::find((int) $request->kelas_id);
            $kelasLabel = $kelas?->nama_kelas ?? 'Semua Kelas';
        }

        $filter = [
            'tanggal'      => $tanggal,
            'tipe'         => $request->tipe,
            'kelas_id'     => $request->kelas_id,
            'kelas_label'  => $kelasLabel,
            'dicetak_pada' => now()->isoFormat('D MMMM Y, HH:mm'),
            'dicetak_oleh' => $authUser->name,
        ];

        $pdf = Pdf::loadView(
            'piket.absensi-gerbang.export-pdf',
            compact('scanList', 'statistik', 'filter')
        )->setPaper('a4', 'portrait');

        return $pdf->download('absensi-gerbang-' . $tanggal . '.pdf');
    }

    // ── exportBelumHadirPdf ───────────────────────────────────────────────────

    /**
     * Export daftar siswa belum hadir ke PDF.
     * Piket butuh ini untuk diserahkan ke wali kelas / kepala sekolah.
     */
    public function exportBelumHadirPdf(Request $request): mixed
    {
        $tanggal = $request->input('tanggal', now()->toDateString());

        if (! preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal)) {
            $tanggal = now()->toDateString();
        }

        $sudahHadirIds = AbsensiGerbang::where('tipe', 'masuk')
            ->where('tanggal_scan', $tanggal)
            ->whereIn('status', ['normal', 'manual', 'koreksi'])
            ->whereNotNull('siswa_id')
            ->pluck('siswa_id');

        $query = Siswa::aktif()->with('kelas')->whereNotIn('id', $sudahHadirIds);

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', (int) $request->kelas_id);
        }

        $belumHadirList = $query->orderBy('nama_lengkap')->get();

        /** @var \App\Models\User $authUser */
        $authUser = Auth::user();

        $kelasLabel = 'Semua Kelas';
        if ($request->filled('kelas_id')) {
            $kelas = Kelas::find((int) $request->kelas_id);
            $kelasLabel = $kelas?->nama_kelas ?? 'Semua Kelas';
        }

        $filter = [
            'tanggal'      => $tanggal,
            'kelas_label'  => $kelasLabel,
            'dicetak_pada' => now()->isoFormat('D MMMM Y, HH:mm'),
            'dicetak_oleh' => $authUser->name,
        ];

        $pdf = Pdf::loadView(
            'piket.absensi-gerbang.belum-hadir-export-pdf',
            compact('belumHadirList', 'filter')
        )->setPaper('a4', 'portrait');

        return $pdf->download('belum-hadir-' . $tanggal . '.pdf');
    }

    // ── webhook ───────────────────────────────────────────────────────────────

    /**
     * Endpoint penerima data dari alat scanner hardware (POST dari device).
     * Tidak memerlukan session auth — withoutMiddleware di route.
     *
     * Alat mengirim: kode_scan + opsional sesi_gerbang_id.
     * Jika sesi_gerbang_id tidak dikirim, sistem auto-detect sesi aktif.
     *
     * Menggunakan AbsensiGerbang::rekamScan() agar logika duplikat
     * dan pendeteksian pemilik (siswa/guru) terpusat di model.
     */
    public function webhook(Request $request): JsonResponse
    {
        $request->validate([
            'kode_scan'       => ['required', 'string', 'max:100'],
            'sesi_gerbang_id' => ['nullable', 'integer', 'exists:sesi_gerbang,id'],
        ]);

        // Cari sesi aktif
        $sesi = $request->filled('sesi_gerbang_id')
            ? SesiGerbang::find($request->sesi_gerbang_id)
            : SesiGerbang::sesiAktifSekarang();

        if (! $sesi || $sesi->status !== 'aktif') {
            return response()->json([
                'status'  => 'error',
                'message' => 'Tidak ada sesi aktif. Minta guru piket membuka sesi terlebih dahulu.',
            ], 422);
        }

        // Gunakan rekamScan() — sudah handle siswa, guru, duplikat, tidak_dikenal
        $scan = AbsensiGerbang::rekamScan($sesi, $request->kode_scan);

        // Refresh relasi untuk response
        $scan->loadMissing(['siswa.kelas', 'guru']);

        // Bangun label nama & kelas berdasarkan tipe pemilik
        $namaPemilik = $scan->nama_pemilik;
        $kelasPemilik = match ($scan->tipe_pemilik) {
            'siswa'  => $scan->siswa?->kelas?->nama_kelas ?? '-',
            'guru'   => 'Guru',
            default  => '-',
        };
        $nisPemilik = match ($scan->tipe_pemilik) {
            'siswa'  => $scan->siswa?->nis ?? '-',
            'guru'   => $scan->guru?->nip ?? '-',
            default  => '-',
        };

        $httpStatus = $scan->status === 'duplikat' ? 200 : 201;

        $message = match ($scan->status) {
            'normal', 'manual' => "Berhasil: {$namaPemilik} ({$scan->tipe})",
            'duplikat'         => "Sudah tercatat {$scan->tipe}: {$namaPemilik}",
            default            => 'Kode tidak dikenal — scan tetap direkam.',
        };

        return response()->json([
            'status'     => $scan->status,
            'message'    => $message,
            'nama'       => $namaPemilik,
            'identitas'  => $nisPemilik,
            'kelas'      => $kelasPemilik,
            'tipe_scan'  => $scan->tipe,
            'waktu_scan' => $scan->waktu_scan->format('H:i:s'),
        ], $httpStatus);
    }

    // ── ajaxLive ──────────────────────────────────────────────────────────────

    /**
     * JSON untuk live monitor — polling dari frontend setiap N detik.
     * Mengembalikan scan terbaru + statistik sesi aktif.
     *
     * Query param:
     *   last_id (int) — hanya kembalikan scan setelah ID ini (efisiensi polling)
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

        $lastId = max(0, (int) $request->input('last_id', 0));

        $scanBaru = AbsensiGerbang::with([
                'siswa:id,nama_lengkap,nis,kelas_id',
                'siswa.kelas:id,nama_kelas',
                'guru:id,nama_lengkap,nip',
            ])
            ->where('sesi_gerbang_id', $sesiAktif->id)
            ->when($lastId > 0, fn ($q) => $q->where('id', '>', $lastId))
            ->orderByDesc('id')
            ->limit(20)
            ->get()
            ->map(fn ($scan) => [
                'id'           => $scan->id,
                'nama'         => $scan->nama_pemilik,
                'identitas'    => match ($scan->tipe_pemilik) {
                    'siswa'  => $scan->siswa?->nis ?? '-',
                    'guru'   => $scan->guru?->nip ?? '-',
                    default  => '-',
                },
                'kelas'        => match ($scan->tipe_pemilik) {
                    'siswa'  => $scan->siswa?->kelas?->nama_kelas ?? '-',
                    'guru'   => 'Guru',
                    default  => '-',
                },
                'tipe_pemilik' => $scan->tipe_pemilik,
                'tipe'         => $scan->tipe,
                'label_tipe'   => $scan->label_tipe,
                'status'       => $scan->status,
                'label_status' => $scan->label_status,
                'is_manual'    => $scan->is_manual,
                'dikenal'      => $scan->dikenal,
                'waktu_scan'   => $scan->waktu_scan->format('H:i:s'),
                'kode_scan'    => $scan->kode_scan,
            ]);

        // Hitung statistik langsung dari query untuk menghindari N+1
        $baseQuery = fn () => $sesiAktif->absensiGerbang();

        $statistik = [
            'total_masuk'   => $baseQuery()->where('tipe', 'masuk')
                                  ->whereIn('status', ['normal', 'manual', 'koreksi'])
                                  ->count(),
            'total_pulang'  => $baseQuery()->where('tipe', 'pulang')
                                  ->whereIn('status', ['normal', 'manual', 'koreksi'])
                                  ->count(),
            'duplikat'      => $baseQuery()->where('status', 'duplikat')->count(),
            'tidak_dikenal' => $baseQuery()->whereNull('siswa_id')->whereNull('guru_id')->count(),
            'last_id'       => $baseQuery()->max('id') ?? 0,
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
     * Hitung statistik absensi siswa harian.
     * Catatan: statistik guru tidak dimasukkan di sini karena scope halaman
     * ini adalah absensi siswa gerbang. Statistik guru ada di AbsensiGuruController.
     */
    private function hitungStatistikHarian(string $tanggal, ?int $kelasId = null): array
    {
        $base = AbsensiGerbang::where('tanggal_scan', $tanggal)
            ->untukSiswa(); // hanya scan siswa

        if ($kelasId) {
            $base->whereHas('siswa', fn ($q) => $q->where('kelas_id', $kelasId));
        }

        $totalSiswa = Siswa::aktif()
            ->when($kelasId, fn ($q) => $q->where('kelas_id', $kelasId))
            ->count();

        $masukIds = (clone $base)
            ->where('tipe', 'masuk')
            ->whereIn('status', ['normal', 'manual', 'koreksi'])
            ->whereNotNull('siswa_id')
            ->pluck('siswa_id')
            ->unique();

        return [
            'total_masuk'      => $masukIds->count(),
            'total_pulang'     => (clone $base)
                ->where('tipe', 'pulang')
                ->whereIn('status', ['normal', 'manual', 'koreksi'])
                ->whereNotNull('siswa_id')
                ->distinct('siswa_id')->count('siswa_id'),
            'belum_hadir'      => max(0, $totalSiswa - $masukIds->count()),
            'scan_manual'      => (clone $base)->where('is_manual', true)->count(),
            'scan_duplikat'    => (clone $base)->where('status', 'duplikat')->count(),
            'tidak_dikenal'    => (clone $base)->whereNull('siswa_id')->whereNull('guru_id')->count(),
            'total_siswa'      => $totalSiswa,
            'persentase_hadir' => $totalSiswa > 0
                ? round(($masukIds->count() / $totalSiswa) * 100, 1)
                : 0,
        ];
    }
}