<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\JurusanKurikulum;
use Illuminate\Http\Request;

class JurusanKurikulumController extends Controller
{
    /**
     * GET /admin/jurusan/{jurusan}/kurikulum
     */
    public function index(Jurusan $jurusan)
    {
        $kurikulum = $jurusan->kurikulum()
            ->orderBy('kelas')
            ->orderBy('semester')
            ->orderBy('urutan')
            ->get()
            ->groupBy(fn($k) => "Kelas {$k->kelas} — Semester {$k->semester}");

        return view('Admin.Jurusan.Kurikulum.index', compact('jurusan', 'kurikulum'));
    }

    /**
     * POST /admin/jurusan/{jurusan}/kurikulum
     */
    public function store(Request $request, Jurusan $jurusan)
    {
        $data = $request->validate([
            'nama_mapel'     => 'required|string|max:255',
            'kelompok'       => 'nullable|string|max:100',
            'kelas'          => 'nullable|integer|in:10,11,12',
            'semester'       => 'nullable|integer|in:1,2',
            'jam_per_minggu' => 'nullable|integer|min:1|max:40',
            'deskripsi'      => 'nullable|string',
            'urutan'         => 'nullable|integer|min:0',
        ]);

        $data['jurusan_id'] = $jurusan->id;
        $data['urutan']     = $data['urutan'] ?? ($jurusan->kurikulum()->max('urutan') + 1);

        JurusanKurikulum::create($data);

        return back()->with('success', 'Mata pelajaran "' . $data['nama_mapel'] . '" berhasil ditambahkan.');
    }

    /**
     * PUT /admin/jurusan/{jurusan}/kurikulum/{kurikulum}
     */
    public function update(Request $request, Jurusan $jurusan, JurusanKurikulum $kurikulum)
    {
        $this->authorize_nested($kurikulum, $jurusan);

        $data = $request->validate([
            'nama_mapel'     => 'required|string|max:255',
            'kelompok'       => 'nullable|string|max:100',
            'kelas'          => 'nullable|integer|in:10,11,12',
            'semester'       => 'nullable|integer|in:1,2',
            'jam_per_minggu' => 'nullable|integer|min:1|max:40',
            'deskripsi'      => 'nullable|string',
            'urutan'         => 'nullable|integer|min:0',
        ]);

        $kurikulum->update($data);

        return back()->with('success', 'Kurikulum berhasil diperbarui.');
    }

    /**
     * DELETE /admin/jurusan/{jurusan}/kurikulum/{kurikulum}
     */
    public function destroy(Jurusan $jurusan, JurusanKurikulum $kurikulum)
    {
        $this->authorize_nested($kurikulum, $jurusan);
        $nama = $kurikulum->nama_mapel;
        $kurikulum->delete();

        return back()->with('success', 'Mata pelajaran "' . $nama . '" berhasil dihapus.');
    }

    /**
     * POST /admin/jurusan/{jurusan}/kurikulum/reorder
     */
    public function reorder(Request $request, Jurusan $jurusan)
    {
        $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'integer',
        ]);

        foreach ($request->ids as $urutan => $id) {
            JurusanKurikulum::where('id', $id)
                ->where('jurusan_id', $jurusan->id)
                ->update(['urutan' => $urutan + 1]);
        }

        return response()->json(['success' => true]);
    }

    // Pastikan record memang milik jurusan ini
    private function authorize_nested(JurusanKurikulum $kurikulum, Jurusan $jurusan): void
    {
        abort_if($kurikulum->jurusan_id !== $jurusan->id, 403);
    }
}