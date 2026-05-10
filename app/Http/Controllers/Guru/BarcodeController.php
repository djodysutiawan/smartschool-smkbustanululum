<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\BarcodeGerbang;
use App\Models\SesiGerbang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * BarcodeController (Guru)
 *
 * LOGIKA:
 * ─────────────────────────────────────────────────────────────
 * Guru hanya memiliki 1 jenis barcode:
 *
 * BARCODE GERBANG (model: BarcodeGerbang, kolom: guru_id)
 *   - 1 barcode per guru, berlaku jangka panjang
 *   - Dipakai BERULANG untuk scan masuk DAN pulang gerbang sekolah
 *   - Dibuat & dikelola admin — guru hanya menampilkan & menyimpannya
 *   - Data diambil dari tabel barcode_gerbang yang sama dengan admin,
 *     difilter berdasarkan guru_id milik guru yang sedang login
 *
 * Alur:
 *   index()           → halaman utama barcode guru + info sesi gerbang aktif
 *   gerbang()         → tampilan fullscreen barcode gerbang
 *   download()        → download kode barcode gerbang (.txt)
 * ─────────────────────────────────────────────────────────────
 */
class BarcodeController extends Controller
{
    // ── Helpers ───────────────────────────────────────────────────────────────

    /**
     * Ambil data guru dari user yang sedang login.
     */
    private function getGuru(): \App\Models\Guru
    {
        $guru = Auth::user()->guru;
        abort_if(! $guru, 403, 'Akun Anda tidak terhubung dengan data guru.');
        return $guru;
    }

    /**
     * Barcode gerbang aktif milik guru.
     * Filter: guru_id, is_aktif = true, masa berlaku mencakup hari ini.
     */
    private function getBarcodeGerbang(\App\Models\Guru $guru): ?BarcodeGerbang
    {
        return BarcodeGerbang::where('guru_id', $guru->id)
            ->aktif()            // is_aktif = true
            ->berlakuHariIni()   // handle NULL berlaku_sampai dengan benar
            ->latest()
            ->first();
    }

    /**
     * Sesi gerbang yang sedang aktif saat ini.
     * Dipakai untuk menampilkan info tipe (masuk/pulang) di halaman barcode
     * agar guru tahu sedang jam masuk atau jam pulang.
     */
    private function getSesiGerbangAktif(): ?SesiGerbang
    {
        return SesiGerbang::sesiAktifSekarang();
    }

    // ── INDEX ─────────────────────────────────────────────────────────────────

    /**
     * GET /guru/barcode
     *
     * Halaman utama barcode guru.
     * Menampilkan:
     *   - Barcode gerbang aktif milik guru
     *   - Info sesi gerbang aktif (masuk/pulang) agar guru tahu sedang jam apa
     *   - Info masa berlaku barcode
     *   - Status barcode (aktif / belum punya / kadaluarsa)
     */
    public function index(): View
    {
        $guru             = $this->getGuru();
        $barcodeGerbang   = $this->getBarcodeGerbang($guru);
        $sesiGerbangAktif = $this->getSesiGerbangAktif();

        // Riwayat barcode milik guru ini (aktif maupun nonaktif)
        $riwayatBarcode = BarcodeGerbang::where('guru_id', $guru->id)
            ->withTrashed()
            ->latest()
            ->get();

        return view('guru.barcode.index', compact(
            'guru',
            'barcodeGerbang',
            'sesiGerbangAktif',
            'riwayatBarcode',
        ));
    }

    // ── BARCODE GERBANG (FULLSCREEN) ──────────────────────────────────────────

    /**
     * GET /guru/barcode/gerbang
     *
     * Tampilan fullscreen barcode gerbang.
     * Guru menunjukkan layar ini ke alat scanner di gerbang sekolah.
     *
     * Barcode yang SAMA dipakai untuk masuk & pulang —
     * sistem / alat IoT membedakan tipe dari sesi gerbang yang sedang aktif.
     *
     * Menampilkan badge info sesi aktif (masuk/pulang) agar guru tidak bingung.
     */
    public function gerbang(): View|RedirectResponse
    {
        $guru           = $this->getGuru();
        $barcodeGerbang = $this->getBarcodeGerbang($guru);

        if (! $barcodeGerbang) {
            return redirect()->route('guru.barcode.index')
                ->with('warning', 'Anda belum memiliki barcode gerbang aktif. Hubungi admin sekolah.');
        }

        $sesiGerbangAktif = $this->getSesiGerbangAktif();

        return view('guru.barcode.gerbang', compact(
            'guru',
            'barcodeGerbang',
            'sesiGerbangAktif',
        ));
    }

    // ── DOWNLOAD BARCODE GERBANG ──────────────────────────────────────────────

    /**
     * GET /guru/barcode/download
     *
     * Download kode barcode gerbang sebagai file .txt (kode mentah).
     * Untuk keperluan cetak fisik kartu guru / ID card.
     *
     * Catatan: gambar barcode di-render di browser menggunakan JsBarcode.
     * Untuk download gambar PNG, gunakan canvas.toDataURL() dari sisi client JS
     * — tidak perlu endpoint server tambahan.
     */
    public function download(): RedirectResponse|\Illuminate\Http\Response
    {
        $guru           = $this->getGuru();
        $barcodeGerbang = $this->getBarcodeGerbang($guru);

        if (! $barcodeGerbang) {
            return redirect()->route('guru.barcode.index')
                ->with('warning', 'Anda belum memiliki barcode gerbang aktif.');
        }

        $nama     = str_replace(' ', '_', $guru->nama_lengkap);
        $filename = "barcode_gerbang_{$nama}_{$barcodeGerbang->kode}.txt";

        return Response::make($barcodeGerbang->kode, 200, [
            'Content-Type'        => 'text/plain',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
}