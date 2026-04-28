<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{
    private function getGuruId(): int
    {
        $guru = Auth::user()->guru;
        abort_if(! $guru, 403, 'Akun Anda tidak terhubung dengan data guru.');
        return $guru->id;
    }

    public function index(Request $request)
    {
        $guruId = $this->getGuruId();

        $query = Nilai::with(['siswa', 'mataPelajaran', 'kelas', 'tahunAjaran'])
            ->where('guru_id', $guruId);

        if ($request->filled('tahun_ajaran_id')) {
            $query->where('tahun_ajaran_id', $request->tahun_ajaran_id);
        }

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        if ($request->filled('mata_pelajaran_id')) {
            $query->where('mata_pelajaran_id', $request->mata_pelajaran_id);
        }

        if ($request->filled('predikat')) {
            $query->where('predikat', $request->predikat);
        }

        if ($request->filled('search')) {
            $query->whereHas('siswa', fn ($q) =>
                $q->where('nama_lengkap', 'like', "%{$request->search}%")
            );
        }

        $nilai        = $query->paginate(20)->withQueryString();
        $tahunAjaran  = TahunAjaran::orderByDesc('tahun')->get();
        $kelasList    = Kelas::aktif()->orderBy('nama_kelas')->get();
        $mapelList    = MataPelajaran::aktif()->orderBy('nama_mapel')->get();
        $predikatList = ['A', 'B', 'C', 'D', 'E'];

        return view('guru.nilai.index',
            compact('nilai', 'tahunAjaran', 'kelasList', 'mapelList', 'predikatList'));
    }

    public function create()
    {
        $siswaList   = Siswa::aktif()->orderBy('nama_lengkap')->get();
        $kelasList   = Kelas::aktif()->orderBy('nama_kelas')->get();
        $mapelList   = MataPelajaran::aktif()->orderBy('nama_mapel')->get();
        $tahunAjaran = TahunAjaran::orderByDesc('tahun')->get();

        return view('guru.nilai.create', compact('siswaList', 'kelasList', 'mapelList', 'tahunAjaran'));
    }

    public function store(Request $request)
    {
        $guruId = $this->getGuruId();

        $validated = $request->validate([
            'siswa_id'          => ['required', 'exists:siswa,id'],
            'mata_pelajaran_id' => ['required', 'exists:mata_pelajaran,id'],
            'kelas_id'          => ['required', 'exists:kelas,id'],
            'tahun_ajaran_id'   => ['required', 'exists:tahun_ajaran,id'],
            'nilai_tugas'       => ['nullable', 'numeric', 'min:0', 'max:100'],
            'nilai_harian'      => ['nullable', 'numeric', 'min:0', 'max:100'],
            'nilai_uts'         => ['nullable', 'numeric', 'min:0', 'max:100'],
            'nilai_uas'         => ['nullable', 'numeric', 'min:0', 'max:100'],
            'catatan'           => ['nullable', 'string', 'max:500'],
        ], $this->messages());

        $validated['guru_id'] = $guruId;

        $exists = Nilai::where('siswa_id', $validated['siswa_id'])
            ->where('mata_pelajaran_id', $validated['mata_pelajaran_id'])
            ->where('tahun_ajaran_id', $validated['tahun_ajaran_id'])
            ->exists();

        if ($exists) {
            return back()->withInput()
                ->with('error', 'Nilai untuk siswa dan mata pelajaran ini pada tahun ajaran yang dipilih sudah ada.');
        }

        Nilai::create($validated);

        return redirect()->route('guru.nilai.index')
            ->with('success', 'Nilai berhasil ditambahkan.');
    }

    public function show(Nilai $nilai)
    {
        $guruId = $this->getGuruId();
        abort_if($nilai->guru_id !== $guruId, 403, 'Anda tidak memiliki akses ke data nilai ini.');

        $nilai->load(['siswa', 'mataPelajaran', 'kelas', 'tahunAjaran']);

        return view('guru.nilai.show', compact('nilai'));
    }

    public function edit(Nilai $nilai)
    {
        $guruId = $this->getGuruId();
        abort_if($nilai->guru_id !== $guruId, 403, 'Anda tidak memiliki akses ke data nilai ini.');

        $siswaList   = Siswa::aktif()->orderBy('nama_lengkap')->get();
        $kelasList   = Kelas::aktif()->orderBy('nama_kelas')->get();
        $mapelList   = MataPelajaran::aktif()->orderBy('nama_mapel')->get();
        $tahunAjaran = TahunAjaran::orderByDesc('tahun')->get();

        return view('guru.nilai.edit',
            compact('nilai', 'siswaList', 'kelasList', 'mapelList', 'tahunAjaran'));
    }

    public function update(Request $request, Nilai $nilai)
    {
        $guruId = $this->getGuruId();
        abort_if($nilai->guru_id !== $guruId, 403, 'Anda tidak memiliki akses ke data nilai ini.');

        $validated = $request->validate([
            'nilai_tugas'  => ['nullable', 'numeric', 'min:0', 'max:100'],
            'nilai_harian' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'nilai_uts'    => ['nullable', 'numeric', 'min:0', 'max:100'],
            'nilai_uas'    => ['nullable', 'numeric', 'min:0', 'max:100'],
            'catatan'      => ['nullable', 'string', 'max:500'],
        ], $this->messages());

        $nilai->update($validated);

        return redirect()->route('guru.nilai.show', $nilai)
            ->with('success', 'Nilai berhasil diperbarui.');
    }

    public function destroy(Nilai $nilai)
    {
        $guruId = $this->getGuruId();
        abort_if($nilai->guru_id !== $guruId, 403, 'Anda tidak memiliki akses ke data nilai ini.');

        $nilai->delete();

        return redirect()->route('guru.nilai.index')
            ->with('success', 'Nilai berhasil dihapus.');
    }

    private function messages(): array
    {
        return [
            'siswa_id.required'          => 'Siswa wajib dipilih.',
            'siswa_id.exists'            => 'Siswa yang dipilih tidak valid.',
            'mata_pelajaran_id.required' => 'Mata pelajaran wajib dipilih.',
            'mata_pelajaran_id.exists'   => 'Mata pelajaran yang dipilih tidak valid.',
            'kelas_id.required'          => 'Kelas wajib dipilih.',
            'kelas_id.exists'            => 'Kelas yang dipilih tidak valid.',
            'tahun_ajaran_id.required'   => 'Tahun ajaran wajib dipilih.',
            'tahun_ajaran_id.exists'     => 'Tahun ajaran yang dipilih tidak valid.',
            'nilai_tugas.numeric'        => 'Nilai tugas harus berupa angka.',
            'nilai_tugas.min'            => 'Nilai tugas minimal 0.',
            'nilai_tugas.max'            => 'Nilai tugas maksimal 100.',
            'nilai_harian.numeric'       => 'Nilai harian harus berupa angka.',
            'nilai_harian.min'           => 'Nilai harian minimal 0.',
            'nilai_harian.max'           => 'Nilai harian maksimal 100.',
            'nilai_uts.numeric'          => 'Nilai UTS harus berupa angka.',
            'nilai_uts.min'              => 'Nilai UTS minimal 0.',
            'nilai_uts.max'              => 'Nilai UTS maksimal 100.',
            'nilai_uas.numeric'          => 'Nilai UAS harus berupa angka.',
            'nilai_uas.min'              => 'Nilai UAS minimal 0.',
            'nilai_uas.max'              => 'Nilai UAS maksimal 100.',
            'catatan.max'                => 'Catatan maksimal 500 karakter.',
        ];
    }
}