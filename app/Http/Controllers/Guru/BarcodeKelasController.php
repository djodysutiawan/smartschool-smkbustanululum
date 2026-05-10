<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\SesiQr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * BarcodeKelasController
 *
 * Dua fungsi utama:
 *
 * 1. BARCODE TETAP GURU  (format: "GURU-{user_id}")
 *    → Untuk absensi guru di pos piket — nilai tidak pernah berubah.
 *    → Tersedia di halaman index sebagai kartu identitas digital.
 *    → Bisa dicetak via cetakBarcodeGuru().
 *
 * 2. QR SESI PELAJARAN  (generate UUID baru tiap sesi)
 *    → Untuk absensi siswa di kelas — satu sesi per pertemuan.
 *    → Wajib berbasis jadwal hari ini (tidak bisa manual).
 *    → Satu jadwal hanya boleh punya satu sesi aktif per hari.
 *    → Ditampilkan fullscreen di showSesi() untuk disorot ke siswa.
 *    → Real-time polling via statusSesiAjax().
 *
 * Perbedaan dengan SesiQrController:
 *   SesiQrController  → management sesi (list, detail, hapus, cetak PDF)
 *   BarcodeKelasController → aksi cepat hari ini (buat, tayangkan, nonaktifkan)
 */
class BarcodeKelasController extends Controller
{
    // ── Helpers ───────────────────────────────────────────────────────────────

    private function getGuru(): \App\Models\Guru
    {
        $guru = Auth::user()->guru;
        abort_if(! $guru, 403, 'Akun Anda tidak terhubung dengan data guru.');
        return $guru;
    }

    private function authorizeSesi(SesiQr $sesiQr): void
    {
        abort_if($sesiQr->dibuat_oleh !== Auth::id(), 403, 'Anda tidak memiliki akses ke sesi QR ini.');
    }

    private function hariIni(): string
    {
        return [
            'Sunday'    => 'minggu',
            'Monday'    => 'senin',
            'Tuesday'   => 'selasa',
            'Wednesday' => 'rabu',
            'Thursday'  => 'kamis',
            'Friday'    => 'jumat',
            'Saturday'  => 'sabtu',
        ][now()->format('l')] ?? 'senin';
    }

    // ── INDEX ─────────────────────────────────────────────────────────────────
    /**
     * Halaman utama Barcode Kelas.
     *
     * Menampilkan:
     * - Barcode tetap guru (untuk piket).
     * - Jadwal hari ini + status sesi QR masing-masing jadwal.
     * - Tombol cepat "Mulai Sesi" / "Lihat QR" per jadwal.
     * - Jadwal semua hari (tab mingguan) untuk referensi.
     */
    public function index()
    {
        $guru = $this->getGuru();
        $user = Auth::user();

        $barcodeGuru = 'GURU-' . $user->id;
        $hariIni     = $this->hariIni();

        // Jadwal hari ini
        $jadwalHariIni = JadwalPelajaran::with(['mataPelajaran', 'kelas', 'ruang'])
            ->where('guru_id', $guru->id)
            ->where('hari', $hariIni)
            ->where('is_active', true)
            ->orderBy('jam_mulai')
            ->get();

        // Sesi aktif hari ini — map by jadwal_pelajaran_id
        $sesiPerJadwal = SesiQr::where('dibuat_oleh', $user->id)
            ->whereDate('tanggal', today())
            ->where('is_active', true)
            ->with(['kelas', 'mataPelajaran'])
            ->get()
            ->keyBy('jadwal_pelajaran_id');

        // Semua jadwal per hari (tab mingguan)
        $hariList    = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];
        $semuaJadwal = JadwalPelajaran::with(['mataPelajaran', 'kelas'])
            ->where('guru_id', $guru->id)
            ->where('is_active', true)
            ->orderByRaw("FIELD(hari,'senin','selasa','rabu','kamis','jumat','sabtu')")
            ->orderBy('jam_mulai')
            ->get()
            ->groupBy('hari');

        return view('guru.barcode-kelas.index', compact(
            'guru', 'barcodeGuru',
            'jadwalHariIni', 'sesiPerJadwal',
            'semuaJadwal', 'hariList', 'hariIni'
        ));
    }

    // ── SHOW: Barcode tetap satu kelas ────────────────────────────────────────
    /**
     * Barcode tetap satu kelas — untuk ditempel di papan kelas.
     * Format: "KELAS-{kelas_id}"
     */
    public function show(Kelas $kelas)
    {
        $guru = $this->getGuru();

        $kelasIds = JadwalPelajaran::where('guru_id', $guru->id)
            ->pluck('kelas_id')
            ->unique();

        abort_unless($kelasIds->contains($kelas->id), 403, 'Anda tidak mengajar di kelas ini.');

        $kelas->load('jurusan');
        $barcodeKelas = 'KELAS-' . $kelas->id;

        return view('guru.barcode-kelas.show', compact('kelas', 'barcodeKelas', 'guru'));
    }

    // ── CETAK: Barcode kelas (print-friendly) ─────────────────────────────────

    public function cetak(Kelas $kelas)
    {
        $guru = $this->getGuru();

        $kelasIds = JadwalPelajaran::where('guru_id', $guru->id)
            ->pluck('kelas_id')
            ->unique();

        abort_unless($kelasIds->contains($kelas->id), 403, 'Anda tidak mengajar di kelas ini.');

        $kelas->load('jurusan');
        $barcodeKelas = 'KELAS-' . $kelas->id;

        return view('guru.barcode-kelas.cetak', compact('kelas', 'barcodeKelas', 'guru'));
    }

    // ── BUAT SESI QR ──────────────────────────────────────────────────────────
    /**
     * Form pembuatan sesi QR — hanya jadwal hari ini yang tampil.
     * Bisa pre-filled via ?jadwal_pelajaran_id=X (dari tombol di index).
     */
    public function createSesi(Request $request)
    {
        $guru    = $this->getGuru();
        $hariIni = $this->hariIni();

        $jadwalHariIni = JadwalPelajaran::with(['mataPelajaran', 'kelas'])
            ->where('guru_id', $guru->id)
            ->where('hari', $hariIni)
            ->where('is_active', true)
            ->orderBy('jam_mulai')
            ->get();

        // Jadwal yang sudah punya sesi (aktif maupun nonaktif) hari ini
        $sesiSudahAda = SesiQr::where('dibuat_oleh', Auth::id())
            ->whereDate('tanggal', today())
            ->pluck('jadwal_pelajaran_id')
            ->toArray();

        $jadwalTerpilih = null;
        if ($request->filled('jadwal_pelajaran_id')) {
            $jadwalTerpilih = $jadwalHariIni->firstWhere('id', (int) $request->jadwal_pelajaran_id);
        }

        return view('guru.barcode-kelas.create-sesi', compact(
            'guru', 'jadwalHariIni', 'sesiSudahAda', 'jadwalTerpilih', 'hariIni'
        ));
    }

    /**
     * Simpan sesi QR baru — validasi ketat berbasis jadwal.
     */
    public function storeSesi(Request $request)
    {
        $guru = $this->getGuru();

        $request->validate([
            'jadwal_pelajaran_id' => ['required', 'exists:jadwal_pelajaran,id'],
            'durasi_menit'        => ['nullable', 'integer', 'min:5', 'max:240'],
            'radius_meter'        => ['nullable', 'integer', 'min:10', 'max:1000'],
            'latitude'            => ['nullable', 'numeric', 'between:-90,90'],
            'longitude'           => ['nullable', 'numeric', 'between:-180,180'],
        ], [
            'jadwal_pelajaran_id.required' => 'Jadwal pelajaran wajib dipilih.',
            'durasi_menit.min'             => 'Durasi minimal 5 menit.',
            'durasi_menit.max'             => 'Durasi maksimal 240 menit.',
            'radius_meter.min'             => 'Radius minimal 10 meter.',
            'radius_meter.max'             => 'Radius maksimal 1000 meter.',
        ]);

        // Pastikan jadwal milik guru ini & aktif
        $jadwal = JadwalPelajaran::where('id', $request->jadwal_pelajaran_id)
            ->where('guru_id', $guru->id)
            ->where('is_active', true)
            ->first();

        abort_if(! $jadwal, 403, 'Jadwal tidak ditemukan atau bukan milik Anda.');

        // Harus hari ini
        if ($jadwal->hari !== $this->hariIni()) {
            return back()->withInput()
                ->with('error', 'Sesi QR hanya bisa dibuat untuk jadwal hari ini (' . ucfirst($this->hariIni()) . ').');
        }

        // Cegah duplikat sesi AKTIF untuk jadwal yang sama hari ini
        $sudahAda = SesiQr::where('jadwal_pelajaran_id', $jadwal->id)
            ->whereDate('tanggal', today())
            ->where('is_active', true)
            ->exists();

        if ($sudahAda) {
            return back()->withInput()
                ->with('error', 'Sudah ada sesi QR aktif untuk jadwal ini. Nonaktifkan sesi sebelumnya terlebih dahulu.');
        }

        // Hitung waktu dari jadwal
        $berlakuMulai = Carbon::parse(today()->toDateString() . ' ' . $jadwal->jam_mulai);

        $durasiMenit = $request->filled('durasi_menit')
            ? (int) $request->durasi_menit
            : max(5, (int) Carbon::parse($jadwal->jam_mulai)->diffInMinutes(Carbon::parse($jadwal->jam_selesai)));

        $kadaluarsaPada = $berlakuMulai->copy()->addMinutes($durasiMenit);

        $sesi = SesiQr::create([
            'jadwal_pelajaran_id' => $jadwal->id,
            'kelas_id'            => $jadwal->kelas_id,
            'mata_pelajaran_id'   => $jadwal->mata_pelajaran_id,
            'guru_id'             => $guru->id,
            'dibuat_oleh'         => Auth::id(),
            'tanggal'             => today(),
            'berlaku_mulai'       => $berlakuMulai,
            'kadaluarsa_pada'     => $kadaluarsaPada,
            'radius_meter'        => $request->filled('radius_meter') ? (int) $request->radius_meter : 100,
            'latitude'            => $request->latitude ?: null,
            'longitude'           => $request->longitude ?: null,
            'maks_scan'           => 0,
            'is_active'           => true,
        ]);

        return redirect()
            ->route('guru.barcode-kelas.show-sesi', $sesi)
            ->with('success', 'Sesi QR berhasil dibuat. Tampilkan QR ke siswa.');
    }

    // ── SHOW SESI: Fullscreen QR ──────────────────────────────────────────────
    /**
     * Tampilkan QR sesi pelajaran secara fullscreen.
     * Guru menampilkan halaman ini di layar/proyektor.
     * Ada countdown timer + rekap scan real-time (via AJAX polling).
     */
    public function showSesi(SesiQr $sesiQr)
    {
        $this->authorizeSesi($sesiQr);

        $sesiQr->load(['kelas', 'mataPelajaran', 'jadwalPelajaran.ruang']);

        $sisaDetik    = max(0, now()->diffInSeconds($sesiQr->kadaluarsa_pada, false));
        $isKadaluarsa = $sesiQr->isKadaluarsa();
        $sudahScan    = $sesiQr->riwayatScan()->where('status', 'valid')->count();
        $totalSiswa   = $sesiQr->kelas?->siswa()->count() ?? 0;

        return view('guru.barcode-kelas.show-sesi', compact(
            'sesiQr', 'sisaDetik', 'isKadaluarsa', 'sudahScan', 'totalSiswa'
        ));
    }

    // ── NONAKTIFKAN SESI ──────────────────────────────────────────────────────

    public function nonaktifkanSesi(SesiQr $sesiQr)
    {
        $this->authorizeSesi($sesiQr);
        $sesiQr->nonaktifkan();

        return back()->with('success', 'Sesi QR berhasil dinonaktifkan.');
    }

    // ── AJAX: Status scan real-time ───────────────────────────────────────────
    /**
     * Polling endpoint untuk halaman showSesi.
     * Dipanggil setiap beberapa detik via JavaScript.
     */
    public function statusSesiAjax(SesiQr $sesiQr)
    {
        $this->authorizeSesi($sesiQr);

        $sudahScan = $sesiQr->riwayatScan()
            ->where('status', 'valid')
            ->with('siswa:id,nama_lengkap,nis')
            ->orderBy('dipindai_pada', 'desc')
            ->get()
            ->map(fn($r) => [
                'siswa_id'     => $r->siswa_id,
                'nama'         => $r->siswa->nama_lengkap ?? '—',
                'nis'          => $r->siswa->nis ?? '—',
                'di_scan_pada' => optional($r->dipindai_pada)->format('H:i:s'),
            ]);

        return response()->json([
            'is_valid'      => $sesiQr->isValid(),
            'is_kadaluarsa' => $sesiQr->isKadaluarsa(),
            'sudah_scan'    => $sudahScan,
            'jumlah_scan'   => $sudahScan->count(),
            'sisa_waktu'    => max(0, now()->diffInSeconds($sesiQr->kadaluarsa_pada, false)),
        ]);
    }

    // ── CETAK BARCODE GURU ────────────────────────────────────────────────────
    /**
     * Print-friendly barcode tetap guru — tanpa layout.
     */
    public function cetakBarcodeGuru()
    {
        $guru        = $this->getGuru();
        $user        = Auth::user();
        $barcodeGuru = 'GURU-' . $user->id;

        return view('guru.barcode-kelas.cetak-barcode-guru', compact('guru', 'user', 'barcodeGuru'));
    }
}