<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BeritaKategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BeritaKategoriController extends Controller
{
    public function index()
    {
        $kategori = BeritaKategori::withCount('berita')->orderBy('urutan')->paginate(20);
        return view('Admin.BeritaKategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('Admin.BeritaKategori.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateKategori($request);
        $data['slug']   = Str::slug($data['nama']);
        $data['urutan'] = $data['urutan'] ?? (BeritaKategori::max('urutan') + 1);

        BeritaKategori::create($data);

        return redirect()->route('admin.berita-kategori.index')
            ->with('success', 'Kategori "' . $data['nama'] . '" berhasil ditambahkan.');
    }

    public function edit(BeritaKategori $beritaKategori)
    {
        return view('Admin.BeritaKategori.edit', compact('beritaKategori'));
    }

    public function update(Request $request, BeritaKategori $beritaKategori)
    {
        $data = $this->validateKategori($request);
        $data['slug']   = Str::slug($data['nama']);
        $data['urutan'] = $data['urutan'] ?? $beritaKategori->urutan;

        $beritaKategori->update($data);

        return redirect()->route('admin.berita-kategori.index')
            ->with('success', 'Kategori "' . $data['nama'] . '" berhasil diperbarui.');
    }

    public function destroy(BeritaKategori $beritaKategori)
    {
        if ($beritaKategori->berita()->exists()) {
            return back()->with('error', 'Kategori tidak bisa dihapus karena masih memiliki berita.');
        }
        $nama = $beritaKategori->nama;
        $beritaKategori->delete();
        return back()->with('success', 'Kategori "' . $nama . '" berhasil dihapus.');
    }

    public function togglePublish(BeritaKategori $beritaKategori)
    {
        $beritaKategori->update(['is_published' => !$beritaKategori->is_published]);
        $label = $beritaKategori->is_published ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', 'Kategori "' . $beritaKategori->nama . '" berhasil ' . $label . '.');
    }

    public function reorder(Request $request)
    {
        $request->validate(['ids' => 'required|array']);
        foreach ($request->ids as $urutan => $id) {
            BeritaKategori::where('id', $id)->update(['urutan' => $urutan + 1]);
        }
        return response()->json(['success' => true]);
    }

    private function validateKategori(Request $request): array
    {
        return $request->validate([
            'nama'         => 'required|string|max:100',
            'deskripsi'    => 'nullable|string',
            'warna'        => 'nullable|string|max:30',
            'is_published' => 'boolean',
            'urutan'       => 'nullable|integer|min:0',
        ]);
    }
}