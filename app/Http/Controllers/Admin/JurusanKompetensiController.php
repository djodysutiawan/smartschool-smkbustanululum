<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\JurusanKompetensi;
use Illuminate\Http\Request;

class JurusanKompetensiController extends Controller
{
    /**
     * GET /admin/jurusan/{jurusan}/kompetensi
     */
    public function index(Jurusan $jurusan)
    {
        $kompetensi = $jurusan->kompetensi()->orderBy('urutan')->get();

        return view('Admin.Jurusan.Kompetensi.index', compact('jurusan', 'kompetensi'));
    }

    /**
     * POST /admin/jurusan/{jurusan}/kompetensi
     */
    public function store(Request $request, Jurusan $jurusan)
    {
        $data = $request->validate([
            'nama_kompetensi' => 'required|string|max:255',
            'deskripsi'       => 'nullable|string',
            'ikon'            => 'nullable|string|max:50',
            'badge_warna'     => 'nullable|string|max:30',
            'urutan'          => 'nullable|integer|min:0',
        ]);

        $data['jurusan_id'] = $jurusan->id;
        $data['urutan']     = $data['urutan'] ?? ($jurusan->kompetensi()->max('urutan') + 1);

        JurusanKompetensi::create($data);

        return back()->with('success', 'Kompetensi "' . $data['nama_kompetensi'] . '" berhasil ditambahkan.');
    }

    /**
     * PUT /admin/jurusan/{jurusan}/kompetensi/{kompetensi}
     */
    public function update(Request $request, Jurusan $jurusan, JurusanKompetensi $kompetensi)
    {
        abort_if($kompetensi->jurusan_id !== $jurusan->id, 403);

        $data = $request->validate([
            'nama_kompetensi' => 'required|string|max:255',
            'deskripsi'       => 'nullable|string',
            'ikon'            => 'nullable|string|max:50',
            'badge_warna'     => 'nullable|string|max:30',
            'urutan'          => 'nullable|integer|min:0',
        ]);

        $kompetensi->update($data);

        return back()->with('success', 'Kompetensi berhasil diperbarui.');
    }

    /**
     * DELETE /admin/jurusan/{jurusan}/kompetensi/{kompetensi}
     */
    public function destroy(Jurusan $jurusan, JurusanKompetensi $kompetensi)
    {
        abort_if($kompetensi->jurusan_id !== $jurusan->id, 403);

        $nama = $kompetensi->nama_kompetensi;
        $kompetensi->delete();

        return back()->with('success', 'Kompetensi "' . $nama . '" berhasil dihapus.');
    }

    /**
     * POST /admin/jurusan/{jurusan}/kompetensi/reorder
     */
    public function reorder(Request $request, Jurusan $jurusan)
    {
        $request->validate(['ids' => 'required|array', 'ids.*' => 'integer']);

        foreach ($request->ids as $urutan => $id) {
            JurusanKompetensi::where('id', $id)
                ->where('jurusan_id', $jurusan->id)
                ->update(['urutan' => $urutan + 1]);
        }

        return response()->json(['success' => true]);
    }
}