<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\TahunAjaran;
use App\Models\Tugas;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TugasExport;
use App\Imports\TugasImport;

class TugasController extends Controller
{
    public function index(Request $request)
    {
        $query = Tugas::with(['guru', 'mataPelajaran', 'kelas', 'tahunAjaran'])->withTrashed();

        if ($request->filled('guru_id')) {
            $query->where('guru_id', $request->guru_id);
        }
        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }
        if ($request->filled('mata_pelajaran_id')) {
            $query->where('mata_pelajaran_id', $request->mata_pelajaran_id);
        }
        if ($request->filled('dipublikasikan')) {
            $query->where('dipublikasikan', $request->boolean('dipublikasikan'));
        }
        if ($request->filled('search')) {
            $query->where('judul', 'like', "%{$request->search}%");
        }

        $tugas     = $query->latest()->paginate(20)->withQueryString();
        $guruList  = Guru::aktif()->orderBy('nama_lengkap')->get();
        $kelasList = Kelas::aktif()->orderBy('nama_kelas')->get();
        $mapelList = MataPelajaran::aktif()->orderBy('nama_mapel')->get();

        return view('admin.tugas.index',
            compact('tugas', 'guruList', 'kelasList', 'mapelList'));
    }

    public function create()
    {
        $guruList         = Guru::aktif()->orderBy('nama_lengkap')->get();
        $kelasList        = Kelas::aktif()->orderBy('nama_kelas')->get();
        $mapelList        = MataPelajaran::aktif()->orderBy('nama_mapel')->get();
        $tahunAjaran      = TahunAjaran::orderByDesc('tahun')->get();
        $jenisPengumpulan = ['file', 'teks', 'link', 'foto'];

        return view('admin.tugas.create',
            compact('guruList', 'kelasList', 'mapelList', 'tahunAjaran', 'jenisPengumpulan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'guru_id'           => ['required', 'exists:guru,id'],
            'mata_pelajaran_id' => ['required', 'exists:mata_pelajaran,id'],
            'kelas_id'          => ['required', 'exists:kelas,id'],
            'tahun_ajaran_id'   => ['required', 'exists:tahun_ajaran,id'],
            'judul'             => ['required', 'string', 'max:255'],
            'deskripsi'         => ['nullable', 'string', 'max:5000'],
            'path_file_soal'    => ['nullable', 'file', 'max:10240'],
            'jenis_pengumpulan' => ['required', Rule::in(['file', 'teks', 'link', 'foto'])],
            'batas_waktu'       => ['required', 'date', 'after:now'],
            'nilai_maksimal'    => ['nullable', 'numeric', 'min:0', 'max:100'],
            'izinkan_terlambat' => ['boolean'],
            'dipublikasikan'    => ['boolean'],
        ], $this->messages());

        if ($request->hasFile('path_file_soal')) {
            $validated['path_file_soal'] = $request->file('path_file_soal')
                ->store('tugas/soal', 'public');
        }

        Tugas::create($validated);

        return redirect()->route('admin.tugas.index')
            ->with('success', 'Tugas berhasil ditambahkan.');
    }

    public function show(Tugas $tugas)
    {
        $tugas->load(['guru', 'mataPelajaran', 'kelas', 'tahunAjaran', 'pengumpulan.siswa']);

        $stats = [
            'total_siswa'   => $tugas->kelas->siswa()->count(),
            'terkumpul'     => $tugas->jumlah_terkumpul,
            'sudah_dinilai' => $tugas->pengumpulan()->where('status', 'dinilai')->count(),
        ];

        return view('admin.tugas.show', compact('tugas', 'stats'));
    }

    public function edit(Tugas $tugas)
    {
        $guruList         = Guru::aktif()->orderBy('nama_lengkap')->get();
        $kelasList        = Kelas::aktif()->orderBy('nama_kelas')->get();
        $mapelList        = MataPelajaran::aktif()->orderBy('nama_mapel')->get();
        $tahunAjaran      = TahunAjaran::orderByDesc('tahun')->get();
        $jenisPengumpulan = ['file', 'teks', 'link', 'foto'];

        return view('admin.tugas.edit',
            compact('tugas', 'guruList', 'kelasList', 'mapelList', 'tahunAjaran', 'jenisPengumpulan'));
    }

    public function update(Request $request, Tugas $tugas)
    {
        $validated = $request->validate([
            'guru_id'           => ['required', 'exists:guru,id'],
            'mata_pelajaran_id' => ['required', 'exists:mata_pelajaran,id'],
            'kelas_id'          => ['required', 'exists:kelas,id'],
            'tahun_ajaran_id'   => ['required', 'exists:tahun_ajaran,id'],
            'judul'             => ['required', 'string', 'max:255'],
            'deskripsi'         => ['nullable', 'string', 'max:5000'],
            'path_file_soal'    => ['nullable', 'file', 'max:10240'],
            'jenis_pengumpulan' => ['required', Rule::in(['file', 'teks', 'link', 'foto'])],
            'batas_waktu'       => ['required', 'date'],
            'nilai_maksimal'    => ['nullable', 'numeric', 'min:0', 'max:100'],
            'izinkan_terlambat' => ['boolean'],
            'dipublikasikan'    => ['boolean'],
        ], $this->messages());

        if ($request->hasFile('path_file_soal')) {
            if ($tugas->path_file_soal) {
                Storage::disk('public')->delete($tugas->path_file_soal);
            }
            $validated['path_file_soal'] = $request->file('path_file_soal')
                ->store('tugas/soal', 'public');
        }

        $tugas->update($validated);

        return redirect()->route('admin.tugas.show', $tugas)
            ->with('success', 'Tugas berhasil diperbarui.');
    }

    public function destroy(Tugas $tugas)
    {
        $tugas->delete();

        return redirect()->route('admin.tugas.index')
            ->with('success', 'Tugas berhasil dihapus.');
    }

    public function restore(int $id)
    {
        $tugas = Tugas::onlyTrashed()->findOrFail($id);
        $tugas->restore();

        return back()->with('success', 'Tugas berhasil dipulihkan.');
    }

    public function toggleStatus(Tugas $tugas)
    {
        $tugas->update(['dipublikasikan' => !$tugas->dipublikasikan]);
        $status = $tugas->dipublikasikan ? 'dipublikasikan' : 'disembunyikan';

        return back()->with('success', "Tugas berhasil {$status}.");
    }

    public function exportPdf(Request $request)
    {
        $query = Tugas::with(['guru', 'mataPelajaran', 'kelas', 'tahunAjaran']);

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        $tugas = $query->latest()->get();

        $pdf = Pdf::loadView('admin.tugas.export-pdf', compact('tugas'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('data-tugas-' . now()->format('YmdHis') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new TugasExport($request->all()),
            'data-tugas-' . now()->format('YmdHis') . '.xlsx'
        );
    }

    public function importTemplate()
    {
        return Excel::download(
            new \App\Exports\TugasTemplateExport(),
            'template-tugas.xlsx'
        );
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
            Excel::import(new TugasImport(), $request->file('file'));
            return back()->with('success', 'Data tugas berhasil diimpor.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengimpor data: ' . $e->getMessage());
        }
    }

    private function messages(): array
    {
        return [
            'guru_id.required'           => 'Guru wajib dipilih.',
            'guru_id.exists'             => 'Guru yang dipilih tidak valid.',
            'mata_pelajaran_id.required' => 'Mata pelajaran wajib dipilih.',
            'mata_pelajaran_id.exists'   => 'Mata pelajaran yang dipilih tidak valid.',
            'kelas_id.required'          => 'Kelas wajib dipilih.',
            'kelas_id.exists'            => 'Kelas yang dipilih tidak valid.',
            'tahun_ajaran_id.required'   => 'Tahun ajaran wajib dipilih.',
            'tahun_ajaran_id.exists'     => 'Tahun ajaran yang dipilih tidak valid.',
            'judul.required'             => 'Judul tugas wajib diisi.',
            'judul.max'                  => 'Judul tugas maksimal 255 karakter.',
            'jenis_pengumpulan.required' => 'Jenis pengumpulan wajib dipilih.',
            'jenis_pengumpulan.in'       => 'Jenis pengumpulan tidak valid.',
            'batas_waktu.required'       => 'Batas waktu pengumpulan wajib diisi.',
            'batas_waktu.date'           => 'Format batas waktu tidak valid.',
            'batas_waktu.after'          => 'Batas waktu harus setelah waktu sekarang.',
            'nilai_maksimal.numeric'     => 'Nilai maksimal harus berupa angka.',
            'nilai_maksimal.min'         => 'Nilai maksimal tidak boleh negatif.',
            'nilai_maksimal.max'         => 'Nilai maksimal tidak boleh lebih dari 100.',
            'path_file_soal.max'         => 'Ukuran file soal maksimal 10MB.',
        ];
    }
}