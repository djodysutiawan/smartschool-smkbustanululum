<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BarcodeGerbang;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BarcodeGerbangController extends Controller
{
    // ── INDEX ─────────────────────────────────────────────────────────────────

    /**
     * Daftar semua barcode gerbang.
     * Filter: kelas, status aktif, search.
     */
    public function index(Request $request): View
    {
        $query = BarcodeGerbang::with(['siswa.kelas'])
            ->withTrashed();

        if ($request->filled('kelas_id')) {
            $query->whereHas('siswa', fn ($q) =>
                $q->where('kelas_id', $request->kelas_id)
            );
        }

        if ($request->filled('is_aktif')) {
            $query->where('is_aktif', $request->boolean('is_aktif'));
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode', 'like', "%{$search}%")
                  ->orWhereHas('siswa', fn ($sq) =>
                      $sq->where('nama_lengkap', 'like', "%{$search}%")
                         ->orWhere('nis', 'like', "%{$search}%")
                  );
            });
        }

        $barcodeList = $query->latest()->paginate(20)->withQueryString();
        $kelasList   = Kelas::aktif()->orderBy('nama_kelas')->get();

        // Stats dihitung dari seluruh data, bukan dari hasil paginasi
        $stats = [
            'total'    => BarcodeGerbang::withTrashed()->count(),
            'aktif'    => BarcodeGerbang::where('is_aktif', true)->count(),
            'nonaktif' => BarcodeGerbang::where('is_aktif', false)->count(),
            'hari_ini' => BarcodeGerbang::masihBerlaku()->count(),
        ];

        return view('admin.barcode-gerbang.index', compact('barcodeList', 'kelasList', 'stats'));
    }

    // ── CREATE ────────────────────────────────────────────────────────────────

    public function create(Request $request): View
    {
        $kelasList = Kelas::aktif()->orderBy('nama_kelas')->get();

        $siswa = $request->filled('siswa_id')
            ? Siswa::findOrFail($request->siswa_id)
            : null;

        return view('admin.barcode-gerbang.create', compact('kelasList', 'siswa'));
    }

    // ── STORE ─────────────────────────────────────────────────────────────────

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'siswa_id'       => ['required', 'exists:siswa,id'],
            'berlaku_mulai'  => ['required', 'date'],
            'berlaku_sampai' => ['nullable', 'date', 'after_or_equal:berlaku_mulai'],
            'keterangan'     => ['nullable', 'string', 'max:255'],
        ]);

        $siswa   = Siswa::findOrFail($request->siswa_id);
        $barcode = BarcodeGerbang::buatUntukSiswa($siswa, [
            'berlaku_mulai'  => $request->berlaku_mulai,
            'berlaku_sampai' => $request->berlaku_sampai,
            'keterangan'     => $request->keterangan,
        ]);

        if ($request->boolean('langsung_cetak')) {
            return redirect()->route('admin.barcode-gerbang.print-satu', $barcode)
                ->with('success', "Barcode untuk {$siswa->nama_lengkap} berhasil dibuat.");
        }

        return redirect()->route('admin.barcode-gerbang.index')
            ->with('success', "Barcode gerbang untuk {$siswa->nama_lengkap} berhasil dibuat.");
    }

    // ── GENERATE MASSAL ───────────────────────────────────────────────────────

    /**
     * Generate barcode untuk semua siswa aktif sekaligus (per kelas opsional).
     *
     * BUG FIX #2: generateMassal() sebelumnya tidak menggunakan DB::transaction(),
     * sehingga bila terjadi error di tengah loop (misal unique constraint race condition),
     * sebagian siswa sudah tergenerate dan sebagian belum — data inkonsisten tanpa
     * pesan error yang jelas. Dibungkus transaction agar atomik.
     */
    public function generateMassal(Request $request): RedirectResponse
    {
        $request->validate([
            'kelas_id'       => ['nullable', 'exists:kelas,id'],
            'berlaku_mulai'  => ['required', 'date'],
            'berlaku_sampai' => ['nullable', 'date', 'after_or_equal:berlaku_mulai'],
            'overwrite'      => ['nullable', 'boolean'],
            'langsung_cetak' => ['nullable', 'boolean'],
        ]);

        $query = Siswa::where('status', 'aktif');

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        $siswaList = $query->get();
        $dibuat    = 0;
        $dilewati  = 0;

        DB::transaction(function () use ($siswaList, $request, &$dibuat, &$dilewati) {
            foreach ($siswaList as $siswa) {
                $sudahAda = BarcodeGerbang::where('siswa_id', $siswa->id)
                    ->aktif()
                    ->berlakuHariIni()
                    ->exists();

                if ($sudahAda && ! $request->boolean('overwrite')) {
                    $dilewati++;
                    continue;
                }

                BarcodeGerbang::buatUntukSiswa($siswa, [
                    'berlaku_mulai'  => $request->berlaku_mulai,
                    'berlaku_sampai' => $request->berlaku_sampai,
                ]);

                $dibuat++;
            }
        });

        $msg = "Selesai. {$dibuat} barcode dibuat, {$dilewati} siswa dilewati (sudah punya barcode aktif).";

        if ($request->filled('kelas_id') && $request->boolean('langsung_cetak')) {
            return redirect()
                ->route('admin.barcode-gerbang.print-kelas', $request->kelas_id)
                ->with('success', $msg);
        }

        return redirect()
            ->route('admin.barcode-gerbang.index')
            ->with('success', $msg);
    }

    // ── SHOW ──────────────────────────────────────────────────────────────────

    public function show(BarcodeGerbang $barcodeGerbang): View
    {
        $barcodeGerbang->load(['siswa.kelas', 'absensiGerbang' => function ($q) {
            $q->latest('waktu_scan')->limit(50);
        }]);

        $riwayatBarcode = BarcodeGerbang::withTrashed()
            ->where('siswa_id', $barcodeGerbang->siswa_id)
            ->latest()
            ->get();

        return view('admin.barcode-gerbang.show', compact('barcodeGerbang', 'riwayatBarcode'));
    }

    // ── PRINT KELAS ───────────────────────────────────────────────────────────

    /**
     * Tampilkan halaman print semua barcode aktif dalam satu kelas.
     *
     * BUG FIX #1 (root cause error): orderByHas() BUKAN method bawaan Eloquent
     * dan tidak terdaftar di Builder manapun — method ini tidak ada, sehingga
     * muncul "Call to undefined method ...::orderByHas()".
     *
     * Solusi: gunakan join ke tabel siswa untuk bisa ORDER BY nama_lengkap
     * langsung di level SQL, tanpa package tambahan.
     * Alternatif lain yang juga valid (lebih sederhana tapi sorting di PHP):
     *   ->get()->sortBy('siswa.nama_lengkap')
     * Namun join lebih efisien untuk data besar karena sorting dilakukan DB.
     */
    public function printKelas(Kelas $kelas): View
    {
        $barcodes = BarcodeGerbang::with('siswa')
            ->join('siswa', 'siswa.id', '=', 'barcode_gerbang.siswa_id')
            ->where('siswa.kelas_id', $kelas->id)
            ->masihBerlaku()
            ->orderBy('siswa.nama_lengkap')
            ->select('barcode_gerbang.*')   // hindari kolom ambigu (id, created_at, dll.)
            ->get();

        return view('admin.barcode-gerbang.print-kelas', compact('barcodes', 'kelas'));
    }

    // ── PRINT SATU ────────────────────────────────────────────────────────────

    /**
     * Tampilkan halaman print satu barcode siswa.
     */
    public function printSatu(BarcodeGerbang $barcodeGerbang): View
    {
        $barcodeGerbang->load('siswa.kelas');

        return view('admin.barcode-gerbang.print-satu', compact('barcodeGerbang'));
    }

    // ── NONAKTIFKAN ───────────────────────────────────────────────────────────

    public function nonaktifkan(BarcodeGerbang $barcodeGerbang): RedirectResponse
    {
        if (! $barcodeGerbang->is_aktif) {
            return back()->with('error', 'Barcode ini sudah nonaktif.');
        }

        $barcodeGerbang->update(['is_aktif' => false]);

        return back()->with('success', 'Barcode berhasil dinonaktifkan.');
    }

    // ── DESTROY ───────────────────────────────────────────────────────────────

    /**
     * Soft-delete. Hanya boleh jika belum pernah digunakan untuk scan.
     *
     * BUG FIX #3: route redirect setelah destroy mengirim $barcodeGerbang
     * yang sudah soft-deleted sebagai route parameter. Pada beberapa versi
     * Laravel, model binding akan gagal resolve model yang sudah deleted
     * (tergantung apakah route model binding pakai withTrashed atau tidak).
     * Aman-nya: redirect ke index tanpa membawa model.
     */
    public function destroy(BarcodeGerbang $barcodeGerbang): RedirectResponse
    {
        if ($barcodeGerbang->absensiGerbang()->exists()) {
            return back()->with('error',
                'Barcode tidak bisa dihapus karena sudah memiliki riwayat scan. Nonaktifkan saja.'
            );
        }

        $barcodeGerbang->delete();

        return redirect()
            ->route('admin.barcode-gerbang.index')
            ->with('success', 'Barcode berhasil dihapus.');
    }
}