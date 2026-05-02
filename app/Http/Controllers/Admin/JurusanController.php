<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class JurusanController extends Controller
{
    /**
     * GET /admin/jurusan
     */
    public function index(Request $request)
    {
        $query = Jurusan::query()
            ->when($request->search, fn($q) =>
                $q->where('nama', 'like', "%{$request->search}%")
                  ->orWhere('singkatan', 'like', "%{$request->search}%")
                  ->orWhere('kode_jurusan', 'like', "%{$request->search}%")
            )
            ->when($request->status, fn($q) => match($request->status) {
                'published' => $q->where('is_published', true),
                'draft'     => $q->where('is_published', false),
                default     => $q,
            })
            ->when($request->penerimaan, fn($q) => match($request->penerimaan) {
                'buka'   => $q->where('is_penerimaan_buka', true),
                'tutup'  => $q->where('is_penerimaan_buka', false),
                default  => $q,
            });

        $jurusan = $query->orderBy('urutan')->paginate(15)->withQueryString();

        return view('Admin.Jurusan.index', compact('jurusan'));
    }

    /**
     * GET /admin/jurusan/create
     */
    public function create()
    {
        return view('Admin.Jurusan.create');
    }

    /**
     * POST /admin/jurusan
     */
    public function store(Request $request)
    {
        $validated = $this->validasiJurusan($request);
        $validated['slug']       = Str::slug($validated['nama']);
        $validated['created_by'] = Auth::id();
        $validated['urutan']     = Jurusan::max('urutan') + 1;

        $this->prosesUpload($request, $validated);

        Jurusan::create($validated);

        return redirect()
            ->route('admin.jurusan.index')
            ->with('success', 'Jurusan "' . $validated['nama'] . '" berhasil ditambahkan.');
    }

    /**
     * GET /admin/jurusan/{jurusan}
     */
    public function show(Jurusan $jurusan)
    {
        $jurusan->load([
            'kurikulum',
            'kompetensi',
            'prospekKerja',
            'fasilitas',
            'createdBy',
        ]);

        $stats = [
            'kurikulum'     => $jurusan->kurikulum->count(),
            'kompetensi'    => $jurusan->kompetensi->count(),
            'prospek_kerja' => $jurusan->prospekKerja->count(),
            'fasilitas'     => $jurusan->fasilitas->count(),
        ];

        return view('Admin.Jurusan.show', compact('jurusan', 'stats'));
    }

    /**
     * GET /admin/jurusan/{jurusan}/edit
     */
    public function edit(Jurusan $jurusan)
    {
        return view('Admin.Jurusan.edit', compact('jurusan'));
    }

    /**
     * PUT /admin/jurusan/{jurusan}
     */
    public function update(Request $request, Jurusan $jurusan)
    {
        $validated         = $this->validasiJurusan($request, $jurusan->id);
        $validated['slug'] = Str::slug($validated['nama']);

        $this->prosesUpload($request, $validated, $jurusan);

        $jurusan->update($validated);

        return redirect()
            ->route('admin.jurusan.index')
            ->with('success', 'Jurusan "' . $jurusan->nama . '" berhasil diperbarui.');
    }

    /**
     * DELETE /admin/jurusan/{jurusan}
     */
    public function destroy(Jurusan $jurusan)
    {
        foreach (['foto_cover_path', 'logo_path', 'foto_kajur_path'] as $col) {
            if ($jurusan->$col) {
                Storage::disk('public')->delete($jurusan->$col);
            }
        }

        $nama = $jurusan->nama;
        $jurusan->delete();

        return redirect()
            ->route('admin.jurusan.index')
            ->with('success', 'Jurusan "' . $nama . '" berhasil dihapus.');
    }

    /**
     * PATCH /admin/jurusan/{jurusan}/toggle-publish
     */
    public function togglePublish(Jurusan $jurusan)
    {
        $jurusan->update(['is_published' => !$jurusan->is_published]);

        $label = $jurusan->is_published ? 'dipublikasikan' : 'disembunyikan';

        return back()->with('success', "Jurusan \"{$jurusan->nama}\" berhasil {$label}.");
    }

    /**
     * PATCH /admin/jurusan/{jurusan}/toggle-penerimaan
     */
    public function togglePenerimaan(Jurusan $jurusan)
    {
        $jurusan->update(['is_penerimaan_buka' => !$jurusan->is_penerimaan_buka]);

        $label = $jurusan->is_penerimaan_buka ? 'dibuka' : 'ditutup';

        return back()->with('success', "Penerimaan jurusan \"{$jurusan->nama}\" berhasil {$label}.");
    }

    /**
     * POST /admin/jurusan/reorder
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'integer|exists:jurusan,id',
        ]);

        foreach ($request->ids as $urutan => $id) {
            Jurusan::where('id', $id)->update(['urutan' => $urutan + 1]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * GET /admin/jurusan/export/pdf
     */
    public function exportPdf()
    {
        $jurusan = Jurusan::published()->get();

        // Uncomment setelah install barryvdh/laravel-dompdf:
        // $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('Admin.Jurusan.export-pdf', compact('jurusan'));
        // return $pdf->download('data-jurusan.pdf');

        return back()->with('info', 'Fitur export PDF membutuhkan package barryvdh/laravel-dompdf.');
    }

    /**
     * GET /admin/jurusan/export/excel
     */
    public function exportExcel()
    {
        // Uncomment setelah install maatwebsite/excel:
        // return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\JurusanExport, 'data-jurusan.xlsx');

        return back()->with('info', 'Fitur export Excel membutuhkan package maatwebsite/excel.');
    }

    // =========================================================================
    // PRIVATE HELPERS
    // =========================================================================

    private function validasiJurusan(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'nama'                => 'required|string|max:255',
            'singkatan'           => 'nullable|string|max:20',
            'kode_jurusan'        => 'nullable|string|max:20',
            'bidang_keahlian'     => 'nullable|string|max:255',
            'program_keahlian'    => 'nullable|string|max:255',
            'kompetensi_keahlian' => 'nullable|string|max:255',
            'deskripsi_singkat'   => 'nullable|string',
            'deskripsi_lengkap'   => 'nullable|string',
            'tujuan_jurusan'      => 'nullable|string',
            'lama_belajar'        => 'nullable|integer|min:1|max:6',
            'akreditasi'          => 'nullable|string|max:5',
            'kapasitas_per_kelas' => 'nullable|integer|min:1|max:100',
            'jumlah_kelas_aktif'  => 'nullable|integer|min:0',
            'total_siswa'         => 'nullable|integer|min:0',
            'nama_kajur'          => 'nullable|string|max:255',
            'is_published'        => 'boolean',
            'is_penerimaan_buka'  => 'boolean',
            'urutan'              => 'nullable|integer|min:0',
            // Upload
            'foto_cover'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'logo'                => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:1024',
            'foto_kajur'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            // URL fallback
            'foto_cover_url'      => 'nullable|url|max:255',
            'logo_url'            => 'nullable|url|max:255',
            'foto_kajur_url'      => 'nullable|url|max:255',
        ]);
    }

    private function prosesUpload(Request $request, array &$validated, ?Jurusan $existing = null): void
    {
        $map = [
            'foto_cover' => 'foto_cover_path',
            'logo'       => 'logo_path',
            'foto_kajur' => 'foto_kajur_path',
        ];

        foreach ($map as $input => $column) {
            if ($request->hasFile($input)) {
                if ($existing && $existing->$column) {
                    Storage::disk('public')->delete($existing->$column);
                }
                $validated[$column] = $request->file($input)
                    ->store("jurusan/{$input}", 'public');
                unset($validated[$input]);
            }
        }
    }
}