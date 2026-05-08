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
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SesiQrGuruController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CATATAN KONSISTENSI
    |--------------------------------------------------------------------------
    | Tabel sesi_qr_guru:
    |   - kode_qr          : uuid, di-generate otomatis via Model::booted()
    |   - is_active        : boolean, default true
    |   - berlaku_mulai    : timestamp (datetime-local dari form)
    |   - kadaluarsa_pada  : timestamp (datetime-local dari form)
    |   - radius_meter     : nullable integer
    |   - dibuat_oleh      : FK users.id
    |
    | Tabel riwayat_scan_guru:
    |   - hasil: enum('berhasil','gagal_kadaluarsa','gagal_duplikat','gagal_lokasi')
    |
    | AbsensiGuru::METODE_LIST = ['manual', 'qr']
    |--------------------------------------------------------------------------
    */

    // ─── INDEX ────────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $query = SesiQrGuru::with(['pembuat'])
            ->withCount([
                'riwayatScan',
                'riwayatScan as scan_berhasil_count' => fn ($q) => $q->where('hasil', 'berhasil'),
            ]);

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        $sesiList = $query->latest()->paginate(15)->withQueryString();

        return view('admin.sesi-qr-guru.index', compact('sesiList'));
    }

    // ─── CREATE ───────────────────────────────────────────────────────────────

    public function create()
    {
        return view('admin.sesi-qr-guru.create');
    }

    // ─── STORE ────────────────────────────────────────────────────────────────

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

        // Cegah duplikat sesi aktif di tanggal yang sama
        $existing = SesiQrGuru::whereDate('tanggal', $validated['tanggal'])
            ->where('is_active', true)
            ->first();

        if ($existing) {
            return back()
                ->withInput()
                ->with('error', 'Sudah ada sesi QR guru aktif pada tanggal ini. Nonaktifkan sesi sebelumnya terlebih dahulu.');
        }

        $validated['dibuat_oleh'] = Auth::id();
        // kode_qr di-generate otomatis oleh SesiQrGuru::booted()

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
        // Cegah hapus jika sudah ada scan berhasil
        if ($sesiQrGuru->riwayatScan()->where('hasil', 'berhasil')->exists()) {
            return back()->with('error', 'Tidak dapat menghapus sesi yang sudah memiliki scan berhasil. Nonaktifkan saja.');
        }

        $sesiQrGuru->delete();

        return redirect()->route('admin.sesi-qr-guru.index')
            ->with('success', 'Sesi QR guru berhasil dihapus.');
    }

    // ─── CETAK QR (PDF satu halaman) ─────────────────────────────────────────

    // public function cetakQr(SesiQrGuru $sesiQrGuru)
    // {
    //     $sesiQrGuru->load('pembuat');

    //     $qrSvg    = QrCode::format('svg')
    //                     ->size(300)
    //                     ->errorCorrection('H')
    //                     ->margin(1)
    //                     ->generate($sesiQrGuru->kode_qr);

    //     $qrBase64 = base64_encode($qrSvg);
    //     $qrMime   = 'image/svg+xml';

    //     $pdf = Pdf::loadView('admin.sesi-qr-guru.exports.cetak-qr', compact('sesiQrGuru', 'qrBase64', 'qrMime'))
    //         ->setPaper('a5', 'portrait')
    //         ->setOption('isHtml5ParserEnabled', true)
    //         ->setOption('isRemoteEnabled', true);

    //     return $pdf->stream('qr_guru_' . $sesiQrGuru->id . '_' . $sesiQrGuru->tanggal->format('Ymd') . '.pdf');
    // }
    public function cetakQr(SesiQrGuru $sesiQrGuru)
    {
        $sesiQrGuru->load('pembuat');

        // Hapus semua kode PDF/QrCode base64 yang lama, cukup return view
        return view('admin.sesi-qr-guru.exports.cetak-qr', compact('sesiQrGuru'));
    }

    // ─── HALAMAN SCAN ─────────────────────────────────────────────────────────

    public function scanGuru(SesiQrGuru $sesiQrGuru)
    {
        if (! $sesiQrGuru->masihBerlaku()) {
            return redirect()->route('admin.sesi-qr-guru.index')
                ->with('error', 'Sesi QR sudah tidak aktif atau telah kadaluarsa.');
        }

        $guruList = Guru::aktif()->orderBy('nama_lengkap')->get();

        return view('admin.sesi-qr-guru.scan', compact('sesiQrGuru', 'guruList'));
    }

    // ─── PROSES QR SCAN (AJAX) ────────────────────────────────────────────────

    public function prosesQr(Request $request): JsonResponse
    {
        $request->validate([
            'kode_qr'   => ['required', 'string'],
            'guru_id'   => ['required', 'exists:guru,id'],
            'latitude'  => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
        ]);

        $sesiQr    = SesiQrGuru::where('kode_qr', $request->kode_qr)->first();
        $guru      = Guru::findOrFail($request->guru_id);
        $ipAddress = $request->ip();
        $device    = $request->userAgent();

        // 1. Validasi QR ditemukan
        if (! $sesiQr) {
            return response()->json([
                'berhasil' => false,
                'pesan'    => 'QR code tidak dikenali.',
            ], 404);
        }

        // 2. Cek sesi aktif
        if (! $sesiQr->is_active) {
            $this->catatRiwayat($sesiQr, $guru->id, 'gagal_kadaluarsa', $request, $ipAddress, $device);
            return response()->json([
                'berhasil' => false,
                'pesan'    => 'Sesi QR sudah dinonaktifkan.',
            ], 422);
        }

        // 3. Cek kadaluarsa
        if (! $sesiQr->masihBerlaku()) {
            $this->catatRiwayat($sesiQr, $guru->id, 'gagal_kadaluarsa', $request, $ipAddress, $device);
            return response()->json([
                'berhasil' => false,
                'pesan'    => 'Sesi QR sudah kadaluarsa.',
            ], 422);
        }

        // 4. Cek sebelum berlaku
        if (now()->isBefore($sesiQr->berlaku_mulai)) {
            return response()->json([
                'berhasil' => false,
                'pesan'    => 'QR belum aktif. Berlaku mulai ' . $sesiQr->berlaku_mulai->format('H:i'),
            ], 422);
        }

        // 5. Cek duplikat scan berhasil
        $sudahScan = RiwayatScanGuru::where('sesi_qr_guru_id', $sesiQr->id)
            ->where('guru_id', $guru->id)
            ->where('hasil', 'berhasil')
            ->exists();

        if ($sudahScan) {
            $this->catatRiwayat($sesiQr, $guru->id, 'gagal_duplikat', $request, $ipAddress, $device);
            return response()->json([
                'berhasil' => false,
                'pesan'    => 'Guru ini sudah melakukan absensi pada sesi ini.',
            ], 422);
        }

        // 6. Validasi radius GPS jika dikonfigurasi
        if ($sesiQr->radius_meter) {
            if (! $request->filled('latitude') || ! $request->filled('longitude')) {
                return response()->json([
                    'berhasil'   => false,
                    'pesan'      => 'Izinkan akses lokasi GPS untuk absensi ini.',
                    'butuh_gps'  => true,
                ], 422);
            }

            $latSekolah = config('sekolah.latitude', -7.2575);
            $lngSekolah = config('sekolah.longitude', 112.7521);

            $jarak = $this->hitungJarak(
                (float) $request->latitude,
                (float) $request->longitude,
                $latSekolah,
                $lngSekolah
            );

            if ($jarak > $sesiQr->radius_meter) {
                $this->catatRiwayat($sesiQr, $guru->id, 'gagal_lokasi', $request, $ipAddress, $device);
                return response()->json([
                    'berhasil'      => false,
                    'pesan'         => "Lokasi terlalu jauh dari sekolah ({$jarak}m). Radius maksimal {$sesiQr->radius_meter}m.",
                    'jarak_meter'   => $jarak,
                    'radius_meter'  => $sesiQr->radius_meter,
                ], 422);
            }
        }

        // 7. Semua valid — simpan dalam transaksi
        DB::transaction(function () use ($sesiQr, $guru, $request, $ipAddress, $device) {
            // Tentukan status: telat jika scan setelah berlaku_mulai + 15 menit
            $status = now()->isAfter($sesiQr->berlaku_mulai->addMinutes(15)) ? 'telat' : 'hadir';

            // Catat riwayat scan berhasil
            RiwayatScanGuru::create([
                'sesi_qr_guru_id' => $sesiQr->id,
                'guru_id'         => $guru->id,
                'dipindai_pada'   => now(),
                'hasil'           => 'berhasil',
                'latitude'        => $request->latitude,
                'longitude'       => $request->longitude,
                'ip_address'      => $ipAddress,
                'info_perangkat'  => $device,
            ]);

            // Buat atau update AbsensiGuru
            AbsensiGuru::updateOrCreate(
                [
                    'guru_id' => $guru->id,
                    'tanggal' => $sesiQr->tanggal->toDateString(),
                ],
                [
                    'dicatat_oleh' => Auth::id(),
                    'jam_masuk'    => now()->format('H:i'),
                    'status'       => $status,
                    'metode'       => 'qr',
                ]
            );
        });

        $status = now()->isAfter($sesiQr->berlaku_mulai->addMinutes(15)) ? 'telat' : 'hadir';
        $label  = $status === 'telat' ? 'Terlambat' : 'Hadir';

        return response()->json([
            'berhasil'   => true,
            'pesan'      => "Absensi berhasil dicatat. Status: {$label}.",
            'nama_guru'  => $guru->nama_lengkap,
            'waktu_scan' => now()->format('H:i:s'),
            'status'     => $status,
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
     * Hitung jarak dua koordinat GPS menggunakan formula Haversine (meter).
     */
    private function hitungJarak(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $R    = 6371000;
        $phi1 = deg2rad($lat1);
        $phi2 = deg2rad($lat2);
        $dphi = deg2rad($lat2 - $lat1);
        $dlng = deg2rad($lng2 - $lng1);

        $a = sin($dphi / 2) ** 2 + cos($phi1) * cos($phi2) * sin($dlng / 2) ** 2;
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return round($R * $c, 2);
    }

}