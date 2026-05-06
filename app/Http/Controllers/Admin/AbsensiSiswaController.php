<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\RiwayatScanQr;
use App\Models\SesiQr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AbsensiSiswaController extends Controller
{
    /**
     * Halaman scan QR siswa (tampil kamera + input kode manual).
     */
    public function scanPage()
    {
        $siswa = Auth::user()->siswa;

        $absensiHariIni = Absensi::with(['mataPelajaran', 'kelas'])
            ->where('siswa_id', $siswa->id)
            ->whereDate('tanggal', today())
            ->orderBy('created_at')
            ->get();

        return view('siswa.absensi.scan', compact('siswa', 'absensiHariIni'));
    }

    /**
     * Proses scan QR: validasi, catat riwayat, buat absensi.
     * Endpoint ini dipanggil via AJAX dari halaman kamera.
     */
    public function prosesScan(Request $request)
    {
        $validated = $request->validate([
            'kode_qr'   => ['required', 'string'],
            'latitude'  => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
        ]);

        $siswa = Auth::user()->siswa;

        if (! $siswa) {
            return response()->json(['success' => false, 'pesan' => 'Akun Anda tidak terhubung ke data siswa.'], 403);
        }

        // 1. Cari sesi QR
        $sesiQr = SesiQr::with('kelas')->where('kode_qr', $validated['kode_qr'])->first();

        if (! $sesiQr) {
            return response()->json(['success' => false, 'pesan' => 'QR code tidak dikenali.'], 404);
        }

        // 2. Cek apakah sesi masih aktif
        if (! $sesiQr->is_active) {
            $this->catatRiwayat($sesiQr, $siswa->id, $validated, 'ditolak_nonaktif', 'QR tidak aktif.');
            return response()->json(['success' => false, 'pesan' => 'QR code sudah tidak aktif.'], 422);
        }

        // 3. Cek kadaluarsa
        if ($sesiQr->isKadaluarsa()) {
            $this->catatRiwayat($sesiQr, $siswa->id, $validated, 'ditolak_kadaluarsa', 'QR sudah kadaluarsa.');
            return response()->json(['success' => false, 'pesan' => 'QR code sudah kadaluarsa.'], 422);
        }

        // 4. Cek sebelum berlaku
        if (now()->isBefore($sesiQr->berlaku_mulai)) {
            return response()->json([
                'success' => false,
                'pesan'   => 'QR code belum aktif. Berlaku mulai ' . $sesiQr->berlaku_mulai->format('H:i'),
            ], 422);
        }

        // 5. Cek apakah siswa anggota kelas ini
        if ($siswa->kelas_id !== $sesiQr->kelas_id) {
            $this->catatRiwayat($sesiQr, $siswa->id, $validated, 'ditolak_bukan_anggota', 'Bukan anggota kelas ini.');
            return response()->json(['success' => false, 'pesan' => 'Anda bukan anggota kelas ini.'], 403);
        }

        // 6. Cek duplikat scan valid
        $sudahScan = RiwayatScanQr::where('sesi_qr_id', $sesiQr->id)
            ->where('siswa_id', $siswa->id)
            ->where('status', 'valid')
            ->exists();

        if ($sudahScan) {
            return response()->json(['success' => false, 'pesan' => 'Anda sudah melakukan absensi untuk sesi ini.'], 422);
        }

        // 7. Validasi radius GPS (jika dikonfigurasi)
        $jarakMeter = null;
        if ($sesiQr->latitude && $sesiQr->longitude) {
            if (! $validated['latitude'] || ! $validated['longitude']) {
                return response()->json([
                    'success'   => false,
                    'pesan'     => 'Izinkan akses lokasi GPS untuk absensi ini.',
                    'butuh_gps' => true,
                ], 422);
            }

            $jarakMeter = (int) round($sesiQr->hitungJarak(
                (float) $validated['latitude'],
                (float) $validated['longitude']
            ));

            if (! $sesiQr->dalamRadius((float) $validated['latitude'], (float) $validated['longitude'])) {
                $this->catatRiwayat($sesiQr, $siswa->id, $validated, 'ditolak_radius',
                    "Jarak {$jarakMeter}m, radius izin {$sesiQr->radius_meter}m.", $jarakMeter);

                return response()->json([
                    'success'      => false,
                    'pesan'        => "Anda berada terlalu jauh ({$jarakMeter}m). Radius maksimal {$sesiQr->radius_meter}m.",
                    'jarak_meter'  => $jarakMeter,
                    'radius_meter' => $sesiQr->radius_meter,
                ], 422);
            }
        }

        // 8. Semua valid → buat absensi dan riwayat dalam satu transaksi
        $hasil = DB::transaction(function () use ($sesiQr, $siswa, $validated, $jarakMeter) {
            // Tentukan status: hadir atau telat (toleransi 15 menit)
            $statusAbsensi = 'hadir';
            if ($sesiQr->berlaku_mulai && now()->isAfter($sesiQr->berlaku_mulai->addMinutes(15))) {
                $statusAbsensi = 'telat';
            }

            /**
             * PERBAIKAN KRITIS:
             * 1. Hapus 'tahun_ajaran_id' — kolom ini tidak ada di tabel absensi.
             *    Filter per tahun ajaran dilakukan via kelas_id (kelas sudah punya tahun_ajaran_id).
             *
             * 2. Hapus 'sesi_qr_id' dari kolom yang tidak ada — sudah ditambahkan di migrasi fix.
             *    Jika migrasi fix belum dijalankan, hapus baris sesi_qr_id dari array ini.
             *
             * 3. Fix metode: pakai Absensi::METODE_QR ('qr') bukan 'qr_scan'.
             *    'qr_scan' tidak ada di enum DB asal, menyebabkan error constraint.
             *    Setelah migrasi fix dijalankan, 'qr_scan' juga valid — tapi 'qr' lebih konsisten.
             */
            $absensi = Absensi::create([
                'siswa_id'            => $siswa->id,
                'kelas_id'            => $sesiQr->kelas_id,
                'sesi_qr_id'          => $sesiQr->id,           // Ada setelah migrasi fix
                'mata_pelajaran_id'   => $sesiQr->mata_pelajaran_id, // Ada setelah migrasi fix
                'jadwal_pelajaran_id' => $sesiQr->jadwal_pelajaran_id,
                'dicatat_oleh'        => Auth::id(),
                'tanggal'             => $sesiQr->tanggal,
                'status'              => $statusAbsensi,
                'metode'              => Absensi::METODE_QR,     // PERBAIKAN: 'qr' bukan 'qr_scan'
                'jam_masuk'           => now()->format('H:i:s'),
            ]);

            $riwayat = RiwayatScanQr::create([
                'sesi_qr_id'   => $sesiQr->id,
                'siswa_id'     => $siswa->id,
                'absensi_id'   => $absensi->id,
                'latitude'     => $validated['latitude'] ?? null,
                'longitude'    => $validated['longitude'] ?? null,
                'jarak_meter'  => $jarakMeter,
                'status'       => 'valid',
                'user_agent'   => request()->userAgent(),
                'di_scan_pada' => now(),
            ]);

            $sesiQr->incrementScan();

            return [
                'absensi' => $absensi,
                'riwayat' => $riwayat,
                'status'  => $statusAbsensi,
            ];
        });

        $label = $hasil['status'] === 'telat' ? 'Terlambat' : 'Hadir';

        return response()->json([
            'success'        => true,
            'pesan'          => "Absensi berhasil! Status: {$label}.",
            'status'         => $hasil['status'],
            'nama_siswa'     => $siswa->nama_lengkap,
            'mata_pelajaran' => $sesiQr->mataPelajaran->nama_mapel ?? '-',
            'jam_masuk'      => now()->format('H:i:s'),
            'jarak_meter'    => $jarakMeter,
        ]);
    }

    /**
     * Halaman riwayat absensi siswa.
     */
    public function riwayat(Request $request)
    {
        $siswa = Auth::user()->siswa;

        $query = Absensi::with(['mataPelajaran', 'kelas', 'jadwalPelajaran'])
            ->where('siswa_id', $siswa->id);

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }
        if ($request->filled('mata_pelajaran_id')) {
            $query->where('mata_pelajaran_id', $request->mata_pelajaran_id);
        }

        $absensi = $query->latest('tanggal')->paginate(30)->withQueryString();
        $stats   = $this->hitungStatistikSiswa($siswa->id, $request);

        return view('siswa.absensi.riwayat', compact('absensi', 'stats', 'siswa'));
    }

    // ── Private helpers ───────────────────────────────────────────────────────

    private function catatRiwayat(
        SesiQr $sesiQr,
        int $siswaId,
        array $validated,
        string $status,
        string $keterangan,
        ?int $jarakMeter = null,
    ): void {
        RiwayatScanQr::firstOrCreate(
            [
                'sesi_qr_id' => $sesiQr->id,
                'siswa_id'   => $siswaId,
                'status'     => $status,
            ],
            [
                'latitude'     => $validated['latitude'] ?? null,
                'longitude'    => $validated['longitude'] ?? null,
                'jarak_meter'  => $jarakMeter,
                'keterangan'   => $keterangan,
                'user_agent'   => request()->userAgent(),
                'di_scan_pada' => now(),
            ]
        );
    }

    private function hitungStatistikSiswa(int $siswaId, Request $request): array
    {
        $query = Absensi::where('siswa_id', $siswaId);

        if ($request->filled('bulan')) $query->whereMonth('tanggal', $request->bulan);
        if ($request->filled('tahun')) $query->whereYear('tanggal', $request->tahun);

        $total = (clone $query)->count();
        $hadir = (clone $query)->whereIn('status', Absensi::STATUS_DIHITUNG_HADIR)->count();
        $izin  = (clone $query)->where('status', Absensi::STATUS_IZIN)->count();
        $sakit = (clone $query)->where('status', Absensi::STATUS_SAKIT)->count();
        $alfa  = (clone $query)->where('status', Absensi::STATUS_ALFA)->count();
        $telat = (clone $query)->where('status', Absensi::STATUS_TELAT)->count();

        return [
            'total'      => $total,
            'hadir'      => $hadir,
            'izin'       => $izin,
            'sakit'      => $sakit,
            'alfa'       => $alfa,
            'telat'      => $telat,
            'persentase' => $total > 0 ? round($hadir / $total * 100, 1) : 0,
        ];
    }
}