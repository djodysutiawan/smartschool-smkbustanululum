<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Materi;
use App\Models\MataPelajaran;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class MateriController extends Controller
{
    private function getGuruId(): int
    {
        $guru = Auth::user()->guru;
        abort_if(! $guru, 403, 'Akun Anda tidak terhubung dengan data guru.');
        return $guru->id;
    }

    public function index(Request $request)
    {
        $guruId = $this->getGuruId();

        $query = Materi::with(['mataPelajaran', 'kelas', 'tahunAjaran'])
            ->where('guru_id', $guruId);

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        if ($request->filled('mata_pelajaran_id')) {
            $query->where('mata_pelajaran_id', $request->mata_pelajaran_id);
        }

        if ($request->filled('dipublikasikan')) {
            $query->where('dipublikasikan', $request->boolean('dipublikasikan'));
        }

        if ($request->filled('search')) {
            $query->where('judul', 'like', "%{$request->search}%");
        }

        $materi    = $query->orderBy('urutan')->latest()->paginate(20)->withQueryString();
        $kelasList = Kelas::aktif()->orderBy('nama_kelas')->get();
        $mapelList = MataPelajaran::aktif()->orderBy('nama_mapel')->get();

        return view('guru.materi.index', compact('materi', 'kelasList', 'mapelList'));
    }

    public function create()
    {
        $kelasList   = Kelas::aktif()->orderBy('nama_kelas')->get();
        $mapelList   = MataPelajaran::aktif()->orderBy('nama_mapel')->get();
        $tahunAjaran = TahunAjaran::orderByDesc('tahun')->get();
        $jenisMateri = ['file', 'video', 'link', 'teks'];

        return view('guru.materi.create', compact('kelasList', 'mapelList', 'tahunAjaran', 'jenisMateri'));
    }

    public function store(Request $request)
    {
        $guruId = $this->getGuruId();

        $validated = $request->validate([
            'mata_pelajaran_id' => ['required', 'exists:mata_pelajaran,id'],
            'kelas_id'          => ['required', 'exists:kelas,id'],
            'tahun_ajaran_id'   => ['required', 'exists:tahun_ajaran,id'],
            'judul'             => ['required', 'string', 'max:255'],
            'deskripsi'         => ['nullable', 'string', 'max:2000'],
            'jenis'             => ['required', Rule::in(['file', 'video', 'link', 'teks'])],
            'path_file'         => ['nullable', 'file', 'max:51200'],
            'url_eksternal'     => ['nullable', 'url', 'max:500'],
            'thumbnail'         => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'urutan'            => ['nullable', 'integer', 'min:0'],
            'dipublikasikan'    => ['boolean'],
        ], $this->messages());

        $validated['guru_id'] = $guruId;

        if ($request->hasFile('path_file')) {
            $validated['path_file'] = $request->file('path_file')->store('materi', 'public');
        }

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('materi/thumbnails', 'public');
        }

        if (! empty($validated['dipublikasikan'])) {
            $validated['dipublikasikan_pada'] = now();
        }

        Materi::create($validated);

        return redirect()->route('guru.materi.index')
            ->with('success', 'Materi berhasil ditambahkan.');
    }

    public function show(Materi $materi)
    {
        $guruId = $this->getGuruId();
        abort_if($materi->guru_id !== $guruId, 403, 'Anda tidak memiliki akses ke materi ini.');

        $materi->load(['mataPelajaran', 'kelas', 'tahunAjaran']);

        return view('guru.materi.show', compact('materi'));
    }

    public function edit(Materi $materi)
    {
        $guruId = $this->getGuruId();
        abort_if($materi->guru_id !== $guruId, 403, 'Anda tidak memiliki akses ke materi ini.');

        $kelasList   = Kelas::aktif()->orderBy('nama_kelas')->get();
        $mapelList   = MataPelajaran::aktif()->orderBy('nama_mapel')->get();
        $tahunAjaran = TahunAjaran::orderByDesc('tahun')->get();
        $jenisMateri = ['file', 'video', 'link', 'teks'];

        return view('guru.materi.edit', compact('materi', 'kelasList', 'mapelList', 'tahunAjaran', 'jenisMateri'));
    }

    public function update(Request $request, Materi $materi)
    {
        $guruId = $this->getGuruId();
        abort_if($materi->guru_id !== $guruId, 403, 'Anda tidak memiliki akses ke materi ini.');

        $validated = $request->validate([
            'mata_pelajaran_id' => ['required', 'exists:mata_pelajaran,id'],
            'kelas_id'          => ['required', 'exists:kelas,id'],
            'tahun_ajaran_id'   => ['required', 'exists:tahun_ajaran,id'],
            'judul'             => ['required', 'string', 'max:255'],
            'deskripsi'         => ['nullable', 'string', 'max:2000'],
            'jenis'             => ['required', Rule::in(['file', 'video', 'link', 'teks'])],
            'path_file'         => ['nullable', 'file', 'max:51200'],
            'url_eksternal'     => ['nullable', 'url', 'max:500'],
            'thumbnail'         => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'urutan'            => ['nullable', 'integer', 'min:0'],
            'dipublikasikan'    => ['boolean'],
        ], $this->messages());

        if ($request->hasFile('path_file')) {
            if ($materi->path_file) {
                Storage::disk('public')->delete($materi->path_file);
            }
            $validated['path_file'] = $request->file('path_file')->store('materi', 'public');
        }

        if ($request->hasFile('thumbnail')) {
            if ($materi->thumbnail) {
                Storage::disk('public')->delete($materi->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('materi/thumbnails', 'public');
        }

        if (! empty($validated['dipublikasikan']) && ! $materi->dipublikasikan) {
            $validated['dipublikasikan_pada'] = now();
        } elseif (empty($validated['dipublikasikan'])) {
            $validated['dipublikasikan_pada'] = null;
        }

        $materi->update($validated);

        return redirect()->route('guru.materi.show', $materi)
            ->with('success', 'Materi berhasil diperbarui.');
    }

    public function destroy(Materi $materi)
    {
        $guruId = $this->getGuruId();
        abort_if($materi->guru_id !== $guruId, 403, 'Anda tidak memiliki akses ke materi ini.');

        if ($materi->path_file) {
            Storage::disk('public')->delete($materi->path_file);
        }

        if ($materi->thumbnail) {
            Storage::disk('public')->delete($materi->thumbnail);
        }

        $materi->delete();

        return redirect()->route('guru.materi.index')
            ->with('success', 'Materi berhasil dihapus.');
    }

    public function togglePublish(Materi $materi)
    {
        $guruId = $this->getGuruId();
        abort_if($materi->guru_id !== $guruId, 403, 'Anda tidak memiliki akses ke materi ini.');

        if ($materi->dipublikasikan) {
            $materi->update([
                'dipublikasikan'      => false,
                'dipublikasikan_pada' => null,
            ]);
            $status = 'disembunyikan';
        } else {
            $materi->update([
                'dipublikasikan'      => true,
                'dipublikasikan_pada' => now(),
            ]);
            $status = 'dipublikasikan';
        }

        return back()->with('success', "Materi berhasil {$status}.");
    }

    private function messages(): array
    {
        return [
            'mata_pelajaran_id.required' => 'Mata pelajaran wajib dipilih.',
            'mata_pelajaran_id.exists'   => 'Mata pelajaran yang dipilih tidak valid.',
            'kelas_id.required'          => 'Kelas wajib dipilih.',
            'kelas_id.exists'            => 'Kelas yang dipilih tidak valid.',
            'tahun_ajaran_id.required'   => 'Tahun ajaran wajib dipilih.',
            'tahun_ajaran_id.exists'     => 'Tahun ajaran yang dipilih tidak valid.',
            'judul.required'             => 'Judul materi wajib diisi.',
            'judul.max'                  => 'Judul materi maksimal 255 karakter.',
            'jenis.required'             => 'Jenis materi wajib dipilih.',
            'jenis.in'                   => 'Jenis materi tidak valid.',
            'url_eksternal.url'          => 'Format URL eksternal tidak valid.',
            'url_eksternal.max'          => 'URL eksternal maksimal 500 karakter.',
            'thumbnail.image'            => 'Thumbnail harus berupa gambar.',
            'thumbnail.mimes'            => 'Format thumbnail harus jpg, jpeg, atau png.',
            'thumbnail.max'              => 'Ukuran thumbnail maksimal 2MB.',
            'path_file.max'              => 'Ukuran file materi maksimal 50MB.',
            'urutan.integer'             => 'Urutan harus berupa angka.',
            'urutan.min'                 => 'Urutan tidak boleh negatif.',
        ];
    }
}