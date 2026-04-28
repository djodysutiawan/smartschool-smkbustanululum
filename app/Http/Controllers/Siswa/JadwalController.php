<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\JadwalPelajaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    private function getSiswa(): \App\Models\Siswa
    {
        $siswa = Auth::user()->siswa;
        abort_if(! $siswa, 403, 'Akun Anda tidak terhubung dengan data siswa.');
        return $siswa;
    }

    /**
     * Tampilkan jadwal pelajaran sesuai kelas siswa (read-only).
     * Dikelompokkan per hari untuk tampilan tabel mingguan.
     *
     * CATATAN: kolom `is_active` dihapus dari query karena belum tentu
     * ada di semua instalasi. Jika tabel Anda punya kolom tersebut,
     * tambahkan kembali ->where('is_active', true).
     */
    public function index(Request $request)
    {
        $siswa = $this->getSiswa();

        $hariList = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];

        $query = JadwalPelajaran::with(['mataPelajaran', 'guru', 'ruang', 'tahunAjaran'])
            ->where('kelas_id', $siswa->kelas_id);

        // Filter per hari jika ada request
        if ($request->filled('hari') && in_array($request->hari, $hariList)) {
            $query->where('hari', $request->hari);
        }

        $jadwal        = $query->orderByRaw("FIELD(hari, 'senin','selasa','rabu','kamis','jumat','sabtu')")
                               ->orderBy('jam_mulai')
                               ->get();

        $jadwalPerHari = $jadwal->groupBy('hari');

        // Hari ini untuk highlight otomatis
        $hariIni       = strtolower(Carbon::now()->locale('id')->isoFormat('dddd'));
        $jadwalHariIni = $jadwalPerHari->get($hariIni, collect());

        // Jam sekarang untuk highlight pelajaran yang sedang berlangsung
        $jamSekarang = Carbon::now()->format('H:i:s');

        return view('siswa.jadwal.index', compact(
            'jadwal',
            'jadwalPerHari',
            'hariList',
            'hariIni',
            'jadwalHariIni',
            'jamSekarang',
            'siswa',
        ));
    }

    /**
     * Detail satu slot jadwal pelajaran.
     */
    public function show(JadwalPelajaran $jadwal)
    {
        $siswa = $this->getSiswa();

        abort_if($jadwal->kelas_id !== $siswa->kelas_id, 403, 'Jadwal ini bukan untuk kelas Anda.');

        $jadwal->load(['mataPelajaran', 'guru', 'ruang', 'kelas', 'tahunAjaran']);

        // Jadwal lain mapel yang sama (referensi pertemuan lain dalam seminggu)
        $jadwalSamMapel = JadwalPelajaran::with(['ruang'])
            ->where('kelas_id', $siswa->kelas_id)
            ->where('mata_pelajaran_id', $jadwal->mata_pelajaran_id)
            ->where('id', '!=', $jadwal->id)
            ->orderByRaw("FIELD(hari, 'senin','selasa','rabu','kamis','jumat','sabtu')")
            ->orderBy('jam_mulai')
            ->get();

        return view('siswa.jadwal.show', compact('jadwal', 'jadwalSamMapel', 'siswa'));
    }
}