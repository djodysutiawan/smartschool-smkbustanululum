<?php

namespace App\Http\Controllers\Api\Siswa;

use App\Http\Controllers\Controller;
use App\Models\KategoriPelanggaran;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelanggaranController extends Controller
{
    // ── Helper ─────────────────────────────────────────────────────────────────

    private function getSiswa(): Siswa
    {
        $siswa = Auth::user()?->siswa;
        abort_if(! $siswa, 403, 'Akun Anda tidak terhubung dengan data siswa.');
        return $siswa;
    }

    private function formatPelanggaran(Pelanggaran $p): array
    {
        return [
            'id'      => $p->id,
            'tanggal' => $p->tanggal?->format('Y-m-d'),
            'uraian'  => $p->uraian,
            'poin'    => $p->poin,
            'status'  => $p->status,
            'catatan' => $p->catatan ?? null,
            'kategori' => $p->relationLoaded('kategori') && $p->kategori ? [
                'id'   => $p->kategori->id,
                'nama' => $p->kategori->nama,
            ] : null,
            'dicatat_oleh' => $p->relationLoaded('dicatatOleh') && $p->dicatatOleh ? [
                'id'           => $p->dicatatOleh->id,
                'nama_lengkap' => $p->dicatatOleh->nama_lengkap,
            ] : null,
            'created_at' => $p->created_at?->toIso8601String(),
        ];
    }

    // ── Index ──────────────────────────────────────────────────────────────────

    /**
     * GET /api/siswa/pelanggaran
     * Daftar catatan kedisiplinan milik siswa (read-only).
     *
     * Query params:
     *   - kategori_id    (int)    : filter kategori
     *   - status         (string) : filter status (whitelist Pelanggaran::STATUSES)
     *   - tanggal_dari   (date)   : Y-m-d
     *   - tanggal_sampai (date)   : Y-m-d, harus >= tanggal_dari
     *   - per_page       (int)    : default 15, max 50
     */
    public function index(Request $request): JsonResponse
    {
        $siswa = $this->getSiswa();

        $request->validate([
            'kategori_id'    => ['nullable', 'integer', 'exists:kategori_pelanggaran,id'],
            'status'         => ['nullable', 'string', 'in:' . implode(',', Pelanggaran::STATUSES)],
            'tanggal_dari'   => ['nullable', 'date'],
            'tanggal_sampai' => ['nullable', 'date', 'after_or_equal:tanggal_dari'],
        ]);

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

        $perPage     = min((int) ($request->per_page ?? 15), 50);
        $pelanggaran = $query
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->paginate($perPage)
            ->withQueryString();

        // Data pendukung
        $kategoriList = KategoriPelanggaran::aktif()->orderBy('nama')->get(['id', 'nama']);

        $totalPoin = Pelanggaran::where('siswa_id', $siswa->id)
            ->poinAktifTahun(now()->year)
            ->sum('poin');

        $rekapRaw = Pelanggaran::where('siswa_id', $siswa->id)
            ->selectRaw('status, count(*) as jumlah')
            ->groupBy('status')
            ->pluck('jumlah', 'status')
            ->toArray();

        $rekapStatus  = array_merge(array_fill_keys(Pelanggaran::STATUSES, 0), $rekapRaw);
        $totalCatatan = array_sum($rekapStatus);

        return response()->json([
            'success' => true,
            'data'    => [
                'pelanggaran'   => $pelanggaran->map(fn ($p) => $this->formatPelanggaran($p)),
                'total_poin'    => (int) $totalPoin,
                'total_catatan' => $totalCatatan,
                'rekap_status'  => $rekapStatus,
                'kategori_list' => $kategoriList,
                'status_list'   => Pelanggaran::STATUSES,
                'meta'          => [
                    'current_page' => $pelanggaran->currentPage(),
                    'last_page'    => $pelanggaran->lastPage(),
                    'per_page'     => $pelanggaran->perPage(),
                    'total'        => $pelanggaran->total(),
                ],
            ],
        ]);
    }

    // ── Show ───────────────────────────────────────────────────────────────────

    /**
     * GET /api/siswa/pelanggaran/{pelanggaran}
     * Detail satu catatan pelanggaran milik siswa.
     */
    public function show(Pelanggaran $pelanggaran): JsonResponse
    {
        $siswa = $this->getSiswa();

        abort_if($pelanggaran->siswa_id !== $siswa->id, 403, 'Ini bukan data kedisiplinan Anda.');

        $pelanggaran->load(['kategori', 'dicatatOleh']);

        $totalPoinSiswa = Pelanggaran::where('siswa_id', $siswa->id)
            ->poinAktifTahun(now()->year)
            ->sum('poin');

        return response()->json([
            'success' => true,
            'data'    => [
                'pelanggaran'     => $this->formatPelanggaran($pelanggaran),
                'total_poin_siswa'=> (int) $totalPoinSiswa,
            ],
        ]);
    }
}