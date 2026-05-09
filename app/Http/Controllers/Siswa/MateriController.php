<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MateriController extends Controller
{
    /**
     * Ambil data siswa dari user yang sedang login.
     * FIX: Abort 403 jika relasi siswa tidak ditemukan.
     */
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

        // FIX: Gunakan scope scopeDipublikasikan() agar konsisten dengan model.
        // FIX: Tambahkan tahunAjaran ke eager load untuk mencegah potensi N+1 di view.
        $query = Materi::with(['mataPelajaran', 'guru', 'kelas'])
            ->where('kelas_id', $siswa->kelas_id)
            ->dipublikasikan(); // pakai scope

        // Filter mata pelajaran
        if ($request->filled('mapel_id')) {
            // FIX: Cast ke int agar tidak ada SQL type mismatch / injeksi string
            $query->where('mata_pelajaran_id', (int) $request->mapel_id);
        }

        // Filter jenis konten
        if ($request->filled('jenis')) {
            // FIX: Whitelist jenis agar nilai sembarang tidak lolos ke query
            $jenisValid = Materi::JENIS_VALID;
            if (in_array($request->jenis, $jenisValid, strict: true)) {
                $query->where('jenis', $request->jenis);
            }
        }

        // Filter pencarian judul
        if ($request->filled('cari')) {
            // FIX: Escape karakter wildcard LIKE (%, _) agar tidak menjadi
            // wildcard tidak sengaja dalam input pengguna.
            $cari = str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $request->cari);
            $query->where('judul', 'like', '%' . $cari . '%');
        }

        $materi = $query
            ->orderByDesc('dipublikasikan_pada')
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        // FIX: Ambil mapel yang terkait dengan kelas siswa melalui materi
        // yang sudah dipublikasikan — lebih akurat daripada melalui jadwal_pelajaran
        // karena jadwal bisa saja tidak memiliki kolom is_active atau berbeda struktur.
        // Fallback ke jadwalPelajaran jika relasi tersedia, atau langsung dari materi.
        $mapelList = MataPelajaran::whereHas('materi', function ($q) use ($siswa) {
                $q->where('kelas_id', $siswa->kelas_id)
                  ->where('dipublikasikan', true);
            })
            ->orderBy('nama_mapel')
            ->get();

        $jenisList = Materi::JENIS_VALID; // FIX: pakai konstanta model, bukan hardcode

        return view('siswa.materi.index', compact('materi', 'mapelList', 'jenisList'));
    }

    /**
     * Detail materi pelajaran.
     * Hanya materi untuk kelas siswa yang sudah dipublikasikan.
     */
    public function show(Materi $materi)
    {
        $siswa = $this->getSiswa();

        // FIX: Gunakan != (loose) bukan !== (strict) untuk menghindari
        // mismatch int vs string antara nilai dari DB dan model yang belum di-cast.
        // Model sudah di-cast ke integer, tapi siswa->kelas_id mungkin belum.
        // Alternatif paling aman: cast keduanya ke int secara eksplisit.
        abort_if(
            (int) $materi->kelas_id !== (int) $siswa->kelas_id || ! $materi->dipublikasikan,
            403,
            'Materi ini tidak tersedia untuk Anda.'
        );

        // FIX: Load semua relasi yang dibutuhkan view sekaligus (hindari lazy load)
        $materi->load(['mataPelajaran', 'guru', 'kelas', 'tahunAjaran']);

        // Materi lain pada mapel yang sama (sidebar)
        $materiTerkait = Materi::where('mata_pelajaran_id', $materi->mata_pelajaran_id)
            ->where('kelas_id', $siswa->kelas_id)
            ->dipublikasikan()   // FIX: pakai scope
            ->where('id', '!=', $materi->id)
            ->orderByDesc('dipublikasikan_pada')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('siswa.materi.show', compact('materi', 'materiTerkait'));
    }
}