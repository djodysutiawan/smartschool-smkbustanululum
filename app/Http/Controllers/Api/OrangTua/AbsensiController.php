<?php

namespace App\Http\Controllers\Api\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    private const STATUS_LIST = ['hadir', 'telat', 'izin', 'sakit', 'alfa'];

    // ── Helpers ──────────────────────────────────────────────────────────────

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

    private function resolveAnak(Request $request, $orangTua)
    {
        $anakList = $orangTua->siswa()->get();
        if ($anakList->isEmpty()) {
            abort(response()->json([
                'success' => false,
                'message' => 'Data anak tidak ditemukan.',
            ], 404));
        }

        if ($request->filled('siswa_id')) {
            $anak = $anakList->firstWhere('id', (int) $request->siswa_id);
            if (! $anak) {
                abort(response()->json([
                    'success' => false,
                    'message' => 'Siswa ini bukan anak Anda.',
                ], 403));
            }
            return $anak;
        }

        return $anakList->first();
    }

    // ── Status Hari Ini ───────────────────────────────────────────────────────

    /**
     * GET /api/ortu/absensi/hari-ini
     * Query: ?siswa_id=
     */
    public function statusHariIni(Request $request): JsonResponse
    {
        $orangTua = $this->getOrangTua();
        $anak     = $this->resolveAnak($request, $orangTua);
        $anakList = $orangTua->siswa()->with('kelas')->get();

        $absensiHariIni = Absensi::with([
                'jadwalPelajaran.mataPelajaran',
                'dicatatOleh',
            ])
            ->where('siswa_id', $anak->id)
            ->whereDate('tanggal', today())
            ->orderBy('jam_masuk')
            ->get();

        return response()->json([
            'success' => true,
            'data'    => [
                'anak'      => [
                    'id'           => $anak->id,
                    'nama_lengkap' => $anak->nama_lengkap,
                    'kelas'        => $anak->kelas?->nama_kelas,
                ],
                'anak_list' => $anakList->map(fn ($a) => [
                    'id'           => $a->id,
                    'nama_lengkap' => $a->nama_lengkap,
                    'kelas'        => $a->kelas?->nama_kelas,
                ])->values(),
                'tanggal'         => today()->toDateString(),
                'hari'            => strtolower(now()->locale('id')->dayName),
                'absensi_hari_ini' => $absensiHariIni->map(fn ($ab) => [
                    'id'            => $ab->id,
                    'status'        => $ab->status,
                    'jam_masuk'     => $ab->jam_masuk,
                    'keterangan'    => $ab->keterangan,
                    'mata_pelajaran' => $ab->jadwalPelajaran?->mataPelajaran?->nama_mapel,
                    'dicatat_oleh'  => $ab->dicatatOleh?->name,
                ])->values(),
            ],
        ]);
    }

    // ── Riwayat ───────────────────────────────────────────────────────────────

    /**
     * GET /api/ortu/absensi/riwayat
     * Query: ?siswa_id= &status= &tanggal_dari= &tanggal_sampai= &page=
     */
    public function riwayat(Request $request): JsonResponse
    {
        $orangTua = $this->getOrangTua();
        $anak     = $this->resolveAnak($request, $orangTua);
        $anakList = $orangTua->siswa()->with('kelas')->get();

        $query = Absensi::with(['jadwalPelajaran.mataPelajaran', 'dicatatOleh'])
            ->where('siswa_id', $anak->id);

        if ($request->filled('status') && in_array($request->status, self::STATUS_LIST)) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        }

        $absensi = $query->orderByDesc('tanggal')->paginate(20)->withQueryString();

        $rekap = [
            'hadir' => Absensi::where('siswa_id', $anak->id)->whereIn('status', ['hadir', 'telat'])->count(),
            'izin'  => Absensi::where('siswa_id', $anak->id)->where('status', 'izin')->count(),
            'sakit' => Absensi::where('siswa_id', $anak->id)->where('status', 'sakit')->count(),
            'alfa'  => Absensi::where('siswa_id', $anak->id)->where('status', 'alfa')->count(),
        ];

        return response()->json([
            'success' => true,
            'data'    => [
                'anak'       => [
                    'id'           => $anak->id,
                    'nama_lengkap' => $anak->nama_lengkap,
                    'kelas'        => $anak->kelas?->nama_kelas,
                ],
                'anak_list'  => $anakList->map(fn ($a) => [
                    'id'           => $a->id,
                    'nama_lengkap' => $a->nama_lengkap,
                    'kelas'        => $a->kelas?->nama_kelas,
                ])->values(),
                'rekap'      => $rekap,
                'status_list' => self::STATUS_LIST,
                'absensi'    => $absensi->map(fn ($ab) => [
                    'id'             => $ab->id,
                    'tanggal'        => $ab->tanggal?->toDateString(),
                    'status'         => $ab->status,
                    'jam_masuk'      => $ab->jam_masuk,
                    'keterangan'     => $ab->keterangan,
                    'mata_pelajaran' => $ab->jadwalPelajaran?->mataPelajaran?->nama_mapel,
                    'dicatat_oleh'   => $ab->dicatatOleh?->name,
                ])->values(),
                'pagination' => [
                    'current_page' => $absensi->currentPage(),
                    'last_page'    => $absensi->lastPage(),
                    'per_page'     => $absensi->perPage(),
                    'total'        => $absensi->total(),
                ],
            ],
        ]);
    }

    // ── Rekap Bulanan ─────────────────────────────────────────────────────────

    /**
     * GET /api/ortu/absensi/rekap
     * Query: ?siswa_id= &bulan= &tahun=
     */
    public function rekap(Request $request): JsonResponse
    {
        $orangTua = $this->getOrangTua();
        $anak     = $this->resolveAnak($request, $orangTua);
        $anakList = $orangTua->siswa()->with('kelas')->get();

        $tahun = $request->filled('tahun') ? (int) $request->tahun : now()->year;
        $bulan = $request->filled('bulan') ? (int) $request->bulan : now()->month;

        $absensiList = Absensi::with(['jadwalPelajaran.mataPelajaran'])
            ->where('siswa_id', $anak->id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal')
            ->get();

        // Haripertanggal: grouped per hari, masuk = absensi hadir/telat pertama
        $hariPerTanggal = $absensiList
            ->groupBy(fn ($a) => $a->tanggal->format('Y-m-d'))
            ->map(function ($absensiHari, $tanggalStr) {
                $absensiHadir = $absensiHari->whereIn('status', ['hadir', 'telat'])->first();
                return [
                    'tanggal'     => $tanggalStr,
                    'ada_masuk'   => $absensiHadir !== null,
                    'status'      => $absensiHadir?->status,
                    'jam_masuk'   => $absensiHadir?->jam_masuk,
                    'ada_pulang'  => false, // tidak ada di model Absensi pelajaran
                    'jam_pulang'  => null,
                ];
            })
            ->sortBy('tanggal')
            ->values();

        $hariMasuk = $absensiList
            ->whereIn('status', ['hadir', 'telat'])
            ->groupBy(fn ($a) => $a->tanggal->format('Y-m-d'))
            ->count();

        $rekap = [
            'total_hari_masuk'  => $hariMasuk,
            'total_hari_pulang' => 0,
            'total_scan'        => $absensiList->count(),
            'hadir'             => $absensiList->where('status', 'hadir')->count(),
            'telat'             => $absensiList->where('status', 'telat')->count(),
            'izin'              => $absensiList->where('status', 'izin')->count(),
            'sakit'             => $absensiList->where('status', 'sakit')->count(),
            'alfa'              => $absensiList->where('status', 'alfa')->count(),
        ];

        // Rekap tren 12 bulan
        $rekapTahunan = collect(range(1, 12))->map(function ($m) use ($anak, $tahun) {
            $bulanData = Absensi::where('siswa_id', $anak->id)
                ->whereMonth('tanggal', $m)
                ->whereYear('tanggal', $tahun)
                ->get();

            return [
                'bulan'  => $m,
                'masuk'  => $bulanData
                    ->whereIn('status', ['hadir', 'telat'])
                    ->groupBy(fn ($a) => $a->tanggal->format('Y-m-d'))
                    ->count(),
                'pulang' => 0,
            ];
        });

        return response()->json([
            'success' => true,
            'data'    => [
                'anak'          => [
                    'id'           => $anak->id,
                    'nama_lengkap' => $anak->nama_lengkap,
                    'kelas'        => $anak->kelas?->nama_kelas,
                ],
                'anak_list'     => $anakList->map(fn ($a) => [
                    'id'           => $a->id,
                    'nama_lengkap' => $a->nama_lengkap,
                    'kelas'        => $a->kelas?->nama_kelas,
                ])->values(),
                'bulan'         => $bulan,
                'tahun'         => $tahun,
                'rekap'         => $rekap,
                'hari_per_tanggal' => $hariPerTanggal,
                'rekap_tahunan' => $rekapTahunan,
            ],
        ]);
    }
}