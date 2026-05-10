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
 *
 * Kolom waktu scan: di_scan_pada (TIMESTAMP) — sesuai struktur tabel riwayat_scan_qr.
 */
class RiwayatScanController extends Controller
{
    /**
     * Pastikan guru terhubung ke data guru dan kembalikan Auth::id().
     */
    private function getUserId(): int
    {
        $guru = Auth::user()->guru;
        abort_if(! $guru, 403, 'Akun Anda tidak terhubung dengan data guru.');
        return Auth::id();
    }

    // ── INDEX ─────────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $userId = $this->getUserId();

        // ID sesi QR milik guru ini
        $sesiIds = SesiQr::where('dibuat_oleh', $userId)->pluck('id');

        // Base query — scoped ke sesiIds milik guru
        $query = RiwayatScanQr::with([
                'sesiQr.kelas:id,nama_kelas',
                'sesiQr.mataPelajaran:id,nama_mapel',
                'siswa:id,nama_lengkap,nis',
            ])
            ->whereIn('sesi_qr_id', $sesiIds);

        // ── Filter: per sesi QR ───────────────────────────────────────────────
        if ($request->filled('sesi_qr_id')) {
            abort_unless($sesiIds->contains((int) $request->sesi_qr_id), 403);
            $query->where('sesi_qr_id', $request->sesi_qr_id);
        }

        // ── Filter: status scan ───────────────────────────────────────────────
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // ── Filter: tanggal spesifik ──────────────────────────────────────────
        if ($request->filled('tanggal')) {
            $query->whereDate('di_scan_pada', $request->tanggal);
        }

        // ── Filter: range tanggal ─────────────────────────────────────────────
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('di_scan_pada', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('di_scan_pada', '<=', $request->tanggal_sampai);
        }

        // ── Filter: nama/NIS siswa ────────────────────────────────────────────
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('siswa', fn ($q) =>
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
            );
        }

        $riwayats = $query->latest('di_scan_pada')->paginate(20)->withQueryString();

        // ── Dropdown sesi QR ──────────────────────────────────────────────────
        $sesiList = SesiQr::where('dibuat_oleh', $userId)
            ->with(['kelas:id,nama_kelas', 'mataPelajaran:id,nama_mapel'])
            ->orderByDesc('tanggal')
            ->get();

        // ── Label status ──────────────────────────────────────────────────────
        $statusList = [
            'valid'                  => 'Valid',
            'ditolak_radius'         => 'Ditolak (Radius)',
            'ditolak_kadaluarsa'     => 'Ditolak (Kadaluarsa)',
            'ditolak_nonaktif'       => 'Ditolak (Nonaktif)',
            'ditolak_duplikat'       => 'Ditolak (Duplikat)',
            'ditolak_bukan_anggota'  => 'Ditolak (Bukan Anggota)',
        ];

        // ── Rekap hari ini (tidak terpengaruh filter aktif) ───────────────────
        $baseHariIni = RiwayatScanQr::whereIn('sesi_qr_id', $sesiIds)
            ->whereDate('di_scan_pada', today());

        $rekap = [
            'total'   => (clone $baseHariIni)->count(),
            'valid'   => (clone $baseHariIni)->where('status', 'valid')->count(),
            'ditolak' => (clone $baseHariIni)->where('status', '!=', 'valid')->count(),
        ];

        return view('guru.riwayat-scan.index', compact(
            'riwayats',
            'sesiList',
            'statusList',
            'rekap',
        ));
    }

    // ── SHOW ──────────────────────────────────────────────────────────────────

    public function show(RiwayatScanQr $riwayat)
    {
        $userId = $this->getUserId();

        abort_unless(
            SesiQr::where('id', $riwayat->sesi_qr_id)
                ->where('dibuat_oleh', $userId)
                ->exists(),
            403,
            'Anda tidak memiliki akses ke riwayat scan ini.'
        );

        $riwayat->load([
            'sesiQr.kelas:id,nama_kelas',
            'sesiQr.mataPelajaran:id,nama_mapel',
            'sesiQr.jadwalPelajaran.ruang',
            'siswa:id,nama_lengkap,nis',
            'absensi',
        ]);

        return view('guru.riwayat-scan.show', compact('riwayat'));
    }
}