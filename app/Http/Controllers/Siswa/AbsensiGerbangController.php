<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\AbsensiGerbang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * AbsensiGerbangController (Siswa)
 * ─────────────────────────────────────────────────────────────────────────────
 * Menangani tampilan absensi gerbang (masuk & pulang) milik siswa yang login.
 *
 * Alur absensi gerbang:
 *   - Siswa scan barcode tetap di alat gerbang sekolah
 *   - Alat mencatat ke tabel absensi_gerbang secara otomatis
 *   - Controller ini hanya READ — siswa tidak bisa input/ubah data
 *
 * Routes yang dilayani:
 *   GET  /siswa/absensi-gerbang/status-hari-ini  → statusHariIni()
 *   GET  /siswa/absensi-gerbang/riwayat          → riwayat()
 *   GET  /siswa/absensi-gerbang/{absensiGerbang} → show()
 * ─────────────────────────────────────────────────────────────────────────────
 */
class AbsensiGerbangController extends Controller
{
    // ── Helper ────────────────────────────────────────────────────────────────

    /**
     * Ambil data siswa dari user yang sedang login.
     * Abort 403 jika akun belum terhubung dengan data siswa.
     */
    private function getSiswa(): \App\Models\Siswa
    {
        $siswa = Auth::user()?->siswa;
        abort_if(! $siswa, 403, 'Akun Anda tidak terhubung dengan data siswa.');
        return $siswa;
    }

    // ── STATUS HARI INI ───────────────────────────────────────────────────────

    /**
     * GET /siswa/absensi-gerbang/status-hari-ini
     *
     * Tampilkan status scan masuk & pulang hari ini.
     * Hanya scan dengan status valid (bukan duplikat) yang ditampilkan ke siswa.
     *
     * View variables:
     *   $siswa        → Model Siswa yang login
     *   $scanHariIni  → Collection AbsensiGerbang valid hari ini (urut waktu)
     *   $scanMasuk    → AbsensiGerbang|null  — scan masuk pertama yang valid hari ini
     *   $scanPulang   → AbsensiGerbang|null  — scan pulang pertama yang valid hari ini
     */
    public function statusHariIni()
    {
        $siswa = $this->getSiswa();

        // Ambil semua scan valid hari ini (bukan duplikat), eager load sesi
        $scanHariIni = AbsensiGerbang::with('sesiGerbang')
            ->where('siswa_id', $siswa->id)
            ->valid()                    // scope: status IN ('normal','manual','koreksi')
            ->hariIni()                 // scope: tanggal_scan = today
            ->orderBy('waktu_scan')
            ->get();

        // Scan masuk & pulang pertama yang valid hari ini
        $scanMasuk  = $scanHariIni->firstWhere('tipe', 'masuk');
        $scanPulang = $scanHariIni->firstWhere('tipe', 'pulang');

        return view('siswa.absensi-gerbang.status-hari-ini', compact(
            'siswa',
            'scanHariIni',
            'scanMasuk',
            'scanPulang',
        ));
    }

    // ── RIWAYAT ───────────────────────────────────────────────────────────────

    /**
     * GET /siswa/absensi-gerbang/riwayat
     *
     * Riwayat seluruh log scan gerbang milik siswa, dengan filter tanggal & tipe.
     * Menampilkan semua status (termasuk duplikat) agar transparan ke siswa,
     * namun bisa di-filter oleh query string.
     *
     * Query string:
     *   tanggal_dari   → YYYY-MM-DD  (opsional)
     *   tanggal_sampai → YYYY-MM-DD  (opsional)
     *   tipe           → masuk|pulang (opsional, default semua)
     *
     * View variables:
     *   $siswa            → Model Siswa
     *   $riwayat          → LengthAwarePaginator (AbsensiGerbang)
     *   $totalHariMasuk   → int — jumlah hari unik ada scan masuk valid
     *   $totalHariPulang  → int — jumlah hari unik ada scan pulang valid
     */
    public function riwayat(Request $request)
    {
        $siswa = $this->getSiswa();

        // ── Validasi input filter ───────────────────────────────────────────
        $request->validate([
            'tanggal_dari'   => ['nullable', 'date'],
            'tanggal_sampai' => ['nullable', 'date', 'after_or_equal:tanggal_dari'],
            'tipe'           => ['nullable', 'in:masuk,pulang'],
        ]);

        // ── Query dasar ─────────────────────────────────────────────────────
        $query = AbsensiGerbang::with('sesiGerbang')
            ->where('siswa_id', $siswa->id)
            ->orderBy('waktu_scan', 'desc');

        // Filter tanggal
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal_scan', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal_scan', '<=', $request->tanggal_sampai);
        }

        // Filter tipe masuk / pulang
        if ($request->filled('tipe') && in_array($request->tipe, ['masuk', 'pulang'])) {
            $query->where('tipe', $request->tipe);
        }

        // Paginate — preserve query string agar filter tidak hilang saat ganti halaman
        $riwayat = $query->paginate(20)->withQueryString();

        // ── Rekap total (dari seluruh data, tidak terpengaruh filter) ───────
        $rekapBase = AbsensiGerbang::where('siswa_id', $siswa->id)->valid();

        $totalHariMasuk = (clone $rekapBase)
            ->masuk()
            ->distinct('tanggal_scan')
            ->count('tanggal_scan');

        $totalHariPulang = (clone $rekapBase)
            ->pulang()
            ->distinct('tanggal_scan')
            ->count('tanggal_scan');

        return view('siswa.absensi-gerbang.riwayat', compact(
            'siswa',
            'riwayat',
            'totalHariMasuk',
            'totalHariPulang',
        ));
    }

    // ── SHOW / DETAIL ─────────────────────────────────────────────────────────

    /**
     * GET /siswa/absensi-gerbang/{absensiGerbang}
     *
     * Detail satu entri scan absensi gerbang.
     * Pastikan record milik siswa yang sedang login (authorization).
     *
     * View variables:
     *   $siswa           → Model Siswa
     *   $absensiGerbang  → Model AbsensiGerbang (dengan relasi dimuat)
     */
    public function show(AbsensiGerbang $absensiGerbang)
    {
        $siswa = $this->getSiswa();

        // Authorization: pastikan record milik siswa yang login
        abort_if(
            $absensiGerbang->siswa_id !== $siswa->id,
            403,
            'Anda tidak memiliki akses ke data ini.'
        );

        // Eager load relasi yang dipakai di view
        $absensiGerbang->loadMissing(['sesiGerbang', 'siswa.kelas', 'inputOleh', 'koreksiDari']);

        return view('siswa.absensi-gerbang.show', compact('siswa', 'absensiGerbang'));
    }
}