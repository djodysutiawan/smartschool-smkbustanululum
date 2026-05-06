<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Materi;
use App\Models\MataPelajaran;
use App\Models\TahunAjaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MateriExport;
use App\Imports\MateriImport;

class MateriController extends Controller
{
    public function index(Request $request)
    {
        $query = Materi::with(['guru', 'mataPelajaran', 'kelas', 'tahunAjaran'])->withTrashed();

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

        $materi    = $query->orderBy('urutan')->latest()->paginate(20)->withQueryString();
        $guruList  = Guru::aktif()->orderBy('nama_lengkap')->get();
        $kelasList = Kelas::aktif()->orderBy('nama_kelas')->get();
        $mapelList = MataPelajaran::aktif()->orderBy('nama_mapel')->get();

        return view('admin.materi.index', compact('materi', 'guruList', 'kelasList', 'mapelList'));
    }

    public function create()
    {
        $guruList    = Guru::aktif()->orderBy('nama_lengkap')->get();
        $kelasList   = Kelas::aktif()->orderBy('nama_kelas')->get();
        $mapelList   = MataPelajaran::aktif()->orderBy('nama_mapel')->get();
        $tahunAjaran = TahunAjaran::orderByDesc('tahun')->get();
        $tahunAktif  = TahunAjaran::getAktif();
        $jenisMateri = ['file', 'video', 'link', 'teks'];

        return view('admin.materi.create',
            compact('guruList', 'kelasList', 'mapelList', 'tahunAjaran', 'tahunAktif', 'jenisMateri'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'guru_id'           => ['required', 'exists:guru,id'],
            'mata_pelajaran_id' => ['required', 'exists:mata_pelajaran,id'],
            'kelas_id'          => ['required', 'exists:kelas,id'],
            'tahun_ajaran_id'   => ['required', 'exists:tahun_ajaran,id'],
            'judul'             => ['required', 'string', 'max:255'],
            'deskripsi'         => ['nullable', 'string', 'max:2000'],
            'jenis'             => ['required', Rule::in(['file', 'video', 'link', 'teks'])],
            'path_file'         => ['nullable', 'file', 'max:51200'],
            'url_eksternal'     => ['nullable', 'url', 'max:500'],
            'thumbnail'         => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'urutan'            => ['nullable', 'integer', 'min:0'],
            'dipublikasikan'    => ['boolean'],
        ], $this->messages());

        if ($request->hasFile('path_file')) {
            $validated['path_file'] = $request->file('path_file')->store('materi', 'public');
        }
        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('materi/thumbnails', 'public');
        }
        if (!empty($validated['dipublikasikan'])) {
            $validated['dipublikasikan_pada'] = now();
        }

        Materi::create($validated);

        return redirect()->route('admin.materi.index')
            ->with('success', 'Materi berhasil ditambahkan.');
    }

    public function show(Materi $materi)
    {
        $materi->load(['guru', 'mataPelajaran', 'kelas', 'tahunAjaran']);

        return view('admin.materi.show', compact('materi'));
    }

    public function edit(Materi $materi)
    {
        $guruList    = Guru::aktif()->orderBy('nama_lengkap')->get();
        $kelasList   = Kelas::aktif()->orderBy('nama_kelas')->get();
        $mapelList   = MataPelajaran::aktif()->orderBy('nama_mapel')->get();
        $tahunAjaran = TahunAjaran::orderByDesc('tahun')->get();
        $jenisMateri = ['file', 'video', 'link', 'teks'];

        // Mapel & kelas milik guru ini (untuk pre-populate saat edit)
        $mapelGuru = $this->_getMapelByGuru($materi->guru_id);
        $kelasGuru = $this->_getKelasByGuru($materi->guru_id);

        return view('admin.materi.edit',
            compact('materi', 'guruList', 'kelasList', 'mapelList', 'tahunAjaran', 'jenisMateri', 'mapelGuru', 'kelasGuru'));
    }

    public function update(Request $request, Materi $materi)
    {
        $validated = $request->validate([
            'guru_id'           => ['required', 'exists:guru,id'],
            'mata_pelajaran_id' => ['required', 'exists:mata_pelajaran,id'],
            'kelas_id'          => ['required', 'exists:kelas,id'],
            'tahun_ajaran_id'   => ['required', 'exists:tahun_ajaran,id'],
            'judul'             => ['required', 'string', 'max:255'],
            'deskripsi'         => ['nullable', 'string', 'max:2000'],
            'jenis'             => ['required', Rule::in(['file', 'video', 'link', 'teks'])],
            'path_file'         => ['nullable', 'file', 'max:51200'],
            'url_eksternal'     => ['nullable', 'url', 'max:500'],
            'thumbnail'         => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'urutan'            => ['nullable', 'integer', 'min:0'],
            'dipublikasikan'    => ['boolean'],
        ], $this->messages());

        if ($request->hasFile('path_file')) {
            if ($materi->path_file) {
                Storage::disk('public')->delete($materi->path_file);
            }
            $validated['path_file'] = $request->file('path_file')->store('materi', 'public');
        }
        if ($request->hasFile('thumbnail')) {
            if ($materi->thumbnail) {
                Storage::disk('public')->delete($materi->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('materi/thumbnails', 'public');
        }

        if (!empty($validated['dipublikasikan']) && !$materi->dipublikasikan) {
            $validated['dipublikasikan_pada'] = now();
        } elseif (empty($validated['dipublikasikan'])) {
            $validated['dipublikasikan_pada'] = null;
        }

        $materi->update($validated);

        return redirect()->route('admin.materi.show', $materi)
            ->with('success', 'Materi berhasil diperbarui.');
    }

    public function destroy(Materi $materi)
    {
        $materi->delete();

        return redirect()->route('admin.materi.index')
            ->with('success', 'Materi berhasil dihapus.');
    }

    public function restore(int $id)
    {
        $materi = Materi::onlyTrashed()->findOrFail($id);
        $materi->restore();

        return back()->with('success', 'Materi berhasil dipulihkan.');
    }

    public function togglePublish(Materi $materi)
    {
        if ($materi->dipublikasikan) {
            $materi->update([
                'dipublikasikan'      => false,
                'dipublikasikan_pada' => null,
            ]);
            $status = 'disembunyikan';
        } else {
            $materi->update([
                'dipublikasikan'      => true,
                'dipublikasikan_pada' => now(),
            ]);
            $status = 'dipublikasikan';
        }

        return back()->with('success', "Materi berhasil {$status}.");
    }

    // ─────────────────────────────────────────────────────────────────────────
    // AJAX — Cascade Dropdown
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * GET /admin/materi/ajax/mapel-by-guru/{guru}
     * Kembalikan daftar mata pelajaran yang diampu guru (via pivot guru_mata_pelajaran).
     * Fallback: semua mapel aktif jika guru tidak punya data pivot.
     */
    public function ajaxMapelByGuru(Guru $guru)
    {
        $mapel = $this->_getMapelByGuru($guru->id);
        return response()->json($mapel);
    }

    /**
     * GET /admin/materi/ajax/kelas-by-guru/{guru}
     * Kembalikan daftar kelas yang diajar guru (via jadwal_pelajaran aktif).
     * Fallback: semua kelas aktif jika guru tidak punya jadwal.
     */
    public function ajaxKelasByGuru(Guru $guru)
    {
        $kelas = $this->_getKelasByGuru($guru->id);
        return response()->json($kelas);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Export / Import
    // ─────────────────────────────────────────────────────────────────────────

    public function exportPdf(Request $request)
    {
        $query = Materi::with(['guru', 'mataPelajaran', 'kelas', 'tahunAjaran']);

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        $materi = $query->orderBy('urutan')->get();

        $pdf = Pdf::loadView('admin.materi.export-pdf', compact('materi'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('data-materi-' . now()->format('YmdHis') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new MateriExport($request->all()),
            'data-materi-' . now()->format('YmdHis') . '.xlsx'
        );
    }

    public function importTemplate()
    {
        return Excel::download(
            new \App\Exports\MateriTemplateExport(),
            'template-materi.xlsx'
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
            Excel::import(new MateriImport(), $request->file('file'));
            return back()->with('success', 'Data materi berhasil diimpor.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengimpor data: ' . $e->getMessage());
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Private Helpers
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Ambil mapel yang diampu guru via pivot guru_mata_pelajaran.
     * Fallback: semua mapel aktif jika pivot kosong.
     */
    private function _getMapelByGuru(int $guruId): \Illuminate\Support\Collection
    {
        $guru = Guru::find($guruId);

        if (!$guru) {
            return MataPelajaran::aktif()->orderBy('nama_mapel')->get(['id', 'nama_mapel', 'kode_mapel']);
        }

        try {
            $mapel = $guru->mataPelajaran()
                ->where('guru_mata_pelajaran.is_active', true)
                ->where('mata_pelajaran.is_active', true)
                ->orderBy('nama_mapel')
                ->get(['mata_pelajaran.id', 'mata_pelajaran.nama_mapel', 'mata_pelajaran.kode_mapel']);
        } catch (\Exception $e) {
            $mapel = collect();
        }

        if ($mapel->isEmpty()) {
            $mapel = MataPelajaran::aktif()->orderBy('nama_mapel')->get(['id', 'nama_mapel', 'kode_mapel']);
        }

        return $mapel;
    }

    /**
     * Ambil kelas yang diajar guru via jadwal_pelajaran aktif.
     * Fallback: semua kelas aktif jika jadwal kosong.
     */
    private function _getKelasByGuru(int $guruId): \Illuminate\Support\Collection
    {
        $kelasIds = DB::table('jadwal_pelajaran')
            ->where('guru_id', $guruId)
            ->where('is_active', true)
            ->pluck('kelas_id')
            ->unique();

        if ($kelasIds->isNotEmpty()) {
            $kelas = Kelas::whereIn('id', $kelasIds)
                ->where('status', 'aktif')
                ->orderBy('nama_kelas')
                ->get(['id', 'nama_kelas', 'tingkat', 'kode_kelas']);
        } else {
            $kelas = collect();
        }

        if ($kelas->isEmpty()) {
            $kelas = Kelas::aktif()->orderBy('nama_kelas')->get(['id', 'nama_kelas', 'tingkat', 'kode_kelas']);
        }

        return $kelas;
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
            'judul.required'             => 'Judul materi wajib diisi.',
            'judul.max'                  => 'Judul materi maksimal 255 karakter.',
            'jenis.required'             => 'Jenis materi wajib dipilih.',
            'jenis.in'                   => 'Jenis materi tidak valid.',
            'url_eksternal.url'          => 'Format URL eksternal tidak valid.',
            'url_eksternal.max'          => 'URL eksternal maksimal 500 karakter.',
            'thumbnail.image'            => 'Thumbnail harus berupa gambar.',
            'thumbnail.mimes'            => 'Format thumbnail harus jpg, jpeg, atau png.',
            'thumbnail.max'              => 'Ukuran thumbnail maksimal 2MB.',
            'path_file.max'              => 'Ukuran file materi maksimal 50MB.',
            'urutan.integer'             => 'Urutan harus berupa angka.',
            'urutan.min'                 => 'Urutan tidak boleh negatif.',
        ];
    }
}