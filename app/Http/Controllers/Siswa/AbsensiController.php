<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\RiwayatScanQr;
use App\Models\SesiQr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JadwalPelajaran;

class AbsensiController extends Controller
{
    private const STATUS_LIST = ['hadir', 'telat', 'izin', 'sakit', 'alfa'];

    private function getSiswa()
    {
        $siswa = Auth::user()->siswa;
        abort_if(! $siswa, 403, 'Akun Anda tidak terhubung dengan data siswa.');
        return $siswa;
    }

    /**
     * Halaman scan QR Code untuk presensi hadir.
     */
    public function scan()
    {
        $siswa = $this->getSiswa();

        $absensiHariIni = Absensi::where('siswa_id', $siswa->id)
            ->whereDate('tanggal', today())
            ->first();

        return view('siswa.absensi.scan', compact('siswa', 'absensiHariIni'));
    }

    /**
     * Proses hasil scan QR Code.
     * Format QR yang valid: SESI-{kode_qr} atau kode_qr langsung.
     */
    public function prosesQr(Request $request)
    {
        $request->validate([
            'qr_code' => ['required', 'string'],
        ]);

        $siswa = $this->getSiswa();

        // Cek apakah sudah absen hari ini
        $sudahAbsen = Absensi::where('siswa_id', $siswa->id)
            ->whereDate('tanggal', today())
            ->exists();

        if ($sudahAbsen) {
            return back()->with('warning', 'Anda sudah melakukan absensi hari ini.');
        }

        // Parse kode dari QR
        $qrInput = $request->qr_code;
        $kodeQr  = str_starts_with($qrInput, 'SESI-')
            ? substr($qrInput, 5)
            : $qrInput;

        // Cari sesi QR yang aktif dan valid untuk kelas siswa
        $sesiQr = SesiQr::where('kode_qr', $kodeQr)
            ->where('is_active', true)
            ->where('kelas_id', $siswa->kelas_id)
            ->whereDate('tanggal', today())
            ->where('berlaku_mulai', '<=', now())
            ->where('kadaluarsa_pada', '>=', now())
            ->first();

        if (! $sesiQr) {
            // Catat riwayat scan gagal
            $this->catatRiwayatScan($siswa->id, null, null, 'gagal', $request);

            return back()->with('error', 'QR Code tidak valid, bukan untuk kelas Anda, atau sudah kadaluarsa.');
        }

        // Tentukan status berdasarkan waktu berlaku_mulai vs sekarang
        // Jika lewat 15 menit dari berlaku_mulai dianggap telat
        $batasWaktuTelat = $sesiQr->berlaku_mulai->copy()->addMinutes(15);
        $status = now()->greaterThan($batasWaktuTelat) ? 'telat' : 'hadir';

        // Simpan absensi
        $absensi = Absensi::create([
            'siswa_id'            => $siswa->id,
            'kelas_id'            => $siswa->kelas_id,
            'jadwal_pelajaran_id' => null, // SesiQr tidak punya jadwal_pelajaran_id
            'dicatat_oleh'        => Auth::id(),
            'tanggal'             => today(),
            'status'              => $status,
            'metode'              => 'qr',
            'jam_masuk'           => now()->format('H:i:s'),
        ]);

        // Catat riwayat scan berhasil
        $this->catatRiwayatScan($siswa->id, $sesiQr->id, $absensi->id, 'berhasil', $request);

        $labelStatus = $status === 'hadir' ? 'Hadir ✓' : 'Telat';
        return back()->with('success', "Absensi berhasil dicatat! Status: {$labelStatus}");
    }

    /**
     * Helper: catat riwayat scan QR.
     */
    private function catatRiwayatScan(
        int $siswaId,
        ?int $sesiQrId,
        ?int $absensiId,
        string $hasil,
        Request $request
    ): void {
        RiwayatScanQr::create([
            'siswa_id'        => $siswaId,
            'sesi_qr_id'      => $sesiQrId,
            'dipindai_pada'   => now(),
            'hasil'           => $hasil,
            'ip_address'      => $request->ip(),
            'info_perangkat'  => $request->userAgent(),
            'latitude'        => $request->latitude  ?? null,
            'longitude'       => $request->longitude ?? null,
        ]);
    }

    /**
     * Riwayat kehadiran siswa dengan filter tanggal, status, bulan, tahun.
     */
    public function riwayat(Request $request)
    {
        $siswa = $this->getSiswa();

        $query = Absensi::with(['kelas', 'jadwalPelajaran.mataPelajaran', 'dicatatOleh'])
            ->where('siswa_id', $siswa->id);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $absensi    = $query->orderByDesc('tanggal')->paginate(20)->withQueryString();
        $statusList = self::STATUS_LIST;

        // Rekap keseluruhan (bukan hanya yang difilter) untuk summary card
        $baseQuery = fn () => Absensi::where('siswa_id', $siswa->id);

        $rekap = [
            'hadir'      => $baseQuery()->whereIn('status', ['hadir', 'telat'])->count(),
            'izin'       => $baseQuery()->where('status', 'izin')->count(),
            'sakit'      => $baseQuery()->where('status', 'sakit')->count(),
            'alfa'       => $baseQuery()->where('status', 'alfa')->count(),
            'total'      => $baseQuery()->count(),
        ];

        // Persentase kehadiran
        $rekap['persen_hadir'] = $rekap['total'] > 0
            ? round(($rekap['hadir'] / $rekap['total']) * 100, 1)
            : 0;

        // Daftar tahun yang tersedia untuk filter
        $tahunList = Absensi::where('siswa_id', $siswa->id)
            ->selectRaw('YEAR(tanggal) as tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

        return view('siswa.absensi.riwayat', compact(
            'absensi', 'statusList', 'rekap', 'tahunList'
        ));
    }

    public function jadwalHariIni()
    {
        $siswa = $this->getSiswa();

        $hariIni = strtolower(now()->locale('id')->dayName);

        $jadwalList = JadwalPelajaran::with(['mataPelajaran', 'guru'])
            ->aktif()
            ->hari($hariIni)
            ->where('kelas_id', $siswa->kelas_id)
            ->orderBy('jam_mulai')
            ->get();

        $jadwalList->each(function ($jadwal) use ($siswa) {
            $jadwal->sesiQrAktif = SesiQr::where('kelas_id', $siswa->kelas_id)
                ->where('mata_pelajaran_id', $jadwal->mata_pelajaran_id)  // ← pakai ini
                ->where('is_active', true)
                ->whereDate('tanggal', today())
                ->where('berlaku_mulai', '<=', now())
                ->where('kadaluarsa_pada', '>=', now())
                ->first();

            $jadwal->sudahAbsen = Absensi::where('siswa_id', $siswa->id)
                ->where('jadwal_pelajaran_id', $jadwal->id)
                ->whereDate('tanggal', today())
                ->first();
        });

        return view('siswa.absensi.jadwal', compact('siswa', 'jadwalList'));
    }
}