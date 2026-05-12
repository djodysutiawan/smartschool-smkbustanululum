<?php

namespace App\Http\Controllers\Api\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Models\MataPelajaran;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MateriController extends Controller
{
    // ── Helper ─────────────────────────────────────────────────────────────────

    private function getSiswa()
    {
        $siswa = Auth::user()->siswa;
        abort_if(! $siswa, 403, 'Akun Anda tidak terhubung dengan data siswa.');
        return $siswa;
    }

    /**
     * Konversi path storage relatif ke URL /api/file/{path}.
     */
    private function toApiFileUrl(?string $path): ?string
    {
        if (! $path) return null;
        return url('api/file/' . ltrim($path, '/'));
    }

    /**
     * Format satu item materi untuk response API.
     */
    private function formatMateri(Materi $materi): array
    {
        return [
            'id'                 => $materi->id,
            'judul'              => $materi->judul,
            'deskripsi'          => $materi->deskripsi,
            'jenis'              => $materi->jenis,
            'konten'             => $materi->konten,
            'file_url'           => $this->toApiFileUrl($materi->file_path ?? null),
            'link_url'           => $materi->link_url ?? null,
            'dipublikasikan_pada'=> $materi->dipublikasikan_pada?->toIso8601String(),
            'mata_pelajaran'     => $materi->relationLoaded('mataPelajaran') ? [
                'id'         => $materi->mataPelajaran->id,
                'nama_mapel' => $materi->mataPelajaran->nama_mapel,
            ] : null,
            'guru' => $materi->relationLoaded('guru') ? [
                'id'           => $materi->guru->id,
                'nama_lengkap' => $materi->guru->nama_lengkap,
            ] : null,
            'kelas' => $materi->relationLoaded('kelas') ? [
                'id'         => $materi->kelas->id,
                'nama_kelas' => $materi->kelas->nama_kelas,
            ] : null,
        ];
    }

    // ── Index ──────────────────────────────────────────────────────────────────

    /**
     * GET /api/siswa/materi
     * Daftar materi yang sudah dipublikasikan untuk kelas siswa.
     *
     * Query params:
     *   - mapel_id  (int)    : filter mata pelajaran
     *   - jenis     (string) : filter jenis konten (whitelist dari Materi::JENIS_VALID)
     *   - cari      (string) : pencarian judul
     *   - per_page  (int)    : jumlah per halaman (default 15)
     */
    public function index(Request $request): JsonResponse
    {
        $siswa = $this->getSiswa();

        $query = Materi::with(['mataPelajaran', 'guru', 'kelas'])
            ->where('kelas_id', $siswa->kelas_id)
            ->dipublikasikan();

        // Filter mata pelajaran
        if ($request->filled('mapel_id')) {
            $query->where('mata_pelajaran_id', (int) $request->mapel_id);
        }

        // Filter jenis (whitelist)
        if ($request->filled('jenis')) {
            $jenisValid = Materi::JENIS_VALID;
            if (in_array($request->jenis, $jenisValid, strict: true)) {
                $query->where('jenis', $request->jenis);
            }
        }

        // Pencarian judul (escape wildcard LIKE)
        if ($request->filled('cari')) {
            $cari = str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $request->cari);
            $query->where('judul', 'like', '%' . $cari . '%');
        }

        $perPage  = min((int) ($request->per_page ?? 15), 50); // max 50 per halaman
        $paginated = $query
            ->orderByDesc('dipublikasikan_pada')
            ->orderByDesc('created_at')
            ->paginate($perPage)
            ->withQueryString();

        // Daftar mapel yang punya materi dipublikasikan di kelas ini (untuk filter)
        $mapelList = MataPelajaran::whereHas('materi', function ($q) use ($siswa) {
                $q->where('kelas_id', $siswa->kelas_id)
                  ->where('dipublikasikan', true);
            })
            ->orderBy('nama_mapel')
            ->get(['id', 'nama_mapel']);

        return response()->json([
            'success' => true,
            'data'    => [
                'materi'     => $paginated->through(fn ($m) => $this->formatMateri($m)),
                'mapel_list' => $mapelList,
                'jenis_list' => Materi::JENIS_VALID,
                'meta'       => [
                    'current_page' => $paginated->currentPage(),
                    'last_page'    => $paginated->lastPage(),
                    'per_page'     => $paginated->perPage(),
                    'total'        => $paginated->total(),
                ],
            ],
        ]);
    }

    // ── Show ───────────────────────────────────────────────────────────────────

    /**
     * GET /api/siswa/materi/{materi}
     * Detail materi — hanya untuk kelas siswa & sudah dipublikasikan.
     */
    public function show(Materi $materi): JsonResponse
    {
        $siswa = $this->getSiswa();

        abort_if(
            (int) $materi->kelas_id !== (int) $siswa->kelas_id || ! $materi->dipublikasikan,
            403,
            'Materi ini tidak tersedia untuk Anda.'
        );

        $materi->load(['mataPelajaran', 'guru', 'kelas', 'tahunAjaran']);

        // Materi terkait pada mapel yang sama
        $materiTerkait = Materi::with(['mataPelajaran', 'guru', 'kelas'])
            ->where('mata_pelajaran_id', $materi->mata_pelajaran_id)
            ->where('kelas_id', $siswa->kelas_id)
            ->dipublikasikan()
            ->where('id', '!=', $materi->id)
            ->orderByDesc('dipublikasikan_pada')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return response()->json([
            'success' => true,
            'data'    => [
                'materi'         => array_merge($this->formatMateri($materi), [
                    'tahun_ajaran' => $materi->relationLoaded('tahunAjaran') && $materi->tahunAjaran ? [
                        'id'           => $materi->tahunAjaran->id,
                        'nama'         => $materi->tahunAjaran->nama ?? null,
                        'tanggal_mulai'=> $materi->tahunAjaran->tanggal_mulai?->format('Y-m-d'),
                        'tanggal_akhir'=> $materi->tahunAjaran->tanggal_akhir?->format('Y-m-d'),
                    ] : null,
                ]),
                'materi_terkait' => $materiTerkait->map(fn ($m) => $this->formatMateri($m)),
            ],
        ]);
    }
}