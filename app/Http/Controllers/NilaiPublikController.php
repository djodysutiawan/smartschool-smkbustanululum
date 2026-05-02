<?php

namespace App\Http\Controllers;

use App\Models\ProfilSekolah;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class NilaiPublikController extends Controller
{
    /**
     * Tampilkan halaman form cek nilai.
     */
    public function index()
    {
        $profil          = ProfilSekolah::instance();
        $tahunAjaranList = TahunAjaran::orderByDesc('tahun')->get();

        return view('nilai.index', compact('profil', 'tahunAjaranList'));
    }

    /**
     * Proses pencarian & tampilkan hasil nilai siswa.
     */
    public function cek(Request $request)
    {
        $request->validate([
            'nis'             => ['required', 'string', 'max:20'],
            'tahun_ajaran_id' => ['required', 'integer', 'exists:tahun_ajaran,id'],
        ], [
            'nis.required'             => 'NIS wajib diisi.',
            'tahun_ajaran_id.required' => 'Tahun ajaran wajib dipilih.',
            'tahun_ajaran_id.exists'   => 'Tahun ajaran tidak valid.',
        ]);

        $profil = ProfilSekolah::instance();

        // Cari siswa berdasarkan NIS
        $siswa = Siswa::where('nis', $request->nis)
            ->with(['kelas', 'tahunAjaran'])
            ->first();

        if (! $siswa) {
            return back()
                ->withInput()
                ->withErrors(['nis' => 'NIS tidak ditemukan. Pastikan NIS yang Anda masukkan benar.']);
        }

        // Ambil tahun ajaran yang dipilih (single model)
        $tahunAjaran = TahunAjaran::findOrFail($request->tahun_ajaran_id);

        // Ambil semua nilai siswa untuk tahun ajaran yang dipilih
        $nilaiList = $siswa->nilai()
            ->where('tahun_ajaran_id', $tahunAjaran->id)
            ->with(['mataPelajaran', 'guru', 'kelas'])
            ->orderBy('mata_pelajaran_id')
            ->get();

        // Hitung ringkasan statistik
        $rataRata       = $nilaiList->avg('nilai_akhir') ?? 0;
        $nilaiTertinggi = $nilaiList->max('nilai_akhir') ?? 0;
        $nilaiTerendah  = $nilaiList->min('nilai_akhir') ?? 0;
        $jumlahLulus    = $nilaiList->where('nilai_akhir', '>=', 70)->count();

        // Daftar semua tahun ajaran untuk dropdown
        $tahunAjaranList = TahunAjaran::orderByDesc('tahun')->get();

        return view('nilai.index', compact(
            'profil',
            'siswa',
            'nilaiList',
            'tahunAjaran',      // single model → aman untuk ->id
            'tahunAjaranList',  // collection → untuk dropdown
            'rataRata',
            'nilaiTertinggi',
            'nilaiTerendah',
            'jumlahLulus',
        ));
    }
}