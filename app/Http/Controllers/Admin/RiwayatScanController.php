<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RiwayatScanQr;
use App\Models\SesiQr;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RiwayatScanExport;
use Barryvdh\DomPDF\Facade\Pdf;

class RiwayatScanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CATATAN KONSISTENSI MIGRASI
    |--------------------------------------------------------------------------
    | Tabel riwayat_scan_qr:
    |   - hasil: enum('berhasil','gagal_kadaluarsa','gagal_lokasi','gagal_duplikat')
    |   - dipindai_pada: timestamp (bukan date)
    |   - latitude / longitude: decimal (nullable)
    |   - ip_address: string(45) nullable
    |   - info_perangkat: text nullable
    |
    | Route yang tersedia (dari web.php):
    |   index, show, destroy, export.pdf, export.excel
    |   (tidak ada create/store/edit/update — hanya dibuat oleh proses scan QR)
    |--------------------------------------------------------------------------
    */

    /** Nilai enum `hasil` yang valid — satu sumber kebenaran. */
    private const HASIL_LIST = [
        'berhasil',
        'gagal_kadaluarsa',
        'gagal_lokasi',
        'gagal_duplikat',
    ];

    // -------------------------------------------------------------------------
    // INDEX
    // -------------------------------------------------------------------------

    public function index(Request $request)
    {
        $query = RiwayatScanQr::with([
            'sesiQr.kelas',
            'sesiQr.mataPelajaran',
            'siswa',
        ]);

        if ($request->filled('sesi_qr_id')) {
            $query->where('sesi_qr_id', $request->sesi_qr_id);
        }

        if ($request->filled('siswa_id')) {
            $query->where('siswa_id', $request->siswa_id);
        }

        if ($request->filled('hasil')) {
            $query->where('hasil', $request->hasil);
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('dipindai_pada', $request->tanggal);
        }

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('dipindai_pada', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('dipindai_pada', '<=', $request->tanggal_sampai);
        }

        $riwayats  = $query->latest('dipindai_pada')->paginate(20)->withQueryString();
        $sesiQrs   = SesiQr::with('kelas')->latest()->get();
        $siswas    = Siswa::aktif()->orderBy('nama_lengkap')->get();
        $hasilList = self::HASIL_LIST;

        return view('admin.riwayat-scan.index',
            compact('riwayats', 'sesiQrs', 'siswas', 'hasilList'));
    }

    // -------------------------------------------------------------------------
    // SHOW
    // -------------------------------------------------------------------------

    public function show(RiwayatScanQr $riwayatScan)
    {
        $riwayatScan->load([
            'sesiQr.kelas',
            'sesiQr.mataPelajaran',
            'siswa',
        ]);

        return view('admin.riwayat-scan.show', compact('riwayatScan'));
    }

    // -------------------------------------------------------------------------
    // DESTROY
    // -------------------------------------------------------------------------

    /**
     * Hapus riwayat scan tertentu.
     * Route: DELETE /admin/riwayat-scan/{riwayatScan}
     */
    public function destroy(RiwayatScanQr $riwayatScan)
    {
        $riwayatScan->delete();

        return redirect()->route('admin.riwayat-scan.index')
            ->with('success', 'Riwayat scan berhasil dihapus.');
    }

    // -------------------------------------------------------------------------
    // EXPORT PDF
    // -------------------------------------------------------------------------

    public function exportPdf(Request $request)
    {
        $query = RiwayatScanQr::with([
            'sesiQr.kelas',
            'sesiQr.mataPelajaran',
            'siswa',
        ]);

        $this->applyFilters($query, $request);

        $riwayats  = $query->latest('dipindai_pada')->get();
        $hasilList = self::HASIL_LIST;

        $pdf = Pdf::loadView('admin.riwayat-scan.exports.pdf', compact('riwayats', 'hasilList'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('riwayat_scan_' . now()->format('Ymd_His') . '.pdf');
    }

    // -------------------------------------------------------------------------
    // EXPORT EXCEL
    // -------------------------------------------------------------------------

    public function exportExcel(Request $request)
    {
        $filters = $request->only([
            'sesi_qr_id', 'siswa_id', 'hasil',
            'tanggal', 'tanggal_dari', 'tanggal_sampai',
        ]);

        return Excel::download(
            new RiwayatScanExport($filters),
            'riwayat_scan_' . now()->format('Ymd_His') . '.xlsx'
        );
    }

    // -------------------------------------------------------------------------
    // HELPER
    // -------------------------------------------------------------------------

    /**
     * Terapkan filter yang sama untuk index & export.
     */
    private function applyFilters(\Illuminate\Database\Eloquent\Builder $query, Request $request): void
    {
        if ($request->filled('sesi_qr_id'))     $query->where('sesi_qr_id', $request->sesi_qr_id);
        if ($request->filled('siswa_id'))        $query->where('siswa_id', $request->siswa_id);
        if ($request->filled('hasil'))           $query->where('hasil', $request->hasil);
        if ($request->filled('tanggal'))         $query->whereDate('dipindai_pada', $request->tanggal);
        if ($request->filled('tanggal_dari'))    $query->whereDate('dipindai_pada', '>=', $request->tanggal_dari);
        if ($request->filled('tanggal_sampai'))  $query->whereDate('dipindai_pada', '<=', $request->tanggal_sampai);
    }
}