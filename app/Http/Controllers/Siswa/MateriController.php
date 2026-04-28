<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Models\MataPelajaran;
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
     * Daftar materi pelajaran yang tersedia untuk kelas siswa.
     * Hanya materi yang sudah dipublikasikan (dipublikasikan = true).
     */
    public function index(Request $request)
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

        $materi    = $query->orderByDesc('created_at')->paginate(15)->withQueryString();
        $mapelList = MataPelajaran::whereHas('jadwalPelajaran', fn ($q) =>
            $q->where('kelas_id', $siswa->kelas_id)->where('is_active', true)
        )->orderBy('nama_mapel')->get();
        $jenisList = ['file', 'video', 'link', 'teks'];

        return view('siswa.materi.index', compact('materi', 'mapelList', 'jenisList'));
    }

    /**
     * Detail materi pelajaran.
     * Hanya materi untuk kelas siswa dan sudah dipublikasikan.
     */
    public function show(Materi $materi)
    {
        $siswa = $this->getSiswa();

        abort_if(
            $materi->kelas_id !== $siswa->kelas_id || ! $materi->dipublikasikan,
            403,
            'Materi ini tidak tersedia untuk Anda.'
        );

        $materi->load(['mataPelajaran', 'guru', 'kelas', 'tahunAjaran']);

        // Materi lain pada mapel yang sama
        $materiTerkait = Materi::where('mata_pelajaran_id', $materi->mata_pelajaran_id)
            ->where('kelas_id', $siswa->kelas_id)
            ->where('dipublikasikan', true)
            ->where('id', '!=', $materi->id)
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('siswa.materi.show', compact('materi', 'materiTerkait'));
    }
}