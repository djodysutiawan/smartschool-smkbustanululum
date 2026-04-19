<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AbsensiGuru;
use App\Models\Guru;
use App\Models\RiwayatScanGuru;
use App\Models\SesiQrGuru;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SesiQrGuruController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CATATAN KONSISTENSI MIGRASI
    |--------------------------------------------------------------------------
    | Tabel sesi_qr_guru:
    |   - kode_qr          : uuid, di-generate otomatis via Model::booted()
    |   - is_active        : boolean, default true
    |   - berlaku_mulai    : timestamp
    |   - kadaluarsa_pada  : timestamp
    |   - radius_meter     : nullable integer
    |
    | Route yang tersedia:
    |   index, create, store, show, nonaktifkan, destroy,
    |   cetak-qr, scan-guru, proses-qr
    |--------------------------------------------------------------------------
    */

    // ─── INDEX ────────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $query = SesiQrGuru::with(['pembuat'])
            ->withCount(['riwayatScan', 'riwayatScan as scan_berhasil_count' => fn ($q) => $q->where('hasil', 'berhasil')]);

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        $sesiList = $query->latest()->paginate(15)->withQueryString();

        return view('admin.sesi-qr-guru.index', compact('sesiList'));
    }

    // ─── CREATE & STORE ───────────────────────────────────────────────────────

    public function create()
    {
        return view('admin.sesi-qr-guru.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal'         => ['required', 'date'],
            'berlaku_mulai'   => ['required', 'date'],
            'kadaluarsa_pada' => ['required', 'date', 'after:berlaku_mulai'],
            'radius_meter'    => ['nullable', 'integer', 'min:10', 'max:1000'],
        ], [
            'kadaluarsa_pada.after' => 'Waktu kadaluarsa harus setelah waktu berlaku.',
        ]);

        // kode_qr di-generate otomatis oleh SesiQrGuru::booted()
        $validated['dibuat_oleh'] = Auth::id();

        SesiQrGuru::create($validated);

        return redirect()->route('admin.sesi-qr-guru.index')
            ->with('success', 'Sesi QR guru berhasil dibuat.');
    }

    // ─── SHOW ─────────────────────────────────────────────────────────────────

    public function show(SesiQrGuru $sesiQrGuru)
    {
        $sesiQrGuru->load([
            'pembuat',
            'riwayatScan.guru',
        ]);

        return view('admin.sesi-qr-guru.show', compact('sesiQrGuru'));
    }

    // ─── NONAKTIFKAN ─────────────────────────────────────────────────────────

    public function nonaktifkan(SesiQrGuru $sesiQrGuru)
    {
        $sesiQrGuru->nonaktifkan();
        return back()->with('success', 'Sesi QR guru berhasil dinonaktifkan.');
    }

    // ─── DESTROY ─────────────────────────────────────────────────────────────

    public function destroy(SesiQrGuru $sesiQrGuru)
    {
        $sesiQrGuru->delete();
        return redirect()->route('admin.sesi-qr-guru.index')
            ->with('success', 'Sesi QR guru berhasil dihapus.');
    }

    // ─── CETAK QR (PDF satu halaman) ─────────────────────────────────────────

    public function cetakQr(SesiQrGuru $sesiQrGuru)
    {
        $sesiQrGuru->load('pembuat');

        $pdf = Pdf::loadView('admin.sesi-qr-guru.exports.cetak-qr', compact('sesiQrGuru'))
            ->setPaper('a5', 'portrait');

        return $pdf->stream('qr_guru_' . $sesiQrGuru->id . '_' . $sesiQrGuru->tanggal->format('Ymd') . '.pdf');
    }

    // ─── HALAMAN SCAN (ditampilkan ke guru untuk di-scan) ────────────────────

    /**
     * Halaman yang menampilkan form scan QR oleh guru piket.
     * Guru piket mengarahkan kamera ke QR code yang sudah dicetak/ditampilkan.
     */
    public function scanGuru(SesiQrGuru $sesiQrGuru)
    {
        // Cek apakah sesi masih berlaku
        if (! $sesiQrGuru->masihBerlaku()) {
            return redirect()->route('admin.sesi-qr-guru.index')
                ->with('error', 'Sesi QR sudah tidak aktif atau telah kadaluarsa.');
        }

        $guruList = Guru::aktif()->orderBy('nama_lengkap')->get();

        return view('admin.sesi-qr-guru.scan', compact('sesiQrGuru', 'guruList'));
    }

    // ─── PROSES QR SCAN ──────────────────────────────────────────────────────

    /**
     * Memproses hasil scan QR kode dari guru.
     * Dipanggil via AJAX dari halaman scan atau dari perangkat guru.
     *
     * Flow:
     * 1. Validasi kode QR → cari SesiQrGuru
     * 2. Cek sesi masih berlaku (is_active + waktu)
     * 3. Cek duplikat (guru ini sudah scan di sesi yang sama)
     * 4. Cek lokasi GPS jika radius_meter diset
     * 5. Simpan RiwayatScanGuru
     * 6. Buat/update AbsensiGuru
     */
    public function prosesQr(Request $request): JsonResponse
    {
        $request->validate([
            'kode_qr'  => ['required', 'string'],
            'guru_id'  => ['required', 'exists:guru,id'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude'=> ['nullable', 'numeric', 'between:-180,180'],
        ]);

        $sesiQr    = SesiQrGuru::where('kode_qr', $request->kode_qr)->first();
        $guru      = Guru::findOrFail($request->guru_id);
        $ipAddress = $request->ip();
        $device    = $request->userAgent();

        // ── Validasi sesi ────────────────────────────────────────────────────
        if (! $sesiQr || ! $sesiQr->masihBerlaku()) {
            $this->catatRiwayat($sesiQr, $guru->id, 'gagal_kadaluarsa', $request, $ipAddress, $device);
            return response()->json([
                'berhasil' => false,
                'pesan'    => 'Sesi QR sudah tidak aktif atau telah kadaluarsa.',
            ], 422);
        }

        // ── Cek duplikat ─────────────────────────────────────────────────────
        $sudahScan = RiwayatScanGuru::where('sesi_qr_guru_id', $sesiQr->id)
            ->where('guru_id', $guru->id)
            ->where('hasil', 'berhasil')
            ->exists();

        if ($sudahScan) {
            $this->catatRiwayat($sesiQr, $guru->id, 'gagal_duplikat', $request, $ipAddress, $device);
            return response()->json([
                'berhasil' => false,
                'pesan'    => 'Guru ini sudah melakukan absensi QR pada sesi ini.',
            ], 422);
        }

        // ── Cek lokasi GPS (jika sesi membatasi radius) ───────────────────────
        if ($sesiQr->radius_meter && $request->filled('latitude') && $request->filled('longitude')) {
            // Koordinat default sekolah (harus dikonfigurasi sesuai lokasi sekolah)
            $latSekolah = config('sekolah.latitude', -7.2575);
            $lngSekolah = config('sekolah.longitude', 112.7521);

            $jarak = $this->hitungJarak(
                $request->latitude, $request->longitude,
                $latSekolah, $lngSekolah
            );

            if ($jarak > $sesiQr->radius_meter) {
                $this->catatRiwayat($sesiQr, $guru->id, 'gagal_lokasi', $request, $ipAddress, $device);
                return response()->json([
                    'berhasil' => false,
                    'pesan'    => "Lokasi Anda terlalu jauh dari sekolah ({$jarak}m > {$sesiQr->radius_meter}m).",
                ], 422);
            }
        }

        // ── Simpan riwayat & absensi dalam transaksi ──────────────────────────
        DB::transaction(function () use ($sesiQr, $guru, $request, $ipAddress, $device) {
            // Simpan riwayat scan berhasil
            $this->catatRiwayat($sesiQr, $guru->id, 'berhasil', $request, $ipAddress, $device);

            // Tentukan status: telat jika scan setelah berlaku_mulai + 15 menit
            $batasTelat = $sesiQr->berlaku_mulai->addMinutes(15);
            $status     = now()->gt($batasTelat) ? 'telat' : 'hadir';

            // Buat absensi guru (updateOrCreate agar aman dari race condition)
            AbsensiGuru::updateOrCreate(
                [
                    'guru_id' => $guru->id,
                    'tanggal' => $sesiQr->tanggal,
                ],
                [
                    'dicatat_oleh' => Auth::id(),
                    'jam_masuk'    => now()->format('H:i'),
                    'status'       => $status,
                    'metode'       => 'qr',
                ]
            );
        });

        return response()->json([
            'berhasil'     => true,
            'pesan'        => 'Absensi berhasil dicatat.',
            'nama_guru'    => $guru->nama_lengkap,
            'waktu_scan'   => now()->format('H:i:s'),
        ]);
    }

    // ─── HELPER PRIVATE ──────────────────────────────────────────────────────

    private function catatRiwayat(
        ?SesiQrGuru $sesiQr,
        int $guruId,
        string $hasil,
        Request $request,
        string $ipAddress,
        ?string $device
    ): void {
        if (! $sesiQr) return;

        RiwayatScanGuru::create([
            'sesi_qr_guru_id' => $sesiQr->id,
            'guru_id'         => $guruId,
            'dipindai_pada'   => now(),
            'hasil'           => $hasil,
            'latitude'        => $request->latitude,
            'longitude'       => $request->longitude,
            'ip_address'      => $ipAddress,
            'info_perangkat'  => $device,
        ]);
    }

    /**
     * Hitung jarak dua koordinat GPS menggunakan formula Haversine (dalam meter).
     */
    private function hitungJarak(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $R    = 6371000; // radius bumi dalam meter
        $phi1 = deg2rad($lat1);
        $phi2 = deg2rad($lat2);
        $dphi = deg2rad($lat2 - $lat1);
        $dlng = deg2rad($lng2 - $lng1);

        $a = sin($dphi / 2) ** 2 + cos($phi1) * cos($phi2) * sin($dlng / 2) ** 2;
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return round($R * $c, 2);
    }
}