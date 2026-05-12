<?php

namespace App\Http\Controllers\Api\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Nilai;
use App\Models\Notifikasi;
use App\Models\Pelanggaran;
use App\Models\Tugas;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user     = Auth::user();
        $orangTua = $user->orangTua;

        if (! $orangTua) {
            return response()->json([
                'success' => false,
                'message' => 'Akun Anda tidak terhubung dengan data orang tua.',
            ], 403);
        }

        $anakList = $orangTua->siswa()->with('kelas')->get();
        $anak     = $anakList->first();

        // ── Absensi hari ini ─────────────────────────────────────────────────
        $absensiHariIni = $anak
            ? Absensi::where('siswa_id', $anak->id)
                ->whereDate('tanggal', today())
                ->first()
            : null;

        // ── Rekap absensi bulan ini per anak ─────────────────────────────────
        $rekapAbsensi = $anakList->map(function ($a) {
            $base = Absensi::where('siswa_id', $a->id)
                ->whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year);

            return [
                'siswa_id'   => $a->id,
                'nama'       => $a->nama_lengkap,
                'kelas'      => $a->kelas?->nama_kelas,
                'hadir'      => (clone $base)->whereIn('status', ['hadir', 'telat'])->count(),
                'izin'       => (clone $base)->where('status', 'izin')->count(),
                'sakit'      => (clone $base)->where('status', 'sakit')->count(),
                'alfa'       => (clone $base)->where('status', 'alfa')->count(),
            ];
        })->values();

        // ── Tugas belum dikumpulkan (anak pertama) ────────────────────────────
        $tugasBelumDikumpulkan = $anak
            ? Tugas::where('kelas_id', $anak->kelas_id)
                ->where('dipublikasikan', true)
                ->whereDoesntHave('pengumpulan', fn ($q) => $q->where('siswa_id', $anak->id))
                ->where('batas_waktu', '>=', now())
                ->with('mataPelajaran')
                ->orderBy('batas_waktu')
                ->limit(5)
                ->get()
                ->map(fn ($t) => [
                    'id'           => $t->id,
                    'judul'        => $t->judul,
                    'mata_pelajaran' => $t->mataPelajaran?->nama_mapel,
                    'batas_waktu'  => $t->batas_waktu?->toIso8601String(),
                ])
            : [];

        // ── Pelanggaran tahun ini ─────────────────────────────────────────────
        $totalPelanggaran = $anak
            ? Pelanggaran::where('siswa_id', $anak->id)
                ->whereYear('tanggal', now()->year)
                ->where('status', '!=', 'dibatalkan')
                ->count()
            : 0;

        // ── Rata-rata nilai ───────────────────────────────────────────────────
        $rataRataNilai = $anak
            ? round((float) (Nilai::where('siswa_id', $anak->id)->avg('nilai_akhir') ?? 0), 1)
            : null;

        // ── Notifikasi belum dibaca ───────────────────────────────────────────
        $unreadNotifikasi = Notifikasi::where('pengguna_id', $user->id)
            ->where('sudah_dibaca', false)
            ->count();

        return response()->json([
            'success' => true,
            'data'    => [
                'orang_tua'              => [
                    'id'           => $orangTua->id,
                    'nama_lengkap' => $orangTua->nama ?? $user->name,
                    'hubungan'     => $orangTua->hubungan,
                ],
                'anak_aktif'             => $anak ? [
                    'id'           => $anak->id,
                    'nama_lengkap' => $anak->nama_lengkap,
                    'kelas'        => $anak->kelas?->nama_kelas,
                ] : null,
                'jumlah_anak'            => $anakList->count(),
                'absensi_hari_ini'       => $absensiHariIni ? [
                    'status'    => $absensiHariIni->status,
                    'tanggal'   => $absensiHariIni->tanggal?->toDateString(),
                    'jam_masuk' => $absensiHariIni->jam_masuk,
                ] : null,
                'rekap_absensi_bulan_ini' => $rekapAbsensi,
                'tugas_belum_dikumpulkan' => $tugasBelumDikumpulkan,
                'total_pelanggaran'      => $totalPelanggaran,
                'rata_rata_nilai'        => $rataRataNilai,
                'unread_notifikasi'      => $unreadNotifikasi,
            ],
        ]);
    }
}