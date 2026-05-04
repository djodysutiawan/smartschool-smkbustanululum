<?php

namespace App\Http\Controllers\Api\Admin; // ← ubah namespace

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\RiwayatScanQr;
use App\Models\SesiQr;
use App\Models\Siswa;
use Illuminate\Http\Request;

class AbsensiQrController extends Controller
{
 /**
     * Endpoint untuk IoT scanner.
     * POST /api/absensi/scan
     *
     * Body: { kode_qr, siswa_id (atau qr_token siswa), latitude, longitude, ip_address, info_perangkat }
     */
    public function scan(Request $request)
    {
        $request->validate([
            'kode_qr'       => ['required', 'string'],
            'siswa_id'      => ['required', 'exists:siswa,id'],
            'latitude'      => ['nullable', 'numeric'],
            'longitude'     => ['nullable', 'numeric'],
            'ip_address'    => ['nullable', 'string'],
            'info_perangkat'=> ['nullable', 'string'],
        ]);

        // 1. Cari sesi QR
        $sesi = SesiQr::with(['kelas', 'mataPelajaran'])
            ->where('kode_qr', $request->kode_qr)
            ->first();

        if (! $sesi) {
            return $this->gagal('QR tidak ditemukan.', $request, null, 'tidak_valid');
        }

        // 2. Validasi sesi masih aktif & belum kadaluarsa
        if (! $sesi->isValid()) {
            $alasan = $sesi->isKadaluarsa() ? 'QR sudah kadaluarsa.' : 'Sesi QR tidak aktif.';
            return $this->gagal($alasan, $request, $sesi, 'kadaluarsa');
        }

        // 3. Cari siswa
        $siswa = Siswa::find($request->siswa_id);

        // 4. Pastikan siswa di kelas yang benar
        if ($siswa->kelas_id !== $sesi->kelas_id) {
            return $this->gagal('Siswa tidak terdaftar di kelas ini.', $request, $sesi, 'kelas_salah');
        }

        // 5. Validasi radius GPS (jika sesi punya batasan radius)
        if ($sesi->radius_meter && $request->filled('latitude') && $request->filled('longitude')) {
            // Ambil koordinat referensi kelas (simpan di tabel kelas, atau pakai koordinat sekolah)
            // Untuk sekarang kita pakai koordinat yang disimpan di sesi_qr jika ada
            // Anda bisa tambahkan kolom lat/lon di tabel kelas atau sekolah
            // Sementara kita skip jika tidak ada koordinat referensi
        }

        // 6. Cek sudah scan sesi ini sebelumnya
        $sudahScan = RiwayatScanQr::where('sesi_qr_id', $sesi->id)
            ->where('siswa_id', $siswa->id)
            ->where('hasil', 'berhasil')
            ->exists();

        if ($sudahScan) {
            return $this->gagal('Siswa sudah absen pada sesi ini.', $request, $sesi, 'duplikat');
        }

        // 7. Tentukan status: telat jika sudah lewat berlaku_mulai + 15 menit
        $status = 'hadir';
        $batasTelat = $sesi->berlaku_mulai->copy()->addMinutes(15);
        if (now()->gt($batasTelat)) {
            $status = 'telat';
        }

        // 8. Simpan riwayat scan
        RiwayatScanQr::create([
            'sesi_qr_id'     => $sesi->id,
            'siswa_id'       => $siswa->id,
            'dipindai_pada'  => now(),
            'latitude'       => $request->latitude,
            'longitude'      => $request->longitude,
            'hasil'          => 'berhasil',
            'ip_address'     => $request->ip_address ?? $request->ip(),
            'info_perangkat' => $request->info_perangkat,
        ]);

        // 9. Catat absensi
        $absensi = Absensi::create([
            'siswa_id'            => $siswa->id,
            'kelas_id'            => $sesi->kelas_id,
            'jadwal_pelajaran_id' => null,
            'dicatat_oleh'        => null,
            'tanggal'             => $sesi->tanggal,
            'status'              => $status,
            'metode'              => 'qr',
            'jam_masuk'           => now()->format('H:i'),
        ]);

        return response()->json([
            'success'   => true,
            'message'   => "Absensi {$siswa->nama_lengkap} berhasil dicatat.",
            'data'      => [
                'siswa'      => $siswa->nama_lengkap,
                'nis'        => $siswa->nis,
                'kelas'      => $sesi->kelas->nama_kelas ?? '-',
                'mapel'      => $sesi->mataPelajaran->nama_mapel ?? '-',
                'status'     => $status,
                'jam_masuk'  => $absensi->jam_masuk,
                'tanggal'    => $absensi->tanggal->format('d M Y'),
            ],
        ]);
    }

    // Helper response gagal + catat riwayat scan
    private function gagal(string $pesan, Request $request, ?SesiQr $sesi, string $hasil)
    {
        if ($sesi && $request->filled('siswa_id')) {
            RiwayatScanQr::create([
                'sesi_qr_id'     => $sesi->id,
                'siswa_id'       => $request->siswa_id,
                'dipindai_pada'  => now(),
                'latitude'       => $request->latitude,
                'longitude'      => $request->longitude,
                'hasil'          => $hasil,
                'ip_address'     => $request->ip_address ?? $request->ip(),
                'info_perangkat' => $request->info_perangkat,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $pesan,
        ], 422);
    }
}