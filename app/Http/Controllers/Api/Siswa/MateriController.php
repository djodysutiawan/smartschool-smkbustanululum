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
    private function getSiswa()
    {
        $siswa = Auth::user()->siswa;
        abort_if(! $siswa, 403, 'Akun Anda tidak terhubung dengan data siswa.');
        return $siswa;
    }

    /**
     * GET /api/siswa/materi
     * Daftar materi yang sudah dipublikasikan untuk kelas siswa.
     * Query: ?mapel_id=&jenis=&cari=&per_page=
     */
    public function index(Request $request): JsonResponse
    {
        $siswa = $this->getSiswa();

        $query = Materi::with(['mataPelajaran', 'guru'])
            ->where('kelas_id', $siswa->kelas_id)
            ->where('dipublikasikan', true);

        if ($request->filled('mapel_id')) {
            $query->where('mata_pelajaran_id', $request->mapel_id);
        }

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        if ($request->filled('cari')) {
            $query->where('judul', 'like', '%' . $request->cari . '%');
        }

        $perPage = min((int) $request->get('per_page', 15), 50);
        $materi  = $query->orderByDesc('created_at')->paginate($perPage);

        $mapelList = MataPelajaran::whereHas('jadwalPelajaran', fn ($q) =>
            $q->where('kelas_id', $siswa->kelas_id)->where('is_active', true)
        )->orderBy('nama_mapel')->get(['id', 'nama_mapel']);

        return response()->json([
            'success' => true,
            'data'    => [
                'materi'     => $materi,
                'mapel_list' => $mapelList,
                'jenis_list' => ['file', 'video', 'link', 'teks'],
            ],
        ]);
    }

    /**
     * GET /api/siswa/materi/{materi}
     * Detail materi beserta materi terkait satu mapel.
     */
    public function show(Materi $materi): JsonResponse
    {
        $siswa = $this->getSiswa();

        abort_if(
            $materi->kelas_id !== $siswa->kelas_id || ! $materi->dipublikasikan,
            403,
            'Materi ini tidak tersedia untuk Anda.'
        );

        $materi->load(['mataPelajaran', 'guru', 'kelas', 'tahunAjaran']);

        $materiTerkait = Materi::where('mata_pelajaran_id', $materi->mata_pelajaran_id)
            ->where('kelas_id', $siswa->kelas_id)
            ->where('dipublikasikan', true)
            ->where('id', '!=', $materi->id)
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return response()->json([
            'success' => true,
            'data'    => [
                'materi'         => $materi,
                'materi_terkait' => $materiTerkait,
            ],
        ]);
    }
}