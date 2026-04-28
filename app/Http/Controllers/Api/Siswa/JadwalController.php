<?php

namespace App\Http\Controllers\Api\Siswa;

use App\Http\Controllers\Controller;
use App\Models\JadwalPelajaran;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
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
     * GET /api/siswa/jadwal
     * Jadwal pelajaran dikelompokkan per hari.
     */
    public function index(Request $request): JsonResponse
    {
        $siswa    = $this->getSiswa();
        $hariList = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];

        $query = JadwalPelajaran::with(['mataPelajaran', 'guru', 'ruang', 'tahunAjaran'])
            ->where('kelas_id', $siswa->kelas_id);

        if ($request->filled('hari') && in_array($request->hari, $hariList)) {
            $query->where('hari', $request->hari);
        }

        $jadwal = $query
            ->orderByRaw("FIELD(hari, 'senin','selasa','rabu','kamis','jumat','sabtu')")
            ->orderBy('jam_mulai')
            ->get();

        $hariIni       = strtolower(Carbon::now()->locale('id')->isoFormat('dddd'));
        $jamSekarang   = Carbon::now()->format('H:i:s');
        $jadwalPerHari = $jadwal->groupBy('hari');

        return response()->json([
            'success' => true,
            'data'    => [
                'jadwal_per_hari' => $jadwalPerHari,
                'hari_list'       => $hariList,
                'hari_ini'        => $hariIni,
                'jadwal_hari_ini' => $jadwalPerHari->get($hariIni, collect()),
                'jam_sekarang'    => $jamSekarang,
                'siswa'           => $siswa->only(['id', 'nama', 'kelas_id']),
            ],
        ]);
    }

    /**
     * GET /api/siswa/jadwal/{jadwal}
     * Detail satu slot jadwal pelajaran.
     */
    public function show(JadwalPelajaran $jadwal): JsonResponse
    {
        $siswa = $this->getSiswa();

        abort_if($jadwal->kelas_id !== $siswa->kelas_id, 403, 'Jadwal ini bukan untuk kelas Anda.');

        $jadwal->load(['mataPelajaran', 'guru', 'ruang', 'kelas', 'tahunAjaran']);

        $jadwalSamMapel = JadwalPelajaran::with(['ruang'])
            ->where('kelas_id', $siswa->kelas_id)
            ->where('mata_pelajaran_id', $jadwal->mata_pelajaran_id)
            ->where('id', '!=', $jadwal->id)
            ->orderByRaw("FIELD(hari, 'senin','selasa','rabu','kamis','jumat','sabtu')")
            ->orderBy('jam_mulai')
            ->get();

        return response()->json([
            'success' => true,
            'data'    => [
                'jadwal'           => $jadwal,
                'jadwal_sam_mapel' => $jadwalSamMapel,
            ],
        ]);
    }
}