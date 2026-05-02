<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GaleriKategori;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GaleriKategoriController extends Controller
{
    public function index(Request $request)
    {
        $kategori = GaleriKategori::withCount(['foto', 'video'])
            ->when($request->tipe, fn($q) => $q->where('tipe', $request->tipe))
            ->orderBy('urutan')
            ->paginate(20);
        return view('Admin.GaleriKategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('Admin.GaleriKategori.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateKategori($request);
        $data['slug']         = Str::slug($data['nama']);
        $data['is_published'] = $request->boolean('is_published'); // ← cast bool

        /** @var User $user */
        $user = Auth::user();
        $data['created_by'] = $user->id;

        $this->handleThumbnail($request, $data);
        GaleriKategori::create($data);
        return redirect()->route('admin.galeri.kategori.index')
            ->with('success', 'Kategori galeri berhasil ditambahkan.');
    }

    public function edit(GaleriKategori $galeriKategori)
    {
        return view('Admin.GaleriKategori.edit', compact('galeriKategori'));
    }

    public function update(Request $request, GaleriKategori $galeriKategori)
    {
        $data = $this->validateKategori($request);
        $data['slug']         = Str::slug($data['nama']);
        $data['is_published'] = $request->boolean('is_published'); // ← cast bool
        $this->handleThumbnail($request, $data, $galeriKategori);
        $galeriKategori->update($data);
        return redirect()->route('admin.galeri.kategori.index')
            ->with('success', 'Kategori galeri berhasil diperbarui.');
    }

    public function destroy(GaleriKategori $galeriKategori)
    {
        if ($galeriKategori->foto()->exists() || $galeriKategori->video()->exists()) {
            return back()->with('error', 'Kategori masih memiliki foto/video. Hapus isinya terlebih dahulu.');
        }
        if ($galeriKategori->thumbnail_path) Storage::delete($galeriKategori->thumbnail_path);
        $galeriKategori->delete();
        return back()->with('success', 'Kategori galeri berhasil dihapus.');
    }

    public function togglePublish(GaleriKategori $galeriKategori)
    {
        $galeriKategori->update(['is_published' => !$galeriKategori->is_published]);
        return back()->with('success', 'Status kategori diperbarui.');
    }

    public function reorder(Request $request)
    {
        $request->validate(['ids' => 'required|array']);
        foreach ($request->ids as $urutan => $id) {
            GaleriKategori::where('id', $id)->update(['urutan' => $urutan + 1]);
        }
        return response()->json(['success' => true]);
    }

    private function validateKategori(Request $request): array
    {
        return $request->validate([
            'nama'          => 'required|string|max:255',
            'deskripsi'     => 'nullable|string',
            'tipe'          => 'required|in:foto,video,semua',
            'is_published'  => 'nullable|in:0,1',  // ← string "0"/"1" dari form HTML
            'urutan'        => 'nullable|integer|min:0',
            'thumbnail'     => 'nullable|image|max:2048',
            'thumbnail_url' => 'nullable|url|max:255',
        ]);
    }

    private function handleThumbnail(Request $request, array &$data, ?GaleriKategori $existing = null): void
    {
        if ($request->hasFile('thumbnail')) {
            if ($existing && $existing->thumbnail_path) Storage::delete($existing->thumbnail_path);
            $data['thumbnail_path'] = $request->file('thumbnail')->store('galeri/kategori', 'public');
            unset($data['thumbnail']);
        }
    }
}