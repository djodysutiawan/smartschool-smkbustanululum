<?php

namespace App\Http\Controllers\Api\Piket;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Piket\Concerns\PiketActiveGuru;
use App\Models\IzinKeluarSiswa;
use App\Models\LaporanHarianPiket;
use App\Models\LogPiket;
use App\Models\Pelanggaran;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    use PiketActiveGuru;

    /**
     * GET /api/piket/laporan/harian
     *
     * Data untuk form laporan harian + ringkasan otomatis.
     */
    public function harian(): JsonResponse
    {
        $guruAktif   = $this->resolveActiveGuru();
        $guruAktifId = $guruAktif?->id;

        if (! $guruAktifId) {
            return response()->json([
                'success' => false,
                'message' => 'Check-in terlebih dahulu untuk membuat laporan harian.',
            ], 403);
        }

        $logHariIni = $this->resolveActiveLog()
            ?? LogPiket::where('guru_id', $guruAktifId)
                ->whereDate('tanggal', today())
                ->latest()
                ->first();

        $laporanHariIni = LaporanHarianPiket::where('dibuat_oleh', Auth::id())
            ->whereDate('tanggal', today())
            ->first();

        $pelanggaranHariIni = Pelanggaran::with(['siswa.kelas', 'kategori'])
            ->where('dicatat_oleh', Auth::id())
            ->whereDate('tanggal', today())
            ->get();

        $izinHariIni = IzinKeluarSiswa::with('siswa.kelas')
            ->whereDate('tanggal', today())
            ->get();

        $ringkasanOtomatis = $this->buatRingkasanOtomatis(
            $logHariIni,
            $pelanggaranHariIni,
            $izinHariIni,
        );

        return response()->json([
            'guru_aktif'          => $guruAktif,
            'laporan_hari_ini'    => $laporanHariIni,
            'log_hari_ini'        => $logHariIni,
            'pelanggaran_hari_ini'=> $pelanggaranHariIni,
            'izin_hari_ini'       => $izinHariIni,
            'ringkasan_otomatis'  => $ringkasanOtomatis,
        ]);
    }

    /**
     * POST /api/piket/laporan/harian
     *
     * Simpan laporan harian (upsert berdasarkan dibuat_oleh + tanggal).
     *
     * Body (JSON):
     * {
     *   "tanggal": "2025-01-20",
     *   "kondisi_sekolah": "Kondisi baik...",
     *   "catatan_umum": null,
     *   "kejadian_khusus": null,
     *   "tamu_penting": null
     * }
     */
    public function simpanHarian(Request $request): JsonResponse
    {
        if (! $this->resolveActiveGuruId()) {
            return response()->json([
                'success' => false,
                'message' => 'Check-in terlebih dahulu untuk menyimpan laporan.',
            ], 403);
        }

        $validated = $request->validate([
            'tanggal'         => ['required', 'date'],
            'kondisi_sekolah' => ['required', 'string'],
            'catatan_umum'    => ['nullable', 'string'],
            'kejadian_khusus' => ['nullable', 'string'],
            'tamu_penting'    => ['nullable', 'string'],
        ], [
            'tanggal.required'         => 'Tanggal laporan wajib diisi.',
            'kondisi_sekolah.required' => 'Kondisi sekolah wajib diisi.',
        ]);

        $validated['dibuat_oleh'] = Auth::id();

        $laporan = LaporanHarianPiket::updateOrCreate(
            [
                'dibuat_oleh' => Auth::id(),
                'tanggal'     => $validated['tanggal'],
            ],
            $validated
        );

        return response()->json([
            'success' => true,
            'message' => 'Laporan harian berhasil disimpan.',
            'laporan' => $laporan,
        ], 201);
    }

    /**
     * GET /api/piket/laporan/riwayat
     *
     * Riwayat laporan harian milik piket yang login.
     *
     * Query params:
     *   - bulan    (optional) 1-12
     *   - tahun    (optional)
     *   - per_page (optional, default 15)
     */
    public function riwayat(Request $request): JsonResponse
    {
        if (! $this->resolveActiveGuruId()) {
            return response()->json([
                'success' => false,
                'message' => 'Check-in terlebih dahulu untuk melihat riwayat laporan.',
            ], 403);
        }

        $query = LaporanHarianPiket::where('dibuat_oleh', Auth::id())
            ->orderByDesc('tanggal');

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $perPage = $request->get('per_page', 15);
        $laporan = $query->paginate($perPage)->withQueryString();

        $tahunList = LaporanHarianPiket::where('dibuat_oleh', Auth::id())
            ->selectRaw('YEAR(tanggal) as tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

        return response()->json([
            'laporan'    => $laporan,
            'tahun_list' => $tahunList,
        ]);
    }

    /**
     * GET /api/piket/laporan/{laporan}
     *
     * Detail laporan harian.
     */
    public function show(LaporanHarianPiket $laporan): JsonResponse
    {
        if ($laporan->dibuat_oleh !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak berhak mengakses laporan ini.',
            ], 403);
        }

        $laporan->load('dibuatOleh');

        $izinHariIni   = $laporan->getIzinKeluarSiswa();
        $ringkasanIzin = $laporan->getRingkasanIzinKeluar();

        return response()->json([
            'laporan'       => $laporan,
            'izin_hari_ini' => $izinHariIni,
            'ringkasan_izin'=> $ringkasanIzin,
        ]);
    }

    // ── Helper ────────────────────────────────────────────────────────────────

    private function buatRingkasanOtomatis(
        ?LogPiket $log,
        \Illuminate\Support\Collection $pelanggaran,
        \Illuminate\Support\Collection $izin,
    ): string {
        $parts = [];

        if ($log) {
            $masuk  = $log->masuk_pada
                ? Carbon::parse($log->masuk_pada)->format('H:i')
                : '-';
            $keluar = $log->keluar_pada
                ? Carbon::parse($log->keluar_pada)->format('H:i')
                : 'belum checkout';
            $parts[] = "Piket dilaksanakan pukul {$masuk} s.d. {$keluar}.";
        }

        if ($pelanggaran->count() > 0) {
            $parts[] = "Terdapat {$pelanggaran->count()} pelanggaran siswa yang dicatat.";
        }

        if ($izin->count() > 0) {
            $disetujui = $izin->where('status', IzinKeluarSiswa::STATUS_DISETUJUI)->count()
                       + $izin->where('status', IzinKeluarSiswa::STATUS_SUDAH_KEMBALI)->count();
            $parts[]   = "Izin keluar siswa: {$izin->count()} pengajuan, {$disetujui} disetujui.";
        }

        return implode(' ', $parts) ?: 'Tidak ada kejadian khusus hari ini.';
    }
}