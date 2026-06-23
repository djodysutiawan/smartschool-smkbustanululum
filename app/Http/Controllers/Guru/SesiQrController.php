<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\JadwalPelajaran;
use App\Models\SesiQr;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SesiQrController extends Controller
{
    private function getGuru(): \App\Models\Guru
    {
        $guru = Auth::user()->guru;
        abort_if(! $guru, 403, 'Akun Anda tidak terhubung dengan data guru.');
        return $guru;
    }

    private function authorizeSesi(SesiQr $sesiQr): void
    {
        // Guru boleh akses sesi yang dibuat siapapun, asal kelasnya adalah kelas yang dia ampu
        $guru = $this->getGuru();
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

    /**
     * Ambil kelas_id yang diampu guru ini.
     */
    private function getKelasIds(\App\Models\Guru $guru): array
    {
        return JadwalPelajaran::where('guru_id', $guru->id)
            ->pluck('kelas_id')
            ->unique()
            ->toArray();
    }

    // ── HELPER: Auto-generate barcode_mapel untuk siswa di kelas ─────────────

    private function generateBarcodeMapelUntukKelas(int $kelasId): void
    {
        $siswaTanpaBarcode = Siswa::where('kelas_id', $kelasId)
            ->whereNull('barcode_mapel')
            ->get();

        foreach ($siswaTanpaBarcode as $siswa) {
            $kode = 'MAP-' . ($siswa->nis
                ? strtoupper($siswa->nis)
                : str_pad($siswa->id, 8, '0', STR_PAD_LEFT)
            );

            $base  = $kode;
            $index = 1;
            while (Siswa::where('barcode_mapel', $kode)->where('id', '!=', $siswa->id)->exists()) {
                $kode = $base . '-' . $index++;
            }

            $siswa->update(['barcode_mapel' => $kode]);
        }
    }

    // ── INDEX ─────────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $guru     = $this->getGuru();
        $kelasIds = $this->getKelasIds($guru);

        // Tampilkan SEMUA sesi di kelas yang diampu guru ini (termasuk yg dibuat admin)
        $query = SesiQr::with(['kelas', 'mataPelajaran', 'jadwalPelajaran'])
            ->whereIn('kelas_id', $kelasIds);

        if ($request->filled('tanggal'))  $query->whereDate('tanggal', $request->tanggal);
        if ($request->filled('kelas_id')) $query->where('kelas_id', $request->kelas_id);
        if ($request->filled('status')) {
            if ($request->status === 'aktif')    $query->where('is_active', true);
            if ($request->status === 'nonaktif') $query->where('is_active', false);
        }

        $sesiList = $query->latest('tanggal')->latest()->paginate(15)->withQueryString();

        $stats = [
            'total'    => SesiQr::whereIn('kelas_id', $kelasIds)->count(),
            'aktif'    => SesiQr::whereIn('kelas_id', $kelasIds)->where('is_active', true)->count(),
            'hari_ini' => SesiQr::whereIn('kelas_id', $kelasIds)->whereDate('tanggal', today())->count(),
        ];

        $kelasList = \App\Models\Kelas::aktif()->whereIn('id', $kelasIds)->orderBy('nama_kelas')->get();

        $hariIni       = $this->hariIni();
        $jadwalHariIni = JadwalPelajaran::with(['mataPelajaran', 'kelas'])
            ->where('guru_id', $guru->id)
            ->where('hari', $hariIni)
            ->where('is_active', true)
            ->orderBy('jam_mulai')
            ->get();

        // Sesi aktif hari ini per jadwal (dari kelas yang diampu, siapapun pembuatnya)
        $sesiPerJadwal = SesiQr::whereIn('kelas_id', $kelasIds)
            ->whereDate('tanggal', today())
            ->where('is_active', true)
            ->get()
            ->keyBy('jadwal_pelajaran_id');

        // Ada sesi aktif yang belum kadaluarsa di kelas yang diampu?
        $adaSesiAktif = SesiQr::whereIn('kelas_id', $kelasIds)
            ->whereDate('tanggal', today())
            ->where('is_active', true)
            ->where('kadaluarsa_pada', '>=', now())
            ->exists();

        return view('guru.sesi-qr.index', compact(
            'sesiList', 'stats', 'kelasList',
            'jadwalHariIni', 'sesiPerJadwal', 'hariIni', 'adaSesiAktif'
        ));
    }

    // ── CREATE ────────────────────────────────────────────────────────────────

    public function create(Request $request)
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

        // Jadwal yang sudah punya sesi aktif hari ini (dari siapapun pembuatnya)
        $sesiSudahAda = SesiQr::whereIn('kelas_id', $kelasIds)
            ->whereDate('tanggal', today())
            ->where('is_active', true)
            ->where('kadaluarsa_pada', '>=', now())
            ->pluck('jadwal_pelajaran_id')
            ->toArray();

        // Sesi aktif yang belum selesai di kelas manapun yang diampu guru ini
        $sesiAktifSekarang = SesiQr::whereIn('kelas_id', $kelasIds)
            ->whereDate('tanggal', today())
            ->where('is_active', true)
            ->where('kadaluarsa_pada', '>=', now())
            ->with(['mataPelajaran', 'kelas'])
            ->first();

        $jadwalTerpilih = null;
        if ($request->filled('jadwal_pelajaran_id')) {
            $jadwalTerpilih = $jadwalHariIni->firstWhere('id', (int) $request->jadwal_pelajaran_id);
        }

        return view('guru.sesi-qr.create', compact(
            'guru', 'jadwalHariIni', 'sesiSudahAda',
            'jadwalTerpilih', 'hariIni', 'sesiAktifSekarang'
        ));
    }

    // ── STORE ─────────────────────────────────────────────────────────────────

    public function store(Request $request)
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
            'jadwal_pelajaran_id.exists'   => 'Jadwal pelajaran tidak ditemukan.',
            'durasi_menit.min'             => 'Durasi minimal 5 menit.',
            'durasi_menit.max'             => 'Durasi maksimal 240 menit.',
            'radius_meter.min'             => 'Radius minimal 10 meter.',
            'radius_meter.max'             => 'Radius maksimal 1000 meter.',
        ]);

        $jadwal = JadwalPelajaran::where('id', $request->jadwal_pelajaran_id)
            ->where('guru_id', $guru->id)
            ->where('is_active', true)
            ->firstOrFail();

        if ($jadwal->hari !== $this->hariIni()) {
            return back()->withInput()
                ->with('error', 'Sesi QR hanya bisa dibuat untuk jadwal hari ini (' . ucfirst($this->hariIni()) . ').');
        }

        // ── VALIDASI UTAMA: Ada sesi aktif di kelas yang diampu? ─────────────
        // Cek lintas pembuat — termasuk sesi yang dibuat admin
        $sesiAktifSekarang = SesiQr::whereIn('kelas_id', $kelasIds)
            ->whereDate('tanggal', today())
            ->where('is_active', true)
            ->where('kadaluarsa_pada', '>=', now())
            ->with(['mataPelajaran', 'kelas'])
            ->first();

        if ($sesiAktifSekarang) {
            $namaMapel = $sesiAktifSekarang->mataPelajaran->nama_mapel ?? 'suatu pelajaran';
            $namaKelas = $sesiAktifSekarang->kelas->nama_kelas ?? '';
            $sisaWaktu = now()->diffForHumans($sesiAktifSekarang->kadaluarsa_pada, true);
            return back()->withInput()
                ->with('error',
                    "Masih ada sesi QR aktif untuk {$namaMapel}" .
                    ($namaKelas ? " ({$namaKelas})" : '') .
                    " — berakhir dalam {$sisaWaktu}. " .
                    "Selesaikan atau nonaktifkan sesi tersebut sebelum membuat sesi baru."
                );
        }

        // ── VALIDASI TAMBAHAN: Duplikat per jadwal ───────────────────────────
        $sudahAda = SesiQr::where('jadwal_pelajaran_id', $jadwal->id)
            ->whereDate('tanggal', today())
            ->where('is_active', true)
            ->exists();

        if ($sudahAda) {
            return back()->withInput()
                ->with('error', 'Sudah ada sesi QR aktif untuk jadwal ini hari ini. Nonaktifkan sesi sebelumnya terlebih dahulu.');
        }

        $berlakuMulai = now();

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

        $this->generateBarcodeMapelUntukKelas($jadwal->kelas_id);

        return redirect()
            ->route('guru.barcode-kelas.show-sesi', $sesi)
            ->with('success', 'Sesi QR berhasil dibuat. Barcode siswa yang belum punya sudah di-generate otomatis.');
    }

    // ── SHOW ──────────────────────────────────────────────────────────────────

    public function show(SesiQr $sesiQr)
    {
        $this->authorizeSesi($sesiQr);
        $sesiQr->load(['kelas', 'mataPelajaran', 'jadwalPelajaran.ruang', 'riwayatScan.siswa']);
        $sudahScan  = $sesiQr->riwayatScan()->where('status', 'valid')->count();
        $totalSiswa = $sesiQr->kelas?->siswa()->count() ?? 0;
        return view('guru.sesi-qr.show', compact('sesiQr', 'sudahScan', 'totalSiswa'));
    }

    // ── STATUS AJAX ───────────────────────────────────────────────────────────

    public function statusAjax(SesiQr $sesiQr)
    {
        $this->authorizeSesi($sesiQr);

        $sudahScan = $sesiQr->riwayatScan()
            ->where('status', 'valid')
            ->with('siswa:id,nama_lengkap,nis')
            ->orderByDesc('dipindai_pada')
            ->get()
            ->map(fn ($r) => [
                'siswa_id'     => $r->siswa_id,
                'nama'         => $r->siswa->nama_lengkap ?? '—',
                'nis'          => $r->siswa->nis ?? '—',
                'di_scan_pada' => $r->dipindai_pada->format('H:i:s'),
            ]);

        $totalSiswa = $sesiQr->kelas?->siswa()->count() ?? 0;

        return response()->json([
            'is_valid'      => $sesiQr->isValid(),
            'is_kadaluarsa' => $sesiQr->isKadaluarsa(),
            'is_active'     => $sesiQr->is_active,
            'jumlah_scan'   => $sudahScan->count(),
            'total_siswa'   => $totalSiswa,
            'persentase'    => $totalSiswa > 0 ? round($sudahScan->count() / $totalSiswa * 100, 1) : 0,
            'sudah_scan'    => $sudahScan,
            'sisa_detik'    => max(0, now()->diffInSeconds($sesiQr->kadaluarsa_pada, false)),
            'kadaluarsa_at' => $sesiQr->kadaluarsa_pada->toISOString(),
        ]);
    }

    // ── NONAKTIFKAN ───────────────────────────────────────────────────────────

    public function nonaktifkan(SesiQr $sesiQr)
    {
        $this->authorizeSesi($sesiQr);
        $sesiQr->nonaktifkan();
        return back()->with('success', 'Sesi QR berhasil dinonaktifkan.');
    }

    // ── DESTROY ───────────────────────────────────────────────────────────────

    public function destroy(SesiQr $sesiQr)
    {
        $this->authorizeSesi($sesiQr);
        if ($sesiQr->is_active && ! $sesiQr->isKadaluarsa()) {
            return back()->with('error', 'Nonaktifkan sesi terlebih dahulu sebelum menghapus.');
        }
        $sesiQr->delete();
        return redirect()->route('guru.sesi-qr.index')->with('success', 'Sesi QR berhasil dihapus.');
    }

    // ── CETAK QR ─────────────────────────────────────────────────────────────

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