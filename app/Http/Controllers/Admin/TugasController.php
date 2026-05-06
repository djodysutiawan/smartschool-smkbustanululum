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
    // ─────────────────────────────────────────────
    //  INDEX
    // ─────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = Tugas::with(['guru', 'mataPelajaran', 'kelas', 'tahunAjaran'])->withTrashed();

        if ($request->filled('guru_id'))           $query->where('guru_id', $request->guru_id);
        if ($request->filled('kelas_id'))          $query->where('kelas_id', $request->kelas_id);
        if ($request->filled('mata_pelajaran_id')) $query->where('mata_pelajaran_id', $request->mata_pelajaran_id);
        if ($request->filled('dipublikasikan'))    $query->where('dipublikasikan', $request->boolean('dipublikasikan'));
        if ($request->filled('search'))            $query->where('judul', 'like', "%{$request->search}%");

        $tugas     = $query->latest()->paginate(20)->withQueryString();
        $guruList  = Guru::aktif()->orderBy('nama_lengkap')->get();
        $kelasList = Kelas::aktif()->orderBy('nama_kelas')->get();
        $mapelList = MataPelajaran::aktif()->orderBy('nama_mapel')->get();

        return view('admin.tugas.index', compact('tugas', 'guruList', 'kelasList', 'mapelList'));
    }

    // ─────────────────────────────────────────────
    //  CREATE
    // ─────────────────────────────────────────────
    public function create()
    {
        $guruList         = Guru::aktif()->orderBy('nama_lengkap')->get();
        $tahunAjaranAktif = TahunAjaran::aktif()->latest('tahun')->first();
        $tahunAjaranList  = TahunAjaran::orderByDesc('tahun')->get();
        $jenisPengumpulan = ['file', 'teks', 'link', 'foto'];

        return view('admin.tugas.create',
            compact('guruList', 'tahunAjaranAktif', 'tahunAjaranList', 'jenisPengumpulan'));
    }

    // ─────────────────────────────────────────────
    //  STORE
    // ─────────────────────────────────────────────
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

        $this->validateGuruRelasi($validated['guru_id'], $validated['mata_pelajaran_id'], $validated['kelas_id']);

        if ($request->hasFile('path_file_soal')) {
            $validated['path_file_soal'] = $request->file('path_file_soal')
                ->store('tugas/soal', 'public');
        }

        Tugas::create($validated);

        return redirect()->route('admin.tugas.index')
            ->with('success', 'Tugas berhasil ditambahkan.');
    }

    // ─────────────────────────────────────────────
    //  SHOW
    // ─────────────────────────────────────────────
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

    // ─────────────────────────────────────────────
    //  EDIT
    // ─────────────────────────────────────────────
    public function edit(Tugas $tugas)
    {
        $tugas->load('guru');

        $guruList         = Guru::aktif()->orderBy('nama_lengkap')->get();
        $tahunAjaranAktif = TahunAjaran::aktif()->latest('tahun')->first();
        $tahunAjaranList  = TahunAjaran::orderByDesc('tahun')->get();
        $jenisPengumpulan = ['file', 'teks', 'link', 'foto'];

        $kelasList = $this->getKelasByGuru($tugas->guru_id);
        $mapelList = $this->getMapelByGuru($tugas->guru_id);

        return view('admin.tugas.edit',
            compact('tugas', 'guruList', 'kelasList', 'mapelList',
                    'tahunAjaranAktif', 'tahunAjaranList', 'jenisPengumpulan'));
    }

    // ─────────────────────────────────────────────
    //  UPDATE
    // ─────────────────────────────────────────────
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

        $this->validateGuruRelasi($validated['guru_id'], $validated['mata_pelajaran_id'], $validated['kelas_id']);

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

    // ─────────────────────────────────────────────
    //  DESTROY / RESTORE / TOGGLE
    // ─────────────────────────────────────────────
    public function destroy(Tugas $tugas)
    {
        $tugas->delete();
        return redirect()->route('admin.tugas.index')->with('success', 'Tugas berhasil dihapus.');
    }

    public function restore(int $id)
    {
        Tugas::onlyTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'Tugas berhasil dipulihkan.');
    }

    public function toggleStatus(Tugas $tugas)
    {
        $tugas->update(['dipublikasikan' => !$tugas->dipublikasikan]);
        $status = $tugas->dipublikasikan ? 'dipublikasikan' : 'disembunyikan';
        return back()->with('success', "Tugas berhasil {$status}.");
    }

    // ─────────────────────────────────────────────
    //  EXPORT / IMPORT
    // ─────────────────────────────────────────────
    public function exportPdf(Request $request)
    {
        $query = Tugas::with(['guru', 'mataPelajaran', 'kelas', 'tahunAjaran']);
        if ($request->filled('kelas_id')) $query->where('kelas_id', $request->kelas_id);
        $tugas = $query->latest()->get();

        return Pdf::loadView('admin.tugas.export-pdf', compact('tugas'))
            ->setPaper('a4', 'landscape')
            ->download('data-tugas-' . now()->format('YmdHis') . '.pdf');
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
        return Excel::download(new \App\Exports\TugasTemplateExport(), 'template-tugas.xlsx');
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

    // ─────────────────────────────────────────────
    //  AJAX ENDPOINTS — Dependent Dropdown
    // ─────────────────────────────────────────────

    public function ajaxMapelByGuru(Guru $guru)
    {
        $mapel = $this->getMapelByGuru($guru->id);
        return response()->json($mapel);
    }

    public function ajaxKelasByGuru(Guru $guru)
    {
        $kelas = $this->getKelasByGuru($guru->id);
        return response()->json($kelas);
    }

    public function ajaxTahunAjaranAktif()
    {
        // ✅ FIX: pakai scopeAktif() — kolom `status` bukan `is_aktif`
        $tahun = TahunAjaran::aktif()
            ->orderByDesc('tahun')
            ->get(['id', 'tahun']);

        return response()->json($tahun);
    }

    // ─────────────────────────────────────────────
    //  PRIVATE HELPERS
    // ─────────────────────────────────────────────

    /**
     * Ambil mapel yang diampu guru ini via pivot guru_mata_pelajaran.
     * Filter: pivot is_active = true & mata_pelajaran.is_active = true
     */
    private function getMapelByGuru(int $guruId)
    {
        $guru = Guru::findOrFail($guruId);

        return $guru->mataPelajaran()
            ->where('guru_mata_pelajaran.is_active', true)
            ->where('mata_pelajaran.is_active', true)
            ->orderBy('nama_mapel')
            ->get(['mata_pelajaran.id', 'nama_mapel']);
    }

    /**
     * Ambil kelas yang diajar guru ini via jadwal_pelajaran.
     * Guru tidak punya relasi BelongsToMany ke kelas secara langsung,
     * melainkan lewat jadwal_pelajaran.
     */
    private function getKelasByGuru(int $guruId)
    {
        return Kelas::aktif()
            ->whereHas('jadwalPelajaran', function ($q) use ($guruId) {
                $q->where('guru_id', $guruId)
                  ->where('is_active', true);
            })
            ->orderBy('nama_kelas')
            ->get(['id', 'nama_kelas']);
    }

    /**
     * Validasi silang: mapel & kelas wajib sesuai guru yang dipilih.
     */
    private function validateGuruRelasi(int $guruId, int $mapelId, int $kelasId): void
    {
        $guru = Guru::findOrFail($guruId);

        // ✅ Cek mapel via pivot guru_mata_pelajaran
        $mapelValid = $guru->mataPelajaran()
            ->where('mata_pelajaran.id', $mapelId)
            ->where('guru_mata_pelajaran.is_active', true)
            ->exists();

        if (!$mapelValid) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'mata_pelajaran_id' => 'Mata pelajaran yang dipilih tidak sesuai dengan guru ini.',
            ]);
        }

        // ✅ Cek kelas via jadwal_pelajaran (bukan relasi langsung guru→kelas)
        $kelasValid = Kelas::where('id', $kelasId)
            ->whereHas('jadwalPelajaran', function ($q) use ($guruId) {
                $q->where('guru_id', $guruId)
                  ->where('is_active', true);
            })
            ->exists();

        if (!$kelasValid) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'kelas_id' => 'Kelas yang dipilih tidak sesuai dengan guru ini.',
            ]);
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