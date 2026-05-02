<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\JurusanProspekKerja;
use Illuminate\Http\Request;

class JurusanProspekKerjaController extends Controller
{
    /**
     * GET /admin/jurusan/{jurusan}/prospek-kerja
     */
    public function index(Jurusan $jurusan)
    {
        $prospekKerja = $jurusan->prospekKerja()->orderBy('urutan')->get();

        return view('Admin.Jurusan.ProspekKerja.index', compact('jurusan', 'prospekKerja'));
    }

    /**
     * POST /admin/jurusan/{jurusan}/prospek-kerja
     */
    public function store(Request $request, Jurusan $jurusan)
    {
        $data = $request->validate([
            'jabatan'         => 'required|string|max:255',
            'bidang_industri' => 'nullable|string|max:255',
            'deskripsi'       => 'nullable|string',
            'ikon'            => 'nullable|string|max:50',
            'urutan'          => 'nullable|integer|min:0',
        ]);

        $data['jurusan_id'] = $jurusan->id;
        $data['urutan']     = $data['urutan'] ?? ($jurusan->prospekKerja()->max('urutan') + 1);

        JurusanProspekKerja::create($data);

        return back()->with('success', 'Prospek kerja "' . $data['jabatan'] . '" berhasil ditambahkan.');
    }

    /**
     * PUT /admin/jurusan/{jurusan}/prospek-kerja/{prospek}
     */
    public function update(Request $request, Jurusan $jurusan, JurusanProspekKerja $prospek)
    {
        abort_if($prospek->jurusan_id !== $jurusan->id, 403);

        $data = $request->validate([
            'jabatan'         => 'required|string|max:255',
            'bidang_industri' => 'nullable|string|max:255',
            'deskripsi'       => 'nullable|string',
            'ikon'            => 'nullable|string|max:50',
            'urutan'          => 'nullable|integer|min:0',
        ]);

        $prospek->update($data);

        return back()->with('success', 'Prospek kerja berhasil diperbarui.');
    }

    /**
     * DELETE /admin/jurusan/{jurusan}/prospek-kerja/{prospek}
     */
    public function destroy(Jurusan $jurusan, JurusanProspekKerja $prospek)
    {
        abort_if($prospek->jurusan_id !== $jurusan->id, 403);

        $nama = $prospek->jabatan;
        $prospek->delete();

        return back()->with('success', 'Prospek kerja "' . $nama . '" berhasil dihapus.');
    }

    /**
     * POST /admin/jurusan/{jurusan}/prospek-kerja/reorder
     */
    public function reorder(Request $request, Jurusan $jurusan)
    {
        $request->validate(['ids' => 'required|array', 'ids.*' => 'integer']);

        foreach ($request->ids as $urutan => $id) {
            JurusanProspekKerja::where('id', $id)
                ->where('jurusan_id', $jurusan->id)
                ->update(['urutan' => $urutan + 1]);
        }

        return response()->json(['success' => true]);
    }
}