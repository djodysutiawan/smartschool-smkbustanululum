<?php

namespace App\Http\Controllers\Api\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\JadwalPelajaran;
use App\Models\Materi;
use App\Models\Nilai;
use App\Models\Notifikasi;
use App\Models\PengumpulanTugas;
use App\Models\Pelanggaran;
use App\Models\Tugas;
use App\Models\Ujian;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    private const HARI_MAP = [
        'Sunday'    => 'minggu',
        'Monday'    => 'senin',
        'Tuesday'   => 'selasa',
        'Wednesday' => 'rabu',
        'Thursday'  => 'kamis',
        'Friday'    => 'jumat',
        'Saturday'  => 'sabtu',
    ];

    private function getSiswa(): \App\Models\Siswa
    {
        $siswa = Auth::user()?->siswa;
        abort_if(! $siswa, 403, 'Akun Anda tidak terhubung dengan data siswa.');
        return $siswa;
    }

    /**
     * GET /api/siswa/dashboard
     */
    public function index(): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user  = Auth::user();
        $siswa = $this->getSiswa();

        $now     = Carbon::now();
        $hariIni = self::HARI_MAP[$now->format('l')] ?? 'senin';

        // ── Jadwal hari ini ──────────────────────────────────────────────────
        $jadwalHariIni = JadwalPelajaran::with(['mataPelajaran', 'guru', 'ruang'])
            ->where('kelas_id', $siswa->kelas_id)
            ->where('hari', $hariIni)
            ->where('is_active', true)
            ->orderBy('jam_mulai')
            ->get()
            ->map(fn ($j) => [
                'id'             => $j->id,
                'mata_pelajaran' => $j->mataPelajaran?->nama,
                'guru'           => $j->guru?->nama_lengkap,
                'ruang'          => $j->ruang?->nama_ruang ?? null,
                'jam_mulai'      => $j->jam_mulai,
                'jam_selesai'    => $j->jam_selesai,
            ]);

        // ── Absensi hari ini ─────────────────────────────────────────────────
        $absensiHariIni = Absensi::where('siswa_id', $siswa->id)
            ->whereDate('tanggal', today())
            ->first();

        // ── Rekap absensi bulan ini ──────────────────────────────────────────
        $baseAbsensi = Absensi::where('siswa_id', $siswa->id)
            ->whereMonth('tanggal', $now->month)
            ->whereYear('tanggal', $now->year);

        $totalHariEfektif = (clone $baseAbsensi)->count();

        $rekapBulanIni = [
            'hadir' => (clone $baseAbsensi)->whereIn('status', ['hadir', 'telat'])->count(),
            'izin'  => (clone $baseAbsensi)->where('status', 'izin')->count(),
            'sakit' => (clone $baseAbsensi)->where('status', 'sakit')->count(),
            'alfa'  => (clone $baseAbsensi)->where('status', 'alfa')->count(),
        ];

        $persentaseHadir = $totalHariEfektif > 0
            ? round(($rekapBulanIni['hadir'] / $totalHariEfektif) * 100)
            : 0;

        // ── Tugas belum dikumpulkan ──────────────────────────────────────────
        $tugasBelumDikumpulkan = Tugas::with(['mataPelajaran', 'guru'])
            ->dipublikasikan()
            ->where('kelas_id', $siswa->kelas_id)
            ->whereDoesntHave('pengumpulan', fn ($q) => $q->where('siswa_id', $siswa->id))
            ->where(function ($q) {
                $q->where('batas_waktu', '>=', now())
                  ->orWhere('izinkan_terlambat', true);
            })
            ->orderBy('batas_waktu')
            ->limit(5)
            ->get()
            ->map(fn ($t) => [
                'id'             => $t->id,
                'judul'          => $t->judul,
                'mata_pelajaran' => $t->mataPelajaran?->nama,
                'guru'           => $t->guru?->nama_lengkap,
                'batas_waktu'    => $t->batas_waktu?->toIso8601String(),
                'terlambat_ok'   => (bool) $t->izinkan_terlambat,
            ]);

        $totalTugasDikumpulkan = PengumpulanTugas::where('siswa_id', $siswa->id)
            ->whereMonth('created_at', $now->month)
            ->count();

        // ── Ujian ────────────────────────────────────────────────────────────
        $ujianKelas = Ujian::with(['mataPelajaran', 'sesi' => fn ($q) =>
                $q->where('siswa_id', $siswa->id)
            ])
            ->where('kelas_id', $siswa->kelas_id)
            ->whereDate('tanggal', '>=', $now->toDateString())
            ->whereDate('tanggal', '<=', $now->copy()->addDays(30)->toDateString())
            ->orderBy('tanggal')
            ->orderBy('jam_mulai')
            ->get();

        $formatUjian = fn ($u) => [
            'id'             => $u->id,
            'judul'          => $u->judul ?? $u->nama ?? null,
            'mata_pelajaran' => $u->mataPelajaran?->nama,
            'tanggal'        => $u->tanggal?->format('Y-m-d'),
            'jam_mulai'      => $u->jam_mulai,
            'durasi_menit'   => $u->durasi_menit,
        ];

        $ujianAktif = $ujianKelas
            ->filter(fn ($u) =>
                $u->sudahDimulai()
                && ! $u->sudahBerakhir()
                && $u->bolehIkut($siswa->id)
                && ! $u->sesi->whereIn('status', ['selesai', 'habis_waktu'])->count()
            )
            ->take(5)
            ->values()
            ->map($formatUjian);

        $ujianMendatang = $ujianKelas
            ->filter(fn ($u) => ! $u->sudahDimulai())
            ->take(3)
            ->values()
            ->map($formatUjian);

        // ── Materi terbaru ───────────────────────────────────────────────────
        $materiTerbaru = Materi::with('mataPelajaran')
            ->where('kelas_id', $siswa->kelas_id)
            ->dipublikasikan()
            ->orderByDesc('created_at')
            ->limit(5)
            ->get()
            ->map(fn ($m) => [
                'id'             => $m->id,
                'judul'          => $m->judul,
                'mata_pelajaran' => $m->mataPelajaran?->nama,
                'created_at'     => $m->created_at?->toIso8601String(),
            ]);

        // ── Nilai terbaru ─────────────────────────────────────────────────────
        $nilaiTerbaru = Nilai::with('mataPelajaran')
            ->where('siswa_id', $siswa->id)
            ->orderByDesc('created_at')
            ->limit(5)
            ->get()
            ->map(fn ($n) => [
                'id'             => $n->id,
                'mata_pelajaran' => $n->mataPelajaran?->nama,
                'nilai_akhir'    => $n->nilai_akhir,
                'created_at'     => $n->created_at?->toIso8601String(),
            ]);

        $rataRataNilai = Nilai::where('siswa_id', $siswa->id)
            ->whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->avg('nilai_akhir') ?? 0;

        // ── Pelanggaran ───────────────────────────────────────────────────────
        $totalPelanggaran = Pelanggaran::where('siswa_id', $siswa->id)
            ->whereYear('tanggal', $now->year)
            ->count();

        // ── Notifikasi ────────────────────────────────────────────────────────
        $unreadNotifikasi = Notifikasi::where('pengguna_id', $user->id)
            ->where('sudah_dibaca', false)
            ->count();

        $notifikasiTerbaru = Notifikasi::where('pengguna_id', $user->id)
            ->orderByDesc('created_at')
            ->limit(3)
            ->get()
            ->map(fn ($n) => [
                'id'           => $n->id,
                'judul'        => $n->judul,
                'pesan'        => $n->pesan,
                'sudah_dibaca' => (bool) $n->sudah_dibaca,
                'created_at'   => $n->created_at?->toIso8601String(),
            ]);

        return response()->json([
            'success' => true,
            'data'    => [
                'siswa' => [
                    'id'            => $siswa->id,
                    'nama_lengkap'  => $siswa->nama_lengkap,
                    'nis'           => $siswa->nis,
                    'kelas'         => $siswa->kelas?->nama_kelas,
                ],
                'jadwal_hari_ini'        => $jadwalHariIni,
                'hari_ini'               => $hariIni,
                'absensi_hari_ini'       => $absensiHariIni ? [
                    'status'    => $absensiHariIni->status,
                    'tanggal'   => $absensiHariIni->tanggal?->format('Y-m-d'),
                    'keterangan'=> $absensiHariIni->keterangan ?? null,
                ] : null,
                'rekap_bulan_ini'        => array_merge($rekapBulanIni, [
                    'total_hari_efektif' => $totalHariEfektif,
                    'persentase_hadir'   => $persentaseHadir,
                ]),
                'tugas' => [
                    'belum_dikumpulkan'      => $tugasBelumDikumpulkan,
                    'total_dikumpulkan_bulan_ini' => $totalTugasDikumpulkan,
                ],
                'ujian' => [
                    'aktif'     => $ujianAktif,
                    'mendatang' => $ujianMendatang,
                ],
                'materi_terbaru'    => $materiTerbaru,
                'nilai' => [
                    'terbaru'          => $nilaiTerbaru,
                    'rata_rata_bulan_ini' => round((float) $rataRataNilai, 2),
                ],
                'total_pelanggaran_tahun_ini' => $totalPelanggaran,
                'notifikasi' => [
                    'unread'  => $unreadNotifikasi,
                    'terbaru' => $notifikasiTerbaru,
                ],
            ],
        ]);
    }
}