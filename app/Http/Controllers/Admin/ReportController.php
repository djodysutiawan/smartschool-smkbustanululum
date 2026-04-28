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
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\Pelanggaran;
use App\Models\KategoriPelanggaran;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
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
            // Tambahan: izin keluar hari ini untuk summary dashboard
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

        $rekapQ = Absensi::query();
        $this->applyAbsensiFilters($rekapQ, $request);
        $rekap = [
            'hadir' => (clone $rekapQ)->whereIn('status', ['hadir', 'telat'])->count(),
            'izin'  => (clone $rekapQ)->where('status', 'izin')->count(),
            'sakit' => (clone $rekapQ)->where('status', 'sakit')->count(),
            'alfa'  => (clone $rekapQ)->where('status', 'alfa')->count(),
        ];

        // Tren 14 hari terakhir
        $trendLabels = [];
        $trendHadir  = [];
        $trendTidak  = [];
        for ($i = 13; $i >= 0; $i--) {
            $date          = now()->subDays($i);
            $trendLabels[] = $date->format('d/m');
            $trendHadir[]  = Absensi::whereDate('tanggal', $date)
                                ->whereIn('status', ['hadir', 'telat'])->count();
            $trendTidak[]  = Absensi::whereDate('tanggal', $date)
                                ->whereIn('status', ['izin', 'sakit', 'alfa'])->count();
        }

        $statusCount = [
            'hadir' => Absensi::where('status', 'hadir')->count(),
            'telat' => Absensi::where('status', 'telat')->count(),
            'izin'  => Absensi::where('status', 'izin')->count(),
            'sakit' => Absensi::where('status', 'sakit')->count(),
            'alfa'  => Absensi::where('status', 'alfa')->count(),
        ];

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
        $tahunAjaran  = TahunAjaran::orderByDesc('id')->get();
        $predikatList = ['A', 'B', 'C', 'D', 'E'];

        $avgQ     = Nilai::query();
        $this->applyNilaiFilters($avgQ, $request);
        $avgNilai = round($avgQ->avg('nilai_akhir') ?? 0, 1);

        $stats = [
            'rata_nilai' => $avgNilai,
            'predikat_A' => Nilai::where('predikat', 'A')->count(),
            'predikat_E' => Nilai::where('predikat', 'E')->count(),
            'bawah_kkm'  => Nilai::where('nilai_akhir', '<', 70)->count(),
        ];

        $predikatData = [
            'A' => Nilai::where('predikat', 'A')->count(),
            'B' => Nilai::where('predikat', 'B')->count(),
            'C' => Nilai::where('predikat', 'C')->count(),
            'D' => Nilai::where('predikat', 'D')->count(),
            'E' => Nilai::where('predikat', 'E')->count(),
        ];

        $komponenData = [
            'Tugas'  => round(Nilai::avg('nilai_tugas') ?? 0, 1),
            'Harian' => round(Nilai::avg('nilai_harian') ?? 0, 1),
            'UTS'    => round(Nilai::avg('nilai_uts') ?? 0, 1),
            'UAS'    => round(Nilai::avg('nilai_uas') ?? 0, 1),
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
        $kategoris    = KategoriPelanggaran::orderBy('nama')->get();

        $statsP = [
            'total'    => Pelanggaran::count(),
            'diproses' => Pelanggaran::where('status', 'diproses')->count(),
            'selesai'  => Pelanggaran::where('status', 'selesai')->count(),
            'banding'  => Pelanggaran::where('status', 'banding')->count(),
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

        $statsS = [
            'total'     => Siswa::count(),
            'aktif'     => Siswa::aktif()->count(),
            'laki'      => Siswa::aktif()->where('jenis_kelamin', 'L')->count(),
            'perempuan' => Siswa::aktif()->where('jenis_kelamin', 'P')->count(),
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
    // Catatan: method teacher() & exportTeacher*() tidak ada di kode asli
    // yang diberikan — stub di bawah ini mengikuti pola yang sudah ada.

    public function teacher(Request $request)
    {
        $query = Guru::with(['pengguna'])->orderBy('nama_lengkap');
        $this->applyGuruFilters($query, $request);
        $guru  = $query->paginate(25)->withQueryString();

        $statsG = [
            'total'  => Guru::count(),
            'aktif'  => Guru::aktif()->count(),
            'laki'   => Guru::aktif()->where('jenis_kelamin', 'L')->count(),
            'perempuan' => Guru::aktif()->where('jenis_kelamin', 'P')->count(),
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
        // Buat GuruExport jika belum ada, mengikuti pola SiswaExport
        return Excel::download(
            new \App\Exports\GuruExport($request->all()),
            'laporan-guru-' . now()->format('Ymd') . '.xlsx'
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

        // ── Stats ringkasan ──────────────────────────────────────────────────
        $statsI = [
            'total'         => IzinKeluarSiswa::count(),
            'bulan_ini'     => IzinKeluarSiswa::whereMonth('tanggal', now()->month)
                                    ->whereYear('tanggal', now()->year)->count(),
            'disetujui'     => IzinKeluarSiswa::where('status', IzinKeluarSiswa::STATUS_DISETUJUI)->count(),
            'ditolak'       => IzinKeluarSiswa::where('status', IzinKeluarSiswa::STATUS_DITOLAK)->count(),
            'menunggu'      => IzinKeluarSiswa::where('status', IzinKeluarSiswa::STATUS_MENUNGGU)->count(),
            'sudah_kembali' => IzinKeluarSiswa::where('status', IzinKeluarSiswa::STATUS_SUDAH_KEMBALI)->count(),
        ];

        // ── Tren 14 hari terakhir ────────────────────────────────────────────
        $trendLabels    = [];
        $trendDisetujui = [];
        $trendDitolak   = [];
        for ($i = 13; $i >= 0; $i--) {
            $date             = now()->subDays($i);
            $trendLabels[]    = $date->format('d/m');
            $trendDisetujui[] = IzinKeluarSiswa::whereDate('tanggal', $date)
                                    ->where('status', '!=', IzinKeluarSiswa::STATUS_MENUNGGU)
                                    ->where('status', '!=', IzinKeluarSiswa::STATUS_DITOLAK)
                                    ->count();
            $trendDitolak[]   = IzinKeluarSiswa::whereDate('tanggal', $date)
                                    ->where('status', IzinKeluarSiswa::STATUS_DITOLAK)
                                    ->count();
        }

        // ── Distribusi per kategori ──────────────────────────────────────────
        $distribusiKategori = [];
        foreach (IzinKeluarSiswa::KATEGORI_LIST as $key => $label) {
            $distribusiKategori[$label] = IzinKeluarSiswa::where('kategori', $key)->count();
        }

        return view('admin.laporan.izin-keluar', compact(
            'izins',
            'kelasList',
            'tahunAjarans',
            'statsI',
            'trendLabels',
            'trendDisetujui',
            'trendDitolak',
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
        if ($r->filled('kelas_id'))       $q->where('kelas_id', $r->kelas_id);
        if ($r->filled('status'))         $q->where('status', $r->status);
        if ($r->filled('metode'))         $q->where('metode', $r->metode);
    }

    private function applyNilaiFilters($q, Request $r): void
    {
        if ($r->filled('tahun_ajaran_id'))   $q->where('tahun_ajaran_id', $r->tahun_ajaran_id);
        if ($r->filled('kelas_id'))          $q->where('kelas_id', $r->kelas_id);
        if ($r->filled('mata_pelajaran_id')) $q->where('mata_pelajaran_id', $r->mata_pelajaran_id);
        if ($r->filled('predikat'))          $q->where('predikat', $r->predikat);
    }

    private function applyPelanggaranFilters($q, Request $r): void
    {
        if ($r->filled('tanggal_dari'))   $q->whereDate('tanggal', '>=', $r->tanggal_dari);
        if ($r->filled('tanggal_sampai')) $q->whereDate('tanggal', '<=', $r->tanggal_sampai);
        if ($r->filled('kelas_id'))       $q->whereHas('siswa', fn($s) => $s->where('kelas_id', $r->kelas_id));
        if ($r->filled('kategori_id'))    $q->where('kategori_pelanggaran_id', $r->kategori_id);
        if ($r->filled('status'))         $q->where('status', $r->status);
        if ($r->filled('siswa_id'))       $q->where('siswa_id', $r->siswa_id);
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
        if ($r->filled('search')) {
            $s = $r->search;
            $q->where(fn($q2) => $q2
                ->where('nama_lengkap', 'like', "%{$s}%")
                ->orWhere('nip',        'like', "%{$s}%"));
        }
    }

    private function applyIzinKeluarFilters($q, Request $r): void
    {
        if ($r->filled('tanggal_dari'))   $q->whereDate('tanggal', '>=', $r->tanggal_dari);
        if ($r->filled('tanggal_sampai')) $q->whereDate('tanggal', '<=', $r->tanggal_sampai);
        if ($r->filled('status'))         $q->where('status', $r->status);
        if ($r->filled('kategori'))       $q->where('kategori', $r->kategori);
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