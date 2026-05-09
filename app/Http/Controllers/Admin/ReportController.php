<?php

namespace App\Http\Controllers\Admin;

use App\Exports\AbsensiExport;
use App\Exports\IzinKeluarSiswaExport;
use App\Exports\NilaiExport;
use App\Exports\PelanggaranExport;
use App\Exports\SiswaExport;
use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Guru;
use App\Models\IzinKeluarSiswa;
use App\Models\JurnalMengajar;
use App\Models\Kelas;
use App\Models\LogPiket;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\Pelanggaran;
use App\Models\KategoriPelanggaran;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    // ─── DASHBOARD ───────────────────────────────────────────────────────────

    public function index()
    {
        $stats = [
            'total_siswa'        => Siswa::aktif()->count(),
            'total_guru'         => Guru::aktif()->count(),
            'total_pelanggaran'  => Pelanggaran::whereMonth('tanggal', now()->month)->count(),
            'kehadiran_hari_ini' => Absensi::whereDate('tanggal', today())
                                     ->whereIn('status', ['hadir', 'telat'])->count(),
            'izin_keluar_hari_ini' => IzinKeluarSiswa::hariIni()->count(),
            'izin_sedang_keluar'   => IzinKeluarSiswa::belumKembali()->count(),
        ];

        $tahunAjaranAktif = TahunAjaran::getAktif();
        $tahunAjaranList  = TahunAjaran::orderByDesc('id')->get();
        $kelasList        = Kelas::aktif()->orderBy('nama_kelas')->get();

        return view('admin.laporan.index', compact(
            'stats', 'tahunAjaranAktif', 'tahunAjaranList', 'kelasList'
        ));
    }

    // ─── ABSENSI ─────────────────────────────────────────────────────────────

    public function attendance(Request $request)
    {
        $query = Absensi::with(['siswa.kelas', 'dicatatOleh'])->orderByDesc('tanggal');
        $this->applyAbsensiFilters($query, $request);
        $absensi    = $query->paginate(25)->withQueryString();
        $kelasList  = Kelas::aktif()->orderBy('nama_kelas')->get();
        $statusList = ['hadir', 'telat', 'izin', 'sakit', 'alfa'];
        $metodeList = ['manual', 'qr_code'];

        // Rekap dengan clone query agar filter aktif ikut terhitung
        $rekapQ = Absensi::query();
        $this->applyAbsensiFilters($rekapQ, $request);
        $rekap = [
            'hadir' => (clone $rekapQ)->whereIn('status', ['hadir', 'telat'])->count(),
            'izin'  => (clone $rekapQ)->where('status', 'izin')->count(),
            'sakit' => (clone $rekapQ)->where('status', 'sakit')->count(),
            'alfa'  => (clone $rekapQ)->where('status', 'alfa')->count(),
        ];

        // FIX: Tren 14 hari — gunakan satu GROUP BY query, bukan 28 query terpisah.
        // Sebelumnya ada loop for($i=13; $i>=0; $i--) yang memanggil Absensi::whereDate()
        // dua kali per iterasi = 28 query N+1.
        $tren14Hari = Absensi::select(
                DB::raw('DATE(tanggal) as tgl'),
                DB::raw("SUM(CASE WHEN status IN ('hadir','telat') THEN 1 ELSE 0 END) as hadir"),
                DB::raw("SUM(CASE WHEN status IN ('izin','sakit','alfa') THEN 1 ELSE 0 END) as tidak")
            )
            ->whereDate('tanggal', '>=', now()->subDays(13)->toDateString())
            ->groupBy(DB::raw('DATE(tanggal)'))
            ->orderBy('tgl')
            ->get()
            ->keyBy('tgl');

        // Bangun array label + data lengkap 14 hari (isi 0 untuk hari tanpa data)
        $trendLabels = [];
        $trendHadir  = [];
        $trendTidak  = [];
        for ($i = 13; $i >= 0; $i--) {
            $date          = now()->subDays($i)->toDateString();
            $trendLabels[] = now()->subDays($i)->format('d/m');
            $trendHadir[]  = $tren14Hari->get($date)?->hadir ?? 0;
            $trendTidak[]  = $tren14Hari->get($date)?->tidak ?? 0;
        }

        // FIX: statusCount — hitung per status dari seluruh DB (bukan filter aktif),
        // untuk keperluan chart distribusi global.
        $statusCount = Absensi::select('status', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('status')
            ->pluck('jumlah', 'status')
            ->toArray();

        // Pastikan semua key ada meski nilainya 0
        foreach (['hadir', 'telat', 'izin', 'sakit', 'alfa'] as $s) {
            $statusCount[$s] = $statusCount[$s] ?? 0;
        }

        return view('admin.laporan.absensi', compact(
            'absensi', 'kelasList', 'statusList', 'metodeList',
            'rekap', 'trendLabels', 'trendHadir', 'trendTidak', 'statusCount'
        ));
    }

    public function exportAttendancePdf(Request $request)
    {
        $query = Absensi::with(['siswa.kelas', 'dicatatOleh'])->orderByDesc('tanggal');
        $this->applyAbsensiFilters($query, $request);
        $data         = $query->get();
        $generated_at = now()->format('d M Y, H:i');

        $pdf = Pdf::loadView('admin.laporan.exports.absensi-pdf', compact('data', 'generated_at'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-absensi-' . now()->format('Ymd') . '.pdf');
    }

    public function exportAttendanceExcel(Request $request)
    {
        return Excel::download(
            new AbsensiExport($request->all()),
            'laporan-absensi-' . now()->format('Ymd') . '.xlsx'
        );
    }

    // ─── NILAI ───────────────────────────────────────────────────────────────

    public function grades(Request $request)
    {
        $query = Nilai::with(['siswa.kelas', 'mataPelajaran', 'guru', 'tahunAjaran'])
            ->orderByDesc('created_at');
        $this->applyNilaiFilters($query, $request);
        $nilai        = $query->paginate(25)->withQueryString();
        $kelasList    = Kelas::aktif()->orderBy('nama_kelas')->get();
        $mapelList    = MataPelajaran::aktif()->orderBy('nama_mapel')->get();
        // FIX: orderByDesc('id') lebih reliable daripada orderByDesc('tahun')
        // karena 'tahun' adalah string "2024/2025" yang sort-nya tidak terprediksi.
        $tahunAjaran  = TahunAjaran::orderByDesc('id')->get();
        $predikatList = ['A', 'B', 'C', 'D', 'E'];

        $avgQ     = Nilai::query();
        $this->applyNilaiFilters($avgQ, $request);
        $avgNilai = round($avgQ->avg('nilai_akhir') ?? 0, 1);

        // FIX: stats & chart data — gunakan satu query GROUP BY per kebutuhan,
        // bukan 5+ query COUNT terpisah untuk predikat.
        $predikatCounts = Nilai::select('predikat', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('predikat')
            ->pluck('jumlah', 'predikat')
            ->toArray();

        $stats = [
            'rata_nilai' => $avgNilai,
            'predikat_A' => $predikatCounts['A'] ?? 0,
            'predikat_E' => $predikatCounts['E'] ?? 0,
            'bawah_kkm'  => Nilai::where('nilai_akhir', '<', 70)->count(),
        ];

        $predikatData = [];
        foreach (['A', 'B', 'C', 'D', 'E'] as $p) {
            $predikatData[$p] = $predikatCounts[$p] ?? 0;
        }

        // FIX: komponen rata-rata — satu query AVG per kolom vs 4 query terpisah.
        // Digabung via satu select agar lebih efisien.
        $komponenRow = Nilai::select(
            DB::raw('ROUND(AVG(nilai_tugas), 1)  as avg_tugas'),
            DB::raw('ROUND(AVG(nilai_harian), 1) as avg_harian'),
            DB::raw('ROUND(AVG(nilai_uts), 1)    as avg_uts'),
            DB::raw('ROUND(AVG(nilai_uas), 1)    as avg_uas')
        )->first();

        $komponenData = [
            'Tugas'  => $komponenRow?->avg_tugas  ?? 0,
            'Harian' => $komponenRow?->avg_harian ?? 0,
            'UTS'    => $komponenRow?->avg_uts    ?? 0,
            'UAS'    => $komponenRow?->avg_uas    ?? 0,
        ];

        $rentangData = [
            '90-100' => Nilai::whereBetween('nilai_akhir', [90, 100])->count(),
            '80-89'  => Nilai::whereBetween('nilai_akhir', [80, 89])->count(),
            '70-79'  => Nilai::whereBetween('nilai_akhir', [70, 79])->count(),
            '60-69'  => Nilai::whereBetween('nilai_akhir', [60, 69])->count(),
            '<60'    => Nilai::where('nilai_akhir', '<', 60)->count(),
        ];

        return view('admin.laporan.nilai', compact(
            'nilai', 'kelasList', 'mapelList', 'tahunAjaran', 'predikatList',
            'avgNilai', 'stats', 'predikatData', 'komponenData', 'rentangData'
        ));
    }

    public function exportGradesPdf(Request $request)
    {
        $query = Nilai::with(['siswa.kelas', 'mataPelajaran', 'guru', 'tahunAjaran'])
            ->orderByDesc('created_at');
        $this->applyNilaiFilters($query, $request);
        $data         = $query->get();
        $generated_at = now()->format('d M Y, H:i');

        $pdf = Pdf::loadView('admin.laporan.exports.nilai-pdf', compact('data', 'generated_at'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-nilai-' . now()->format('Ymd') . '.pdf');
    }

    public function exportGradesExcel(Request $request)
    {
        return Excel::download(
            new NilaiExport($request->all()),
            'laporan-nilai-' . now()->format('Ymd') . '.xlsx'
        );
    }

    // ─── PELANGGARAN ─────────────────────────────────────────────────────────

    public function violation(Request $request)
    {
        $query = Pelanggaran::with(['siswa.kelas', 'kategori', 'dicatatOleh'])
            ->orderByDesc('tanggal');
        $this->applyPelanggaranFilters($query, $request);
        $pelanggaran  = $query->paginate(25)->withQueryString();
        $kelasList    = Kelas::aktif()->orderBy('nama_kelas')->get();
        $kategoriList = KategoriPelanggaran::orderBy('nama')->get();
        $siswas       = Siswa::aktif()->orderBy('nama_lengkap')->get();
        $kategoris    = $kategoriList; // alias agar view lama tetap bisa pakai $kategoris

        // FIX: gunakan satu GROUP BY untuk stats status, bukan 4 COUNT terpisah.
        $statusCounts = Pelanggaran::select('status', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('status')
            ->pluck('jumlah', 'status')
            ->toArray();

        $statsP = [
            'total'    => array_sum($statusCounts),
            'diproses' => $statusCounts['diproses']   ?? 0,
            'selesai'  => $statusCounts['selesai']    ?? 0,
            'banding'  => $statusCounts['banding']    ?? 0,
            'pending'    => $statusCounts['pending']    ?? 0,
            'dibatalkan' => $statusCounts['dibatalkan'] ?? 0,
        ];

        return view('admin.laporan.pelanggaran', compact(
            'pelanggaran', 'kelasList', 'kategoriList', 'siswas', 'kategoris', 'statsP'
        ));
    }

    public function exportViolationPdf(Request $request)
    {
        $query = Pelanggaran::with(['siswa.kelas', 'kategori', 'dicatatOleh'])
            ->orderByDesc('tanggal');
        $this->applyPelanggaranFilters($query, $request);
        $data         = $query->get();
        $generated_at = now()->format('d M Y, H:i');

        $pdf = Pdf::loadView('admin.laporan.exports.pelanggaran-pdf', compact('data', 'generated_at'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-pelanggaran-' . now()->format('Ymd') . '.pdf');
    }

    public function exportViolationExcel(Request $request)
    {
        return Excel::download(
            new PelanggaranExport($request->all()),
            'laporan-pelanggaran-' . now()->format('Ymd') . '.xlsx'
        );
    }

    // ─── SISWA ───────────────────────────────────────────────────────────────

    public function student(Request $request)
    {
        $query = Siswa::with(['kelas.tahunAjaran', 'pengguna'])->orderBy('nama_lengkap');
        $this->applySiswaFilters($query, $request);
        $siswa           = $query->paginate(25)->withQueryString();
        $kelas           = Kelas::aktif()->orderBy('nama_kelas')->get();
        $kelasList       = $kelas;
        $tahunAjaranList = TahunAjaran::orderByDesc('id')->get();

        // FIX: gunakan satu GROUP BY untuk jenis kelamin, bukan 2 COUNT terpisah.
        $jkCounts = Siswa::aktif()
            ->select('jenis_kelamin', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('jenis_kelamin')
            ->pluck('jumlah', 'jenis_kelamin')
            ->toArray();

        $statsS = [
            'total'     => Siswa::count(),
            'aktif'     => Siswa::aktif()->count(),
            'laki'      => $jkCounts['L'] ?? 0,
            'perempuan' => $jkCounts['P'] ?? 0,
        ];

        return view('admin.laporan.siswa', compact(
            'siswa', 'kelas', 'kelasList', 'tahunAjaranList', 'statsS'
        ));
    }

    public function exportStudentPdf(Request $request)
    {
        $query = Siswa::with(['kelas.tahunAjaran', 'pengguna'])->orderBy('nama_lengkap');
        $this->applySiswaFilters($query, $request);
        $data         = $query->get();
        $generated_at = now()->format('d M Y, H:i');

        $pdf = Pdf::loadView('admin.laporan.exports.siswa-pdf', compact('data', 'generated_at'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('laporan-siswa-' . now()->format('Ymd') . '.pdf');
    }

    public function exportStudentExcel(Request $request)
    {
        return Excel::download(
            new SiswaExport($request->all()),
            'laporan-siswa-' . now()->format('Ymd') . '.xlsx'
        );
    }

    // ─── GURU ────────────────────────────────────────────────────────────────

    public function teacher(Request $request)
    {
        $query = Guru::with(['pengguna'])->orderBy('nama_lengkap');
        $this->applyGuruFilters($query, $request);
        $guru = $query->paginate(25)->withQueryString();

        // FIX: gunakan satu GROUP BY untuk jenis kelamin guru.
        $jkCounts = Guru::aktif()
            ->select('jenis_kelamin', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('jenis_kelamin')
            ->pluck('jumlah', 'jenis_kelamin')
            ->toArray();

        $statsG = [
            'total'     => Guru::count(),
            'aktif'     => Guru::aktif()->count(),
            'laki'      => $jkCounts['L'] ?? 0,
            'perempuan' => $jkCounts['P'] ?? 0,
        ];

        return view('admin.laporan.guru', compact('guru', 'statsG'));
    }

    public function exportTeacherPdf(Request $request)
    {
        $query = Guru::with(['pengguna'])->orderBy('nama_lengkap');
        $this->applyGuruFilters($query, $request);
        $data         = $query->get();
        $generated_at = now()->format('d M Y, H:i');

        $pdf = Pdf::loadView('admin.laporan.exports.guru-pdf', compact('data', 'generated_at'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('laporan-guru-' . now()->format('Ymd') . '.pdf');
    }

    public function exportTeacherExcel(Request $request)
    {
        return Excel::download(
            new \App\Exports\GuruExport($request->all()),
            'laporan-guru-' . now()->format('Ymd') . '.xlsx'
        );
    }

    // ─── JURNAL MENGAJAR ─────────────────────────────────────────────────────

    /**
     * Laporan jurnal mengajar guru.
     * Model: JurnalMengajar (relasi: guru, kelas, mataPelajaran, tahunAjaran)
     */
    public function teachingJournal(Request $request)
    {
        // Eager load hanya relasi yang BENAR-BENAR ada di model
        $query = JurnalMengajar::with(['guru', 'kelas', 'mataPelajaran', 'diverifikasiOleh'])
            ->orderByDesc('tanggal');
    
        $this->applyJurnalFilters($query, $request);
    
        $jurnal    = $query->paginate(25)->withQueryString();
        $guruList  = Guru::aktif()->orderBy('nama_lengkap')->get();
        $kelasList = Kelas::aktif()->orderBy('nama_kelas')->get();
        $mapelList = MataPelajaran::aktif()->orderBy('nama_mapel')->get();
        // Tidak ada tahunAjaran di model — $tahunAjaran dikirim kosong
        // agar filter dropdown di view tidak error jika masih ada
        $tahunAjaran = collect();
    
        // Stats — "status" diturunkan dari diverifikasi_pada (bukan kolom status)
        // disetujui  = sudah diverifikasi (diverifikasi_pada NOT NULL)
        // menunggu   = belum diverifikasi (diverifikasi_pada IS NULL)
        // Tidak ada kolom ditolak/draft di model ini
        $totalJurnal  = JurnalMengajar::count();
        $disetujui    = JurnalMengajar::whereNotNull('diverifikasi_pada')->count();
        $menunggu     = JurnalMengajar::whereNull('diverifikasi_pada')->count();
        $bulanIni     = JurnalMengajar::whereMonth('tanggal', now()->month)
                            ->whereYear('tanggal', now()->year)->count();
    
        $statsJ = [
            'total'      => $totalJurnal,
            'bulan_ini'  => $bulanIni,
            'disetujui'  => $disetujui,
            'menunggu'   => $menunggu,
            'ditolak'    => 0, // tidak ada di model, diisi 0 agar view tidak error
        ];
    
        // Tren 14 hari — satu GROUP BY query
        $tren14Hari = JurnalMengajar::select(
                DB::raw('DATE(tanggal) as tgl'),
                DB::raw('COUNT(*) as jumlah'),
                DB::raw('SUM(CASE WHEN diverifikasi_pada IS NOT NULL THEN 1 ELSE 0 END) as diverifikasi'),
                DB::raw('SUM(CASE WHEN diverifikasi_pada IS NULL THEN 1 ELSE 0 END) as belum')
            )
            ->whereDate('tanggal', '>=', now()->subDays(13)->toDateString())
            ->groupBy(DB::raw('DATE(tanggal)'))
            ->orderBy('tgl')
            ->get()
            ->keyBy('tgl');
    
        $trendLabels      = [];
        $trendJurnal      = [];
        $trendDiverifikasi = [];
        $trendBelum       = [];
    
        for ($i = 13; $i >= 0; $i--) {
            $date               = now()->subDays($i)->toDateString();
            $trendLabels[]      = now()->subDays($i)->format('d/m');
            $trendJurnal[]      = $tren14Hari->get($date)?->jumlah      ?? 0;
            $trendDiverifikasi[]= $tren14Hari->get($date)?->diverifikasi ?? 0;
            $trendBelum[]       = $tren14Hari->get($date)?->belum        ?? 0;
        }
    
        return view('admin.laporan.jurnal-mengajar', compact(
            'jurnal', 'guruList', 'kelasList', 'mapelList', 'tahunAjaran',
            'statsJ', 'trendLabels', 'trendJurnal', 'trendDiverifikasi', 'trendBelum'
        ));
    }

    public function exportTeachingJournalPdf(Request $request)
    {
        $query = JurnalMengajar::with(['guru', 'kelas', 'mataPelajaran', 'diverifikasiOleh'])
            ->orderByDesc('tanggal');
        $this->applyJurnalFilters($query, $request);
        $data         = $query->get();
        $generated_at = now()->format('d M Y, H:i');
    
        $pdf = Pdf::loadView('admin.laporan.exports.jurnal-mengajar-pdf', compact('data', 'generated_at'))
            ->setPaper('a4', 'landscape');
    
        return $pdf->download('laporan-jurnal-mengajar-' . now()->format('Ymd') . '.pdf');
    }
 
    public function exportTeachingJournalExcel(Request $request)
    {
        return Excel::download(
            new \App\Exports\JurnalMengajarExport($request->all()),
            'laporan-jurnal-mengajar-' . now()->format('Ymd') . '.xlsx'
        );
    }

    // ─── LOG PIKET ───────────────────────────────────────────────────────────

    /**
     * Laporan log piket guru.
     * Model: LogPiket (relasi: guru [via guru_id], pengguna [via pengguna_id])
     * Cast di model: tanggal:date, masuk_pada:datetime, keluar_pada:datetime
     */
    public function piketLog(Request $request)
    {
        $query = LogPiket::with(['guru', 'pengguna'])
            ->orderByDesc('tanggal')
            ->orderByDesc('masuk_pada');
        $this->applyLogPiketFilters($query, $request);
        $logs = $query->paginate(25)->withQueryString();

        $guruList = Guru::aktif()->orderBy('nama_lengkap')->get();

        // FIX: stats via satu GROUP BY — bukan N query terpisah.
        // Status ditentukan dari kombinasi masuk_pada & keluar_pada.
        $statsLP = [
            'total'        => LogPiket::count(),
            'bulan_ini'    => LogPiket::whereMonth('tanggal', now()->month)
                                  ->whereYear('tanggal', now()->year)->count(),
            // Sedang bertugas hari ini: masuk tapi belum keluar
            'bertugas'     => LogPiket::whereDate('tanggal', today())
                                  ->whereNotNull('masuk_pada')
                                  ->whereNull('keluar_pada')->count(),
            // Sudah selesai hari ini: sudah keluar
            'selesai_hari_ini' => LogPiket::whereDate('tanggal', today())
                                      ->whereNotNull('keluar_pada')->count(),
        ];

        // Tren 14 hari — satu GROUP BY query
        $tren14Hari = LogPiket::select(
                DB::raw('DATE(tanggal) as tgl'),
                DB::raw('COUNT(*) as jumlah')
            )
            ->whereDate('tanggal', '>=', now()->subDays(13)->toDateString())
            ->groupBy(DB::raw('DATE(tanggal)'))
            ->orderBy('tgl')
            ->get()
            ->keyBy('tgl');

        $trendLabels  = [];
        $trendLogPiket = [];
        for ($i = 13; $i >= 0; $i--) {
            $date            = now()->subDays($i)->toDateString();
            $trendLabels[]   = now()->subDays($i)->format('d/m');
            $trendLogPiket[] = $tren14Hari->get($date)?->jumlah ?? 0;
        }

        // Distribusi per shift
        $distribusiShift = LogPiket::select('shift', DB::raw('COUNT(*) as jumlah'))
            ->whereNotNull('shift')
            ->groupBy('shift')
            ->pluck('jumlah', 'shift')
            ->toArray();

        return view('admin.laporan.log-piket', compact(
            'logs', 'guruList',
            'statsLP', 'trendLabels', 'trendLogPiket', 'distribusiShift'
        ));
    }

    public function exportPiketLogPdf(Request $request)
    {
        $query = LogPiket::with(['guru', 'pengguna'])
            ->orderByDesc('tanggal')
            ->orderByDesc('masuk_pada');
        $this->applyLogPiketFilters($query, $request);
        $logs         = $query->get();
        $generated_at = now()->format('d M Y, H:i');

        $pdf = Pdf::loadView('admin.laporan.exports.log-piket-pdf', compact('logs', 'generated_at'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-log-piket-' . now()->format('Ymd') . '.pdf');
    }

    public function exportPiketLogExcel(Request $request)
    {
        return Excel::download(
            new \App\Exports\LogPiketExport($request->all()),
            'laporan-log-piket-' . now()->format('Ymd') . '.xlsx'
        );
    }

    // ─── UJIAN ───────────────────────────────────────────────────────────────

    /**
     * Laporan ujian siswa.
     *
     * Model yang diasumsikan tersedia: \App\Models\HasilUjian atau \App\Models\Ujian.
     * Sesuaikan nama model, relasi, dan kolom dengan model yang ada di project Anda.
     *
     * Relasi yang diasumsikan:
     *   HasilUjian: siswa (BelongsTo), ujian (BelongsTo → judul, tanggal)
     *   Ujian: mataPelajaran (BelongsTo), guru (BelongsTo), kelas (BelongsTo)
     *
     * Jika model berbeda, sesuaikan nama class di bawah ini.
     */
    public function exam(Request $request)
    {
        if (! class_exists(\App\Models\Ujian::class)) {
            return view('admin.laporan.ujian', [
                'ujians'       => collect(),
                'kelasList'    => Kelas::aktif()->orderBy('nama_kelas')->get(),
                'mapelList'    => MataPelajaran::aktif()->orderBy('nama_mapel')->get(),
                'tahunAjaran'  => TahunAjaran::orderByDesc('id')->get(),
                'guruList'     => Guru::aktif()->orderBy('nama_lengkap')->get(),
                'statsU'       => ['total' => 0, 'bulan_ini' => 0, 'aktif' => 0, 'tidak_aktif' => 0],
                'trendLabels'  => [],
                'trendUjian'   => [],
            ]);
        }

        $query = \App\Models\Ujian::with(['mataPelajaran', 'guru', 'kelas', 'tahunAjaran'])
            ->orderByDesc('tanggal');
        $this->applyUjianFilters($query, $request);
        $ujians = $query->paginate(25)->withQueryString();

        $kelasList   = Kelas::aktif()->orderBy('nama_kelas')->get();
        $mapelList   = MataPelajaran::aktif()->orderBy('nama_mapel')->get();
        $tahunAjaran = TahunAjaran::orderByDesc('id')->get();
        $guruList    = Guru::aktif()->orderBy('nama_lengkap')->get();

        // is_active (boolean) bukan kolom 'status'
        $statsU = [
            'total'       => \App\Models\Ujian::count(),
            'bulan_ini'   => \App\Models\Ujian::whereMonth('tanggal', now()->month)
                                ->whereYear('tanggal', now()->year)->count(),
            'aktif'       => \App\Models\Ujian::where('is_active', true)->count(),
            'tidak_aktif' => \App\Models\Ujian::where('is_active', false)->count(),
        ];

        // Tren 14 hari — GROUP BY tanggal (bukan tanggal_mulai)
        $tren14Hari = \App\Models\Ujian::select(
                DB::raw('DATE(tanggal) as tgl'),
                DB::raw('COUNT(*) as jumlah')
            )
            ->whereDate('tanggal', '>=', now()->subDays(13)->toDateString())
            ->groupBy(DB::raw('DATE(tanggal)'))
            ->orderBy('tgl')
            ->get()
            ->keyBy('tgl');

        $trendLabels = [];
        $trendUjian  = [];
        for ($i = 13; $i >= 0; $i--) {
            $date          = now()->subDays($i)->toDateString();
            $trendLabels[] = now()->subDays($i)->format('d/m');
            $trendUjian[]  = $tren14Hari->get($date)?->jumlah ?? 0;
        }

        return view('admin.laporan.ujian', compact(
            'ujians', 'kelasList', 'mapelList', 'tahunAjaran', 'guruList',
            'statsU', 'trendLabels', 'trendUjian'
        ));
    }

    public function exportExamPdf(Request $request)
    {
        if (! class_exists(\App\Models\Ujian::class)) {
            return back()->with('error', 'Model Ujian belum tersedia.');
        }

        $query = \App\Models\Ujian::with(['mataPelajaran', 'guru', 'kelas', 'tahunAjaran'])
            ->orderByDesc('tanggal');
        $this->applyUjianFilters($query, $request);
        $data         = $query->get();
        $generated_at = now()->format('d M Y, H:i');

        $pdf = Pdf::loadView('admin.laporan.exports.ujian-pdf', compact('data', 'generated_at'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-ujian-' . now()->format('Ymd') . '.pdf');
    }

    public function exportExamExcel(Request $request)
    {
        if (! class_exists(\App\Models\Ujian::class)) {
            return back()->with('error', 'Model Ujian belum tersedia.');
        }

        return Excel::download(
            new \App\Exports\UjianExport($request->all()),
            'laporan-ujian-' . now()->format('Ymd') . '.xlsx'
        );
    }

    // ─── IZIN KELUAR SISWA ───────────────────────────────────────────────────

    public function izinKeluar(Request $request)
    {
        $query = IzinKeluarSiswa::with(['siswa.kelas', 'diprosesOleh', 'tahunAjaran'])
            ->orderByDesc('tanggal')
            ->orderByDesc('id');

        $this->applyIzinKeluarFilters($query, $request);

        $izins        = $query->paginate(25)->withQueryString();
        $kelasList    = Kelas::aktif()->orderBy('nama_kelas')->get();
        $tahunAjarans = TahunAjaran::orderByDesc('id')->get();

        // Stats ringkasan via GROUP BY
        $statusCounts = IzinKeluarSiswa::select('status', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('status')
            ->pluck('jumlah', 'status')
            ->toArray();

        $statsI = [
            'total'         => array_sum($statusCounts),
            'bulan_ini'     => IzinKeluarSiswa::whereMonth('tanggal', now()->month)
                                    ->whereYear('tanggal', now()->year)->count(),
            'disetujui'     => $statusCounts[IzinKeluarSiswa::STATUS_DISETUJUI]     ?? 0,
            'ditolak'       => $statusCounts[IzinKeluarSiswa::STATUS_DITOLAK]       ?? 0,
            'menunggu'      => $statusCounts[IzinKeluarSiswa::STATUS_MENUNGGU]      ?? 0,
            'sudah_kembali' => $statusCounts[IzinKeluarSiswa::STATUS_SUDAH_KEMBALI] ?? 0,
        ];

        // FIX: Tren 14 hari — satu GROUP BY, bukan 28 query terpisah.
        $tren14Hari = IzinKeluarSiswa::select(
                DB::raw('DATE(tanggal) as tgl'),
                DB::raw("SUM(CASE WHEN status != '" . IzinKeluarSiswa::STATUS_DITOLAK . "' AND status != '" . IzinKeluarSiswa::STATUS_MENUNGGU . "' THEN 1 ELSE 0 END) as disetujui"),
                DB::raw("SUM(CASE WHEN status = '" . IzinKeluarSiswa::STATUS_DITOLAK . "' THEN 1 ELSE 0 END) as ditolak")
            )
            ->whereDate('tanggal', '>=', now()->subDays(13)->toDateString())
            ->groupBy(DB::raw('DATE(tanggal)'))
            ->orderBy('tgl')
            ->get()
            ->keyBy('tgl');

        $trendLabels    = [];
        $trendDisetujui = [];
        $trendDitolak   = [];
        for ($i = 13; $i >= 0; $i--) {
            $date             = now()->subDays($i)->toDateString();
            $trendLabels[]    = now()->subDays($i)->format('d/m');
            $trendDisetujui[] = $tren14Hari->get($date)?->disetujui ?? 0;
            $trendDitolak[]   = $tren14Hari->get($date)?->ditolak   ?? 0;
        }

        // Distribusi per kategori
        $distribusiKategori = [];
        foreach (IzinKeluarSiswa::KATEGORI_LIST as $key => $label) {
            $distribusiKategori[$label] = IzinKeluarSiswa::where('kategori', $key)->count();
        }

        return view('admin.laporan.izin-keluar', compact(
            'izins', 'kelasList', 'tahunAjarans',
            'statsI', 'trendLabels', 'trendDisetujui', 'trendDitolak',
            'distribusiKategori'
        ));
    }

    public function exportIzinKeluarPdf(Request $request)
    {
        $query = IzinKeluarSiswa::with(['siswa.kelas', 'diprosesOleh', 'tahunAjaran'])
            ->orderByDesc('tanggal');
        $this->applyIzinKeluarFilters($query, $request);
        $data         = $query->get();
        $generated_at = now()->format('d M Y, H:i');

        $pdf = Pdf::loadView('admin.laporan.exports.izin-keluar-pdf', compact('data', 'generated_at'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-izin-keluar-siswa-' . now()->format('Ymd') . '.pdf');
    }

    public function exportIzinKeluarExcel(Request $request)
    {
        return Excel::download(
            new IzinKeluarSiswaExport($request->all()),
            'laporan-izin-keluar-siswa-' . now()->format('Ymd') . '.xlsx'
        );
    }

    // ─── HELPERS ─────────────────────────────────────────────────────────────

    private function applyAbsensiFilters($q, Request $r): void
    {
        if ($r->filled('tanggal_dari'))   $q->whereDate('tanggal', '>=', $r->tanggal_dari);
        if ($r->filled('tanggal_sampai')) $q->whereDate('tanggal', '<=', $r->tanggal_sampai);
        // FIX: absensi punya kelas_id langsung di tabel — tidak perlu whereHas
        if ($r->filled('kelas_id'))       $q->where('kelas_id', $r->kelas_id);
        if ($r->filled('status'))         $q->where('status', $r->status);
        if ($r->filled('metode'))         $q->where('metode', $r->metode);
        if ($r->filled('search')) {
            $s = $r->search;
            $q->whereHas('siswa', fn($q2) => $q2
                ->where('nama_lengkap', 'like', "%{$s}%")
                ->orWhere('nis', 'like', "%{$s}%")
            );
        }
    }

    private function applyNilaiFilters($q, Request $r): void
    {
        if ($r->filled('tahun_ajaran_id'))   $q->where('tahun_ajaran_id', $r->tahun_ajaran_id);
        if ($r->filled('kelas_id'))          $q->where('kelas_id', $r->kelas_id);
        if ($r->filled('mata_pelajaran_id')) $q->where('mata_pelajaran_id', $r->mata_pelajaran_id);
        if ($r->filled('predikat'))          $q->where('predikat', $r->predikat);
        if ($r->filled('search')) {
            $s = $r->search;
            $q->whereHas('siswa', fn($q2) => $q2
                ->where('nama_lengkap', 'like', "%{$s}%")
                ->orWhere('nis', 'like', "%{$s}%")
            );
        }
    }

    private function applyPelanggaranFilters($q, Request $r): void
    {
        if ($r->filled('tanggal_dari'))   $q->whereDate('tanggal', '>=', $r->tanggal_dari);
        if ($r->filled('tanggal_sampai')) $q->whereDate('tanggal', '<=', $r->tanggal_sampai);
        if ($r->filled('kelas_id'))       $q->whereHas('siswa', fn($s) => $s->where('kelas_id', $r->kelas_id));
        if ($r->filled('kategori_id'))    $q->where('kategori_pelanggaran_id', $r->kategori_id);
        if ($r->filled('status'))         $q->where('status', $r->status);
        if ($r->filled('siswa_id'))       $q->where('siswa_id', $r->siswa_id);
        if ($r->filled('search')) {
            $s = $r->search;
            $q->whereHas('siswa', fn($q2) => $q2
                ->where('nama_lengkap', 'like', "%{$s}%")
                ->orWhere('nis', 'like', "%{$s}%")
            );
        }
    }

    private function applySiswaFilters($q, Request $r): void
    {
        if ($r->filled('kelas_id'))        $q->where('kelas_id', $r->kelas_id);
        if ($r->filled('tahun_ajaran_id')) $q->where('tahun_ajaran_id', $r->tahun_ajaran_id);
        if ($r->filled('jenis_kelamin'))   $q->where('jenis_kelamin', $r->jenis_kelamin);
        if ($r->filled('status'))          $q->where('status', $r->status);
        if ($r->filled('search')) {
            $s = $r->search;
            $q->where(fn($q2) => $q2
                ->where('nama_lengkap', 'like', "%{$s}%")
                ->orWhere('nis',        'like', "%{$s}%")
                ->orWhere('nisn',       'like', "%{$s}%"));
        }
    }

    private function applyGuruFilters($q, Request $r): void
    {
        if ($r->filled('status'))        $q->where('status', $r->status);
        if ($r->filled('jenis_kelamin')) $q->where('jenis_kelamin', $r->jenis_kelamin);
        // FIX: filter status_kepegawaian ditambahkan karena ada di model Guru
        if ($r->filled('status_kepegawaian')) $q->where('status_kepegawaian', $r->status_kepegawaian);
        if ($r->filled('search')) {
            $s = $r->search;
            $q->where(fn($q2) => $q2
                ->where('nama_lengkap', 'like', "%{$s}%")
                ->orWhere('nip',        'like', "%{$s}%"));
        }
    }

    /**
     * Filter jurnal mengajar.
     * Kolom yang diasumsikan ada di tabel jurnal_mengajar:
     * tanggal, guru_id, kelas_id, mata_pelajaran_id, tahun_ajaran_id, status
     */
    private function applyJurnalFilters($q, Request $r): void
    {
        if ($r->filled('tanggal_dari'))      $q->whereDate('tanggal', '>=', $r->tanggal_dari);
        if ($r->filled('tanggal_sampai'))    $q->whereDate('tanggal', '<=', $r->tanggal_sampai);
        if ($r->filled('guru_id'))           $q->where('guru_id', $r->guru_id);
        if ($r->filled('kelas_id'))          $q->where('kelas_id', $r->kelas_id);
        if ($r->filled('mata_pelajaran_id')) $q->where('mata_pelajaran_id', $r->mata_pelajaran_id);
    
        // "status" di filter → diterjemahkan ke kondisi diverifikasi_pada
        if ($r->filled('status')) {
            match ($r->status) {
                'disetujui' => $q->whereNotNull('diverifikasi_pada'),
                'menunggu'  => $q->whereNull('diverifikasi_pada'),
                default     => null,
            };
        }
    
        // Search: materi_ajar (bukan materi_pokok) atau nama guru
        if ($r->filled('search')) {
            $s = $r->search;
            $q->where(fn($q2) => $q2
                ->where('materi_ajar', 'like', "%{$s}%")
                ->orWhereHas('guru', fn($g) => $g->where('nama_lengkap', 'like', "%{$s}%"))
            );
        }
    
        // tahun_ajaran_id & status (kolom) DIHAPUS — tidak ada di model
    }

    /**
     * Filter log piket.
     * Kolom yang ada di model LogPiket: tanggal (date), pengguna_id, shift
     * Relasi: guru (via guru_id), pengguna (via pengguna_id)
     */
    private function applyLogPiketFilters($q, Request $r): void
    {
        if ($r->filled('tanggal_dari'))   $q->whereDate('tanggal', '>=', $r->tanggal_dari);
        if ($r->filled('tanggal_sampai')) $q->whereDate('tanggal', '<=', $r->tanggal_sampai);
        if ($r->filled('shift'))          $q->where('shift', $r->shift);
        // FIX: LogPiket punya kolom pengguna_id (bukan guru_id langsung di beberapa
        // implementasi). Gunakan guru_id jika relasi guru via guru_id.
        if ($r->filled('guru_id'))        $q->where('guru_id', $r->guru_id);
        if ($r->filled('status')) {
            // Status diturunkan dari kondisi masuk_pada & keluar_pada, bukan kolom status.
            // Mapping status filter ke kondisi query.
            match ($r->status) {
                'bertugas' => $q->whereNotNull('masuk_pada')->whereNull('keluar_pada'),
                'selesai'  => $q->whereNotNull('keluar_pada'),
                'belum'    => $q->whereNull('masuk_pada'),
                default    => null,
            };
        }
        if ($r->filled('search')) {
            $s = $r->search;
            $q->whereHas('guru', fn($g) => $g->where('nama_lengkap', 'like', "%{$s}%"));
        }
    }

    /**
     * Filter ujian.
     * Kolom yang diasumsikan: tanggal_mulai, kelas_id, mata_pelajaran_id,
     * guru_id, tahun_ajaran_id, status
     */
    private function applyUjianFilters($q, Request $r): void
    {
        if ($r->filled('tanggal_dari'))      $q->whereDate('tanggal', '>=', $r->tanggal_dari);
        if ($r->filled('tanggal_sampai'))    $q->whereDate('tanggal', '<=', $r->tanggal_sampai);
        if ($r->filled('kelas_id'))          $q->where('kelas_id', $r->kelas_id);
        if ($r->filled('mata_pelajaran_id')) $q->where('mata_pelajaran_id', $r->mata_pelajaran_id);
        if ($r->filled('guru_id'))           $q->where('guru_id', $r->guru_id);
        if ($r->filled('tahun_ajaran_id'))   $q->where('tahun_ajaran_id', $r->tahun_ajaran_id);
        if ($r->filled('status'))            $q->where('status', $r->status);
        if ($r->filled('search')) {
            $s = $r->search;
            $q->where(fn($q2) => $q2
                ->where('judul', 'like', "%{$s}%")
                ->orWhereHas('mataPelajaran', fn($m) => $m->where('nama_mapel', 'like', "%{$s}%"))
            );
        }
    }

    private function applyIzinKeluarFilters($q, Request $r): void
    {
        if ($r->filled('tanggal_dari'))    $q->whereDate('tanggal', '>=', $r->tanggal_dari);
        if ($r->filled('tanggal_sampai'))  $q->whereDate('tanggal', '<=', $r->tanggal_sampai);
        if ($r->filled('status'))          $q->where('status', $r->status);
        if ($r->filled('kategori'))        $q->where('kategori', $r->kategori);
        if ($r->filled('tahun_ajaran_id')) $q->where('tahun_ajaran_id', $r->tahun_ajaran_id);
        if ($r->filled('kelas_id')) {
            $q->whereHas('siswa', fn($s) => $s->where('kelas_id', $r->kelas_id));
        }
        if ($r->filled('search')) {
            $s = $r->search;
            $q->where(fn($q2) => $q2
                ->whereHas('siswa', fn($s2) => $s2->where('nama_lengkap', 'like', "%{$s}%"))
                ->orWhere('nomor_surat', 'like', "%{$s}%")
                ->orWhere('tujuan',      'like', "%{$s}%"));
        }
    }


}