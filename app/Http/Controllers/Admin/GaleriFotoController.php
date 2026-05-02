<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GaleriFoto;
use App\Models\GaleriKategori;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GaleriFotoController extends Controller
{
    public function index(Request $request)
    {
        $foto = GaleriFoto::with('kategori')
            ->when($request->kategori_id, fn($q) => $q->where('galeri_kategori_id', $request->kategori_id))
            ->when($request->featured, fn($q) => $q->where('is_featured', true))
            ->orderBy('urutan')
            ->paginate(24);
        $kategori = GaleriKategori::published()->get();
        return view('Admin.GaleriFoto.index', compact('foto', 'kategori'));
    }

    public function create()
    {
        $kategori = GaleriKategori::published()->get();
        return view('Admin.GaleriFoto.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $data = $this->validateFoto($request);

        /** @var User $user */
        $user = Auth::user();
        $data['uploaded_by'] = $user->id;

        // Fallback urutan jika tidak diisi
        if (empty($data['urutan'])) {
            $data['urutan'] = GaleriFoto::max('urutan') + 1;
        }

        if ($request->hasFile('foto')) {
            $data['foto_path'] = $request->file('foto')->store('galeri/foto', 'public');
            unset($data['foto']);
        }
        GaleriFoto::create($data);
        return redirect()->route('admin.galeri.foto.index')
            ->with('success', 'Foto berhasil diunggah.');
    }

    public function edit(GaleriFoto $galeriFoto)
    {
        $kategori = GaleriKategori::published()->get();
        return view('Admin.GaleriFoto.edit', compact('galeriFoto', 'kategori'));
    }

    public function update(Request $request, GaleriFoto $galeriFoto)
    {
        $data = $this->validateFoto($request);
        if ($request->hasFile('foto')) {
            if ($galeriFoto->foto_path) Storage::delete($galeriFoto->foto_path);
            $data['foto_path'] = $request->file('foto')->store('galeri/foto', 'public');
            unset($data['foto']);
        }
        $galeriFoto->update($data);
        return redirect()->route('admin.galeri.foto.index')
            ->with('success', 'Foto berhasil diperbarui.');
    }

    public function destroy(GaleriFoto $galeriFoto)
    {
        if ($galeriFoto->foto_path) Storage::delete($galeriFoto->foto_path);
        if ($galeriFoto->foto_thumbnail_path) Storage::delete($galeriFoto->foto_thumbnail_path);
        $galeriFoto->delete();
        return back()->with('success', 'Foto berhasil dihapus.');
    }

    public function togglePublish(GaleriFoto $galeriFoto)
    {
        $galeriFoto->update(['is_published' => !$galeriFoto->is_published]);
        return back()->with('success', 'Status foto diperbarui.');
    }

    public function toggleFeatured(GaleriFoto $galeriFoto)
    {
        $galeriFoto->update(['is_featured' => !$galeriFoto->is_featured]);
        return back()->with('success', 'Status unggulan foto diperbarui.');
    }

    public function bulkUpload(Request $request)
    {
        $request->validate([
            'galeri_kategori_id' => 'required|exists:galeri_kategori,id',
            'foto.*'             => 'required|image|max:3072',
        ]);

        /** @var User $user */
        $user = Auth::user();

        $urutan = GaleriFoto::max('urutan') + 1; // ← tambah ini

        $count = 0;
        foreach ($request->file('foto', []) as $file) {
            GaleriFoto::create([
                'galeri_kategori_id' => $request->galeri_kategori_id,
                'judul'              => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                'foto_path'          => $file->store('galeri/foto', 'public'),
                'is_published'       => true,
                'uploaded_by'        => $user->id,
                'urutan'             => $urutan++, // ← tambah ini
            ]);
            $count++;
        }
        return back()->with('success', "{$count} foto berhasil diunggah.");
    }

    public function bulkDelete(Request $request)
    {
        $request->validate(['ids' => 'required|array', 'ids.*' => 'exists:galeri_foto,id']);
        $foto = GaleriFoto::whereIn('id', $request->ids)->get();
        foreach ($foto as $f) {
            if ($f->foto_path) Storage::delete($f->foto_path);
            if ($f->foto_thumbnail_path) Storage::delete($f->foto_thumbnail_path);
            $f->delete();
        }
        return back()->with('success', count($request->ids) . ' foto berhasil dihapus.');
    }

    public function reorder(Request $request)
    {
        $request->validate(['ids' => 'required|array']);
        foreach ($request->ids as $urutan => $id) {
            GaleriFoto::where('id', $id)->update(['urutan' => $urutan + 1]);
        }
        return response()->json(['success' => true]);
    }

    public function exportPdf()
    {
        return back()->with('info', 'Fitur export PDF segera hadir.');
    }

    private function validateFoto(Request $request): array
    {
        return $request->validate([
            'galeri_kategori_id' => 'required|exists:galeri_kategori,id',
            'judul'              => 'required|string|max:255',
            'keterangan'         => 'nullable|string',
            'alt_text'           => 'nullable|string|max:255',
            'sumber'             => 'nullable|string|max:255',
            'tanggal_foto'       => 'nullable|date',
            'is_published'       => 'boolean',
            'is_featured'        => 'boolean',
            'urutan'             => 'nullable|integer|min:0',
            'foto'               => 'nullable|image|max:4096',
            'foto_url'           => 'nullable|url|max:255',
        ]);
    }
}