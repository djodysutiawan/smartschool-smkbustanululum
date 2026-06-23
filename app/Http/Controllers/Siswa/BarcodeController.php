<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\BarcodeGerbang;
use App\Models\SesiQr;
use App\Models\SesiGerbang;
use App\Models\JadwalPelajaran;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

/**
 * BarcodeController (Siswa)
 *
 * LOGIKA:
 * ─────────────────────────────────────────────────────────────
 * Setiap siswa memiliki 2 barcode:
 *
 * 1. BARCODE GERBANG (model: BarcodeGerbang)
 *    - 1 barcode per siswa, berlaku jangka panjang (1–3 tahun)
 *    - Dipakai BERULANG untuk masuk DAN pulang (tidak sekali pakai)
 *    - Sistem membedakan tipe (masuk/pulang) dari SesiGerbang yang aktif saat scan
 *    - Dibuat & dikelola admin — siswa hanya menampilkan & menyimpannya
 *
 * 2. BARCODE MAPEL (kolom `barcode_mapel` di tabel siswa, atau model terpisah)
 *    - 1 barcode per siswa, dipakai saat guru/admin membuka sesi QR per mata pelajaran
 *    - Di-scan alat IoT di kelas ketika pelajaran dimulai
 *    - Bisa berupa kode unik permanen (NIS, UUID, dsb.)
 *
 * Alur di halaman siswa:
 *   index()           → tampilkan kedua barcode + info sesi aktif
 *   gerbang()         → tampilan fullscreen barcode gerbang
 *   mapel()           → tampilan fullscreen barcode mapel
 *   downloadGerbang() → download kode barcode gerbang (.txt)
 *   downloadMapel()   → download kode barcode mapel (.txt)
 * ─────────────────────────────────────────────────────────────
 */
class BarcodeController extends Controller
{
    // ── Helpers ───────────────────────────────────────────────────────────────
    
    private function getSiswa(): \App\Models\Siswa
    {
        $siswa = Auth::user()->siswa;
        abort_if(! $siswa, 403, 'Akun Anda tidak terhubung dengan data siswa.');
        return $siswa;
    }

    /**
     * Barcode gerbang aktif milik siswa.
     *
     * Berlaku jangka panjang — tidak pakai berlakuHariIni(),
     * cukup cek is_active & tanggal_kadaluarsa >= hari ini.
     */
    private function getBarcodeGerbang(\App\Models\Siswa $siswa): ?BarcodeGerbang
    {
        return BarcodeGerbang::where('siswa_id', $siswa->id)
            ->aktif()           // is_aktif = true
            ->berlakuHariIni()  // handle NULL berlaku_sampai dengan benar
            ->latest()
            ->first();
    }

    /**
     * Kode barcode mapel milik siswa.
     *
     * Sesuaikan dengan struktur tabel Anda:
     *   - Opsi A (default): kolom `barcode_mapel` langsung di tabel siswa
     *   - Opsi B: model/tabel BarcodeMapel terpisah (uncomment blok di bawah)
     */
    private function getKodeBarcodeMapel(\App\Models\Siswa $siswa): ?string
    {
        // Opsi A — paling sederhana, kolom di tabel siswa:
        return $siswa->barcode_mapel ?? null;

        // Opsi B — jika ada tabel BarcodeMapel terpisah:
        // return \App\Models\BarcodeMapel::where('siswa_id', $siswa->id)
        //     ->where('is_active', true)
        //     ->value('kode');
    }

    /**
     * Sesi gerbang yang sedang aktif saat ini.
     * Dipakai untuk menampilkan info tipe (masuk/pulang) di halaman barcode
     * agar siswa tahu sedang jam masuk atau jam pulang.
     */
    private function getSesiGerbangAktif(): ?SesiGerbang
    {
        return SesiGerbang::sesiAktifSekarang();
    }

    /**
     * Sesi QR mapel yang sedang aktif untuk kelas siswa.
     * Dipakai untuk menampilkan info mapel apa yang sedang dibuka absensinya.
     */
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

    // ── INDEX ─────────────────────────────────────────────────────────────────

    /**
     * GET /siswa/barcode
     *
     * Halaman utama barcode siswa.
     * Menampilkan kedua barcode sekaligus:
     *   - Barcode Gerbang : untuk scan masuk & pulang sekolah
     *   - Barcode Mapel   : untuk scan absensi per mata pelajaran di kelas
     *
     * Juga menampilkan:
     *   - Info sesi gerbang aktif (masuk/pulang) agar siswa tahu sedang jam apa
     *   - Info sesi QR mapel aktif jika guru sudah membuka absensi pelajaran
     *   - Jadwal pelajaran hari ini sebagai konteks
     */
    public function index()
    {
        $siswa = $this->getSiswa();

        // Debug — hapus setelah selesai


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
            ->get();

        return view('siswa.barcode.index', compact(
            'siswa',
            'barcodeGerbang',
            'kodeBarcodeMapel',
            'sesiGerbangAktif',
            'sesiQrAktif',
            'jadwalHariIni',
        ));
    }

    // ── BARCODE GERBANG (FULLSCREEN) ──────────────────────────────────────────

    /**
     * GET /siswa/barcode/gerbang
     *
     * Tampilan fullscreen barcode gerbang.
     * Siswa menunjukkan layar ini ke alat scanner di gerbang sekolah.
     *
     * Barcode yang SAMA dipakai untuk masuk & pulang —
     * sistem / alat IoT membedakan tipe dari sesi gerbang yang sedang aktif.
     *
     * Menampilkan badge info sesi aktif (masuk/pulang) agar siswa tidak bingung.
     */
    public function gerbang()
    {
        $siswa = $this->getSiswa();
        $barcodeGerbang = $this->getBarcodeGerbang($siswa);

        if (! $barcodeGerbang) {
            return redirect()->route('siswa.barcode.index')
                ->with('warning', 'Anda belum memiliki barcode gerbang aktif. Hubungi admin sekolah.');
        }

        $sesiGerbangAktif = $this->getSesiGerbangAktif();

        return view('siswa.barcode.gerbang', compact(
            'siswa',
            'barcodeGerbang',
            'sesiGerbangAktif',
        ));
    }

    // ── BARCODE MAPEL (FULLSCREEN) ────────────────────────────────────────────

    /**
     * GET /siswa/barcode/mapel
     *
     * Tampilan fullscreen barcode mapel.
     * Siswa maju ke depan kelas dan alat IoT men-scan barcode ini
     * saat guru/admin membuka sesi absensi per mata pelajaran.
     *
     * Menampilkan info sesi QR mapel yang sedang aktif agar siswa tahu
     * mapel apa yang sedang dibuka absensinya.
     */
    public function mapel()
    {
        $siswa = $this->getSiswa();
        $kodeBarcodeMapel = $this->getKodeBarcodeMapel($siswa);

        if (! $kodeBarcodeMapel) {
            return redirect()->route('siswa.barcode.index')
                ->with('warning', 'Anda belum memiliki barcode mapel. Hubungi admin sekolah.');
        }

        $sesiQrAktif = $this->getSesiQrAktif($siswa);

        return view('siswa.barcode.mapel', compact(
            'siswa',
            'kodeBarcodeMapel',
            'sesiQrAktif',
        ));
    }

    // ── DOWNLOAD BARCODE GERBANG ──────────────────────────────────────────────

    /**
     * GET /siswa/barcode/gerbang/download
     *
     * Download kode barcode gerbang sebagai file .txt (kode mentah).
     * Untuk keperluan cetak fisik kartu siswa / ID card.
     *
     * Catatan: gambar barcode di-render di browser menggunakan JsBarcode.
     * Untuk download gambar PNG, gunakan canvas.toDataURL() dari sisi client JS
     * — tidak perlu endpoint server tambahan.
     */
    public function downloadGerbang()
    {
        $siswa = $this->getSiswa();
        $barcodeGerbang = $this->getBarcodeGerbang($siswa);

        if (! $barcodeGerbang) {
            return redirect()->route('siswa.barcode.index')
                ->with('warning', 'Anda belum memiliki barcode gerbang aktif.');
        }

        $nama     = str_replace(' ', '_', $siswa->nama_lengkap);
        $filename = "barcode_gerbang_{$nama}_{$barcodeGerbang->kode}.txt";

        return Response::make($barcodeGerbang->kode, 200, [
            'Content-Type'        => 'text/plain',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    // ── DOWNLOAD BARCODE MAPEL ────────────────────────────────────────────────

    /**
     * GET /siswa/barcode/mapel/download
     *
     * Download kode barcode mapel sebagai file .txt (kode mentah).
     */
    public function downloadMapel()
    {
        $siswa = $this->getSiswa();
        $kodeBarcodeMapel = $this->getKodeBarcodeMapel($siswa);

        if (! $kodeBarcodeMapel) {
            return redirect()->route('siswa.barcode.index')
                ->with('warning', 'Anda belum memiliki barcode mapel.');
        }

        $nama     = str_replace(' ', '_', $siswa->nama_lengkap);
        $filename = "barcode_mapel_{$nama}.txt";

        return Response::make($kodeBarcodeMapel, 200, [
            'Content-Type'        => 'text/plain',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
}