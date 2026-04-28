<?php

namespace App\Http\Controllers\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\PengumpulanTugas;
use App\Models\TahunAjaran;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AkademikController extends Controller
{
    // ── Helper: ambil data orang tua yang login ───────────────────────────────

    private function getOrangTua()
    {
        $orangTua = Auth::user()->orangTua;
        abort_if(! $orangTua, 403, 'Akun Anda tidak terhubung dengan data orang tua.');
        return $orangTua;
    }

    /**
     * Pastikan siswa adalah anak dari orang tua yang login.
     * Jika ada lebih dari 1 anak, bisa dipilih via query string ?siswa_id=X
     */
    private function resolveAnak(Request $request, $orangTua)
    {
        $anakList = $orangTua->siswa()->with('kelas')->get();
        abort_if($anakList->isEmpty(), 404, 'Data anak tidak ditemukan.');

        if ($request->filled('siswa_id')) {
            $anak = $anakList->firstWhere('id', $request->siswa_id);
            abort_if(! $anak, 403, 'Siswa ini bukan anak Anda.');
            return $anak;
        }

        return $anakList->first();
    }

    /**
     * Tahun ajaran yang sedang aktif atau paling baru.
     */
    private function resolveTahunAjaran(Request $request): ?TahunAjaran
    {
        if ($request->filled('tahun_ajaran_id')) {
            return TahunAjaran::find($request->tahun_ajaran_id);
        }
        return TahunAjaran::aktif()->first()
            ?? TahunAjaran::orderByDesc('tahun')->first();
    }

    // ── NILAI PER MATA PELAJARAN ───────────────────────────────────────────────
    // GET /ortu/akademik/nilai

    public function nilai(Request $request)
    {
        $orangTua = $this->getOrangTua();
        $anak     = $this->resolveAnak($request, $orangTua);
        $anakList = $orangTua->siswa()->with('kelas')->get();

        $tahunAjaran   = $this->resolveTahunAjaran($request);
        $tahunAjaranId = $tahunAjaran?->id;

        // Ambil semua nilai anak pada tahun ajaran yang dipilih
        $nilaiList = Nilai::with(['mataPelajaran', 'guru', 'tahunAjaran'])
            ->where('siswa_id', $anak->id)
            ->when($tahunAjaranId, fn ($q) => $q->where('tahun_ajaran_id', $tahunAjaranId))
            ->when($request->filled('mapel_id'), fn ($q) => $q->where('mata_pelajaran_id', $request->mapel_id))
            ->orderBy('mata_pelajaran_id')
            ->get();

        // Daftar mapel yang pernah ada nilainya (untuk filter)
        $mapelList = MataPelajaran::whereHas('nilai', fn ($q) =>
            $q->where('siswa_id', $anak->id)
        )->orderBy('nama_mapel')->get();

        $tahunList = TahunAjaran::orderByDesc('tahun')->get();

        // Statistik ringkas per mapel (rata-rata semua komponen)
        $statsPerMapel = $nilaiList->groupBy('mata_pelajaran_id')->map(function ($group) {
            $row = $group->first();
            return [
                'nama'         => $row->mataPelajaran->nama_mapel ?? '-',
                'nilai_tugas'  => round($group->avg('nilai_tugas') ?? 0, 1),
                'nilai_harian' => round($group->avg('nilai_harian') ?? 0, 1),
                'nilai_uts'    => round($group->avg('nilai_uts') ?? 0, 1),
                'nilai_uas'    => round($group->avg('nilai_uas') ?? 0, 1),
                'nilai_akhir'  => round($group->avg('nilai_akhir') ?? 0, 1),
                'predikat'     => $row->predikat ?? '-',
            ];
        });

        // Rata-rata nilai akhir keseluruhan
        $rataRataAkhir = $nilaiList->avg('nilai_akhir');

        return view('orangtua.akademik.nilai', compact(
            'anak',
            'anakList',
            'nilaiList',
            'mapelList',
            'tahunList',
            'tahunAjaran',
            'tahunAjaranId',
            'statsPerMapel',
            'rataRataAkhir',
        ));
    }

    // ── REKAP / RAPOR ─────────────────────────────────────────────────────────
    // GET /ortu/akademik/rapor

    public function rapor(Request $request)
    {
        $orangTua = $this->getOrangTua();
        $anak     = $this->resolveAnak($request, $orangTua);
        $anakList = $orangTua->siswa()->with('kelas')->get();

        $tahunAjaran   = $this->resolveTahunAjaran($request);
        $tahunAjaranId = $tahunAjaran?->id;

        // Ambil semua nilai anak, satu baris per mata pelajaran per tahun ajaran
        $nilaiAll = Nilai::with(['mataPelajaran', 'guru'])
            ->where('siswa_id', $anak->id)
            ->when($tahunAjaranId, fn ($q) => $q->where('tahun_ajaran_id', $tahunAjaranId))
            ->get();

        // Susun data rapor per mata pelajaran
        // Model Nilai sudah punya kolom: nilai_tugas, nilai_harian, nilai_uts, nilai_uas, nilai_akhir, predikat
        // Jika ada beberapa record per mapel (misal update berkala), ambil yang terbaru
        $raporData = $nilaiAll
            ->groupBy('mata_pelajaran_id')
            ->map(function ($group) {
                // Ambil record dengan nilai_akhir tertinggi / terbaru
                $latest = $group->sortByDesc('updated_at')->first();
                return [
                    'mapel'        => $latest->mataPelajaran,
                    'guru'         => $latest->guru,
                    'nilai_tugas'  => $latest->nilai_tugas,
                    'nilai_harian' => $latest->nilai_harian,
                    'nilai_uts'    => $latest->nilai_uts,
                    'nilai_uas'    => $latest->nilai_uas,
                    'nilai_akhir'  => $latest->nilai_akhir,
                    'predikat'     => $latest->predikat,
                    'catatan'      => $latest->catatan,
                ];
            })
            ->sortBy('mapel.nama_mapel')
            ->values();

        $rataRata  = $raporData->avg('nilai_akhir');
        $tahunList = TahunAjaran::orderByDesc('tahun')->get();

        // Hitung sebaran predikat
        $sebaranPredikat = $raporData->groupBy('predikat')->map->count();

        // Mapel dengan nilai terendah & tertinggi
        $nilaiTertinggi = $raporData->sortByDesc('nilai_akhir')->first();
        $nilaiTerendah  = $raporData->sortBy('nilai_akhir')->first();

        return view('orangtua.akademik.rapor', compact(
            'anak',
            'anakList',
            'raporData',
            'rataRata',
            'tahunList',
            'tahunAjaran',
            'tahunAjaranId',
            'sebaranPredikat',
            'nilaiTertinggi',
            'nilaiTerendah',
        ));
    }

    // ── PROGRESS TUGAS ────────────────────────────────────────────────────────
    // GET /ortu/akademik/tugas

    public function tugas(Request $request)
    {
        $orangTua = $this->getOrangTua();
        $anak     = $this->resolveAnak($request, $orangTua);
        $anakList = $orangTua->siswa()->with('kelas')->get();

        // Filter status
        $filterStatus = $request->get('status'); // belum | sudah | terlambat

        $tugasQuery = Tugas::with(['mataPelajaran', 'guru'])
            ->where('kelas_id', $anak->kelas_id)
            ->where('dipublikasikan', true)
            ->orderByDesc('batas_waktu');

        $tugasAll = $tugasQuery->paginate(15)->withQueryString();

        // Map pengumpulan siswa per tugas — load relasi tugas agar isTerlambat() tidak N+1
        $pengumpulanMap = PengumpulanTugas::with('tugas')
            ->where('siswa_id', $anak->id)
            ->whereIn('tugas_id', $tugasAll->pluck('id'))
            ->get()
            ->keyBy('tugas_id');

        // Statistik cepat (dari semua tugas, tanpa paginasi)
        $semuaTugas = Tugas::where('kelas_id', $anak->kelas_id)
            ->where('dipublikasikan', true)
            ->pluck('id');

        $semuaPengumpulan = PengumpulanTugas::where('siswa_id', $anak->id)
            ->whereIn('tugas_id', $semuaTugas)
            ->get();

        $statTugas = [
            'total'      => $semuaTugas->count(),
            'dikumpulkan'=> $semuaPengumpulan->whereNotNull('dikumpulkan_pada')->count(),
            'dinilai'    => $semuaPengumpulan->where('status', 'sudah_dinilai')->count(),
            'rata_nilai' => round($semuaPengumpulan->whereNotNull('nilai')->avg('nilai') ?? 0, 1),
        ];

        return view('orangtua.akademik.tugas', compact(
            'anak',
            'anakList',
            'tugasAll',
            'pengumpulanMap',
            'statTugas',
        ));
    }
}