<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\RiwayatScanQr;
use App\Models\SesiQr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * RiwayatScanController (Guru)
 *
 * Guru hanya bisa melihat riwayat scan dari sesi QR yang dia buat sendiri
 * (dibuat_oleh = Auth::id()). Tidak ada akses ke sesi QR guru lain.
 */
class RiwayatScanController extends Controller
{
    /**
     * Pastikan guru terhubung ke data guru.
     */
    private function getUserId(): int
    {
        $guru = Auth::user()->guru;
        abort_if(! $guru, 403, 'Akun Anda tidak terhubung dengan data guru.');
        return Auth::id();
    }

    // ── INDEX ─────────────────────────────────────────────────────────────────
    /**
     * Daftar riwayat scan — hanya dari sesi QR yang dibuat guru ini.
     */
    public function index(Request $request)
    {
        $userId = $this->getUserId();

        // Ambil ID sesi QR milik guru ini
        $sesiIds = SesiQr::where('dibuat_oleh', $userId)
            ->pluck('id');

        $query = RiwayatScanQr::with([
                'sesiQr.kelas',
                'sesiQr.mataPelajaran',
                'siswa',
            ])
            ->whereIn('sesi_qr_id', $sesiIds);

        // Filter per sesi
        if ($request->filled('sesi_qr_id')) {
            // Pastikan sesi yang diminta memang milik guru ini
            abort_unless($sesiIds->contains($request->sesi_qr_id), 403);
            $query->where('sesi_qr_id', $request->sesi_qr_id);
        }

        // Filter status scan (valid / ditolak_*)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('di_scan_pada', $request->tanggal);
        }

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('di_scan_pada', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('di_scan_pada', '<=', $request->tanggal_sampai);
        }

        // Filter nama siswa
        if ($request->filled('search')) {
            $query->whereHas('siswa', fn ($q) =>
                $q->where('nama_lengkap', 'like', "%{$request->search}%")
            );
        }

        $riwayats = $query->latest('di_scan_pada')->paginate(20)->withQueryString();

        // Daftar sesi QR milik guru ini untuk dropdown filter
        $sesiList = SesiQr::where('dibuat_oleh', $userId)
            ->with(['kelas', 'mataPelajaran'])
            ->orderByDesc('tanggal')
            ->get();

        // Status list untuk filter
        $statusList = [
            'valid'                  => 'Valid',
            'ditolak_radius'         => 'Ditolak (Radius)',
            'ditolak_kadaluarsa'     => 'Ditolak (Kadaluarsa)',
            'ditolak_nonaktif'       => 'Ditolak (Nonaktif)',
            'ditolak_duplikat'       => 'Ditolak (Duplikat)',
            'ditolak_bukan_anggota'  => 'Ditolak (Bukan Anggota)',
        ];

        // Rekap ringkasan hari ini
        $rekap = [
            'valid'    => (clone $query)->whereDate('di_scan_pada', today())->where('status', 'valid')->count(),
            'ditolak'  => (clone $query)->whereDate('di_scan_pada', today())->where('status', '!=', 'valid')->count(),
            'total'    => (clone $query)->whereDate('di_scan_pada', today())->count(),
        ];

        return view('guru.riwayat-scan.index', compact(
            'riwayats',
            'sesiList',
            'statusList',
            'rekap',
        ));
    }

    // ── SHOW ──────────────────────────────────────────────────────────────────
    /**
     * Detail satu riwayat scan.
     * Hanya bisa diakses jika sesi QR-nya dibuat oleh guru ini.
     */
    public function show(RiwayatScanQr $riwayat)
    {
        $userId = $this->getUserId();

        // Verifikasi kepemilikan sesi
        abort_unless(
            SesiQr::where('id', $riwayat->sesi_qr_id)
                ->where('dibuat_oleh', $userId)
                ->exists(),
            403,
            'Anda tidak memiliki akses ke riwayat scan ini.'
        );

        $riwayat->load([
            'sesiQr.kelas',
            'sesiQr.mataPelajaran',
            'siswa',
            'absensi',
        ]);

        return view('guru.riwayat-scan.show', compact('riwayat'));
    }
}