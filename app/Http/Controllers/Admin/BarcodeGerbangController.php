<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BarcodeGerbang;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BarcodeGerbangController extends Controller
{
    // ── INDEX ─────────────────────────────────────────────────────────────────

    /**
     * Daftar semua barcode gerbang (siswa + guru).
     * Filter: kelas (siswa), tipe_pemilik, status aktif, search.
     */
    public function index(Request $request): View
    {
        $query = BarcodeGerbang::with(['siswa.kelas', 'guru'])
            ->withTrashed();

        // Filter tipe pemilik
        if ($request->filled('tipe_pemilik')) {
            if ($request->tipe_pemilik === 'siswa') {
                $query->untukSiswa();
            } elseif ($request->tipe_pemilik === 'guru') {
                $query->untukGuru();
            }
        }

        // Filter kelas (hanya berlaku untuk siswa)
        if ($request->filled('kelas_id')) {
            $query->whereHas('siswa', fn ($q) =>
                $q->where('kelas_id', $request->kelas_id)
            );
        }

        // Filter status aktif
        if ($request->filled('is_aktif')) {
            $query->where('is_aktif', $request->boolean('is_aktif'));
        }

        // Pencarian: kode, nama siswa/guru, NIS, NIP
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode', 'like', "%{$search}%")
                  ->orWhereHas('siswa', fn ($sq) =>
                      $sq->where('nama_lengkap', 'like', "%{$search}%")
                         ->orWhere('nis', 'like', "%{$search}%")
                  )
                  ->orWhereHas('guru', fn ($sq) =>
                      $sq->where('nama_lengkap', 'like', "%{$search}%")
                         ->orWhere('nip', 'like', "%{$search}%")
                  );
            });
        }

        $barcodeList = $query->latest()->paginate(20)->withQueryString();
        $kelasList   = Kelas::aktif()->orderBy('nama_kelas')->get();

        // Stats dari seluruh data (bukan dari hasil paginasi/filter)
        $stats = [
            'total'         => BarcodeGerbang::withTrashed()->count(),
            'aktif'         => BarcodeGerbang::where('is_aktif', true)->count(),
            'nonaktif'      => BarcodeGerbang::where('is_aktif', false)->count(),
            'hari_ini'      => BarcodeGerbang::masihBerlaku()->count(),
            'total_siswa'   => BarcodeGerbang::withTrashed()->untukSiswa()->count(),
            'total_guru'    => BarcodeGerbang::withTrashed()->untukGuru()->count(),
        ];

        return view('admin.barcode-gerbang.index', compact('barcodeList', 'kelasList', 'stats'));
    }

    // ── CREATE ────────────────────────────────────────────────────────────────

    /**
     * Form buat barcode baru.
     * Query param: siswa_id atau guru_id untuk pre-select pemilik.
     */
    public function create(Request $request): View
    {
        $kelasList = Kelas::aktif()->orderBy('nama_kelas')->get();

        $siswa = $request->filled('siswa_id')
            ? Siswa::findOrFail($request->siswa_id)
            : null;

        $guru = $request->filled('guru_id')
            ? Guru::findOrFail($request->guru_id)
            : null;

        return view('admin.barcode-gerbang.create', compact('kelasList', 'siswa', 'guru'));
    }

    // ── STORE ─────────────────────────────────────────────────────────────────

    /**
     * Simpan barcode baru (siswa ATAU guru).
     * Validasi: tepat salah satu dari siswa_id / guru_id harus terisi.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'tipe_pemilik'   => ['required', 'in:siswa,guru'],
            'siswa_id'       => ['required_if:tipe_pemilik,siswa', 'nullable', 'exists:siswa,id'],
            'guru_id'        => ['required_if:tipe_pemilik,guru',  'nullable', 'exists:guru,id'],
            'berlaku_mulai'  => ['required', 'date'],
            'berlaku_sampai' => ['nullable', 'date', 'after_or_equal:berlaku_mulai'],
            'keterangan'     => ['nullable', 'string', 'max:255'],
        ]);

        $data = [
            'berlaku_mulai'  => $request->berlaku_mulai,
            'berlaku_sampai' => $request->berlaku_sampai,
            'keterangan'     => $request->keterangan,
        ];

        if ($request->tipe_pemilik === 'siswa') {
            $pemilik = Siswa::findOrFail($request->siswa_id);
            $barcode = BarcodeGerbang::buatUntukSiswa($pemilik, $data);
            $namaPemilik = $pemilik->nama_lengkap;
        } else {
            $pemilik = Guru::findOrFail($request->guru_id);
            $barcode = BarcodeGerbang::buatUntukGuru($pemilik, $data);
            $namaPemilik = $pemilik->nama_lengkap;
        }

        if ($request->boolean('langsung_cetak')) {
            return redirect()->route('admin.barcode-gerbang.print-satu', $barcode)
                ->with('success', "Barcode untuk {$namaPemilik} berhasil dibuat.");
        }

        return redirect()->route('admin.barcode-gerbang.index')
            ->with('success', "Barcode gerbang untuk {$namaPemilik} berhasil dibuat.");
    }

    // ── GENERATE MASSAL SISWA ─────────────────────────────────────────────────

    /**
     * Generate barcode untuk semua siswa aktif sekaligus (per kelas opsional).
     * Dibungkus transaction agar atomik.
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

        $msg = "Selesai. {$dibuat} barcode siswa dibuat, {$dilewati} dilewati (sudah punya barcode aktif).";

        if ($request->filled('kelas_id') && $request->boolean('langsung_cetak')) {
            return redirect()
                ->route('admin.barcode-gerbang.print-kelas', $request->kelas_id)
                ->with('success', $msg);
        }

        return redirect()->route('admin.barcode-gerbang.index')->with('success', $msg);
    }

    // ── GENERATE MASSAL GURU ──────────────────────────────────────────────────

    /**
     * Generate barcode untuk semua guru aktif sekaligus.
     * Dibungkus transaction agar atomik.
     */
    public function generateMassalGuru(Request $request): RedirectResponse
    {
        $request->validate([
            'berlaku_mulai'  => ['required', 'date'],
            'berlaku_sampai' => ['nullable', 'date', 'after_or_equal:berlaku_mulai'],
            'overwrite'      => ['nullable', 'boolean'],
        ]);

        $guruList = Guru::where('status', 'aktif')->get();
        $dibuat   = 0;
        $dilewati = 0;

        DB::transaction(function () use ($guruList, $request, &$dibuat, &$dilewati) {
            foreach ($guruList as $guru) {
                $sudahAda = BarcodeGerbang::where('guru_id', $guru->id)
                    ->aktif()
                    ->berlakuHariIni()
                    ->exists();

                if ($sudahAda && ! $request->boolean('overwrite')) {
                    $dilewati++;
                    continue;
                }

                BarcodeGerbang::buatUntukGuru($guru, [
                    'berlaku_mulai'  => $request->berlaku_mulai,
                    'berlaku_sampai' => $request->berlaku_sampai,
                ]);

                $dibuat++;
            }
        });

        $msg = "Selesai. {$dibuat} barcode guru dibuat, {$dilewati} dilewati (sudah punya barcode aktif).";

        return redirect()->route('admin.barcode-gerbang.index')->with('success', $msg);
    }

    // ── SHOW ──────────────────────────────────────────────────────────────────

    public function show(BarcodeGerbang $barcodeGerbang): View
    {
        $barcodeGerbang->load(['siswa.kelas', 'guru', 'absensiGerbang' => function ($q) {
            $q->latest('waktu_scan')->limit(50);
        }]);

        // Riwayat barcode milik pemilik yang sama
        if ($barcodeGerbang->tipe_pemilik === 'guru') {
            $riwayatBarcode = BarcodeGerbang::withTrashed()
                ->where('guru_id', $barcodeGerbang->guru_id)
                ->latest()
                ->get();
        } else {
            $riwayatBarcode = BarcodeGerbang::withTrashed()
                ->where('siswa_id', $barcodeGerbang->siswa_id)
                ->latest()
                ->get();
        }

        return view('admin.barcode-gerbang.show', compact('barcodeGerbang', 'riwayatBarcode'));
    }

    // ── PRINT KELAS (siswa) ───────────────────────────────────────────────────

    /**
     * Tampilkan halaman print semua barcode aktif siswa dalam satu kelas.
     */
    public function printKelas(Kelas $kelas): View
    {
        $barcodes = BarcodeGerbang::with('siswa')
            ->join('siswa', 'siswa.id', '=', 'barcode_gerbang.siswa_id')
            ->where('siswa.kelas_id', $kelas->id)
            ->masihBerlaku()
            ->orderBy('siswa.nama_lengkap')
            ->select('barcode_gerbang.*')
            ->get();

        return view('admin.barcode-gerbang.print-kelas', compact('barcodes', 'kelas'));
    }

    // ── PRINT SEMUA GURU ──────────────────────────────────────────────────────

    /**
     * Tampilkan halaman print semua barcode aktif guru.
     */
    public function printGuru(): View
    {
        $barcodes = BarcodeGerbang::with('guru')
            ->join('guru', 'guru.id', '=', 'barcode_gerbang.guru_id')
            ->whereNotNull('barcode_gerbang.guru_id')
            ->masihBerlaku()
            ->orderBy('guru.nama_lengkap')
            ->select('barcode_gerbang.*')
            ->get();

        return view('admin.barcode-gerbang.print-guru', compact('barcodes'));
    }

    // ── PRINT SATU ────────────────────────────────────────────────────────────

    /**
     * Tampilkan halaman print satu barcode (siswa atau guru).
     */
    public function printSatu(BarcodeGerbang $barcodeGerbang): View
    {
        $barcodeGerbang->load(['siswa.kelas', 'guru']);

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

    // ── SEARCH GURU (AJAX) ────────────────────────────────────────────────────

    /**
     * Endpoint pencarian guru untuk typeahead di form create.
     * GET /admin/barcode-gerbang/search-guru?q=...&per_page=8
     */
    public function searchGuru(Request $request)
    {
        $q       = $request->input('q', '');
        $perPage = (int) $request->input('per_page', 8);

        $guru = Guru::where('status', 'aktif')
            ->where(function ($query) use ($q) {
                $query->where('nama_lengkap', 'like', "%{$q}%")
                      ->orWhere('nip', 'like', "%{$q}%");
            })
            ->orderBy('nama_lengkap')
            ->limit($perPage)
            ->get(['id', 'nama_lengkap', 'nip', 'status_kepegawaian']);

        return response()->json($guru);
    }
}