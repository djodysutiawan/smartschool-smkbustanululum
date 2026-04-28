<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Guru;
use App\Models\IzinKeluarSiswa;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\Nilai;
use App\Models\Notifikasi;
use App\Models\Pelanggaran;
use App\Models\Pengumuman;
use App\Models\PengumpulanTugas;
use App\Models\Siswa;
use App\Models\Tugas;
use App\Models\Ujian;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * GET /api/admin/dashboard
     */
    public function index(): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // ── Statistik entitas utama ──────────────────────────────────────
        $totalSiswa = Siswa::count();
        $totalGuru  = Guru::count();
        $totalKelas = Kelas::count();
        $totalUser  = User::count();

        // ── Absensi hari ini ─────────────────────────────────────────────
        $absensiHariIniRaw = Absensi::whereDate('tanggal', today())
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $absensiHariIni = [
            'hadir' => ($absensiHariIniRaw['hadir'] ?? 0) + ($absensiHariIniRaw['telat'] ?? 0),
            'izin'  => $absensiHariIniRaw['izin']  ?? 0,
            'sakit' => $absensiHariIniRaw['sakit'] ?? 0,
            'alfa'  => $absensiHariIniRaw['alfa']  ?? 0,
        ];

        // ── Absensi bulan ini ────────────────────────────────────────────
        $absensiBulanIniRaw = Absensi::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $absensiBulanIni = [
            'hadir' => ($absensiBulanIniRaw['hadir'] ?? 0) + ($absensiBulanIniRaw['telat'] ?? 0),
            'izin'  => $absensiBulanIniRaw['izin']  ?? 0,
            'sakit' => $absensiBulanIniRaw['sakit'] ?? 0,
            'alfa'  => $absensiBulanIniRaw['alfa']  ?? 0,
        ];

        // ── Tren absensi 7 hari terakhir ─────────────────────────────────
        $trenAbsensi = Absensi::whereDate('tanggal', '>=', now()->subDays(6)->toDateString())
            ->whereDate('tanggal', '<=', today()->toDateString())
            ->select('tanggal', 'status', DB::raw('count(*) as total'))
            ->groupBy('tanggal', 'status')
            ->orderBy('tanggal')
            ->get()
            ->groupBy('tanggal')
            ->map(fn ($rows, $tanggal) => [
                'tanggal' => $tanggal,
                'hadir'   => $rows->whereIn('status', ['hadir', 'telat'])->sum('total'),
                'alpha'   => $rows->where('status', 'alfa')->sum('total'),
                'izin'    => $rows->where('status', 'izin')->sum('total'),
                'sakit'   => $rows->where('status', 'sakit')->sum('total'),
            ])
            ->values();

        // ── Pelanggaran ──────────────────────────────────────────────────
        $pelanggaranHariIni = Pelanggaran::whereDate('tanggal', today())
            ->where('status', '!=', 'dibatalkan')
            ->count();

        $pelanggaranBulanIni = Pelanggaran::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->where('status', '!=', 'dibatalkan')
            ->count();

        $pelanggaranTerbaru = Pelanggaran::with(['siswa.kelas', 'kategori', 'dicatatOleh'])
            ->where('status', '!=', 'dibatalkan')
            ->latest('tanggal')
            ->limit(5)
            ->get()
            ->map(fn ($p) => [
                'id'           => $p->id,
                'tanggal'      => $p->tanggal,
                'status'       => $p->status,
                'siswa'        => [
                    'id'           => $p->siswa?->id,
                    'nama_lengkap' => $p->siswa?->nama_lengkap,
                    'kelas'        => $p->siswa?->kelas?->nama_kelas,
                ],
                'kategori'     => $p->kategori?->nama,
                'dicatat_oleh' => $p->dicatatOleh?->name,
            ]);

        $siswaRawanPelanggaran = Siswa::select(
                'siswa.id', 'siswa.nama_lengkap', 'siswa.kelas_id',
                DB::raw('count(pelanggaran.id) as total_pelanggaran')
            )
            ->join('pelanggaran', 'pelanggaran.siswa_id', '=', 'siswa.id')
            ->whereYear('pelanggaran.tanggal', now()->year)
            ->where('pelanggaran.status', '!=', 'dibatalkan')
            ->groupBy('siswa.id', 'siswa.nama_lengkap', 'siswa.kelas_id')
            ->with('kelas')
            ->orderByDesc('total_pelanggaran')
            ->limit(5)
            ->get()
            ->map(fn ($s) => [
                'id'                => $s->id,
                'nama_lengkap'      => $s->nama_lengkap,
                'kelas'             => $s->kelas?->nama_kelas,
                'total_pelanggaran' => $s->total_pelanggaran,
            ]);

        // ── Tugas & Ujian ────────────────────────────────────────────────
        $totalTugas        = Tugas::where('dipublikasikan', true)->count();
        $tugasBelumDinilai = PengumpulanTugas::whereIn('status', ['dikumpulkan', 'terlambat'])->count();

        $now    = Carbon::now();
        $ujians = Ujian::with('mataPelajaran')
            ->whereDate('tanggal', '>=', $now->toDateString())
            ->whereDate('tanggal', '<=', $now->copy()->addDays(7)->toDateString())
            ->orderBy('tanggal')->orderBy('jam_mulai')
            ->get();

        $formatUjian = fn ($u) => [
            'id'             => $u->id,
            'judul'          => $u->judul,
            'jenis'          => $u->jenis,
            'tanggal'        => $u->tanggal,
            'jam_mulai'      => $u->jam_mulai,
            'durasi_menit'   => $u->durasi_menit,
            'mata_pelajaran' => $u->mataPelajaran?->nama_mapel,
        ];

        $ujianAktif     = $ujians->filter(fn ($u) => $u->sudahDimulai() && ! $u->sudahBerakhir())->values()->map($formatUjian);
        $ujianMendatang = $ujians->filter(fn ($u) => ! $u->sudahDimulai())->take(5)->values()->map($formatUjian);

        // ── Izin keluar ──────────────────────────────────────────────────
        $izinMenunggu     = IzinKeluarSiswa::where('status', IzinKeluarSiswa::STATUS_MENUNGGU)->count();
        $izinSedangKeluar = IzinKeluarSiswa::belumKembali()->count();

        // ── Nilai rata-rata per kelas (top 5) ────────────────────────────
        $rataRataNilaiPerKelas = Nilai::select(
                'siswa.kelas_id', 'kelas.nama_kelas',
                DB::raw('AVG(nilai.nilai_akhir) as rata')
            )
            ->join('siswa', 'siswa.id', '=', 'nilai.siswa_id')
            ->join('kelas', 'kelas.id', '=', 'siswa.kelas_id')
            ->groupBy('siswa.kelas_id', 'kelas.nama_kelas')
            ->orderByDesc('rata')
            ->limit(5)
            ->get()
            ->map(fn ($r) => [
                'kelas_id'   => $r->kelas_id,
                'nama_kelas' => $r->nama_kelas,
                'rata'       => round($r->rata, 2),
            ]);

        // ── Pengumuman aktif ─────────────────────────────────────────────
        $pengumuman = Pengumuman::whereNotNull('dipublikasikan_pada')
            ->where(fn ($q) => $q->whereNull('kadaluarsa_pada')->orWhere('kadaluarsa_pada', '>', now()))
            ->orderByDesc('dipinned')->orderByDesc('dipublikasikan_pada')
            ->take(3)->get()
            ->map(fn ($p) => [
                'id'                  => $p->id,
                'judul'               => $p->judul,
                'target_role'         => $p->target_role,
                'dipinned'            => (bool) $p->dipinned,
                'dipublikasikan_pada' => $p->dipublikasikan_pada,
                'kadaluarsa_pada'     => $p->kadaluarsa_pada,
            ]);

        // ── Jadwal hari ini ──────────────────────────────────────────────
        $hariIni       = strtolower(Carbon::now()->locale('id')->isoFormat('dddd'));
        $jadwalHariIni = JadwalPelajaran::with(['mataPelajaran', 'guru', 'kelas', 'ruang'])
            ->where('hari', $hariIni)->where('is_active', true)
            ->orderBy('jam_mulai')->limit(10)->get()
            ->map(fn ($j) => [
                'id'             => $j->id,
                'hari'           => $j->hari,
                'jam_mulai'      => $j->jam_mulai,
                'jam_selesai'    => $j->jam_selesai,
                'mata_pelajaran' => $j->mataPelajaran?->nama_mapel,
                'guru'           => $j->guru?->nama_lengkap,
                'kelas'          => $j->kelas?->nama_kelas,
                'ruang'          => $j->ruang?->nama_ruang,
            ]);

        // ── Notifikasi ───────────────────────────────────────────────────
        $unreadNotifikasi = Notifikasi::where('pengguna_id', $user->id)->where('sudah_dibaca', false)->count();

        $notifikasiTerbaru = Notifikasi::where('pengguna_id', $user->id)
            ->latest()->take(5)->get()
            ->map(fn ($n) => [
                'id'           => $n->id,
                'judul'        => $n->judul,
                'pesan'        => $n->pesan,
                'jenis'        => $n->jenis,
                'sudah_dibaca' => (bool) $n->sudah_dibaca,
                'url_tujuan'   => $n->url_tujuan,
                'created_at'   => $n->created_at,
            ]);

        return response()->json([
            'status' => 'success',
            'data'   => [
                'statistik' => [
                    'total_siswa' => $totalSiswa,
                    'total_guru'  => $totalGuru,
                    'total_kelas' => $totalKelas,
                    'total_user'  => $totalUser,
                ],
                'absensi' => [
                    'hari_ini'       => $absensiHariIni,
                    'total_hari_ini' => array_sum($absensiHariIni),
                    'bulan_ini'      => $absensiBulanIni,
                    'tren_7_hari'    => $trenAbsensi,
                ],
                'pelanggaran' => [
                    'hari_ini'    => $pelanggaranHariIni,
                    'bulan_ini'   => $pelanggaranBulanIni,
                    'terbaru'     => $pelanggaranTerbaru,
                    'siswa_rawan' => $siswaRawanPelanggaran,
                ],
                'akademik' => [
                    'total_tugas'           => $totalTugas,
                    'tugas_belum_dinilai'   => $tugasBelumDinilai,
                    'ujian_aktif'           => $ujianAktif,
                    'ujian_mendatang'       => $ujianMendatang,
                    'rata_rata_nilai_kelas' => $rataRataNilaiPerKelas,
                ],
                'izin' => [
                    'menunggu'      => $izinMenunggu,
                    'sedang_keluar' => $izinSedangKeluar,
                ],
                'pengumuman'      => $pengumuman,
                'jadwal_hari_ini' => $jadwalHariIni,
                'notifikasi' => [
                    'unread'  => $unreadNotifikasi,
                    'terbaru' => $notifikasiTerbaru,
                ],
            ],
        ]);
    }
}