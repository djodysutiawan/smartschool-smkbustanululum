<?php

namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\JurusanFasilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
 
class JurusanFasilitasController extends Controller
{
    public function index(Jurusan $jurusan)
    {
        $fasilitas = $jurusan->fasilitas()->paginate(20);
        return view('Admin.Jurusan.Fasilitas.index', compact('jurusan', 'fasilitas'));
    }
 
    public function store(Request $request, Jurusan $jurusan)
    {
        $data = $request->validate([
            'nama_fasilitas' => 'required|string|max:255',
            'deskripsi'      => 'nullable|string',
            'foto'           => 'nullable|image|max:2048',
            'foto_url'       => 'nullable|url|max:255',
            'jumlah'         => 'nullable|integer|min:0',
            'urutan'         => 'nullable|integer|min:0',
        ]);
        if ($request->hasFile('foto')) {
            $data['foto_path'] = $request->file('foto')->store('jurusan/fasilitas', 'public');
            unset($data['foto']);
        }
        $jurusan->fasilitas()->create($data);
        return back()->with('success', 'Fasilitas berhasil ditambahkan.');
    }
 
    public function update(Request $request, Jurusan $jurusan, JurusanFasilitas $fasilitas)
    {
        $data = $request->validate([
            'nama_fasilitas' => 'required|string|max:255',
            'deskripsi'      => 'nullable|string',
            'foto'           => 'nullable|image|max:2048',
            'foto_url'       => 'nullable|url|max:255',
            'jumlah'         => 'nullable|integer|min:0',
            'urutan'         => 'nullable|integer|min:0',
        ]);
        if ($request->hasFile('foto')) {
            if ($fasilitas->foto_path) Storage::delete($fasilitas->foto_path);
            $data['foto_path'] = $request->file('foto')->store('jurusan/fasilitas', 'public');
            unset($data['foto']);
        }
        $fasilitas->update($data);
        return back()->with('success', 'Fasilitas berhasil diperbarui.');
    }
 
    public function destroy(Jurusan $jurusan, JurusanFasilitas $fasilitas)
    {
        if ($fasilitas->foto_path) Storage::delete($fasilitas->foto_path);
        $fasilitas->delete();
        return back()->with('success', 'Fasilitas berhasil dihapus.');
    }
 
    public function reorder(Request $request, Jurusan $jurusan)
    {
        $request->validate(['ids' => 'required|array']);
        foreach ($request->ids as $urutan => $id) {
            JurusanFasilitas::where('id', $id)->where('jurusan_id', $jurusan->id)->update(['urutan' => $urutan + 1]);
        }
        return response()->json(['success' => true]);
    }
}
 