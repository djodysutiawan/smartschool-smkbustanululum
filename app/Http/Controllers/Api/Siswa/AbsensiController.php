<?php

namespace App\Http\Controllers\Api\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\RiwayatScanQr;
use App\Models\SesiQr;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    private const STATUS_LIST = ['hadir', 'telat', 'izin', 'sakit', 'alfa'];

    private function getSiswa()
    {
        $siswa = Auth::user()->siswa;
        abort_if(! $siswa, 403, 'Akun Anda tidak terhubung dengan data siswa.');
        return $siswa;
    }

    /**
     * GET /api/siswa/absensi/status-hari-ini
     * Status absensi hari ini milik siswa.
     */
    public function statusHariIni(): JsonResponse
    {
        $siswa = $this->getSiswa();

        $absensiHariIni = Absensi::where('siswa_id', $siswa->id)
            ->whereDate('tanggal', today())
            ->first();

        return response()->json([
            'success' => true,
            'data'    => [
                'sudah_absen'     => ! is_null($absensiHariIni),
                'absensi_hari_ini' => $absensiHariIni,
            ],
        ]);
    }

    /**
     * POST /api/siswa/absensi/scan
     * Proses hasil scan QR Code.
     * Body: { "qr_code": "SESI-xxxx" | "xxxx", "latitude": float|null, "longitude": float|null }
     */
    public function prosesQr(Request $request): JsonResponse
    {
        $request->validate([
            'qr_code'   => ['required', 'string'],
            'latitude'  => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
        ]);

        $siswa = $this->getSiswa();

        $sudahAbsen = Absensi::where('siswa_id', $siswa->id)
            ->whereDate('tanggal', today())
            ->exists();

        if ($sudahAbsen) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melakukan absensi hari ini.',
            ], 422);
        }

        $qrInput = $request->qr_code;
        $kodeQr  = str_starts_with($qrInput, 'SESI-')
            ? substr($qrInput, 5)
            : $qrInput;

        $sesiQr = SesiQr::where('kode_qr', $kodeQr)
            ->where('is_active', true)
            ->where('kelas_id', $siswa->kelas_id)
            ->whereDate('tanggal', today())
            ->where('berlaku_mulai', '<=', now())
            ->where('kadaluarsa_pada', '>=', now())
            ->first();

        if (! $sesiQr) {
            $this->catatRiwayatScan($siswa->id, null, null, 'gagal', $request);

            return response()->json([
                'success' => false,
                'message' => 'QR Code tidak valid, bukan untuk kelas Anda, atau sudah kadaluarsa.',
            ], 422);
        }

        $batasWaktuTelat = $sesiQr->berlaku_mulai->copy()->addMinutes(15);
        $status          = now()->greaterThan($batasWaktuTelat) ? 'telat' : 'hadir';

        $absensi = Absensi::create([
            'siswa_id'            => $siswa->id,
            'kelas_id'            => $siswa->kelas_id,
            'jadwal_pelajaran_id' => null,
            'dicatat_oleh'        => Auth::id(),
            'tanggal'             => today(),
            'status'              => $status,
            'metode'              => 'qr',
            'jam_masuk'           => now()->format('H:i:s'),
        ]);

        $this->catatRiwayatScan($siswa->id, $sesiQr->id, $absensi->id, 'berhasil', $request);

        $labelStatus = $status === 'hadir' ? 'Hadir ✓' : 'Telat';

        return response()->json([
            'success' => true,
            'message' => "Absensi berhasil dicatat! Status: {$labelStatus}",
            'data'    => ['absensi' => $absensi, 'status' => $status],
        ]);
    }

    /**
     * Helper: catat riwayat scan QR.
     */
    private function catatRiwayatScan(
        int $siswaId,
        ?int $sesiQrId,
        ?int $absensiId,
        string $hasil,
        Request $request
    ): void {
        RiwayatScanQr::create([
            'siswa_id'       => $siswaId,
            'sesi_qr_id'     => $sesiQrId,
            'dipindai_pada'  => now(),
            'hasil'          => $hasil,
            'ip_address'     => $request->ip(),
            'info_perangkat' => $request->userAgent(),
            'latitude'       => $request->latitude  ?? null,
            'longitude'      => $request->longitude ?? null,
        ]);
    }

    /**
     * GET /api/siswa/absensi/riwayat
     * Riwayat kehadiran dengan filter.
     * Query: ?status=&tanggal_dari=&tanggal_sampai=&bulan=&tahun=&per_page=
     */
    public function riwayat(Request $request): JsonResponse
    {
        $siswa = $this->getSiswa();

        $query = Absensi::with(['kelas', 'jadwalPelajaran.mataPelajaran', 'dicatatOleh'])
            ->where('siswa_id', $siswa->id);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $perPage = min((int) $request->get('per_page', 20), 50);
        $absensi = $query->orderByDesc('tanggal')->paginate($perPage);

        $baseQuery = fn () => Absensi::where('siswa_id', $siswa->id);
        $rekap     = [
            'hadir'  => $baseQuery()->whereIn('status', ['hadir', 'telat'])->count(),
            'izin'   => $baseQuery()->where('status', 'izin')->count(),
            'sakit'  => $baseQuery()->where('status', 'sakit')->count(),
            'alfa'   => $baseQuery()->where('status', 'alfa')->count(),
            'total'  => $baseQuery()->count(),
        ];

        $rekap['persen_hadir'] = $rekap['total'] > 0
            ? round(($rekap['hadir'] / $rekap['total']) * 100, 1)
            : 0;

        $tahunList = Absensi::where('siswa_id', $siswa->id)
            ->selectRaw('YEAR(tanggal) as tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

        return response()->json([
            'success' => true,
            'data'    => [
                'absensi'     => $absensi,
                'rekap'       => $rekap,
                'status_list' => self::STATUS_LIST,
                'tahun_list'  => $tahunList,
            ],
        ]);
    }
}