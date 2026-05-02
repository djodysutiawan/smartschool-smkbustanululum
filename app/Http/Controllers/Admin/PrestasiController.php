<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Prestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PrestasiController extends Controller
{
    public function index(Request $request)
    {
        $prestasi = Prestasi::with(['jurusan'])
            ->when($request->search,     fn($q) => $q->where('judul', 'like', "%{$request->search}%"))
            ->when($request->tingkat,    fn($q) => $q->where('tingkat', $request->tingkat))
            ->when($request->bidang,     fn($q) => $q->where('bidang', $request->bidang))
            ->when($request->jurusan_id, fn($q) => $q->where('jurusan_id', $request->jurusan_id))
            ->when($request->tahun,      fn($q) => $q->where('tahun', $request->tahun))
            ->when($request->featured,   fn($q) => $q->where('is_featured', true))
            ->orderByDesc('tanggal')
            ->paginate(15)
            ->withQueryString();

        $jurusan  = Jurusan::published()->get();
        $tingkats = ['sekolah', 'kecamatan', 'kabupaten', 'provinsi', 'nasional', 'internasional'];

        return view('Admin.Prestasi.index', compact('prestasi', 'jurusan', 'tingkats'));
    }

    public function create()
    {
        $jurusan = Jurusan::published()->get();
        return view('Admin.Prestasi.create', compact('jurusan'));
    }

    public function store(Request $request)
    {
        $data = $this->validatePrestasi($request);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $data['created_by'] = $user->id;

        $this->handleFiles($request, $data);
        Prestasi::create($data);

        return redirect()->route('admin.prestasi.index')
            ->with('success', 'Prestasi berhasil ditambahkan.');
    }

    public function show(Prestasi $prestasi)
    {
        $prestasi->load(['jurusan']);
        return view('Admin.Prestasi.show', compact('prestasi'));
    }

    public function edit(Prestasi $prestasi)
    {
        $jurusan = Jurusan::published()->get();
        return view('Admin.Prestasi.edit', compact('prestasi', 'jurusan'));
    }

    public function update(Request $request, Prestasi $prestasi)
    {
        $data = $this->validatePrestasi($request);
        $this->handleFiles($request, $data, $prestasi);
        $prestasi->update($data);

        return redirect()->route('admin.prestasi.index')
            ->with('success', 'Prestasi berhasil diperbarui.');
    }

    public function destroy(Prestasi $prestasi)
    {
        if ($prestasi->foto_path)       Storage::delete($prestasi->foto_path);
        if ($prestasi->sertifikat_path) Storage::delete($prestasi->sertifikat_path);
        $prestasi->delete();

        return redirect()->route('admin.prestasi.index')
            ->with('success', 'Prestasi berhasil dihapus.');
    }

    public function togglePublish(Prestasi $prestasi)
    {
        $prestasi->update(['is_published' => !$prestasi->is_published]);
        return back()->with('success', 'Status prestasi diperbarui.');
    }

    public function toggleFeatured(Prestasi $prestasi)
    {
        $prestasi->update(['is_featured' => !$prestasi->is_featured]);
        return back()->with('success', 'Status unggulan prestasi diperbarui.');
    }

    public function exportPdf()   { return back()->with('info', 'Fitur export PDF segera hadir.'); }
    public function exportExcel() { return back()->with('info', 'Fitur export Excel segera hadir.'); }

    /* ─────────────────────────────────────────────────────── helpers ── */

    private function validatePrestasi(Request $request): array
    {
        // Pastikan checkbox boolean terkirim meski tidak dicentang
        $request->merge([
            'is_published' => $request->boolean('is_published'),
            'is_featured'  => $request->boolean('is_featured'),
        ]);

        $validated = $request->validate([
            'judul'         => 'required|string|max:255',
            'deskripsi'     => 'nullable|string',
            'tingkat'       => 'required|in:sekolah,kecamatan,kabupaten,provinsi,nasional,internasional',
            'bidang'        => 'nullable|string|max:100',
            'nama_event'    => 'nullable|string|max:255',
            'penyelenggara' => 'nullable|string|max:255',
            'peringkat'     => 'nullable|string|max:50',
            'tanggal'       => 'nullable|date',
            'tahun'         => 'nullable|integer|min:2000|max:' . date('Y'),
            'tipe_penerima' => 'required|in:siswa,tim,guru,sekolah',   // wajib — kolom NOT NULL di DB
            'nama_penerima' => 'nullable|string|max:255',
            'jurusan_id'    => 'nullable|exists:jurusan,id',
            'is_published'  => 'boolean',
            'is_featured'   => 'boolean',
            'urutan'        => 'nullable|integer|min:0',
            'foto'          => 'nullable|image|max:2048',
            'foto_url'      => 'nullable|url|max:255',
            'sertifikat'    => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        return $validated;
    }

    private function handleFiles(Request $request, array &$data, ?Prestasi $existing = null): void
    {
        if ($request->hasFile('foto')) {
            if ($existing?->foto_path) Storage::delete($existing->foto_path);
            $data['foto_path'] = $request->file('foto')->store('prestasi/foto', 'public');
            unset($data['foto']);
        }
        if ($request->hasFile('sertifikat')) {
            if ($existing?->sertifikat_path) Storage::delete($existing->sertifikat_path);
            $data['sertifikat_path'] = $request->file('sertifikat')->store('prestasi/sertifikat', 'public');
            unset($data['sertifikat']);
        }
    }
}