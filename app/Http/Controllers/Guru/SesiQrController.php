<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\JadwalPelajaran;
use App\Models\SesiQr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * SesiQrController
 *
 * Mengelola sesi QR absensi berbasis jadwal pelajaran.
 * Guru hanya bisa membuat sesi QR dari jadwal yang sudah ada —
 * tidak bisa membuat sesi manual tanpa jadwal.
 *
 * Alur:
 *   index  → daftar semua sesi QR milik guru (historis + aktif)
 *   create → pilih jadwal hari ini → isi durasi/radius
 *   store  → validasi ketat → buat sesi → redirect ke show
 *   show   → detail sesi (bukan fullscreen QR, itu di BarcodeKelasController)
 *   nonaktifkan → matikan sesi lebih awal
 *   destroy → hapus sesi (hanya jika tidak aktif / sudah kadaluarsa)
 *   cetakQr → PDF cetak QR
 */
class SesiQrController extends Controller
{
    // ── Auth Helper ───────────────────────────────────────────────────────────

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

    // ── Hari Helper ───────────────────────────────────────────────────────────

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

    // ── Index ─────────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $guru = $this->getGuru();

        $query = SesiQr::with(['kelas', 'mataPelajaran', 'jadwalPelajaran'])
            ->where('dibuat_oleh', Auth::id());

        // Filter tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        // Filter status
        if ($request->filled('status')) {
            if ($request->status === 'aktif') {
                $query->where('is_active', true);
            } elseif ($request->status === 'nonaktif') {
                $query->where('is_active', false);
            }
        }

        // Filter kelas
        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        $sesiList = $query->latest('tanggal')->latest()->paginate(15)->withQueryString();

        // Stats
        $stats = [
            'total'    => SesiQr::where('dibuat_oleh', Auth::id())->count(),
            'aktif'    => SesiQr::where('dibuat_oleh', Auth::id())->where('is_active', true)->count(),
            'hari_ini' => SesiQr::where('dibuat_oleh', Auth::id())->whereDate('tanggal', today())->count(),
        ];

        // Daftar kelas untuk dropdown filter
        $kelasIds  = JadwalPelajaran::where('guru_id', $guru->id)->pluck('kelas_id')->unique();
        $kelasList = \App\Models\Kelas::aktif()->whereIn('id', $kelasIds)->orderBy('nama_kelas')->get();

        // Jadwal hari ini + status sesi
        $hariIni       = $this->hariIni();
        $jadwalHariIni = JadwalPelajaran::with(['mataPelajaran', 'kelas'])
            ->where('guru_id', $guru->id)
            ->where('hari', $hariIni)
            ->where('is_active', true)
            ->orderBy('jam_mulai')
            ->get();

        $sesiPerJadwal = SesiQr::where('dibuat_oleh', Auth::id())
            ->whereDate('tanggal', today())
            ->where('is_active', true)
            ->get()
            ->keyBy('jadwal_pelajaran_id');

        return view('guru.sesi-qr.index', compact(
            'sesiList', 'stats', 'kelasList',
            'jadwalHariIni', 'sesiPerJadwal', 'hariIni'
        ));
    }

    // ── Create ────────────────────────────────────────────────────────────────

    public function create(Request $request)
    {
        $guru    = $this->getGuru();
        $hariIni = $this->hariIni();

        // Jadwal hari ini milik guru ini
        $jadwalHariIni = JadwalPelajaran::with(['mataPelajaran', 'kelas'])
            ->where('guru_id', $guru->id)
            ->where('hari', $hariIni)
            ->where('is_active', true)
            ->orderBy('jam_mulai')
            ->get();

        // Tandai jadwal yang sudah punya sesi aktif hari ini
        $sesiSudahAda = SesiQr::where('dibuat_oleh', Auth::id())
            ->whereDate('tanggal', today())
            ->pluck('jadwal_pelajaran_id')
            ->toArray();

        // Pre-selected dari query string (dari tombol "Buat QR" di index)
        $jadwalTerpilih = null;
        if ($request->filled('jadwal_pelajaran_id')) {
            $jadwalTerpilih = $jadwalHariIni->firstWhere('id', (int) $request->jadwal_pelajaran_id);
        }

        return view('guru.sesi-qr.create', compact(
            'guru', 'jadwalHariIni', 'sesiSudahAda', 'jadwalTerpilih', 'hariIni'
        ));
    }

    // ── Store ─────────────────────────────────────────────────────────────────

    public function store(Request $request)
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
            'jadwal_pelajaran_id.exists'   => 'Jadwal pelajaran tidak ditemukan.',
            'durasi_menit.min'             => 'Durasi minimal 5 menit.',
            'durasi_menit.max'             => 'Durasi maksimal 240 menit.',
            'radius_meter.min'             => 'Radius minimal 10 meter.',
            'radius_meter.max'             => 'Radius maksimal 1000 meter.',
        ]);

        // Pastikan jadwal milik guru ini & aktif
        $jadwal = JadwalPelajaran::where('id', $request->jadwal_pelajaran_id)
            ->where('guru_id', $guru->id)
            ->where('is_active', true)
            ->firstOrFail();

        // Jadwal harus untuk hari ini
        if ($jadwal->hari !== $this->hariIni()) {
            return back()->withInput()
                ->with('error', 'Sesi QR hanya bisa dibuat untuk jadwal hari ini (' . ucfirst($this->hariIni()) . ').');
        }

        // Cegah duplikat sesi aktif untuk jadwal yang sama hari ini
        $sudahAda = SesiQr::where('jadwal_pelajaran_id', $jadwal->id)
            ->whereDate('tanggal', today())
            ->where('is_active', true)
            ->exists();

        if ($sudahAda) {
            return back()->withInput()
                ->with('error', 'Sudah ada sesi QR aktif untuk jadwal ini hari ini. Nonaktifkan sesi sebelumnya terlebih dahulu.');
        }

        // Hitung waktu berlaku dari jam jadwal
        $berlakuMulai = Carbon::parse(today()->toDateString() . ' ' . $jadwal->jam_mulai);

        $durasiMenit = $request->filled('durasi_menit')
            ? (int) $request->durasi_menit
            : (int) Carbon::parse($jadwal->jam_mulai)->diffInMinutes(Carbon::parse($jadwal->jam_selesai));

        // Minimal 5 menit
        $durasiMenit = max(5, $durasiMenit);

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
            ->with('success', 'Sesi QR berhasil dibuat. Tampilkan QR ke siswa sekarang.');
    }

    // ── Show ──────────────────────────────────────────────────────────────────

    public function show(SesiQr $sesiQr)
    {
        $this->authorizeSesi($sesiQr);

        $sesiQr->load(['kelas', 'mataPelajaran', 'jadwalPelajaran.ruang', 'riwayatScan.siswa']);

        $sudahScan  = $sesiQr->riwayatScan()->where('status', 'valid')->count();
        $totalSiswa = $sesiQr->kelas?->siswa()->count() ?? 0;

        return view('guru.sesi-qr.show', compact('sesiQr', 'sudahScan', 'totalSiswa'));
    }

    // ── Nonaktifkan ───────────────────────────────────────────────────────────

    public function nonaktifkan(SesiQr $sesiQr)
    {
        $this->authorizeSesi($sesiQr);
        $sesiQr->nonaktifkan();

        return back()->with('success', 'Sesi QR berhasil dinonaktifkan.');
    }

    // ── Destroy ───────────────────────────────────────────────────────────────

    public function destroy(SesiQr $sesiQr)
    {
        $this->authorizeSesi($sesiQr);

        // Tidak boleh hapus sesi yang masih aktif & belum kadaluarsa
        if ($sesiQr->is_active && ! $sesiQr->isKadaluarsa()) {
            return back()->with('error', 'Nonaktifkan sesi terlebih dahulu sebelum menghapus.');
        }

        $sesiQr->delete();

        return redirect()
            ->route('guru.sesi-qr.index')
            ->with('success', 'Sesi QR berhasil dihapus.');
    }

    // ── Cetak QR (PDF) ────────────────────────────────────────────────────────

    public function cetakQr(SesiQr $sesiQr)
    {
        $this->authorizeSesi($sesiQr);
        $sesiQr->load(['kelas', 'mataPelajaran']);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
            'guru.sesi-qr.exports.cetak-qr',
            compact('sesiQr')
        )->setPaper('a5', 'portrait');

        return $pdf->stream('qr_sesi_' . $sesiQr->id . '_' . $sesiQr->tanggal->format('Ymd') . '.pdf');
    }
}