<?php

namespace App\Http\Controllers\Api\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Nilai;
use App\Models\Pelanggaran;
use App\Models\Tugas;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ProfilAnakController extends Controller
{
    private function getOrangTua()
    {
        $orangTua = Auth::user()->orangTua;
        if (! $orangTua) {
            abort(response()->json([
                'success' => false,
                'message' => 'Akun Anda tidak terhubung dengan data orang tua.',
            ], 403));
        }
        return $orangTua;
    }

    /**
     * GET /api/ortu/anak
     * Daftar semua anak beserta ringkasan singkat.
     */
    public function index(): JsonResponse
    {
        $orangTua = $this->getOrangTua();
        $anakList = $orangTua->siswa()->with(['kelas', 'pengguna'])->orderBy('nama_lengkap')->get();

        $bulan = now()->month;
        $tahun = now()->year;

        $data = $anakList->map(function ($anak) use ($bulan, $tahun) {
            $totalAbsensi = Absensi::where('siswa_id', $anak->id)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->whereIn('status', Absensi::STATUS_DIHITUNG_HADIR)
                ->count();

            $rataRataNilai = Nilai::where('siswa_id', $anak->id)
                ->whereNotNull('nilai_akhir')
                ->avg('nilai_akhir');

            $totalPelanggaran = Pelanggaran::where('siswa_id', $anak->id)
                ->aktif()
                ->whereYear('tanggal', $tahun)
                ->count();

            $totalPoinPelanggaran = Pelanggaran::where('siswa_id', $anak->id)
                ->aktif()
                ->whereYear('tanggal', $tahun)
                ->sum('poin');

            return [
                'id'                      => $anak->id,
                'nis'                     => $anak->nis,
                'nama_lengkap'            => $anak->nama_lengkap,
                'jenis_kelamin'           => $anak->jenis_kelamin,
                'kelas'                   => $anak->kelas?->nama_kelas,
                'foto_url'                => $anak->foto ? url('api/file/' . ltrim($anak->foto, '/')) : null,
                'total_absensi_bulan_ini' => $totalAbsensi,
                'rata_rata_nilai'         => $rataRataNilai ? round((float) $rataRataNilai, 1) : null,
                'total_pelanggaran'       => $totalPelanggaran,
                'total_poin_pelanggaran'  => $totalPoinPelanggaran,
            ];
        })->values();

        return response()->json([
            'success' => true,
            'data'    => [
                'orang_tua' => [
                    'id'           => $orangTua->id,
                    'nama_lengkap' => $orangTua->nama ?? Auth::user()->name,
                    'hubungan'     => $orangTua->hubungan,
                ],
                'anak_list' => $data,
            ],
        ]);
    }

    /**
     * GET /api/ortu/anak/{siswaId}
     * Detail profil satu anak lengkap.
     */
    public function show(int $siswaId): JsonResponse
    {
        $orangTua = $this->getOrangTua();

        $anak = $orangTua->siswa()
            ->with(['kelas', 'pengguna'])
            ->find($siswaId);

        if (! $anak) {
            return response()->json([
                'success' => false,
                'message' => 'Data anak tidak ditemukan atau bukan anak Anda.',
            ], 404);
        }

        $bulan = now()->month;
        $tahun = now()->year;

        // ── Absensi bulan ini ─────────────────────────────────────────────
        $baseAbsensi = Absensi::where('siswa_id', $anak->id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun);

        $absensiSummary = [
            'hadir' => (clone $baseAbsensi)->whereIn('status', Absensi::STATUS_DIHITUNG_HADIR)->count(),
            'izin'  => (clone $baseAbsensi)->where('status', Absensi::STATUS_IZIN)->count(),
            'sakit' => (clone $baseAbsensi)->where('status', Absensi::STATUS_SAKIT)->count(),
            'alfa'  => (clone $baseAbsensi)->where('status', Absensi::STATUS_ALFA)->count(),
        ];

        $absensiTerbaru = Absensi::where('siswa_id', $anak->id)
            ->orderByDesc('tanggal')
            ->limit(10)
            ->get()
            ->map(fn ($ab) => [
                'tanggal'    => $ab->tanggal?->toDateString(),
                'status'     => $ab->status,
                'jam_masuk'  => $ab->jam_masuk,
                'keterangan' => $ab->keterangan,
            ])->values();

        // ── Nilai ─────────────────────────────────────────────────────────
        $nilaiList = Nilai::where('siswa_id', $anak->id)
            ->with('mataPelajaran')
            ->latest()
            ->get();

        $rataRataNilai = $nilaiList->whereNotNull('nilai_akhir')->avg('nilai_akhir');

        // ── Tugas ─────────────────────────────────────────────────────────
        $tugasBelum = Tugas::where('kelas_id', $anak->kelas_id)
            ->dipublikasikan()
            ->whereDoesntHave('pengumpulan', fn ($q) => $q->where('siswa_id', $anak->id))
            ->where('batas_waktu', '>=', now())
            ->with('mataPelajaran')
            ->orderBy('batas_waktu')
            ->limit(5)
            ->get()
            ->map(fn ($t) => [
                'id'             => $t->id,
                'judul'          => $t->judul,
                'mata_pelajaran' => $t->mataPelajaran?->nama_mapel,
                'batas_waktu'    => $t->batas_waktu?->toIso8601String(),
            ])->values();

        $tugasTerlambat = Tugas::where('kelas_id', $anak->kelas_id)
            ->dipublikasikan()
            ->whereDoesntHave('pengumpulan', fn ($q) => $q->where('siswa_id', $anak->id))
            ->where('batas_waktu', '<', now())
            ->where('izinkan_terlambat', false)
            ->with('mataPelajaran')
            ->orderByDesc('batas_waktu')
            ->limit(3)
            ->get()
            ->map(fn ($t) => [
                'id'             => $t->id,
                'judul'          => $t->judul,
                'mata_pelajaran' => $t->mataPelajaran?->nama_mapel,
                'batas_waktu'    => $t->batas_waktu?->toIso8601String(),
            ])->values();

        // ── Pelanggaran ───────────────────────────────────────────────────
        $pelanggaranList = Pelanggaran::where('siswa_id', $anak->id)
            ->with('kategori')
            ->aktif()
            ->whereYear('tanggal', $tahun)
            ->orderByDesc('tanggal')
            ->limit(5)
            ->get()
            ->map(fn ($p) => [
                'id'           => $p->id,
                'tanggal'      => $p->tanggal?->toDateString(),
                'kategori'     => $p->kategori?->nama,
                'tingkat'      => $p->kategori?->tingkat,
                'poin'         => $p->poin,
                'keterangan'   => $p->keterangan,
                'status'       => $p->status,
            ])->values();

        // FIX: total poin dari semua pelanggaran aktif, bukan hanya 5 yang difetch
        $totalPoinPelanggaran = Pelanggaran::where('siswa_id', $anak->id)
            ->aktif()
            ->whereYear('tanggal', $tahun)
            ->sum('poin');

        return response()->json([
            'success' => true,
            'data'    => [
                'anak'                 => [
                    'id'             => $anak->id,
                    'nis'            => $anak->nis,
                    'nisn'           => $anak->nisn,
                    'nama_lengkap'   => $anak->nama_lengkap,
                    'jenis_kelamin'  => $anak->jenis_kelamin,
                    'tempat_lahir'   => $anak->tempat_lahir,
                    'tanggal_lahir'  => $anak->tanggal_lahir?->format('d/m/Y'),
                    'alamat'         => $anak->alamat,
                    'kelas'          => $anak->kelas?->nama_kelas,
                    'kelas_id'       => $anak->kelas?->id,
                    'foto_url'       => $anak->foto ? url('api/file/' . ltrim($anak->foto, '/')) : null,
                ],
                'absensi_summary'      => $absensiSummary,
                'absensi_terbaru'      => $absensiTerbaru,
                'nilai_list'           => $nilaiList->map(fn ($n) => [
                    'id'             => $n->id,
                    'mata_pelajaran' => $n->mataPelajaran?->nama_mapel,
                    'nilai_tugas'    => $n->nilai_tugas,
                    'nilai_harian'   => $n->nilai_harian,
                    'nilai_uts'      => $n->nilai_uts,
                    'nilai_uas'      => $n->nilai_uas,
                    'nilai_akhir'    => $n->nilai_akhir,
                    'predikat'       => $n->predikat,
                ])->values(),
                'rata_rata_nilai'      => $rataRataNilai ? round((float) $rataRataNilai, 1) : null,
                'tugas_belum'          => $tugasBelum,
                'tugas_terlambat'      => $tugasTerlambat,
                'pelanggaran_list'     => $pelanggaranList,
                'total_poin_pelanggaran' => $totalPoinPelanggaran,
            ],
        ]);
    }
}