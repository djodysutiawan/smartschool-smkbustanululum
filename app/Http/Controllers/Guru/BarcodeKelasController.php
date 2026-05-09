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
 * Mengelola dua jenis barcode/QR untuk guru:
 *
 * 1. BARCODE TETAP GURU (untuk absen di pos piket)
 *    → Nilai tetap berdasarkan user ID, tidak berubah.
 *    → Digunakan oleh sistem piket untuk mencatat kehadiran guru.
 *    → Tersedia di halaman index sebagai kartu identitas digital guru.
 *
 * 2. QR SESI PELAJARAN (untuk absensi siswa di kelas)
 *    → Hanya bisa dibuat dari jadwal pelajaran yang sudah ada (tidak manual).
 *    → Berlaku pada hari & jam sesuai jadwal — tidak bisa memilih sembarang waktu.
 *    → Satu jadwal hanya boleh punya satu sesi aktif per hari.
 *    → Menggunakan model SesiQr yang sama dengan admin.
 */
class BarcodeKelasController extends Controller
{
    /**
     * Ambil data guru yang sedang login.
     * Abort 403 jika akun tidak terhubung ke data guru.
     */
    private function getGuru(): \App\Models\Guru
    {
        $guru = Auth::user()->guru;
        abort_if(! $guru, 403, 'Akun Anda tidak terhubung dengan data guru.');
        return $guru;
    }

    // ── INDEX ─────────────────────────────────────────────────────────────────
    /**
     * Halaman utama Barcode Guru.
     *
     * Menampilkan:
     * - Barcode tetap guru (untuk scan di pos piket).
     * - Daftar jadwal hari ini dengan tombol "Buat Sesi QR".
     * - Daftar jadwal semua hari milik guru ini.
     * - Sesi QR aktif hari ini (jika ada).
     */
    public function index(Request $request)
    {
        $guru   = $this->getGuru();
        $user   = Auth::user();

        // ── Barcode tetap guru ────────────────────────────────────────────────
        // Nilai barcode = "GURU-{user_id}" — tetap, tidak berubah.
        // Format ini dikenali oleh scanner di pos piket guru.
        $barcodeGuru = 'GURU-' . $user->id;

        // ── Jadwal hari ini ───────────────────────────────────────────────────
        $hariIndo = [
            'Sunday'    => 'minggu',
            'Monday'    => 'senin',
            'Tuesday'   => 'selasa',
            'Wednesday' => 'rabu',
            'Thursday'  => 'kamis',
            'Friday'    => 'jumat',
            'Saturday'  => 'sabtu',
        ];
        $hariIni = $hariIndo[now()->format('l')] ?? 'senin';

        $jadwalHariIni = JadwalPelajaran::with(['mataPelajaran', 'kelas', 'ruang'])
            ->where('guru_id', $guru->id)
            ->where('hari', $hariIni)
            ->where('is_active', true)
            ->orderBy('jam_mulai')
            ->get();

        // ── Sesi QR aktif hari ini (milik guru ini) ───────────────────────────
        $sesiAktifHariIni = SesiQr::where('dibuat_oleh', $user->id)
            ->whereDate('tanggal', today())
            ->where('is_active', true)
            ->with(['kelas', 'mataPelajaran'])
            ->get();

        // Map: jadwal_pelajaran_id → sesi_qr (untuk cek di view)
        $sesiPerJadwal = $sesiAktifHariIni->keyBy('jadwal_pelajaran_id');

        // ── Semua jadwal per hari (untuk tab mingguan) ────────────────────────
        $semuaJadwal = JadwalPelajaran::with(['mataPelajaran', 'kelas'])
            ->where('guru_id', $guru->id)
            ->where('is_active', true)
            ->orderByRaw("FIELD(hari,'senin','selasa','rabu','kamis','jumat','sabtu')")
            ->orderBy('jam_mulai')
            ->get()
            ->groupBy('hari');

        $hariList = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];

        return view('guru.barcode-kelas.index', compact(
            'guru',
            'barcodeGuru',
            'jadwalHariIni',
            'sesiPerJadwal',
            'semuaJadwal',
            'hariList',
            'hariIni',
        ));
    }

    // ── SHOW: Barcode satu kelas (fullscreen / print-friendly) ───────────────
    /**
     * Tampilkan barcode tetap satu kelas yang diajar guru ini.
     * Digunakan untuk ditempel di papan kelas / dicetak.
     *
     * Format: "KELAS-{kelas_id}" — dikenali scanner absensi gerbang.
     */
    public function show(Kelas $kelas)
    {
        $guru = $this->getGuru();

        // Pastikan guru memang mengajar di kelas ini
        $kelasIds = JadwalPelajaran::where('guru_id', $guru->id)
            ->pluck('kelas_id')
            ->unique();

        abort_unless($kelasIds->contains($kelas->id), 403, 'Anda tidak mengajar di kelas ini.');

        $barcodeKelas = 'KELAS-' . $kelas->id;
        $kelas->load('jurusan');

        return view('guru.barcode-kelas.show', compact('kelas', 'barcodeKelas', 'guru'));
    }

    // ── CETAK: View khusus tanpa layout ──────────────────────────────────────
    /**
     * Print-friendly view barcode kelas (tanpa sidebar/navbar).
     */
    public function cetak(Kelas $kelas)
    {
        $guru = $this->getGuru();

        $kelasIds = JadwalPelajaran::where('guru_id', $guru->id)
            ->pluck('kelas_id')
            ->unique();

        abort_unless($kelasIds->contains($kelas->id), 403, 'Anda tidak mengajar di kelas ini.');

        $barcodeKelas = 'KELAS-' . $kelas->id;
        $kelas->load('jurusan');

        return view('guru.barcode-kelas.cetak', compact('kelas', 'barcodeKelas', 'guru'));
    }

    // ── BUAT SESI QR PELAJARAN ────────────────────────────────────────────────
    /**
     * Form pembuatan sesi QR berdasarkan jadwal pelajaran.
     *
     * Guru memilih jadwal yang sudah ada — sistem otomatis mengisi:
     * - kelas, mata pelajaran, tanggal (hari ini), jam mulai & durasi.
     *
     * Jika ?jadwal_pelajaran_id=X dikirim, form langsung pre-filled.
     */
    public function createSesi(Request $request)
    {
        $guru = $this->getGuru();
        $user = Auth::user();

        // Hanya jadwal hari ini yang bisa dipilih
        $hariIndo = [
            'Sunday'    => 'minggu',
            'Monday'    => 'senin',
            'Tuesday'   => 'selasa',
            'Wednesday' => 'rabu',
            'Thursday'  => 'kamis',
            'Friday'    => 'jumat',
            'Saturday'  => 'sabtu',
        ];
        $hariIni = $hariIndo[now()->format('l')] ?? 'senin';

        $jadwalHariIni = JadwalPelajaran::with(['mataPelajaran', 'kelas'])
            ->where('guru_id', $guru->id)
            ->where('hari', $hariIni)
            ->where('is_active', true)
            ->orderBy('jam_mulai')
            ->get();

        // Sesi yang sudah ada hari ini agar ditandai di view
        $sesiSudahAda = SesiQr::where('dibuat_oleh', $user->id)
            ->whereDate('tanggal', today())
            ->pluck('jadwal_pelajaran_id')
            ->toArray();

        // Pre-selected jadwal jika dari tombol "Buat QR" di index
        $jadwalTerpilih = null;
        if ($request->filled('jadwal_pelajaran_id')) {
            $jadwalTerpilih = $jadwalHariIni->firstWhere('id', $request->jadwal_pelajaran_id);
        }

        return view('guru.barcode-kelas.create-sesi', compact(
            'guru',
            'jadwalHariIni',
            'sesiSudahAda',
            'jadwalTerpilih',
            'hariIni',
        ));
    }

    /**
     * Simpan sesi QR pelajaran baru.
     *
     * Validasi ketat:
     * - Jadwal harus milik guru ini.
     * - Jadwal harus untuk hari ini.
     * - Belum ada sesi aktif untuk jadwal yang sama hari ini.
     * - Waktu berlaku otomatis dari jam_mulai jadwal.
     * - Durasi default dari selisih jam_mulai–jam_selesai jadwal.
     */
    public function storeSesi(Request $request)
    {
        $guru = $this->getGuru();
        $user = Auth::user();

        $request->validate([
            'jadwal_pelajaran_id' => ['required', 'exists:jadwal_pelajaran,id'],
            'durasi_menit'        => ['nullable', 'integer', 'min:5', 'max:240'],
            'radius_meter'        => ['nullable', 'integer', 'min:10', 'max:1000'],
            'latitude'            => ['nullable', 'numeric', 'between:-90,90'],
            'longitude'           => ['nullable', 'numeric', 'between:-180,180'],
        ], [
            'jadwal_pelajaran_id.required' => 'Jadwal pelajaran wajib dipilih.',
            'jadwal_pelajaran_id.exists'   => 'Jadwal pelajaran tidak ditemukan.',
            'durasi_menit.min'             => 'Durasi minimal 5 menit.',
            'durasi_menit.max'             => 'Durasi maksimal 240 menit.',
            'radius_meter.min'             => 'Radius minimal 10 meter.',
            'radius_meter.max'             => 'Radius maksimal 1000 meter.',
        ]);

        // Ambil jadwal dan pastikan milik guru ini
        $jadwal = JadwalPelajaran::where('id', $request->jadwal_pelajaran_id)
            ->where('guru_id', $guru->id)
            ->where('is_active', true)
            ->first();

        abort_if(! $jadwal, 403, 'Jadwal tidak ditemukan atau bukan milik Anda.');

        // Pastikan hari jadwal adalah hari ini
        $hariIndo = [
            'Sunday'    => 'minggu',
            'Monday'    => 'senin',
            'Tuesday'   => 'selasa',
            'Wednesday' => 'rabu',
            'Thursday'  => 'kamis',
            'Friday'    => 'jumat',
            'Saturday'  => 'sabtu',
        ];
        $hariIni = $hariIndo[now()->format('l')] ?? 'senin';

        if ($jadwal->hari !== $hariIni) {
            return back()->withInput()
                ->with('error', 'Sesi QR hanya bisa dibuat untuk jadwal hari ini (' . ucfirst($hariIni) . ').');
        }

        // Cek sesi aktif untuk jadwal ini hari ini
        $sudahAda = SesiQr::where('jadwal_pelajaran_id', $jadwal->id)
            ->whereDate('tanggal', today())
            ->where('is_active', true)
            ->exists();

        if ($sudahAda) {
            return back()->withInput()
                ->with('error', 'Sudah ada sesi QR aktif untuk jadwal ini hari ini. Nonaktifkan sesi sebelumnya terlebih dahulu.');
        }

        // Hitung berlaku_mulai dan kadaluarsa_pada dari jadwal
        $berlakuMulai = Carbon::parse(today()->toDateString() . ' ' . $jadwal->jam_mulai);

        // Durasi: dari request atau selisih jam jadwal
        $durasiMenit = $request->filled('durasi_menit')
            ? (int) $request->durasi_menit
            : (int) Carbon::parse($jadwal->jam_mulai)->diffInMinutes(Carbon::parse($jadwal->jam_selesai));

        $kadaluarsaPada = $berlakuMulai->copy()->addMinutes($durasiMenit);

        $sesi = SesiQr::create([
            'jadwal_pelajaran_id' => $jadwal->id,
            'kelas_id'            => $jadwal->kelas_id,
            'mata_pelajaran_id'   => $jadwal->mata_pelajaran_id,
            'guru_id'             => $guru->id,
            'dibuat_oleh'         => $user->id,
            'tanggal'             => today(),
            'berlaku_mulai'       => $berlakuMulai,
            'kadaluarsa_pada'     => $kadaluarsaPada,
            'radius_meter'        => $request->radius_meter ?? 100,
            'latitude'            => $request->latitude,
            'longitude'           => $request->longitude,
            'maks_scan'           => 0,
            'is_active'           => true,
        ]);

        return redirect()->route('guru.barcode-kelas.show-sesi', $sesi)
            ->with('success', 'Sesi QR berhasil dibuat. Tampilkan QR ke siswa.');
    }

    // ── TAMPILKAN QR SESI (Fullscreen untuk ditayangkan di kelas) ────────────
    /**
     * Tampilkan QR sesi pelajaran secara fullscreen.
     * Guru menampilkan halaman ini di layar/proyektor saat pelajaran.
     */
    public function showSesi(SesiQr $sesiQr)
    {
        $user = Auth::user();

        abort_if($sesiQr->dibuat_oleh !== $user->id, 403, 'Anda tidak memiliki akses ke sesi QR ini.');

        $sesiQr->load(['kelas', 'mataPelajaran', 'jadwalPelajaran']);

        // Hitung sisa waktu
        $sisaDetik  = max(0, now()->diffInSeconds($sesiQr->kadaluarsa_pada, false));
        $isKadaluarsa = $sesiQr->isKadaluarsa();

        // Rekap scan
        $sudahScan = $sesiQr->riwayatScan()->where('status', 'valid')->count();
        $totalSiswa = $sesiQr->kelas?->siswa()->count() ?? 0;

        return view('guru.barcode-kelas.show-sesi', compact(
            'sesiQr',
            'sisaDetik',
            'isKadaluarsa',
            'sudahScan',
            'totalSiswa',
        ));
    }

    // ── NONAKTIFKAN SESI ──────────────────────────────────────────────────────
    /**
     * Nonaktifkan sesi QR pelajaran lebih awal.
     */
    public function nonaktifkanSesi(SesiQr $sesiQr)
    {
        $user = Auth::user();
        abort_if($sesiQr->dibuat_oleh !== $user->id, 403, 'Anda tidak memiliki akses ke sesi QR ini.');

        $sesiQr->nonaktifkan();

        return back()->with('success', 'Sesi QR berhasil dinonaktifkan.');
    }

    // ── AJAX: Status scan real-time ────────────────────────────────────────────
    /**
     * Endpoint polling AJAX untuk update jumlah scan di halaman showSesi.
     */
    public function statusSesiAjax(SesiQr $sesiQr)
    {
        $user = Auth::user();
        abort_if($sesiQr->dibuat_oleh !== $user->id, 403);

        $sudahScan = $sesiQr->riwayatScan()
            ->where('status', 'valid')
            ->with('siswa:id,nama_lengkap,nis')
            ->get()
            ->map(fn ($r) => [
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

    // ── CETAK BARCODE GURU (untuk ditempel di kartu / ID card) ───────────────
    /**
     * Halaman cetak barcode tetap guru — tanpa layout.
     * Format barcode: "GURU-{user_id}"
     */
    public function cetakBarcodeGuru()
    {
        $guru        = $this->getGuru();
        $user        = Auth::user();
        $barcodeGuru = 'GURU-' . $user->id;

        return view('guru.barcode-kelas.cetak-barcode-guru', compact('guru', 'user', 'barcodeGuru'));
    }
}