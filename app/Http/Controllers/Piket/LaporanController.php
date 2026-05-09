<?php

namespace App\Http\Controllers\Piket;

use App\Http\Controllers\Controller;
use App\Models\IzinKeluarSiswa;
use App\Models\LaporanHarianPiket;
use App\Models\LogPiket;
use App\Models\Pelanggaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LaporanController extends Controller
{
    // =========================================================================
    // FORM BUAT / EDIT LAPORAN HARIAN
    // =========================================================================

    public function harian(): View|RedirectResponse
    {
        $userId   = Auth::id();
        $logAktif = $this->getLogAktif($userId);

        // Wajib check-in untuk membuat laporan — berbeda dengan riwayat & show
        if (! $logAktif) {
            return redirect()
                ->route('piket.log.checkin')
                ->with('error', 'Check-in terlebih dahulu untuk membuat laporan harian.');
        }

        // Laporan hari ini jika sudah pernah dibuat (untuk mode edit)
        $laporanHariIni = LaporanHarianPiket::where('dibuat_oleh', $userId)
            ->whereDate('tanggal', today())
            ->first();

        // Pelanggaran yang dicatat oleh user ini hari ini
        $pelanggaranHariIni = Pelanggaran::with(['siswa.kelas', 'kategori'])
            ->where('dicatat_oleh', $userId)
            ->whereDate('tanggal', today())
            ->get();

        // Semua izin keluar yang diajukan hari ini (bukan hanya milik piket ini)
        $izinHariIni = IzinKeluarSiswa::with('siswa.kelas')
            ->whereDate('tanggal', today())
            ->orderBy('jam_keluar')
            ->get();

        $ringkasanOtomatis = $this->buatRingkasanOtomatis(
            $logAktif,
            $pelanggaranHariIni,
            $izinHariIni,
        );

        return view('piket.laporan.harian', compact(
            'logAktif',
            'laporanHariIni',
            'pelanggaranHariIni',
            'izinHariIni',
            'ringkasanOtomatis',
        ));
    }

    // =========================================================================
    // SIMPAN LAPORAN HARIAN (create atau update)
    // =========================================================================

    public function simpanHarian(Request $request): RedirectResponse
    {
        $userId   = Auth::id();
        $logAktif = $this->getLogAktif($userId);

        if (! $logAktif) {
            return redirect()
                ->route('piket.log.checkin')
                ->with('error', 'Check-in terlebih dahulu untuk menyimpan laporan.');
        }

        $validated = $request->validate([
            'tanggal'         => ['required', 'date', 'before_or_equal:today'],
            'kondisi_sekolah' => ['required', 'string', 'max:2000'],
            'catatan_umum'    => ['nullable', 'string', 'max:2000'],
            'kejadian_khusus' => ['nullable', 'string', 'max:2000'],
            'tamu_penting'    => ['nullable', 'string', 'max:1000'],
        ], [
            'tanggal.required'             => 'Tanggal laporan wajib diisi.',
            'tanggal.before_or_equal'      => 'Tanggal laporan tidak boleh melebihi hari ini.',
            'kondisi_sekolah.required'     => 'Kondisi sekolah wajib diisi.',
            'kondisi_sekolah.max'          => 'Kondisi sekolah maksimal 2000 karakter.',
        ]);

        $validated['dibuat_oleh'] = $userId;

        LaporanHarianPiket::updateOrCreate(
            [
                'dibuat_oleh' => $userId,
                'tanggal'     => $validated['tanggal'],
            ],
            $validated
        );

        return redirect()
            ->route('piket.laporan.riwayat')
            ->with('success', 'Laporan harian berhasil disimpan.');
    }

    // =========================================================================
    // RIWAYAT LAPORAN
    // Tidak perlu check-in — piket boleh lihat riwayat laporan miliknya
    // kapan saja (termasuk setelah checkout)
    // =========================================================================

    public function riwayat(Request $request): View
    {
        $userId = Auth::id();

        $query = LaporanHarianPiket::where('dibuat_oleh', $userId)
            ->withCount('pelanggaran') // pakai relasi HasMany di model
            ->orderByDesc('tanggal');

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $laporan = $query->paginate(15)->withQueryString();

        // Daftar tahun yang ada laporannya — untuk dropdown filter
        $tahunList = LaporanHarianPiket::where('dibuat_oleh', $userId)
            ->selectRaw('YEAR(tanggal) as tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

        // Daftar bulan 1-12 — untuk dropdown filter
        $bulanList = collect(range(1, 12))->mapWithKeys(fn ($b) => [
            $b => Carbon::create()->month($b)->translatedFormat('F'),
        ]);

        // Apakah sedang aktif piket hari ini — untuk tampilkan tombol "Buat Laporan"
        $guruAktifId = $this->getLogAktif($userId) ? $userId : null;

        return view('piket.laporan.riwayat', compact(
            'laporan',
            'tahunList',
            'bulanList',
            'guruAktifId',
        ));
    }

    // =========================================================================
    // DETAIL LAPORAN
    // Ownership check: hanya pembuat yang boleh lihat detail laporannya
    // =========================================================================

    public function show(LaporanHarianPiket $laporan): View
    {
        abort_unless(
            $laporan->dibuat_oleh === Auth::id(),
            403,
            'Anda tidak berhak mengakses laporan ini.'
        );

        $laporan->load('dibuatOleh');

        // Izin keluar pada hari yang sama via helper model
        $izinHariIni   = $laporan->getIzinKeluarSiswa();
        $ringkasanIzin = $laporan->getRingkasanIzinKeluar();

        // Pelanggaran yang dicatat oleh pembuat laporan pada hari itu
        $pelanggaranHariItu = Pelanggaran::with(['siswa.kelas', 'kategori'])
            ->where('dicatat_oleh', $laporan->dibuat_oleh)
            ->whereDate('tanggal', $laporan->tanggal)
            ->orderBy('tanggal')
            ->get();

        // Log piket pembuat pada hari itu
        $logPiketHariItu = LogPiket::where('pengguna_id', $laporan->dibuat_oleh)
            ->whereDate('tanggal', $laporan->tanggal)
            ->first();

        return view('piket.laporan.show', compact(
            'laporan',
            'izinHariIni',
            'ringkasanIzin',
            'pelanggaranHariItu',
            'logPiketHariItu',
        ));
    }

    // =========================================================================
    // EXPORT PDF
    // Route: piket.laporan.export-pdf (terdaftar di sidebar)
    // =========================================================================

    public function exportPdf(Request $request)
    {
        $userId = Auth::id();

        $query = LaporanHarianPiket::where('dibuat_oleh', $userId)
            ->with('dibuatOleh')
            ->orderByDesc('tanggal');

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        // Batasi 100 baris agar PDF tidak timeout
        $laporan = $query->limit(100)->get();

        // Data pendukung untuk setiap laporan (izin + pelanggaran)
        $detailPerLaporan = $laporan->mapWithKeys(function ($lap) {
            return [
                $lap->id => [
                    'izin'        => $lap->getRingkasanIzinKeluar(),
                    'pelanggaran' => Pelanggaran::where('dicatat_oleh', $lap->dibuat_oleh)
                        ->whereDate('tanggal', $lap->tanggal)
                        ->count(),
                ],
            ];
        });

        $filterLabel = $this->buildFilterLabel($request);

        $pdf = Pdf::loadView(
            'piket.laporan.export-pdf',
            compact('laporan', 'detailPerLaporan', 'filterLabel')
        )->setPaper('a4', 'portrait');

        return $pdf->download('laporan-piket-' . now()->format('Ymd-His') . '.pdf');
    }

    // =========================================================================
    // PRIVATE HELPERS
    // =========================================================================

    /**
     * Ambil log piket aktif hari ini (sudah check-in, belum checkout).
     * Konsisten dengan PelanggaranController & IzinKeluarSiswaController:
     * pakai 'pengguna_id' sesuai kolom di tabel log_piket.
     */
    private function getLogAktif(int $userId): ?LogPiket
    {
        return LogPiket::where('pengguna_id', $userId)
            ->whereDate('tanggal', today())
            ->whereNotNull('masuk_pada')
            ->whereNull('keluar_pada')
            ->first();
    }

    /**
     * Buat ringkasan otomatis sebagai isian awal form laporan.
     * Handle semua edge case: log null, masuk_pada null, koleksi kosong.
     */
    private function buatRingkasanOtomatis(
        ?LogPiket $log,
        \Illuminate\Support\Collection $pelanggaran,
        \Illuminate\Support\Collection $izin,
    ): string {
        $parts = [];

        if ($log) {
            // masuk_pada selalu ada jika log aktif (sudah check-in)
            // tapi kita handle null untuk keamanan
            $masuk = $log->masuk_pada
                ? Carbon::parse($log->masuk_pada)->format('H:i')
                : '-';

            // keluar_pada null artinya belum checkout — wajar saat form dibuka
            $keluar = $log->keluar_pada
                ? Carbon::parse($log->keluar_pada)->format('H:i')
                : 'belum selesai';

            $parts[] = "Piket dilaksanakan pukul {$masuk} s.d. {$keluar}.";
        }

        if ($pelanggaran->isNotEmpty()) {
            $parts[] = "Terdapat {$pelanggaran->count()} pelanggaran siswa yang dicatat.";
        }

        if ($izin->isNotEmpty()) {
            // Hitung izin yang disetujui (termasuk yang sudah kembali)
            $disetujui = $izin->whereIn('status', [
                IzinKeluarSiswa::STATUS_DISETUJUI,
                IzinKeluarSiswa::STATUS_SUDAH_KEMBALI,
            ])->count();

            $parts[] = "Izin keluar siswa: {$izin->count()} pengajuan, {$disetujui} disetujui.";
        }

        return implode(' ', $parts) ?: 'Tidak ada kejadian khusus hari ini.';
    }

    /**
     * Label filter untuk header PDF — dipakai buildFilterLabel().
     */
    private function buildFilterLabel(Request $request): string
    {
        $parts = [];

        if ($request->filled('bulan')) {
            $parts[] = 'Bulan: ' . Carbon::create()->month($request->bulan)->translatedFormat('F');
        }

        if ($request->filled('tahun')) {
            $parts[] = 'Tahun: ' . $request->tahun;
        }

        return implode(', ', $parts) ?: 'Semua laporan';
    }
}