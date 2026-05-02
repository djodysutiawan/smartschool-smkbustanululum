<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BeritaKategori;
use App\Models\BeritaPublik;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaPublikController extends Controller
{
    public function index(Request $request)
    {
        $berita = BeritaPublik::with('kategori')
            ->when($request->search, fn($q) => $q->where('judul', 'like', "%{$request->search}%"))
            ->when($request->kategori_id, fn($q) => $q->where('berita_kategori_id', $request->kategori_id))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest('created_at')
            ->paginate(15)
            ->withQueryString();

        $kategori = BeritaKategori::published()->get();
        return view('Admin.Berita.index', compact('berita', 'kategori'));
    }

    public function create()
    {
        $kategori = BeritaKategori::published()->get();
        return view('Admin.Berita.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateBerita($request);

        /** @var User $user */
        $user = Auth::user();
        $validated['author_id'] = $user->id;
        $validated['slug']      = Str::slug($validated['judul']);
        $validated['status']    = 'draft';

        $this->handleThumbnail($request, $validated);

        BeritaPublik::create($validated);
        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil disimpan sebagai draft.');
    }

    public function show(BeritaPublik $berita)
    {
        return view('Admin.Berita.show', compact('berita'));
    }

    public function edit(BeritaPublik $berita)
    {
        $kategori = BeritaKategori::published()->get();
        return view('Admin.Berita.edit', compact('berita', 'kategori'));
    }

    public function update(Request $request, BeritaPublik $berita)
    {
        $validated         = $this->validateBerita($request);
        $validated['slug'] = Str::slug($validated['judul']);
        $this->handleThumbnail($request, $validated, $berita);
        $berita->update($validated);
        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(BeritaPublik $berita)
    {
        if ($berita->thumbnail_path) {
            Storage::delete($berita->thumbnail_path);
        }
        $berita->delete();
        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil dihapus.');
    }

    public function publish(BeritaPublik $berita)
    {
        $berita->update(['status' => 'published', 'published_at' => now()]);
        return back()->with('success', 'Berita berhasil dipublikasikan.');
    }

    public function unpublish(BeritaPublik $berita)
    {
        $berita->update(['status' => 'draft', 'published_at' => null]);
        return back()->with('success', 'Berita berhasil ditarik dari publikasi.');
    }

    public function toggleFeatured(BeritaPublik $berita)
    {
        $berita->update(['is_featured' => !$berita->is_featured]);
        return back()->with('success', 'Status unggulan diperbarui.');
    }

    public function exportPdf()
    {
        return back()->with('info', 'Fitur export PDF segera hadir.');
    }

    public function exportExcel()
    {
        return back()->with('info', 'Fitur export Excel segera hadir.');
    }

    private function validateBerita(Request $request): array
    {
        return $request->validate([
            'berita_kategori_id' => 'required|exists:berita_kategori,id',
            'judul'              => 'required|string|max:255',
            'ringkasan'          => 'nullable|string|max:500',
            'konten'             => 'required|string',
            'nama_penulis'       => 'nullable|string|max:100',
            'tags'               => 'nullable|string|max:500',
            'meta_title'         => 'nullable|string|max:255',
            'meta_description'   => 'nullable|string|max:500',
            'is_featured'        => 'boolean',
            'allow_comment'      => 'boolean',
            'thumbnail'          => 'nullable|image|max:2048',
            'thumbnail_url'      => 'nullable|url|max:255',
            'thumbnail_alt'      => 'nullable|string|max:255',
        ]);
    }

    private function handleThumbnail(Request $request, array &$validated, ?BeritaPublik $existing = null): void
    {
        if ($request->hasFile('thumbnail')) {
            if ($existing && $existing->thumbnail_path) {
                Storage::delete($existing->thumbnail_path);
            }
            $validated['thumbnail_path'] = $request->file('thumbnail')->store('berita/thumbnail', 'public');
            unset($validated['thumbnail']);
        }
    }
}