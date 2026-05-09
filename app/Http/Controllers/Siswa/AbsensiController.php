<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\JadwalPelajaran;
use App\Models\SesiQr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * AbsensiController (Siswa) — Absensi Per Mata Pelajaran
 *
 * Siswa TIDAK lagi scan QR dari kamera HP.
 * Absensi mapel dicatat otomatis oleh alat IoT di kelas
 * ketika siswa menunjukkan barcode mapel ke alat saat pelajaran dimulai.
 *
 * Namun, halaman scan() tetap dipertahankan sebagai fallback manual
 * apabila alat IoT tidak tersedia.
 */
class AbsensiController extends Controller
{
    private const STATUS_LIST = ['hadir', 'telat', 'izin', 'sakit', 'alfa'];

    // ── Helper ────────────────────────────────────────────────────────────────

    /**
     * FIX: Tambah null-safe operator (?->) agar tidak fatal error
     * jika Auth::user() mengembalikan null (edge case: session expired mid-request).
     */
    private function getSiswa(): \App\Models\Siswa
    {
        $siswa = Auth::user()?->siswa;
        abort_if(! $siswa, 403, 'Akun Anda tidak terhubung dengan data siswa.');
        return $siswa;
    }

    // ── SCAN QR (fallback manual) ─────────────────────────────────────────────

    /**
     * GET /siswa/absensi/scan
     *
     * Halaman scan QR — dipakai sebagai fallback jika alat IoT tidak tersedia.
     * Menampilkan scanner kamera + form input kode manual.
     * Juga menampilkan ringkasan absensi hari ini.
     */
    public function scan()
    {
        $siswa = $this->getSiswa();

        // Absensi hari ini (collection, bukan single model)
        $absensiHariIni = Absensi::with(['jadwalPelajaran.mataPelajaran', 'kelas'])
            ->where('siswa_id', $siswa->id)
            ->whereDate('tanggal', today())
            ->orderBy('jam_masuk')
            ->get();

        return view('siswa.absensi.scan', compact('siswa', 'absensiHariIni'));
    }

    /**
     * POST /siswa/absensi/scan
     *
     * Proses scan QR manual dari form (kode diisi lewat kamera JS atau input teks).
     *
     * Format kode yang diterima:
     *   - "SESI-{uuid}"  → prefix dari QR code yang di-generate view jadwal
     *   - "{uuid}"       → kode raw (tanpa prefix)
     *
     * PERBAIKAN:
     *   - Field name di form harus 'kode_qr' (bukan 'qr_code')
     *   - Trim prefix 'SESI-' sebelum lookup ke DB
     *   - Cek duplikasi per sesi_qr_id (bukan per tanggal saja) agar
     *     siswa bisa absen mapel berbeda di hari yang sama
     */
    public function doScan(Request $request)
    {
        $request->validate([
            'kode_qr' => ['required', 'string', 'max:255'],
        ], [
            'kode_qr.required' => 'Kode QR tidak boleh kosong.',
        ]);

        $siswa = $this->getSiswa();

        // Normalisasi: hapus prefix "SESI-" jika ada
        $kode = trim($request->kode_qr);
        if (str_starts_with(strtoupper($kode), 'SESI-')) {
            $kode = substr($kode, 5);
        }

        // Cari sesi QR berdasarkan kode
        $sesi = SesiQr::where('kode_qr', $kode)->first();

        if (! $sesi) {
            return back()
                ->withInput()
                ->with('error', 'Kode QR tidak ditemukan. Pastikan kode yang Anda masukkan benar.');
        }

        // Validasi: sesi masih aktif & belum kadaluarsa
        if (! $sesi->isValid()) {
            $pesan = $sesi->isKadaluarsa()
                ? 'Sesi QR ini sudah kadaluarsa. Minta guru untuk membuka sesi baru.'
                : 'Sesi QR ini sudah tidak aktif.';
            return back()->withInput()->with('error', $pesan);
        }

        // Validasi: kelas siswa harus sesuai kelas sesi
        if ($sesi->kelas_id !== $siswa->kelas_id) {
            return back()
                ->withInput()
                ->with('error', 'QR Code ini bukan untuk kelas Anda.');
        }

        // Cek duplikasi: sudah absen di sesi yang sama?
        $sudahAbsenSesi = Absensi::where('siswa_id', $siswa->id)
            ->where('sesi_qr_id', $sesi->id)
            ->exists();

        if ($sudahAbsenSesi) {
            return back()->with('warning', 'Anda sudah tercatat hadir untuk pelajaran ini.');
        }

        // Tentukan status: hadir atau telat
        $status = Absensi::STATUS_HADIR;

        // Jika jam pelajaran sudah lewat lebih dari 15 menit → telat
        if ($sesi->jadwalPelajaran) {
            $batasLambat = \Carbon\Carbon::parse($sesi->jadwalPelajaran->jam_mulai)->addMinutes(15);
            if (now()->gt($batasLambat)) {
                $status = Absensi::STATUS_TELAT;
            }
        }

        // Catat absensi
        Absensi::create([
            'siswa_id'            => $siswa->id,
            'kelas_id'            => $siswa->kelas_id,
            'sesi_qr_id'          => $sesi->id,
            'mata_pelajaran_id'   => $sesi->mata_pelajaran_id,
            'jadwal_pelajaran_id' => $sesi->jadwal_pelajaran_id,
            'dicatat_oleh'        => null, // otomatis oleh siswa
            'tanggal'             => today(),
            'status'              => $status,
            'metode'              => Absensi::METODE_QR,
            'jam_masuk'           => now()->format('H:i:s'),
            'keterangan'          => 'Scan QR manual oleh siswa',
        ]);

        // Increment counter scan sesi
        $sesi->incrementScan();

        $labelStatus = $status === Absensi::STATUS_TELAT ? 'Telat' : 'Hadir';
        $namaMapel   = $sesi->mataPelajaran?->nama_mapel ?? 'Mata Pelajaran';

        return redirect()
            ->route('siswa.absensi.scan')
            ->with('success', "Absensi {$namaMapel} berhasil dicatat. Status: {$labelStatus}.");
    }

    // ── STATUS HARI INI ───────────────────────────────────────────────────────

    /**
     * GET /siswa/absensi/status-hari-ini
     *
     * Status absensi kelas siswa untuk hari ini per jadwal pelajaran.
     * Menampilkan mapel yang sudah tercatat dan yang belum.
     */
    public function statusHariIni()
    {
        $siswa = $this->getSiswa();

        $absensiHariIni = Absensi::with(['jadwalPelajaran.mataPelajaran', 'kelas'])
            ->where('siswa_id', $siswa->id)
            ->whereDate('tanggal', today())
            ->orderBy('jam_masuk')
            ->get();

        // Jadwal hari ini
        $hariIni = strtolower(\Carbon\Carbon::now()->locale('id')->isoFormat('dddd'));
        $jadwalHariIni = JadwalPelajaran::with(['mataPelajaran', 'guru'])
            ->where('kelas_id', $siswa->kelas_id)
            ->where('hari', $hariIni)
            ->where('is_active', true)
            ->orderBy('jam_mulai')
            ->get();

        // Map absensi berdasarkan jadwal_pelajaran_id untuk lookup cepat di view
        $absensiMap = $absensiHariIni->keyBy('jadwal_pelajaran_id');

        return view('siswa.absensi.status-hari-ini', compact(
            'siswa',
            'absensiHariIni',
            'jadwalHariIni',
            'absensiMap',
        ));
    }

    // ── JADWAL HARI INI ───────────────────────────────────────────────────────

    /**
     * GET /siswa/absensi/jadwal
     *
     * Jadwal pelajaran hari ini beserta status sesi QR aktif & status absensi siswa.
     * Siswa bisa melihat mapel mana yang sedang buka absensi dan menampilkan QR-nya.
     *
     * FIX: Gunakan query terpisah (bukan N+1 each()) untuk inject data sesi QR
     * dan status absensi ke setiap jadwal. Menghindari N query ke DB untuk
     * jadwal yang banyak.
     */
    public function jadwalHariIni()
    {
        $siswa = $this->getSiswa();

        $hariIni = strtolower(\Carbon\Carbon::now()->locale('id')->isoFormat('dddd'));

        $jadwalList = JadwalPelajaran::with(['mataPelajaran', 'guru'])
            ->where('kelas_id', $siswa->kelas_id)
            ->where('hari', $hariIni)
            ->where('is_active', true)
            ->orderBy('jam_mulai')
            ->get();

        // FIX: Ambil semua sesi QR aktif hari ini untuk kelas ini sekaligus (1 query)
        // lalu key by jadwal_pelajaran_id untuk lookup O(1) di loop berikutnya.
        $jadwalIds = $jadwalList->pluck('id');

        $sesiQrAktifMap = SesiQr::where('kelas_id', $siswa->kelas_id)
            ->whereIn('jadwal_pelajaran_id', $jadwalIds)
            ->where('is_active', true)
            ->whereDate('tanggal', today())
            ->where('berlaku_mulai', '<=', now())
            ->where('kadaluarsa_pada', '>=', now())
            ->get()
            ->keyBy('jadwal_pelajaran_id');

        // FIX: Ambil semua absensi hari ini sekaligus (1 query)
        $absensiMap = Absensi::where('siswa_id', $siswa->id)
            ->whereIn('jadwal_pelajaran_id', $jadwalIds)
            ->whereDate('tanggal', today())
            ->get()
            ->keyBy('jadwal_pelajaran_id');

        // Inject ke collection jadwal tanpa N+1
        $jadwalList->each(function ($jadwal) use ($sesiQrAktifMap, $absensiMap) {
            $jadwal->sesiQrAktif = $sesiQrAktifMap->get($jadwal->id);
            $jadwal->sudahAbsen  = $absensiMap->get($jadwal->id);
        });

        return view('siswa.absensi.jadwal', compact('siswa', 'jadwalList'));
    }

    // ── RIWAYAT ───────────────────────────────────────────────────────────────

    /**
     * GET /siswa/absensi/riwayat
     *
     * Riwayat kehadiran kelas siswa.
     * Filter: status, tanggal_dari, tanggal_sampai, bulan, tahun.
     *
     * FIX: Tambah validasi input agar tidak ada SQL injection via filter,
     * dan bulan/tahun di-cast ke integer sebelum dipakai di query.
     */
    public function riwayat(Request $request)
    {
        $siswa = $this->getSiswa();

        // FIX: Validasi semua filter input
        $request->validate([
            'status'         => ['nullable', 'in:' . implode(',', self::STATUS_LIST)],
            'tanggal_dari'   => ['nullable', 'date'],
            'tanggal_sampai' => ['nullable', 'date', 'after_or_equal:tanggal_dari'],
            'bulan'          => ['nullable', 'integer', 'between:1,12'],
            'tahun'          => ['nullable', 'integer', 'min:2000', 'max:2100'],
        ]);

        $query = Absensi::with(['kelas', 'jadwalPelajaran.mataPelajaran', 'dicatatOleh'])
            ->where('siswa_id', $siswa->id);

        if ($request->filled('status'))         $query->where('status', $request->status);
        if ($request->filled('tanggal_dari'))   $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        if ($request->filled('tanggal_sampai')) $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        // FIX: cast ke int sebelum dipakai whereMonth/whereYear
        if ($request->filled('bulan'))          $query->whereMonth('tanggal', (int) $request->bulan);
        if ($request->filled('tahun'))          $query->whereYear('tanggal',  (int) $request->tahun);

        $absensi    = $query->orderByDesc('tanggal')->paginate(20)->withQueryString();
        $statusList = self::STATUS_LIST;

        // Rekap keseluruhan (bukan hanya yang difilter) untuk summary card
        $base  = fn () => Absensi::where('siswa_id', $siswa->id);
        $rekap = [
            'hadir' => $base()->whereIn('status', ['hadir', 'telat'])->count(),
            'izin'  => $base()->where('status', 'izin')->count(),
            'sakit' => $base()->where('status', 'sakit')->count(),
            'alfa'  => $base()->where('status', 'alfa')->count(),
            'total' => $base()->count(),
        ];
        $rekap['persen_hadir'] = $rekap['total'] > 0
            ? round(($rekap['hadir'] / $rekap['total']) * 100, 1)
            : 0;

        $tahunList = Absensi::where('siswa_id', $siswa->id)
            ->selectRaw('YEAR(tanggal) as tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

        return view('siswa.absensi.riwayat', compact(
            'absensi', 'statusList', 'rekap', 'tahunList',
        ));
    }

    // ── REKAP ─────────────────────────────────────────────────────────────────

    /**
     * GET /siswa/absensi/rekap
     *
     * Rekap kehadiran siswa per bulan dan per mata pelajaran.
     * Default: bulan & tahun berjalan.
     *
     * FIX: bulan & tahun di-cast ke int dan di-clamp ke range valid sebelum
     * dipakai di query agar tidak ada nilai aneh dari query string.
     */
    public function rekap(Request $request)
    {
        $siswa = $this->getSiswa();

        // FIX: validasi + cast eksplisit, bukan hanya (int) cast langsung
        $request->validate([
            'bulan' => ['nullable', 'integer', 'between:1,12'],
            'tahun' => ['nullable', 'integer', 'min:2000', 'max:2100'],
        ]);

        $bulan = $request->filled('bulan') ? (int) $request->bulan : now()->month;
        $tahun = $request->filled('tahun') ? (int) $request->tahun : now()->year;

        $absensiList = Absensi::with('jadwalPelajaran.mataPelajaran')
            ->where('siswa_id', $siswa->id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal')
            ->get();

        $rekap = [
            'hadir' => $absensiList->whereIn('status', ['hadir', 'telat'])->count(),
            'izin'  => $absensiList->where('status', 'izin')->count(),
            'sakit' => $absensiList->where('status', 'sakit')->count(),
            'alfa'  => $absensiList->where('status', 'alfa')->count(),
            'total' => $absensiList->count(),
        ];
        $rekap['persen_hadir'] = $rekap['total'] > 0
            ? round(($rekap['hadir'] / $rekap['total']) * 100, 1)
            : 0;

        // Rekap per mata pelajaran
        // FIX: groupBy closure bisa menghasilkan key null jika mata_pelajaran_id null.
        // Gunakan string cast agar tidak error saat filter() dan sortBy().
        $rekapPerMapel = $absensiList
            ->whereNotNull('jadwal_pelajaran_id')
            ->groupBy(fn ($a) => (string) ($a->jadwalPelajaran?->mata_pelajaran_id ?? 'unknown'))
            ->map(function ($group) {
                $pertama = $group->first();
                return [
                    'nama_mapel' => $pertama->jadwalPelajaran?->mataPelajaran?->nama_mapel ?? '-',
                    'hadir'      => $group->whereIn('status', ['hadir', 'telat'])->count(),
                    'izin'       => $group->where('status', 'izin')->count(),
                    'sakit'      => $group->where('status', 'sakit')->count(),
                    'alfa'       => $group->where('status', 'alfa')->count(),
                    'total'      => $group->count(),
                ];
            })
            ->filter(fn ($item) => $item['nama_mapel'] !== '-')
            ->sortBy('nama_mapel')
            ->values();

        $tahunList = Absensi::where('siswa_id', $siswa->id)
            ->selectRaw('YEAR(tanggal) as tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

        $bulanList = collect(range(1, 12))->mapWithKeys(fn ($b) => [
            $b => \Carbon\Carbon::create()->month($b)->locale('id')->isoFormat('MMMM'),
        ]);

        return view('siswa.absensi.rekap', compact(
            'siswa',
            'rekap',
            'rekapPerMapel',
            'absensiList',
            'bulan',
            'tahun',
            'bulanList',
            'tahunList',
        ));
    }
}