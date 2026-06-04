<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class MateriController extends Controller
{
    /**
     * Ambil data siswa dari user yang sedang login.
     * Abort 403 jika relasi siswa tidak ditemukan.
     */
    private function getSiswa()
    {
        $siswa = Auth::user()->siswa;
        abort_if(! $siswa, 403, 'Akun Anda tidak terhubung dengan data siswa.');
        return $siswa;
    }

    /**
     * Validasi kepemilikan materi untuk siswa.
     * Materi harus: (1) untuk kelas siswa, (2) sudah dipublikasikan.
     */
    private function authorizeMateriBySiswa(Materi $materi, $siswa): void
    {
        abort_if(
            (int) $materi->kelas_id !== (int) $siswa->kelas_id || ! $materi->dipublikasikan,
            403,
            'Materi ini tidak tersedia untuk Anda.'
        );
    }

    /**
     * Daftar materi pelajaran yang tersedia untuk kelas siswa.
     * Hanya materi yang sudah dipublikasikan (dipublikasikan = true).
     */
    public function index(Request $request)
    {
        $siswa = $this->getSiswa();

        $query = Materi::with(['mataPelajaran', 'guru', 'kelas'])
            ->where('kelas_id', $siswa->kelas_id)
            ->dipublikasikan();

        // Filter mata pelajaran
        if ($request->filled('mapel_id')) {
            $query->where('mata_pelajaran_id', (int) $request->mapel_id);
        }

        // Filter jenis konten — whitelist agar nilai sembarang tidak lolos ke query
        if ($request->filled('jenis')) {
            $jenisValid = Materi::JENIS_VALID;
            if (in_array($request->jenis, $jenisValid, strict: true)) {
                $query->where('jenis', $request->jenis);
            }
        }

        // Filter pencarian judul — escape wildcard LIKE
        if ($request->filled('cari')) {
            $cari = str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $request->cari);
            $query->where('judul', 'like', '%' . $cari . '%');
        }

        $materi = $query
            ->orderByDesc('dipublikasikan_pada')
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        $mapelList = MataPelajaran::whereHas('materi', function ($q) use ($siswa) {
                $q->where('kelas_id', $siswa->kelas_id)
                  ->where('dipublikasikan', true);
            })
            ->orderBy('nama_mapel')
            ->get();

        $jenisList = Materi::JENIS_VALID;

        return view('siswa.materi.index', compact('materi', 'mapelList', 'jenisList'));
    }

    /**
     * Detail materi pelajaran.
     * Hanya materi untuk kelas siswa yang sudah dipublikasikan.
     */
    public function show(Materi $materi)
    {
        $siswa = $this->getSiswa();
        $this->authorizeMateriBySiswa($materi, $siswa);

        $materi->load(['mataPelajaran', 'guru', 'kelas', 'tahunAjaran']);

        // Materi lain pada mapel yang sama (sidebar)
        $materiTerkait = Materi::where('mata_pelajaran_id', $materi->mata_pelajaran_id)
            ->where('kelas_id', $siswa->kelas_id)
            ->dipublikasikan()
            ->where('id', '!=', $materi->id)
            ->orderByDesc('dipublikasikan_pada')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('siswa.materi.show', compact('materi', 'materiTerkait'));
    }

    /**
     * Download file materi.
     *
     * Hanya tersedia untuk jenis 'file'. Endpoint ini dipisah dari show()
     * agar URL download bisa di-log, di-throttle, atau diberi middleware
     * tambahan (rate limit, audit trail) tanpa menyentuh logika tampilan.
     *
     * Alur:
     *   1. Otentikasi siswa.
     *   2. Otorisasi: kelas cocok + sudah dipublikasikan.
     *   3. Validasi: jenis harus 'file' dan path_file tidak kosong.
     *   4. Validasi: file benar-benar ada di storage (hindari path traversal).
     *   5. Stream file sebagai unduhan dengan nama file yang bersih.
     */
    public function download(Materi $materi): BinaryFileResponse
    {
        $siswa = $this->getSiswa();
        $this->authorizeMateriBySiswa($materi, $siswa);

        // Hanya materi bertipe 'file' yang bisa diunduh lewat endpoint ini
        abort_if(
            $materi->jenis !== 'file',
            404,
            'Materi ini tidak memiliki file untuk diunduh.'
        );

        // Pastikan kolom path_file terisi
        abort_if(
            empty($materi->path_file),
            404,
            'File materi tidak ditemukan.'
        );

        // Gunakan Storage facade agar path traversal tidak mungkin terjadi
        // (Storage::exists() hanya menerima path relatif dalam disk 'public')
        abort_if(
            ! Storage::disk('public')->exists($materi->path_file),
            404,
            'File materi tidak tersedia di server.'
        );

        // Nama file yang dilihat user: slug judul + ekstensi asli
        $ekstensi  = pathinfo($materi->path_file, PATHINFO_EXTENSION);
        $namaUnduh = \Illuminate\Support\Str::slug($materi->judul) . ($ekstensi ? '.' . $ekstensi : '');

        // Ambil path absolut dari disk 'public', lalu stream via response()->download()
        // agar Intelephense tidak menghasilkan P1013 (method tidak ada di interface Filesystem)
        $pathAbsolut = Storage::disk('public')->path($materi->path_file);

        return response()->download($pathAbsolut, $namaUnduh);
    }
}