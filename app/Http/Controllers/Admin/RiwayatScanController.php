<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RiwayatScanQr;
use App\Models\SesiQr;
use App\Models\Siswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RiwayatScanExport;

class RiwayatScanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CATATAN KONSISTENSI
    |--------------------------------------------------------------------------
    | Model RiwayatScanQr:
    |   - Kolom status   : enum(valid | ditolak_radius | ditolak_kadaluarsa |
    |                           ditolak_nonaktif | ditolak_duplikat |
    |                           ditolak_bukan_anggota)
    |   - Kolom dipindai_pada : timestamp  ← nama kolom tunggal di seluruh codebase
    |   - Kolom ip_address    : varchar(45) nullable
    |   - Kolom user_agent    : text nullable
    |
    | Route (web.php):
    |   admin.riwayat-scan.index
    |   admin.riwayat-scan.show
    |   admin.riwayat-scan.destroy
    |   admin.riwayat-scan.export.pdf
    |   admin.riwayat-scan.export.excel
    |--------------------------------------------------------------------------
    */

    // ── INDEX ─────────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $query = RiwayatScanQr::with([
            'sesiQr.kelas',
            'sesiQr.mataPelajaran',
            'siswa',
        ]);

        $this->applyFilters($query, $request);

        $riwayats   = $query->latest('di_scan_pada')->paginate(20)->withQueryString();
        $sesiQrs    = SesiQr::with('kelas')->latest()->get();
        $siswas     = Siswa::aktif()->orderBy('nama_lengkap')->get();
        $statusList = RiwayatScanQr::statusList();
        $hasilList  = ['berhasil', 'gagal_kadaluarsa', 'gagal_lokasi', 'gagal_duplikat'];

        return view('admin.riwayat-scan.index',
            compact('riwayats', 'sesiQrs', 'siswas', 'statusList', 'hasilList'));
    }

    // ── SHOW ──────────────────────────────────────────────────────────────────

    public function show(RiwayatScanQr $riwayatScan)
    {
        $riwayatScan->load([
            'sesiQr.kelas',
            'sesiQr.mataPelajaran',
            'siswa',
            'absensi',
        ]);

        return view('admin.riwayat-scan.show', compact('riwayatScan'));
    }

    // ── DESTROY ───────────────────────────────────────────────────────────────

    public function destroy(RiwayatScanQr $riwayatScan)
    {
        $riwayatScan->delete();

        return redirect()->route('admin.riwayat-scan.index')
            ->with('success', 'Riwayat scan berhasil dihapus.');
    }

    // ── EXPORT PDF ────────────────────────────────────────────────────────────

    public function exportPdf(Request $request)
    {
        $query = RiwayatScanQr::with([
            'sesiQr.kelas',
            'sesiQr.mataPelajaran',
            'siswa',
        ]);

        $this->applyFilters($query, $request);

        $riwayats   = $query->latest('di_scan_pada')->get();
        $statusList = RiwayatScanQr::statusList();

        $pdf = Pdf::loadView(
            'admin.riwayat-scan.exports.pdf',
            compact('riwayats', 'statusList')
        )->setPaper('a4', 'landscape');

        return $pdf->download('riwayat_scan_' . now()->format('Ymd_His') . '.pdf');
    }

    // ── EXPORT EXCEL ─────────────────────────────────────────────────────────

    public function exportExcel(Request $request)
    {
        // Hanya teruskan filter yang relevan — nama key harus cocok dengan
        // yang dipakai di applyFilters() agar hasil export konsisten dengan tampilan.
        $filters = $request->only([
            'sesi_qr_id',
            'siswa_id',
            'status',
            'hasil',
            'tanggal',
            'tanggal_dari',
            'tanggal_sampai',
        ]);

        return Excel::download(
            new RiwayatScanExport($filters),
            'riwayat_scan_' . now()->format('Ymd_His') . '.xlsx'
        );
    }

    // ── HELPER ────────────────────────────────────────────────────────────────

    /**
     * Terapkan filter yang sama untuk index, exportPdf, dan exportExcel.
     * Semua filter menggunakan nama kolom yang konsisten dengan schema DB.
     */
    private function applyFilters(Builder $query, Request $request): void
    {
        if ($request->filled('sesi_qr_id')) {
            $query->where('sesi_qr_id', $request->sesi_qr_id);
        }

        if ($request->filled('siswa_id')) {
            $query->where('siswa_id', $request->siswa_id);
        }

        // Filter kolom status (enum valid|ditolak_*)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter kolom hasil (enum berhasil|gagal_*)
        if ($request->filled('hasil')) {
            $query->where('hasil', $request->hasil);
        }

        // Filter tanggal — menggunakan kolom di_scan_pada (nama asli di DB)
        if ($request->filled('tanggal')) {
            $query->whereDate('di_scan_pada', $request->tanggal);
        }

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('di_scan_pada', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('di_scan_pada', '<=', $request->tanggal_sampai);
        }
    }
}