<?php

namespace App\Http\Controllers\Api\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\JadwalPelajaran;
use App\Models\SesiQr;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * AbsensiController (API — Siswa)
 *
 * Endpoint:
 *   GET  /api/siswa/absensi/status-hari-ini  → statusHariIni()
 *   POST /api/siswa/absensi/scan             → prosesQr()
 *   GET  /api/siswa/absensi/riwayat          → riwayat()
 *   GET  /api/siswa/absensi/rekap            → rekap()
 *   GET  /api/siswa/absensi/jadwal           → jadwalHariIni()
 */
class AbsensiController extends Controller
{
    private const STATUS_LIST = ['hadir', 'telat', 'izin', 'sakit', 'alfa'];

    // ── Helper ────────────────────────────────────────────────────────────────

    private function getSiswa(): \App\Models\Siswa
    {
        $siswa = Auth::user()?->siswa;
        abort_if(! $siswa, 403, 'Akun Anda tidak terhubung dengan data siswa.');
        return $siswa;
    }

    // ── STATUS HARI INI ───────────────────────────────────────────────────────

    /**
     * GET /api/siswa/absensi/status-hari-ini
     *
     * Status absensi siswa hari ini per jadwal pelajaran.
     * Menampilkan mapel yang sudah tercatat dan yang belum.
     */
    public function statusHariIni(): JsonResponse
    {
        $siswa = $this->getSiswa();

        $absensiHariIni = Absensi::with(['jadwalPelajaran.mataPelajaran', 'kelas'])
            ->where('siswa_id', $siswa->id)
            ->whereDate('tanggal', today())
            ->orderBy('jam_masuk')
            ->get();

        $hariIni = strtolower(\Carbon\Carbon::now()->locale('id')->isoFormat('dddd'));

        $jadwalHariIni = JadwalPelajaran::with(['mataPelajaran', 'guru'])
            ->where('kelas_id', $siswa->kelas_id)
            ->where('hari', $hariIni)
            ->where('is_active', true)
            ->orderBy('jam_mulai')
            ->get();

        $absensiMap = $absensiHariIni->keyBy('jadwal_pelajaran_id');

        $jadwalDenganStatus = $jadwalHariIni->map(function ($jadwal) use ($absensiMap) {
            $absensi = $absensiMap->get($jadwal->id);
            return [
                'jadwal_id'      => $jadwal->id,
                'mata_pelajaran' => $jadwal->mataPelajaran?->nama_mapel,
                'guru'           => $jadwal->guru?->nama_lengkap,
                'jam_mulai'      => $jadwal->jam_mulai,
                'jam_selesai'    => $jadwal->jam_selesai,
                'status'         => $absensi?->status ?? 'belum',
                'jam_masuk'      => $absensi?->jam_masuk,
                'keterangan'     => $absensi?->keterangan,
            ];
        });

        // Rekap ringkas
        $rekap = [
            'hadir' => $absensiHariIni->whereIn('status', ['hadir', 'telat'])->count(),
            'izin'  => $absensiHariIni->where('status', 'izin')->count(),
            'sakit' => $absensiHariIni->where('status', 'sakit')->count(),
            'alfa'  => $absensiHariIni->where('status', 'alfa')->count(),
            'belum' => $jadwalHariIni->count() - $absensiHariIni->count(),
            'total_jadwal' => $jadwalHariIni->count(),
        ];

        return response()->json([
            'success' => true,
            'data'    => [
                'tanggal'  => today()->toDateString(),
                'hari'     => $hariIni,
                'rekap'    => $rekap,
                'jadwal'   => $jadwalDenganStatus,
            ],
        ]);
    }

    // ── SCAN QR (fallback manual) ─────────────────────────────────────────────

    /**
     * POST /api/siswa/absensi/scan
     *
     * Proses scan QR manual dari aplikasi mobile.
     *
     * Body:
     *   kode_qr (required) — kode dari kamera atau input teks
     *                        Bisa berformat "SESI-{uuid}" atau "{uuid}" saja
     */
    public function prosesQr(Request $request): JsonResponse
    {
        $request->validate([
            'kode_qr' => ['required', 'string', 'max:255'],
        ]);

        $siswa = $this->getSiswa();

        // Normalisasi: hapus prefix "SESI-" jika ada
        $kode = trim($request->kode_qr);
        if (str_starts_with(strtoupper($kode), 'SESI-')) {
            $kode = substr($kode, 5);
        }

        $sesi = SesiQr::where('kode_qr', $kode)->first();

        if (! $sesi) {
            return response()->json([
                'success' => false,
                'message' => 'Kode QR tidak ditemukan. Pastikan kode yang Anda masukkan benar.',
            ], 404);
        }

        if (! $sesi->isValid()) {
            $pesan = $sesi->isKadaluarsa()
                ? 'Sesi QR ini sudah kadaluarsa. Minta guru untuk membuka sesi baru.'
                : 'Sesi QR ini sudah tidak aktif.';

            return response()->json(['success' => false, 'message' => $pesan], 422);
        }

        if ($sesi->kelas_id !== $siswa->kelas_id) {
            return response()->json([
                'success' => false,
                'message' => 'QR Code ini bukan untuk kelas Anda.',
            ], 422);
        }

        $sudahAbsen = Absensi::where('siswa_id', $siswa->id)
            ->where('sesi_qr_id', $sesi->id)
            ->exists();

        if ($sudahAbsen) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah tercatat hadir untuk pelajaran ini.',
            ], 422);
        }

        // Tentukan status: hadir atau telat
        $status = Absensi::STATUS_HADIR;
        if ($sesi->jadwalPelajaran) {
            $batasLambat = \Carbon\Carbon::parse($sesi->jadwalPelajaran->jam_mulai)->addMinutes(15);
            if (now()->gt($batasLambat)) {
                $status = Absensi::STATUS_TELAT;
            }
        }

        $absensi = Absensi::create([
            'siswa_id'            => $siswa->id,
            'kelas_id'            => $siswa->kelas_id,
            'sesi_qr_id'          => $sesi->id,
            'mata_pelajaran_id'   => $sesi->mata_pelajaran_id,
            'jadwal_pelajaran_id' => $sesi->jadwal_pelajaran_id,
            'dicatat_oleh'        => null,
            'tanggal'             => today(),
            'status'              => $status,
            'metode'              => Absensi::METODE_QR,
            'jam_masuk'           => now()->format('H:i:s'),
            'keterangan'          => 'Scan QR manual oleh siswa (mobile)',
        ]);

        $sesi->incrementScan();

        return response()->json([
            'success' => true,
            'message' => 'Absensi berhasil dicatat.',
            'data'    => [
                'status'         => $status,
                'jam_masuk'      => $absensi->jam_masuk,
                'mata_pelajaran' => $sesi->mataPelajaran?->nama_mapel,
                'tanggal'        => $absensi->tanggal,
            ],
        ]);
    }

    // ── RIWAYAT ───────────────────────────────────────────────────────────────

    /**
     * GET /api/siswa/absensi/riwayat
     *
     * Riwayat absensi mapel dengan filter opsional.
     *
     * Query string:
     *   status         → hadir|telat|izin|sakit|alfa
     *   tanggal_dari   → YYYY-MM-DD
     *   tanggal_sampai → YYYY-MM-DD
     *   bulan          → 1–12
     *   tahun          → 2000–2100
     *   per_page       → default 20
     */
    public function riwayat(Request $request): JsonResponse
    {
        $siswa = $this->getSiswa();

        $request->validate([
            'status'         => ['nullable', 'in:' . implode(',', self::STATUS_LIST)],
            'tanggal_dari'   => ['nullable', 'date'],
            'tanggal_sampai' => ['nullable', 'date', 'after_or_equal:tanggal_dari'],
            'bulan'          => ['nullable', 'integer', 'between:1,12'],
            'tahun'          => ['nullable', 'integer', 'min:2000', 'max:2100'],
            'per_page'       => ['nullable', 'integer', 'between:5,100'],
        ]);

        $query = Absensi::with(['kelas', 'jadwalPelajaran.mataPelajaran'])
            ->where('siswa_id', $siswa->id);

        if ($request->filled('status'))         $query->where('status', $request->status);
        if ($request->filled('tanggal_dari'))   $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        if ($request->filled('tanggal_sampai')) $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        if ($request->filled('bulan'))          $query->whereMonth('tanggal', (int) $request->bulan);
        if ($request->filled('tahun'))          $query->whereYear('tanggal', (int) $request->tahun);

        $perPage  = (int) ($request->per_page ?? 20);
        $absensi  = $query->orderByDesc('tanggal')->paginate($perPage);

        // Rekap keseluruhan (tidak terpengaruh filter)
        $base  = fn () => Absensi::where('siswa_id', $siswa->id);
        $rekap = [
            'hadir'  => $base()->whereIn('status', ['hadir', 'telat'])->count(),
            'izin'   => $base()->where('status', 'izin')->count(),
            'sakit'  => $base()->where('status', 'sakit')->count(),
            'alfa'   => $base()->where('status', 'alfa')->count(),
            'total'  => $base()->count(),
        ];
        $rekap['persen_hadir'] = $rekap['total'] > 0
            ? round(($rekap['hadir'] / $rekap['total']) * 100, 1)
            : 0;

        return response()->json([
            'success' => true,
            'data'    => [
                'rekap'    => $rekap,
                'absensi'  => $absensi->map(fn ($a) => [
                    'id'             => $a->id,
                    'tanggal'        => $a->tanggal,
                    'mata_pelajaran' => $a->jadwalPelajaran?->mataPelajaran?->nama_mapel,
                    'status'         => $a->status,
                    'jam_masuk'      => $a->jam_masuk,
                    'keterangan'     => $a->keterangan,
                    'metode'         => $a->metode,
                ]),
                'meta'     => [
                    'current_page' => $absensi->currentPage(),
                    'last_page'    => $absensi->lastPage(),
                    'per_page'     => $absensi->perPage(),
                    'total'        => $absensi->total(),
                ],
            ],
        ]);
    }

    // ── REKAP ─────────────────────────────────────────────────────────────────

    /**
     * GET /api/siswa/absensi/rekap
     *
     * Rekap kehadiran per bulan dan per mata pelajaran.
     *
     * Query string:
     *   bulan → 1–12  (default: bulan berjalan)
     *   tahun → 2000–2100 (default: tahun berjalan)
     */
    public function rekap(Request $request): JsonResponse
    {
        $siswa = $this->getSiswa();

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

        return response()->json([
            'success' => true,
            'data'    => [
                'periode'         => [
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                    'label' => \Carbon\Carbon::create($tahun, $bulan)->locale('id')->isoFormat('MMMM YYYY'),
                ],
                'rekap'           => $rekap,
                'rekap_per_mapel' => $rekapPerMapel,
            ],
        ]);
    }

    // ── JADWAL HARI INI + SESI QR AKTIF ──────────────────────────────────────

    /**
     * GET /api/siswa/absensi/jadwal
     *
     * Jadwal pelajaran hari ini beserta status sesi QR aktif & status absensi.
     * Dipakai aplikasi untuk tampilkan tombol "Scan QR" jika sesi sedang aktif.
     */
    public function jadwalHariIni(): JsonResponse
    {
        $siswa = $this->getSiswa();

        $hariIni = strtolower(\Carbon\Carbon::now()->locale('id')->isoFormat('dddd'));

        $jadwalList = JadwalPelajaran::with(['mataPelajaran', 'guru'])
            ->where('kelas_id', $siswa->kelas_id)
            ->where('hari', $hariIni)
            ->where('is_active', true)
            ->orderBy('jam_mulai')
            ->get();

        $jadwalIds = $jadwalList->pluck('id');

        // Ambil sesi QR aktif sekaligus (1 query)
        $sesiQrAktifMap = SesiQr::where('kelas_id', $siswa->kelas_id)
            ->whereIn('jadwal_pelajaran_id', $jadwalIds)
            ->where('is_active', true)
            ->whereDate('tanggal', today())
            ->where('berlaku_mulai', '<=', now())
            ->where('kadaluarsa_pada', '>=', now())
            ->get()
            ->keyBy('jadwal_pelajaran_id');

        // Ambil absensi hari ini sekaligus (1 query)
        $absensiMap = Absensi::where('siswa_id', $siswa->id)
            ->whereIn('jadwal_pelajaran_id', $jadwalIds)
            ->whereDate('tanggal', today())
            ->get()
            ->keyBy('jadwal_pelajaran_id');

        $result = $jadwalList->map(function ($jadwal) use ($sesiQrAktifMap, $absensiMap) {
            $sesi    = $sesiQrAktifMap->get($jadwal->id);
            $absensi = $absensiMap->get($jadwal->id);

            return [
                'jadwal_id'      => $jadwal->id,
                'mata_pelajaran' => $jadwal->mataPelajaran?->nama_mapel,
                'guru'           => $jadwal->guru?->nama_lengkap,
                'jam_mulai'      => $jadwal->jam_mulai,
                'jam_selesai'    => $jadwal->jam_selesai,
                'sesi_aktif'     => $sesi ? [
                    'id'            => $sesi->id,
                    'kode_qr'       => $sesi->kode_qr,
                    'berlaku_mulai' => $sesi->berlaku_mulai,
                    'kadaluarsa'    => $sesi->kadaluarsa_pada,
                ] : null,
                'status_absensi' => $absensi?->status ?? 'belum',
                'jam_masuk'      => $absensi?->jam_masuk,
                'bisa_scan'      => $sesi !== null && $absensi === null,
            ];
        });

        return response()->json([
            'success' => true,
            'data'    => [
                'hari'    => $hariIni,
                'tanggal' => today()->toDateString(),
                'jadwal'  => $result,
            ],
        ]);
    }
}