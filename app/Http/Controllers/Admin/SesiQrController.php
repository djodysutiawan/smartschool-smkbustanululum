<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SesiQr;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SesiQrExport;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Siswa;
use App\Models\Notifikasi;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SesiQrController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CATATAN KONSISTENSI MIGRASI
    |--------------------------------------------------------------------------
    | Tabel sesi_qr:
    |   - kode_qr  : uuid, di-generate otomatis via Model::booted()
    |   - is_active: boolean, default true
    |   - radius_meter: nullable integer (batasan GPS)
    |   - berlaku_mulai / kadaluarsa_pada: timestamp (bukan date)
    |
    | Route yang tersedia (dari web.php):
    |   index, create, store, show, destroy, nonaktifkan,
    |   cetak-qr, export.pdf, export.excel
    |   (tidak ada edit/update — sesi QR tidak boleh diubah setelah dibuat)
    |--------------------------------------------------------------------------
    */

    // -------------------------------------------------------------------------
    // INDEX
    // -------------------------------------------------------------------------

    public function index(Request $request)
    {
        $query = SesiQr::with(['kelas', 'mataPelajaran', 'dibuatOleh']);

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        $sesiQrs   = $query->latest()->paginate(15)->withQueryString();
        $kelasList = Kelas::aktif()->orderBy('nama_kelas')->get();

        return view('admin.sesi-qr.index', compact('sesiQrs', 'kelasList'));
    }

    // -------------------------------------------------------------------------
    // CREATE & STORE
    // -------------------------------------------------------------------------

    public function create()
    {
        $kelasList     = Kelas::aktif()->orderBy('nama_kelas')->get();
        $mataPelajaran = MataPelajaran::aktif()->orderBy('nama_mapel')->get();

        return view('admin.sesi-qr.create', compact('kelasList', 'mataPelajaran'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kelas_id'          => ['required', 'exists:kelas,id'],
            'mata_pelajaran_id' => ['nullable', 'exists:mata_pelajaran,id'],
            'tanggal'           => ['required', 'date'],
            'berlaku_mulai'     => ['required', 'date'],
            'kadaluarsa_pada'   => ['required', 'date', 'after:berlaku_mulai'],
            'radius_meter'      => ['nullable', 'integer', 'min:10', 'max:1000'],
        ]);

        $validated['dibuat_oleh'] = Auth::id();

        $sesiQr = SesiQr::create($validated);
        $sesiQr->load(['kelas', 'mataPelajaran']);

        // Kirim notifikasi ke semua siswa aktif di kelas tersebut
        $siswaList = Siswa::where('kelas_id', $sesiQr->kelas_id)
            ->aktif()
            ->with('pengguna')
            ->get();

        $pesanNotif = sprintf(
            'Absensi QR dibuka untuk %s — %s. Berlaku sampai %s.',
            $sesiQr->mataPelajaran->nama_mapel ?? 'mata pelajaran',
            $sesiQr->tanggal->format('d M Y'),
            $sesiQr->kadaluarsa_pada->format('H:i')
        );

        $notifikasiData = $siswaList
            ->filter(fn($s) => $s->pengguna_id)
            ->map(fn($s) => [
                'pengguna_id' => $s->pengguna_id,
                'judul'       => 'Absensi QR Dibuka',
                'pesan'       => $pesanNotif,
                'sudah_dibaca'=> false,
                'created_at'  => now(),
                'updated_at'  => now(),
            ])->values()->toArray();

        if (! empty($notifikasiData)) {
            Notifikasi::insert($notifikasiData);
        }

        

        return redirect()->route('admin.sesi-qr.index')
            ->with('success', "Sesi QR berhasil dibuat & notifikasi dikirim ke {$siswaList->count()} siswa.");
    }

    // -------------------------------------------------------------------------
    // SHOW
    // -------------------------------------------------------------------------

    public function show(SesiQr $sesiQr)
    {
        $sesiQr->load([
            'kelas',
            'mataPelajaran',
            'dibuatOleh',
            'riwayatScan.siswa',
        ]);

        return view('admin.sesi-qr.show', compact('sesiQr'));
    }

    // -------------------------------------------------------------------------
    // NONAKTIFKAN
    // -------------------------------------------------------------------------

    public function nonaktifkan(SesiQr $sesiQr)
    {
        $sesiQr->nonaktifkan();

        return back()->with('success', 'Sesi QR berhasil dinonaktifkan.');
    }

    // -------------------------------------------------------------------------
    // DESTROY
    // -------------------------------------------------------------------------

    public function destroy(SesiQr $sesiQr)
    {
        $sesiQr->delete();

        return redirect()->route('admin.sesi-qr.index')
            ->with('success', 'Sesi QR berhasil dihapus.');
    }

    // -------------------------------------------------------------------------
    // CETAK QR (PDF satu halaman dengan QR code)
    // -------------------------------------------------------------------------

    /**
     * Render QR code satu sesi ke PDF yang bisa dicetak / ditempel di kelas.
     *
     * Tampilan view harus menggunakan library QR (misalnya simplesoftwareio/simple-qrcode
     * atau endroid/qr-code) untuk merender $sesiQr->kode_qr sebagai gambar.
     */
    public function cetakQr(SesiQr $sesiQr)
    {
        $sesiQr->load(['kelas', 'mataPelajaran']);

        // SVG tidak butuh Imagick sama sekali
        $qrSvg    = QrCode::format('svg')
                        ->size(300)
                        ->errorCorrection('H')
                        ->margin(1)
                        ->generate($sesiQr->kode_qr);

        $qrBase64 = base64_encode($qrSvg);
        $qrMime   = 'image/svg+xml';

        $pdf = Pdf::loadView('admin.sesi-qr.exports.cetak-qr', compact('sesiQr', 'qrBase64', 'qrMime'))
            ->setPaper('a5', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', true);

        return $pdf->stream('qr_sesi_' . $sesiQr->id . '_' . $sesiQr->tanggal->format('Ymd') . '.pdf');
    }

    // -------------------------------------------------------------------------
    // EXPORT PDF (daftar semua sesi)
    // -------------------------------------------------------------------------

    public function exportPdf(Request $request)
    {
        $query = SesiQr::with(['kelas', 'mataPelajaran', 'dibuatOleh']);

        if ($request->filled('kelas_id'))  $query->where('kelas_id', $request->kelas_id);
        if ($request->filled('tanggal'))   $query->whereDate('tanggal', $request->tanggal);
        if ($request->filled('is_active')) $query->where('is_active', $request->boolean('is_active'));

        $sesiQrs = $query->latest()->get();

        $pdf = Pdf::loadView('admin.sesi-qr.exports.pdf', compact('sesiQrs'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('sesi_qr_' . now()->format('Ymd_His') . '.pdf');
    }

    // -------------------------------------------------------------------------
    // EXPORT EXCEL
    // -------------------------------------------------------------------------

    public function exportExcel(Request $request)
    {
        $filters = $request->only(['kelas_id', 'tanggal', 'is_active']);

        return Excel::download(
            new SesiQrExport($filters),
            'sesi_qr_' . now()->format('Ymd_His') . '.xlsx'
        );
    }
}