<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\SesiQr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarcodeKelasController extends Controller
{
    // ── Helpers ───────────────────────────────────────────────────────────────

    private function getGuru(): \App\Models\Guru
    {
        $guru = Auth::user()->guru;
        abort_if(! $guru, 403, 'Akun Anda tidak terhubung dengan data guru.');
        return $guru;
    }

    /**
     * Guru boleh akses sesi apapun selama kelas-nya adalah kelas yang dia ampu.
     * (Termasuk sesi yang dibuat admin.)
     */
    private function authorizeSesi(SesiQr $sesiQr): void
    {
        $guru     = $this->getGuru();
        $kelasIds = JadwalPelajaran::where('guru_id', $guru->id)
            ->pluck('kelas_id')
            ->unique()
            ->toArray();

        abort_if(! in_array($sesiQr->kelas_id, $kelasIds), 403, 'Anda tidak memiliki akses ke sesi QR ini.');
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

    private function getKelasIds(\App\Models\Guru $guru): array
    {
        return JadwalPelajaran::where('guru_id', $guru->id)
            ->pluck('kelas_id')
            ->unique()
            ->toArray();
    }

    // ── INDEX ─────────────────────────────────────────────────────────────────

    public function index()
    {
        $guru     = $this->getGuru();
        $user     = Auth::user();
        $kelasIds = $this->getKelasIds($guru);

        $barcodeGuru = 'GURU-' . $user->id;
        $hariIni     = $this->hariIni();

        $jadwalHariIni = JadwalPelajaran::with(['mataPelajaran', 'kelas', 'ruang'])
            ->where('guru_id', $guru->id)
            ->where('hari', $hariIni)
            ->where('is_active', true)
            ->orderBy('jam_mulai')
            ->get();

        // Sesi aktif hari ini di kelas yang diampu guru (termasuk buatan admin)
        $sesiPerJadwal = SesiQr::whereIn('kelas_id', $kelasIds)
            ->whereDate('tanggal', today())
            ->where('is_active', true)
            ->with(['kelas', 'mataPelajaran'])
            ->get()
            ->keyBy('jadwal_pelajaran_id');

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

    // ── CETAK: Barcode kelas ──────────────────────────────────────────────────

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

    public function createSesi(Request $request)
    {
        $guru     = $this->getGuru();
        $hariIni  = $this->hariIni();
        $kelasIds = $this->getKelasIds($guru);

        $jadwalHariIni = JadwalPelajaran::with(['mataPelajaran', 'kelas'])
            ->where('guru_id', $guru->id)
            ->where('hari', $hariIni)
            ->where('is_active', true)
            ->orderBy('jam_mulai')
            ->get();

        // Jadwal yang sudah punya sesi aktif hari ini (dari siapapun)
        $sesiSudahAda = SesiQr::whereIn('kelas_id', $kelasIds)
            ->whereDate('tanggal', today())
            ->where('is_active', true)
            ->where('kadaluarsa_pada', '>=', now())
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

    public function storeSesi(Request $request)
    {
        $guru     = $this->getGuru();
        $kelasIds = $this->getKelasIds($guru);

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

        $jadwal = JadwalPelajaran::where('id', $request->jadwal_pelajaran_id)
            ->where('guru_id', $guru->id)
            ->where('is_active', true)
            ->first();

        abort_if(! $jadwal, 403, 'Jadwal tidak ditemukan atau bukan milik Anda.');

        if ($jadwal->hari !== $this->hariIni()) {
            return back()->withInput()
                ->with('error', 'Sesi QR hanya bisa dibuat untuk jadwal hari ini (' . ucfirst($this->hariIni()) . ').');
        }

        // Cek sesi aktif di kelas yang diampu (dari siapapun pembuatnya)
        $sesiAktif = SesiQr::whereIn('kelas_id', $kelasIds)
            ->whereDate('tanggal', today())
            ->where('is_active', true)
            ->where('kadaluarsa_pada', '>=', now())
            ->with(['mataPelajaran', 'kelas'])
            ->first();

        if ($sesiAktif) {
            $namaMapel = $sesiAktif->mataPelajaran->nama_mapel ?? 'suatu pelajaran';
            $namaKelas = $sesiAktif->kelas->nama_kelas ?? '';
            $sisaWaktu = now()->diffForHumans($sesiAktif->kadaluarsa_pada, true);
            return back()->withInput()
                ->with('error',
                    "Masih ada sesi QR aktif untuk {$namaMapel}" .
                    ($namaKelas ? " ({$namaKelas})" : '') .
                    " — berakhir dalam {$sisaWaktu}. " .
                    "Selesaikan atau nonaktifkan sesi tersebut sebelum membuat sesi baru."
                );
        }

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

    public function cetakBarcodeGuru()
    {
        $guru        = $this->getGuru();
        $user        = Auth::user();
        $barcodeGuru = 'GURU-' . $user->id;

        return view('guru.barcode-kelas.cetak-barcode-guru', compact('guru', 'user', 'barcodeGuru'));
    }
}