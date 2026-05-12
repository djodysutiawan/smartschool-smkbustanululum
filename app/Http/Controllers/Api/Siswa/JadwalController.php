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
    private const HARI_MAP = [
        'Sunday'    => 'minggu',
        'Monday'    => 'senin',
        'Tuesday'   => 'selasa',
        'Wednesday' => 'rabu',
        'Thursday'  => 'kamis',
        'Friday'    => 'jumat',
        'Saturday'  => 'sabtu',
    ];

    private const HARI_LIST = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];

    private function getSiswa(): \App\Models\Siswa
    {
        $siswa = Auth::user()?->siswa;
        abort_if(! $siswa, 403, 'Akun Anda tidak terhubung dengan data siswa.');
        return $siswa;
    }

    private function formatJadwal(JadwalPelajaran $j): array
    {
        return [
            'id'             => $j->id,
            'hari'           => $j->hari,
            'jam_mulai'      => $j->jam_mulai,
            'jam_selesai'    => $j->jam_selesai,
            'mata_pelajaran' => $j->relationLoaded('mataPelajaran') ? [
                'id'   => $j->mataPelajaran?->id,
                'nama' => $j->mataPelajaran?->nama,
                'kode' => $j->mataPelajaran?->kode ?? null,
            ] : null,
            'guru'           => $j->relationLoaded('guru') ? [
                'id'           => $j->guru?->id,
                'nama_lengkap' => $j->guru?->nama_lengkap,
            ] : null,
            'ruang'          => $j->relationLoaded('ruang') ? [
                'id'        => $j->ruang?->id,
                'nama_ruang'=> $j->ruang?->nama_ruang ?? null,
            ] : null,
            'tahun_ajaran'   => $j->relationLoaded('tahunAjaran')
                ? ($j->tahunAjaran?->nama ?? null)
                : null,
        ];
    }

    /**
     * GET /api/siswa/jadwal
     *
     * Query string:
     *   hari → senin|selasa|rabu|kamis|jumat|sabtu (opsional, filter per hari)
     */
    public function index(Request $request): JsonResponse
    {
        $siswa = $this->getSiswa();

        abort_if(! $siswa->kelas_id, 403, 'Anda belum terdaftar di kelas manapun.');

        $request->validate([
            'hari' => ['nullable', 'in:' . implode(',', self::HARI_LIST)],
        ]);

        $allJadwal = JadwalPelajaran::with(['mataPelajaran', 'guru', 'ruang', 'tahunAjaran'])
            ->where('kelas_id', $siswa->kelas_id)
            ->where('is_active', true)
            ->orderByRaw("FIELD(hari, 'senin','selasa','rabu','kamis','jumat','sabtu')")
            ->orderBy('jam_mulai')
            ->get();

        $hariIni     = self::HARI_MAP[Carbon::now()->format('l')] ?? 'senin';
        $jamSekarang = Carbon::now()->format('H:i:s');

        // Filter hari jika diminta
        $filterHari = $request->filled('hari') ? $request->hari : null;
        $jadwal     = $filterHari
            ? $allJadwal->where('hari', $filterHari)->values()
            : $allJadwal;

        // Kelompokkan per hari untuk weekly view
        $jadwalPerHari = $allJadwal
            ->groupBy('hari')
            ->map(fn ($items) => $items->map(fn ($j) => $this->formatJadwal($j))->values());

        return response()->json([
            'success' => true,
            'data'    => [
                'hari_ini'       => $hariIni,
                'jam_sekarang'   => $jamSekarang,
                'filter_hari'    => $filterHari,
                'hari_list'      => self::HARI_LIST,
                'jadwal'         => $jadwal->map(fn ($j) => $this->formatJadwal($j))->values(),
                'jadwal_per_hari'=> $jadwalPerHari,
            ],
        ]);
    }

    /**
     * GET /api/siswa/jadwal/{jadwal}
     */
    public function show(JadwalPelajaran $jadwal): JsonResponse
    {
        $siswa = $this->getSiswa();

        abort_if(
            $jadwal->kelas_id !== $siswa->kelas_id,
            403,
            'Jadwal ini bukan untuk kelas Anda.'
        );

        $jadwal->load(['mataPelajaran', 'guru', 'ruang', 'kelas', 'tahunAjaran']);

        $jadwalSamMapel = JadwalPelajaran::with(['ruang'])
            ->where('kelas_id', $siswa->kelas_id)
            ->where('mata_pelajaran_id', $jadwal->mata_pelajaran_id)
            ->where('id', '!=', $jadwal->id)
            ->where('is_active', true)
            ->orderByRaw("FIELD(hari, 'senin','selasa','rabu','kamis','jumat','sabtu')")
            ->orderBy('jam_mulai')
            ->get()
            ->map(fn ($j) => [
                'id'          => $j->id,
                'hari'        => $j->hari,
                'jam_mulai'   => $j->jam_mulai,
                'jam_selesai' => $j->jam_selesai,
                'ruang'       => $j->ruang?->nama_ruang ?? null,
            ]);

        $data                    = $this->formatJadwal($jadwal);
        $data['kelas']           = $jadwal->kelas?->nama_kelas ?? null;
        $data['jadwal_sam_mapel'] = $jadwalSamMapel;

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }
}