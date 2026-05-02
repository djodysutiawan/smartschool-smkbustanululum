<?php

namespace App\Http\Controllers;

use App\Models\ProfilSekolah;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class AbsensiPublikController extends Controller
{
    /**
     * Tampilkan halaman form cek absensi.
     */
    public function index()
    {
        $profil          = ProfilSekolah::instance();
        $tahunAjaranList = TahunAjaran::orderByDesc('tahun')->get();

        return view('absensi.index', compact('profil', 'tahunAjaranList'));
    }

    /**
     * Proses pencarian & tampilkan rekap absensi siswa.
     */
    public function cek(Request $request)
    {
        $request->validate([
            'nis'             => ['required', 'string', 'max:20'],
            'tahun_ajaran_id' => ['required', 'integer', 'exists:tahun_ajaran,id'],
            'bulan'           => ['nullable', 'integer', 'min:1', 'max:12'],
        ], [
            'nis.required'             => 'NIS wajib diisi.',
            'tahun_ajaran_id.required' => 'Tahun ajaran wajib dipilih.',
            'tahun_ajaran_id.exists'   => 'Tahun ajaran tidak valid.',
        ]);

        $profil = ProfilSekolah::instance();

        $siswa = Siswa::where('nis', $request->nis)
            ->with(['kelas', 'tahunAjaran'])
            ->first();

        if (! $siswa) {
            return back()
                ->withInput()
                ->withErrors(['nis' => 'NIS tidak ditemukan. Pastikan NIS yang Anda masukkan benar.']);
        }

        $tahunAjaran = TahunAjaran::findOrFail($request->tahun_ajaran_id);

        // Query dasar absensi untuk siswa + tahun ajaran
        // Absensi tidak punya kolom tahun_ajaran_id, jadi filter via tanggal
        $query = $siswa->absensi()
            ->whereBetween('tanggal', [
                $tahunAjaran->tanggal_mulai,
                $tahunAjaran->tanggal_selesai,
            ])
            ->orderBy('tanggal');

        // Filter bulan jika dipilih
        $bulanDipilih = $request->bulan ? (int) $request->bulan : null;
        if ($bulanDipilih) {
            $query->whereMonth('tanggal', $bulanDipilih);
        }

        $absensiList = $query->get();

        // Hitung rekap total
        $totalHadir = $absensiList->where('status', 'hadir')->count();
        $totalTelat = $absensiList->where('status', 'telat')->count();
        $totalSakit = $absensiList->where('status', 'sakit')->count();
        $totalIzin  = $absensiList->where('status', 'izin')->count();
        $totalAlfa  = $absensiList->where('status', 'alfa')->count();
        $totalHari  = $absensiList->count();

        $totalMasuk = $totalHadir + $totalTelat;
        $persentase = $totalHari > 0
            ? round(($totalMasuk / $totalHari) * 100, 1)
            : 0;

        // Kelompokkan per bulan untuk chart/tampilan ringkasan
        $perBulan = $absensiList
            ->groupBy(fn($a) => $a->tanggal->format('Y-m'))
            ->map(fn($group, $key) => [
                'label'  => \Carbon\Carbon::createFromFormat('Y-m', $key)->translatedFormat('F Y'),
                'hadir'  => $group->where('status', 'hadir')->count(),
                'telat'  => $group->where('status', 'telat')->count(),
                'sakit'  => $group->where('status', 'sakit')->count(),
                'izin'   => $group->where('status', 'izin')->count(),
                'alfa'   => $group->where('status', 'alfa')->count(),
                'total'  => $group->count(),
            ])
            ->values();

        $tahunAjaranList = TahunAjaran::orderByDesc('tahun')->get();

        // Daftar bulan yang tersedia dalam tahun ajaran ini
        $bulanList = $this->getBulanList($tahunAjaran);

        return view('absensi.index', compact(
            'profil',
            'siswa',
            'absensiList',
            'tahunAjaran',
            'tahunAjaranList',
            'bulanList',
            'bulanDipilih',
            'totalHadir',
            'totalTelat',
            'totalSakit',
            'totalIzin',
            'totalAlfa',
            'totalHari',
            'totalMasuk',
            'persentase',
            'perBulan',
        ));
    }

    /**
     * Generate daftar bulan antara tanggal_mulai dan tanggal_selesai tahun ajaran.
     */
    private function getBulanList(TahunAjaran $ta): array
    {
        $bulan  = [];
        $cursor = $ta->tanggal_mulai->copy()->startOfMonth();
        $end    = $ta->tanggal_selesai->copy()->startOfMonth();

        while ($cursor->lte($end)) {
            $bulan[] = [
                'value' => (int) $cursor->format('n'),
                'label' => $cursor->translatedFormat('F'),
            ];
            $cursor->addMonth();
        }

        return $bulan;
    }
}