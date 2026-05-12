<?php

namespace App\Http\Controllers\Api\Siswa;

use App\Http\Controllers\Controller;
use App\Models\AbsensiGerbang;
use App\Models\BarcodeGerbang;
use App\Models\JadwalPelajaran;
use App\Models\SesiGerbang;
use App\Models\SesiQr;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * BarcodeController (API — Siswa)
 *
 * Endpoint:
 *   GET /api/siswa/barcode               → index()
 *   GET /api/siswa/barcode/gerbang       → gerbang()
 *   GET /api/siswa/barcode/mapel         → mapel()
 *
 * Endpoint AbsensiGerbang (read-only):
 *   GET /api/siswa/absensi-gerbang/status-hari-ini → statusGerbangHariIni()
 *   GET /api/siswa/absensi-gerbang/riwayat         → riwayatGerbang()
 *   GET /api/siswa/absensi-gerbang/{id}            → showGerbang()
 */
class BarcodeController extends Controller
{
    // ── Helpers ───────────────────────────────────────────────────────────────

    private function getSiswa(): \App\Models\Siswa
    {
        $siswa = Auth::user()?->siswa;
        abort_if(! $siswa, 403, 'Akun Anda tidak terhubung dengan data siswa.');
        return $siswa;
    }

    private function getBarcodeGerbang(\App\Models\Siswa $siswa): ?BarcodeGerbang
    {
        return BarcodeGerbang::where('siswa_id', $siswa->id)
            ->aktif()
            ->berlakuHariIni()
            ->latest()
            ->first();
    }

    private function getKodeBarcodeMapel(\App\Models\Siswa $siswa): ?string
    {
        return $siswa->barcode_mapel ?? null;
    }

    private function getSesiGerbangAktif(): ?SesiGerbang
    {
        return SesiGerbang::sesiAktifSekarang();
    }

    private function getSesiQrAktif(\App\Models\Siswa $siswa): \Illuminate\Support\Collection
    {
        return SesiQr::with('mataPelajaran')
            ->where('kelas_id', $siswa->kelas_id)
            ->where('is_active', true)
            ->whereDate('tanggal', today())
            ->where('berlaku_mulai', '<=', now())
            ->where('kadaluarsa_pada', '>=', now())
            ->orderBy('berlaku_mulai')
            ->get();
    }

    private function formatSesiGerbang(?SesiGerbang $sesi): ?array
    {
        if (! $sesi) return null;
        return [
            'id'         => $sesi->id,
            'tipe'       => $sesi->tipe,    // 'masuk' | 'pulang'
            'mulai'      => $sesi->berlaku_mulai,
            'selesai'    => $sesi->berlaku_sampai,
        ];
    }

    private function formatSesiQr(\Illuminate\Support\Collection $sesiList): array
    {
        return $sesiList->map(fn ($s) => [
            'id'             => $s->id,
            'mata_pelajaran' => $s->mataPelajaran?->nama_mapel,
            'berlaku_mulai'  => $s->berlaku_mulai,
            'kadaluarsa'     => $s->kadaluarsa_pada,
        ])->values()->toArray();
    }

    // ── BARCODE INDEX ─────────────────────────────────────────────────────────

    /**
     * GET /api/siswa/barcode
     *
     * Mengembalikan kedua kode barcode siswa beserta info sesi aktif.
     */
    public function index(): JsonResponse
    {
        $siswa = $this->getSiswa();

        $barcodeGerbang   = $this->getBarcodeGerbang($siswa);
        $kodeBarcodeMapel = $this->getKodeBarcodeMapel($siswa);
        $sesiGerbangAktif = $this->getSesiGerbangAktif();
        $sesiQrAktif      = $this->getSesiQrAktif($siswa);

        $hariIni = strtolower(\Carbon\Carbon::now()->locale('id')->isoFormat('dddd'));
        $jadwalHariIni = JadwalPelajaran::with('mataPelajaran')
            ->where('kelas_id', $siswa->kelas_id)
            ->where('hari', $hariIni)
            ->where('is_active', true)
            ->orderBy('jam_mulai')
            ->get()
            ->map(fn ($j) => [
                'id'             => $j->id,
                'mata_pelajaran' => $j->mataPelajaran?->nama_mapel,
                'jam_mulai'      => $j->jam_mulai,
                'jam_selesai'    => $j->jam_selesai,
            ]);

        return response()->json([
            'success' => true,
            'data'    => [
                'barcode_gerbang' => $barcodeGerbang ? [
                    'kode'             => $barcodeGerbang->kode,
                    'berlaku_sampai'   => $barcodeGerbang->berlaku_sampai,
                    'sesi_aktif'       => $this->formatSesiGerbang($sesiGerbangAktif),
                ] : null,
                'barcode_mapel' => $kodeBarcodeMapel ? [
                    'kode'       => $kodeBarcodeMapel,
                    'sesi_aktif' => $this->formatSesiQr($sesiQrAktif),
                ] : null,
                'jadwal_hari_ini' => $jadwalHariIni,
            ],
        ]);
    }

    // ── BARCODE GERBANG ───────────────────────────────────────────────────────

    /**
     * GET /api/siswa/barcode/gerbang
     *
     * Kode barcode gerbang siswa + info sesi aktif (masuk/pulang).
     * Dipakai mobile untuk render barcode di layar fullscreen.
     */
    public function gerbang(): JsonResponse
    {
        $siswa          = $this->getSiswa();
        $barcodeGerbang = $this->getBarcodeGerbang($siswa);

        if (! $barcodeGerbang) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum memiliki barcode gerbang aktif. Hubungi admin sekolah.',
            ], 404);
        }

        $sesiGerbangAktif = $this->getSesiGerbangAktif();

        return response()->json([
            'success' => true,
            'data'    => [
                'kode'           => $barcodeGerbang->kode,
                'berlaku_sampai' => $barcodeGerbang->berlaku_sampai,
                'sesi_aktif'     => $this->formatSesiGerbang($sesiGerbangAktif),
            ],
        ]);
    }

    // ── BARCODE MAPEL ─────────────────────────────────────────────────────────

    /**
     * GET /api/siswa/barcode/mapel
     *
     * Kode barcode mapel siswa + sesi QR yang sedang aktif.
     * Dipakai mobile untuk render barcode di layar fullscreen.
     */
    public function mapel(): JsonResponse
    {
        $siswa            = $this->getSiswa();
        $kodeBarcodeMapel = $this->getKodeBarcodeMapel($siswa);

        if (! $kodeBarcodeMapel) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum memiliki barcode mapel. Hubungi admin sekolah.',
            ], 404);
        }

        $sesiQrAktif = $this->getSesiQrAktif($siswa);

        return response()->json([
            'success' => true,
            'data'    => [
                'kode'       => $kodeBarcodeMapel,
                'sesi_aktif' => $this->formatSesiQr($sesiQrAktif),
            ],
        ]);
    }

    // ── ABSENSI GERBANG — STATUS HARI INI ─────────────────────────────────────

    /**
     * GET /api/siswa/absensi-gerbang/status-hari-ini
     *
     * Status scan masuk & pulang gerbang hari ini.
     */
    public function statusGerbangHariIni(): JsonResponse
    {
        $siswa = $this->getSiswa();

        $scanHariIni = AbsensiGerbang::with('sesiGerbang')
            ->where('siswa_id', $siswa->id)
            ->valid()
            ->hariIni()
            ->orderBy('waktu_scan')
            ->get();

        $scanMasuk  = $scanHariIni->firstWhere('tipe', 'masuk');
        $scanPulang = $scanHariIni->firstWhere('tipe', 'pulang');

        $format = fn ($scan) => $scan ? [
            'id'          => $scan->id,
            'tipe'        => $scan->tipe,
            'waktu_scan'  => $scan->waktu_scan,
            'status'      => $scan->status,
            'keterangan'  => $scan->keterangan,
        ] : null;

        return response()->json([
            'success' => true,
            'data'    => [
                'tanggal'     => today()->toDateString(),
                'scan_masuk'  => $format($scanMasuk),
                'scan_pulang' => $format($scanPulang),
                'semua_scan'  => $scanHariIni->map($format)->values(),
            ],
        ]);
    }

    // ── ABSENSI GERBANG — RIWAYAT ─────────────────────────────────────────────

    /**
     * GET /api/siswa/absensi-gerbang/riwayat
     *
     * Riwayat log scan gerbang dengan filter opsional.
     *
     * Query string:
     *   tanggal_dari   → YYYY-MM-DD
     *   tanggal_sampai → YYYY-MM-DD
     *   tipe           → masuk|pulang
     *   per_page       → default 20
     */
    public function riwayatGerbang(Request $request): JsonResponse
    {
        $siswa = $this->getSiswa();

        $request->validate([
            'tanggal_dari'   => ['nullable', 'date'],
            'tanggal_sampai' => ['nullable', 'date', 'after_or_equal:tanggal_dari'],
            'tipe'           => ['nullable', 'in:masuk,pulang'],
            'per_page'       => ['nullable', 'integer', 'between:5,100'],
        ]);

        $query = AbsensiGerbang::with('sesiGerbang')
            ->where('siswa_id', $siswa->id)
            ->orderBy('waktu_scan', 'desc');

        if ($request->filled('tanggal_dari'))   $query->whereDate('tanggal_scan', '>=', $request->tanggal_dari);
        if ($request->filled('tanggal_sampai')) $query->whereDate('tanggal_scan', '<=', $request->tanggal_sampai);
        if ($request->filled('tipe'))           $query->where('tipe', $request->tipe);

        $perPage = (int) ($request->per_page ?? 20);
        $riwayat = $query->paginate($perPage);

        // Rekap total (tidak terpengaruh filter)
        $rekapBase       = AbsensiGerbang::where('siswa_id', $siswa->id)->valid();
        $totalHariMasuk  = (clone $rekapBase)->masuk()->distinct('tanggal_scan')->count('tanggal_scan');
        $totalHariPulang = (clone $rekapBase)->pulang()->distinct('tanggal_scan')->count('tanggal_scan');

        return response()->json([
            'success' => true,
            'data'    => [
                'rekap' => [
                    'total_hari_masuk'  => $totalHariMasuk,
                    'total_hari_pulang' => $totalHariPulang,
                ],
                'riwayat' => $riwayat->map(fn ($s) => [
                    'id'          => $s->id,
                    'tipe'        => $s->tipe,
                    'tanggal'     => $s->tanggal_scan,
                    'waktu_scan'  => $s->waktu_scan,
                    'status'      => $s->status,
                    'keterangan'  => $s->keterangan,
                ]),
                'meta' => [
                    'current_page' => $riwayat->currentPage(),
                    'last_page'    => $riwayat->lastPage(),
                    'per_page'     => $riwayat->perPage(),
                    'total'        => $riwayat->total(),
                ],
            ],
        ]);
    }

    // ── ABSENSI GERBANG — SHOW ────────────────────────────────────────────────

    /**
     * GET /api/siswa/absensi-gerbang/{absensiGerbangId}
     *
     * Detail satu entri scan absensi gerbang milik siswa yang login.
     */
    public function showGerbang(int $absensiGerbangId): JsonResponse
    {
        $siswa          = $this->getSiswa();
        $absensiGerbang = AbsensiGerbang::findOrFail($absensiGerbangId);

        abort_if(
            $absensiGerbang->siswa_id !== $siswa->id,
            403,
            'Anda tidak memiliki akses ke data ini.'
        );

        $absensiGerbang->loadMissing(['sesiGerbang', 'siswa.kelas', 'inputOleh', 'koreksiDari']);

        return response()->json([
            'success' => true,
            'data'    => [
                'id'           => $absensiGerbang->id,
                'tipe'         => $absensiGerbang->tipe,
                'tanggal'      => $absensiGerbang->tanggal_scan,
                'waktu_scan'   => $absensiGerbang->waktu_scan,
                'status'       => $absensiGerbang->status,
                'keterangan'   => $absensiGerbang->keterangan,
                'sesi_gerbang' => $absensiGerbang->sesiGerbang ? [
                    'id'    => $absensiGerbang->sesiGerbang->id,
                    'tipe'  => $absensiGerbang->sesiGerbang->tipe,
                    'mulai' => $absensiGerbang->sesiGerbang->berlaku_mulai,
                ] : null,
                'input_oleh'    => $absensiGerbang->inputOleh?->name,
                'koreksi_dari'  => $absensiGerbang->koreksiDari?->id,
            ],
        ]);
    }
}