<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\KategoriPelanggaran;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelanggaranController extends Controller
{
    // ── Helper ────────────────────────────────────────────────────────────────

    /**
     * Ambil model Siswa yang terhubung ke user yang sedang login.
     * Abort 403 jika user tidak memiliki relasi siswa.
     */
    private function getSiswa(): Siswa
    {
        $siswa = Auth::user()?->siswa;
        abort_if(! $siswa, 403, 'Akun Anda tidak terhubung dengan data siswa.');
        return $siswa;
    }

    // ── INDEX ─────────────────────────────────────────────────────────────────

    /**
     * GET /siswa/pelanggaran
     *
     * Daftar catatan kedisiplinan milik siswa yang sedang login.
     * Read-only — siswa tidak bisa menambah, mengubah, atau menghapus.
     *
     * Filter: kategori, status, rentang tanggal.
     */
    public function index(Request $request)
    {
        $siswa = $this->getSiswa();

        // ── Validasi ringan input filter ──────────────────────────────────────
        $request->validate([
            'kategori_id'    => ['nullable', 'integer', 'exists:kategori_pelanggaran,id'],
            'status'         => ['nullable', 'string', 'in:' . implode(',', Pelanggaran::STATUSES)],
            'tanggal_dari'   => ['nullable', 'date'],
            'tanggal_sampai' => ['nullable', 'date', 'after_or_equal:tanggal_dari'],
        ]);

        // ── Query utama ───────────────────────────────────────────────────────
        $query = Pelanggaran::with(['kategori', 'dicatatOleh'])
            ->where('siswa_id', $siswa->id);

        if ($request->filled('kategori_id')) {
            $query->where('kategori_pelanggaran_id', $request->integer('kategori_id'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal', '>=', $request->input('tanggal_dari'));
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal', '<=', $request->input('tanggal_sampai'));
        }

        $pelanggaran = $query->orderByDesc('tanggal')
            ->orderByDesc('id')          // tiebreaker agar urutan stabil di pagination
            ->paginate(15)
            ->withQueryString();

        // ── Data pendukung ────────────────────────────────────────────────────

        // Hanya tampilkan kategori aktif pada filter
        $kategoriList = KategoriPelanggaran::aktif()->orderBy('nama')->get();

        // Status yang bisa dipilih siswa untuk filter (semua termasuk dibatalkan)
        $statusList = Pelanggaran::STATUSES;

        // Total poin aktif tahun ini (hanya status aktif)
        $totalPoin = Pelanggaran::where('siswa_id', $siswa->id)
            ->poinAktifTahun(now()->year)
            ->sum('poin');

        // Rekap per-status untuk summary card — pastikan semua key ada (default 0)
        $rekapRaw    = Pelanggaran::where('siswa_id', $siswa->id)
            ->selectRaw('status, count(*) as jumlah')
            ->groupBy('status')
            ->pluck('jumlah', 'status')
            ->toArray();

        // Isi default 0 untuk status yang belum ada agar view tidak perlu ?? setiap saat
        $rekapStatus = array_merge(
            array_fill_keys(Pelanggaran::STATUSES, 0),
            $rekapRaw,
        );

        $totalCatatan = array_sum($rekapStatus);

        return view('siswa.pelanggaran.index', compact(
            'pelanggaran',
            'kategoriList',
            'statusList',
            'totalPoin',
            'rekapStatus',
            'totalCatatan',
            'siswa',
        ));
    }

    // ── SHOW ──────────────────────────────────────────────────────────────────

    /**
     * GET /siswa/pelanggaran/{pelanggaran}
     *
     * Detail satu catatan pelanggaran milik siswa.
     * Abort 403 jika bukan milik siswa yang sedang login.
     */
    public function show(Pelanggaran $pelanggaran)
    {
        $siswa = $this->getSiswa();

        // Pastikan pelanggaran ini benar-benar milik siswa yang login
        abort_if($pelanggaran->siswa_id !== $siswa->id, 403, 'Ini bukan data kedisiplinan Anda.');

        // Eager load hanya relasi yang benar-benar dipakai di view
        $pelanggaran->load(['kategori', 'dicatatOleh']);

        // Total poin aktif siswa tahun ini
        $totalPoinSiswa = Pelanggaran::where('siswa_id', $siswa->id)
            ->poinAktifTahun(now()->year)
            ->sum('poin');

        return view('siswa.pelanggaran.show', compact('pelanggaran', 'totalPoinSiswa'));
    }
}