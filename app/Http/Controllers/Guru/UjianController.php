<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\TahunAjaran;
use App\Models\Ujian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UjianController extends Controller
{
    private const JENIS_LIST = ['ulangan_harian', 'uts', 'uas', 'remedial', 'quiz'];

    private function getGuruId(): int
    {
        $guru = Auth::user()->guru;
        abort_if(! $guru, 403, 'Akun Anda tidak terhubung dengan data guru.');
        return $guru->id;
    }

    public function index(Request $request)
    {
        $guruId = $this->getGuruId();

        $query = Ujian::with(['mataPelajaran', 'kelas', 'tahunAjaran'])
            ->where('guru_id', $guruId);

        if ($request->filled('tahun_ajaran_id')) {
            $query->where('tahun_ajaran_id', $request->tahun_ajaran_id);
        }

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        if ($request->filled('search')) {
            $query->where('judul', 'like', "%{$request->search}%");
        }

        $ujian       = $query->orderByDesc('tanggal')->paginate(20)->withQueryString();
        $tahunAjaran = TahunAjaran::orderByDesc('tahun')->get();
        $kelasList   = Kelas::aktif()->orderBy('nama_kelas')->get();
        $jenisList   = self::JENIS_LIST;

        return view('guru.ujian.index', compact('ujian', 'tahunAjaran', 'kelasList', 'jenisList'));
    }

    public function create()
    {
        $kelasList   = Kelas::aktif()->orderBy('nama_kelas')->get();
        $mapelList   = MataPelajaran::aktif()->orderBy('nama_mapel')->get();
        $tahunAjaran = TahunAjaran::orderByDesc('tahun')->get();
        $jenisList   = self::JENIS_LIST;

        return view('guru.ujian.create', compact('kelasList', 'mapelList', 'tahunAjaran', 'jenisList'));
    }

    public function store(Request $request)
    {
        $guruId = $this->getGuruId();

        $validated = $request->validate([
            'mata_pelajaran_id' => ['required', 'exists:mata_pelajaran,id'],
            'kelas_id'          => ['required', 'exists:kelas,id'],
            'tahun_ajaran_id'   => ['required', 'exists:tahun_ajaran,id'],
            'judul'             => ['required', 'string', 'max:255'],
            'jenis'             => ['required', Rule::in(self::JENIS_LIST)],
            'tanggal'           => ['required', 'date'],
            'jam_mulai'         => ['nullable', 'date_format:H:i'],
            'durasi_menit'      => ['required', 'integer', 'min:1', 'max:480'],
            'nilai_kkm'         => ['nullable', 'integer', 'min:0', 'max:100'],
            'acak_soal'         => ['boolean'],
            'acak_pilihan'      => ['boolean'],
            'tampilkan_nilai'   => ['boolean'],
            'maks_percobaan'    => ['nullable', 'integer', 'min:1', 'max:10'],
            'keterangan'        => ['nullable', 'string', 'max:1000'],
            'is_active'         => ['boolean'],
        ], $this->messages());

        $validated['guru_id'] = $guruId;

        Ujian::create($validated);

        return redirect()->route('guru.ujian.index')
            ->with('success', 'Ujian berhasil ditambahkan.');
    }

    public function show(Ujian $ujian)
    {
        $guruId = $this->getGuruId();
        abort_if($ujian->guru_id !== $guruId, 403, 'Anda tidak memiliki akses ke ujian ini.');

        $ujian->load(['mataPelajaran', 'kelas', 'tahunAjaran', 'soal']);

        $stats = [
            'total_soal'    => $ujian->total_soal,
            'total_bobot'   => $ujian->total_bobot,
            'siswa_selesai' => $ujian->siswaSelesai()->count(),
            'siswa_lulus'   => $ujian->sesi()->where('lulus', true)->count(),
            'rata_nilai'    => round($ujian->sesi()->whereNotNull('nilai_akhir')->avg('nilai_akhir') ?? 0, 2),
        ];

        return view('guru.ujian.show', compact('ujian', 'stats'));
    }

    public function edit(Ujian $ujian)
    {
        $guruId = $this->getGuruId();
        abort_if($ujian->guru_id !== $guruId, 403, 'Anda tidak memiliki akses ke ujian ini.');

        $kelasList   = Kelas::aktif()->orderBy('nama_kelas')->get();
        $mapelList   = MataPelajaran::aktif()->orderBy('nama_mapel')->get();
        $tahunAjaran = TahunAjaran::orderByDesc('tahun')->get();
        $jenisList   = self::JENIS_LIST;

        return view('guru.ujian.edit',
            compact('ujian', 'kelasList', 'mapelList', 'tahunAjaran', 'jenisList'));
    }

    public function update(Request $request, Ujian $ujian)
    {
        $guruId = $this->getGuruId();
        abort_if($ujian->guru_id !== $guruId, 403, 'Anda tidak memiliki akses ke ujian ini.');

        $validated = $request->validate([
            'mata_pelajaran_id' => ['required', 'exists:mata_pelajaran,id'],
            'kelas_id'          => ['required', 'exists:kelas,id'],
            'tahun_ajaran_id'   => ['required', 'exists:tahun_ajaran,id'],
            'judul'             => ['required', 'string', 'max:255'],
            'jenis'             => ['required', Rule::in(self::JENIS_LIST)],
            'tanggal'           => ['required', 'date'],
            'jam_mulai'         => ['nullable', 'date_format:H:i'],
            'durasi_menit'      => ['required', 'integer', 'min:1', 'max:480'],
            'nilai_kkm'         => ['nullable', 'integer', 'min:0', 'max:100'],
            'acak_soal'         => ['boolean'],
            'acak_pilihan'      => ['boolean'],
            'tampilkan_nilai'   => ['boolean'],
            'maks_percobaan'    => ['nullable', 'integer', 'min:1', 'max:10'],
            'keterangan'        => ['nullable', 'string', 'max:1000'],
            'is_active'         => ['boolean'],
        ], $this->messages());

        $ujian->update($validated);

        return redirect()->route('guru.ujian.show', $ujian)
            ->with('success', 'Ujian berhasil diperbarui.');
    }

    public function destroy(Ujian $ujian)
    {
        $guruId = $this->getGuruId();
        abort_if($ujian->guru_id !== $guruId, 403, 'Anda tidak memiliki akses ke ujian ini.');

        // Cegah hapus ujian yang sudah ada sesi berjalan
        if ($ujian->sesi()->whereIn('status', ['berlangsung'])->exists()) {
            return back()->with('error', 'Ujian tidak dapat dihapus karena masih ada sesi yang sedang berlangsung.');
        }

        $ujian->delete();

        return redirect()->route('guru.ujian.index')
            ->with('success', 'Ujian berhasil dihapus.');
    }

    public function toggleStatus(Ujian $ujian)
    {
        $guruId = $this->getGuruId();
        abort_if($ujian->guru_id !== $guruId, 403, 'Anda tidak memiliki akses ke ujian ini.');

        $ujian->update(['is_active' => ! $ujian->is_active]);
        $status = $ujian->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Ujian berhasil {$status}.");
    }

    /**
     * Tampilkan hasil/rekap nilai ujian per siswa.
     */
    public function hasil(Ujian $ujian)
    {
        $guruId = $this->getGuruId();
        abort_if($ujian->guru_id !== $guruId, 403, 'Anda tidak memiliki akses ke ujian ini.');

        $ujian->load(['mataPelajaran', 'kelas', 'tahunAjaran']);

        $sesiList = $ujian->sesi()
            ->with(['siswa'])
            ->whereIn('status', ['selesai', 'habis_waktu'])
            ->orderByDesc('nilai_akhir')
            ->get();

        $stats = [
            'total_peserta'  => $sesiList->count(),
            'rata_nilai'     => round($sesiList->avg('nilai_akhir') ?? 0, 2),
            'nilai_tertinggi' => $sesiList->max('nilai_akhir') ?? 0,
            'nilai_terendah'  => $sesiList->min('nilai_akhir') ?? 0,
            'lulus'          => $sesiList->where('lulus', true)->count(),
            'tidak_lulus'    => $sesiList->where('lulus', false)->count(),
        ];

        return view('guru.ujian.hasil', compact('ujian', 'sesiList', 'stats'));
    }

    private function messages(): array
    {
        return [
            'mata_pelajaran_id.required' => 'Mata pelajaran wajib dipilih.',
            'mata_pelajaran_id.exists'   => 'Mata pelajaran yang dipilih tidak valid.',
            'kelas_id.required'          => 'Kelas wajib dipilih.',
            'kelas_id.exists'            => 'Kelas yang dipilih tidak valid.',
            'tahun_ajaran_id.required'   => 'Tahun ajaran wajib dipilih.',
            'tahun_ajaran_id.exists'     => 'Tahun ajaran yang dipilih tidak valid.',
            'judul.required'             => 'Judul ujian wajib diisi.',
            'judul.max'                  => 'Judul ujian maksimal 255 karakter.',
            'jenis.required'             => 'Jenis ujian wajib dipilih.',
            'jenis.in'                   => 'Jenis ujian yang dipilih tidak valid.',
            'tanggal.required'           => 'Tanggal ujian wajib diisi.',
            'tanggal.date'               => 'Format tanggal tidak valid.',
            'jam_mulai.date_format'      => 'Format jam mulai harus HH:MM.',
            'durasi_menit.required'      => 'Durasi ujian wajib diisi.',
            'durasi_menit.integer'       => 'Durasi harus berupa angka.',
            'durasi_menit.min'           => 'Durasi minimal 1 menit.',
            'durasi_menit.max'           => 'Durasi maksimal 480 menit.',
            'nilai_kkm.min'              => 'Nilai KKM minimal 0.',
            'nilai_kkm.max'              => 'Nilai KKM maksimal 100.',
            'maks_percobaan.min'         => 'Maksimal percobaan minimal 1.',
            'maks_percobaan.max'         => 'Maksimal percobaan tidak boleh lebih dari 10.',
        ];
    }
}