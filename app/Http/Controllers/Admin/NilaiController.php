<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NilaiExport;
use App\Exports\NilaiRaporExport;
use App\Imports\NilaiImport;

class NilaiController extends Controller
{
    public function index(Request $request)
    {
        $query = Nilai::with(['siswa', 'mataPelajaran', 'guru', 'kelas', 'tahunAjaran']);

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
            $query->whereHas('siswa', fn($q) =>
                $q->where('nama_lengkap', 'like', "%{$request->search}%")
            );
        }

        $nilai        = $query->paginate(20)->withQueryString();
        $tahunAjaran  = TahunAjaran::orderByDesc('tahun')->get();
        $kelasList    = Kelas::aktif()->orderBy('nama_kelas')->get();
        $mapelList    = MataPelajaran::aktif()->orderBy('nama_mapel')->get();
        $predikatList = ['A', 'B', 'C', 'D', 'E'];

        return view('admin.nilai.index',
            compact('nilai', 'tahunAjaran', 'kelasList', 'mapelList', 'predikatList'));
    }

    public function create()
    {
        $siswaList   = Siswa::aktif()->orderBy('nama_lengkap')->get();
        $guruList    = Guru::aktif()->orderBy('nama_lengkap')->get();
        $kelasList   = Kelas::aktif()->orderBy('nama_kelas')->get();
        $mapelList   = MataPelajaran::aktif()->orderBy('nama_mapel')->get();
        $tahunAjaran = TahunAjaran::orderByDesc('tahun')->get();

        return view('admin.nilai.create',
            compact('siswaList', 'guruList', 'kelasList', 'mapelList', 'tahunAjaran'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'siswa_id'          => ['required', 'exists:siswa,id'],
            'mata_pelajaran_id' => ['required', 'exists:mata_pelajaran,id'],
            'guru_id'           => ['required', 'exists:guru,id'],
            'kelas_id'          => ['required', 'exists:kelas,id'],
            'tahun_ajaran_id'   => ['required', 'exists:tahun_ajaran,id'],
            'nilai_tugas'       => ['nullable', 'numeric', 'min:0', 'max:100'],
            'nilai_harian'      => ['nullable', 'numeric', 'min:0', 'max:100'],
            'nilai_uts'         => ['nullable', 'numeric', 'min:0', 'max:100'],
            'nilai_uas'         => ['nullable', 'numeric', 'min:0', 'max:100'],
            'catatan'           => ['nullable', 'string', 'max:500'],
        ], $this->messages());

        $exists = Nilai::where('siswa_id', $validated['siswa_id'])
            ->where('mata_pelajaran_id', $validated['mata_pelajaran_id'])
            ->where('tahun_ajaran_id', $validated['tahun_ajaran_id'])
            ->exists();

        if ($exists) {
            return back()->withInput()
                ->with('error', 'Nilai untuk siswa dan mata pelajaran ini pada tahun ajaran yang dipilih sudah ada.');
        }

        Nilai::create($validated);

        return redirect()->route('admin.nilai.index')
            ->with('success', 'Nilai berhasil ditambahkan.');
    }

    public function show(Nilai $nilai)
    {
        $nilai->load(['siswa', 'mataPelajaran', 'guru', 'kelas', 'tahunAjaran']);

        return view('admin.nilai.show', compact('nilai'));
    }

    public function edit(Nilai $nilai)
    {
        $siswaList   = Siswa::aktif()->orderBy('nama_lengkap')->get();
        $guruList    = Guru::aktif()->orderBy('nama_lengkap')->get();
        $kelasList   = Kelas::aktif()->orderBy('nama_kelas')->get();
        $mapelList   = MataPelajaran::aktif()->orderBy('nama_mapel')->get();
        $tahunAjaran = TahunAjaran::orderByDesc('tahun')->get();

        return view('admin.nilai.edit',
            compact('nilai', 'siswaList', 'guruList', 'kelasList', 'mapelList', 'tahunAjaran'));
    }

    public function update(Request $request, Nilai $nilai)
    {
        $validated = $request->validate([
            'nilai_tugas'  => ['nullable', 'numeric', 'min:0', 'max:100'],
            'nilai_harian' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'nilai_uts'    => ['nullable', 'numeric', 'min:0', 'max:100'],
            'nilai_uas'    => ['nullable', 'numeric', 'min:0', 'max:100'],
            'catatan'      => ['nullable', 'string', 'max:500'],
        ], $this->messages());

        $nilai->update($validated);

        return redirect()->route('admin.nilai.show', $nilai)
            ->with('success', 'Nilai berhasil diperbarui.');
    }

    public function destroy(Nilai $nilai)
    {
        $nilai->delete();

        return redirect()->route('admin.nilai.index')
            ->with('success', 'Nilai berhasil dihapus.');
    }

    public function raporKelas(Request $request)
    {
        $request->validate([
            'kelas_id'        => ['required', 'exists:kelas,id'],
            'tahun_ajaran_id' => ['required', 'exists:tahun_ajaran,id'],
        ], [
            'kelas_id.required'        => 'Kelas wajib dipilih.',
            'kelas_id.exists'          => 'Kelas yang dipilih tidak valid.',
            'tahun_ajaran_id.required' => 'Tahun ajaran wajib dipilih.',
            'tahun_ajaran_id.exists'   => 'Tahun ajaran yang dipilih tidak valid.',
        ]);

        $nilai = Nilai::with(['siswa', 'mataPelajaran'])
            ->where('kelas_id', $request->kelas_id)
            ->where('tahun_ajaran_id', $request->tahun_ajaran_id)
            ->get()
            ->groupBy('siswa_id');

        $kelas       = Kelas::findOrFail($request->kelas_id);
        $tahunAjaran = TahunAjaran::findOrFail($request->tahun_ajaran_id);

        return view('admin.nilai.rapor', compact('nilai', 'kelas', 'tahunAjaran'));
    }

    public function exportPdf(Request $request)
    {
        $query = Nilai::with(['siswa', 'mataPelajaran', 'guru', 'kelas', 'tahunAjaran']);

        if ($request->filled('tahun_ajaran_id')) {
            $query->where('tahun_ajaran_id', $request->tahun_ajaran_id);
        }
        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        $nilai = $query->get();

        $pdf = Pdf::loadView('admin.nilai.export-pdf', compact('nilai'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('data-nilai-' . now()->format('YmdHis') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new NilaiExport($request->all()),
            'data-nilai-' . now()->format('YmdHis') . '.xlsx'
        );
    }

    public function exportRaporPdf(Request $request)
    {
        $request->validate([
            'kelas_id'        => ['required', 'exists:kelas,id'],
            'tahun_ajaran_id' => ['required', 'exists:tahun_ajaran,id'],
        ]);

        $nilai = Nilai::with(['siswa', 'mataPelajaran'])
            ->where('kelas_id', $request->kelas_id)
            ->where('tahun_ajaran_id', $request->tahun_ajaran_id)
            ->get()
            ->groupBy('siswa_id');

        $kelas       = Kelas::findOrFail($request->kelas_id);
        $tahunAjaran = TahunAjaran::findOrFail($request->tahun_ajaran_id);

        $pdf = Pdf::loadView('admin.nilai.rapor-pdf', compact('nilai', 'kelas', 'tahunAjaran'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('rapor-' . $kelas->nama_kelas . '-' . now()->format('YmdHis') . '.pdf');
    }

    public function exportRaporExcel(Request $request)
    {
        return Excel::download(
            new NilaiRaporExport($request->kelas_id, $request->tahun_ajaran_id),
            'rapor-kelas-' . now()->format('YmdHis') . '.xlsx'
        );
    }

    public function importTemplate()
    {
        return Excel::download(new \App\Exports\NilaiTemplateExport(), 'template-nilai.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls', 'max:5120'],
        ], [
            'file.required' => 'File impor wajib diunggah.',
            'file.mimes'    => 'Format file harus berupa Excel (.xlsx atau .xls).',
            'file.max'      => 'Ukuran file tidak boleh lebih dari 5MB.',
        ]);

        try {
            Excel::import(new NilaiImport(), $request->file('file'));
            return back()->with('success', 'Data nilai berhasil diimpor.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengimpor data: ' . $e->getMessage());
        }
    }

    private function messages(): array
    {
        return [
            'siswa_id.required'          => 'Siswa wajib dipilih.',
            'siswa_id.exists'            => 'Siswa yang dipilih tidak valid.',
            'mata_pelajaran_id.required' => 'Mata pelajaran wajib dipilih.',
            'mata_pelajaran_id.exists'   => 'Mata pelajaran yang dipilih tidak valid.',
            'guru_id.required'           => 'Guru wajib dipilih.',
            'guru_id.exists'             => 'Guru yang dipilih tidak valid.',
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