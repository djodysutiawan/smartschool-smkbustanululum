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
    // ── Helpers ───────────────────────────────────────────────────────────────

    private function getGuruId(): int
    {
        $guru = Auth::user()->guru;
        abort_if(! $guru, 403, 'Akun Anda tidak terhubung dengan data guru.');
        return $guru->id;
    }

    /**
     * Pastikan materi milik guru yang sedang login.
     */
    private function authorizeMateri(Materi $materi): void
    {
        abort_if($materi->guru_id !== $this->getGuruId(), 403, 'Anda tidak memiliki akses ke materi ini.');
    }

    /**
     * Aturan validasi — dikondisikan berdasarkan jenis materi.
     */
    private function validationRules(Request $request, ?Materi $materi = null): array
    {
        $jenis = $request->input('jenis');

        return [
            'mata_pelajaran_id' => ['required', 'exists:mata_pelajaran,id'],
            'kelas_id'          => ['required', 'exists:kelas,id'],
            'tahun_ajaran_id'   => ['required', 'exists:tahun_ajaran,id'],
            'judul'             => ['required', 'string', 'max:255'],
            'deskripsi'         => ['nullable', 'string', 'max:2000'],
            'jenis'             => ['required', Rule::in(Materi::JENIS_VALID)],

            // File hanya wajib saat create dengan jenis=file dan belum ada file
            'path_file'         => array_filter([
                'nullable',
                'file',
                'max:51200',
                // Wajib upload saat create baru dengan jenis file
                (is_null($materi) && $jenis === Materi::JENIS_FILE) ? 'required' : null,
            ]),

            // URL wajib untuk link & video
            'url_eksternal'     => [
                in_array($jenis, [Materi::JENIS_LINK, Materi::JENIS_VIDEO]) ? 'required' : 'nullable',
                'url',
                'max:500',
            ],

            // Konten teks wajib untuk jenis teks
            'konten_teks'       => [
                $jenis === Materi::JENIS_TEKS ? 'required' : 'nullable',
                'string',
                'max:65535',
            ],

            'thumbnail'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'urutan'            => ['nullable', 'integer', 'min:0'],
            'dipublikasikan'    => ['nullable', 'boolean'],
        ];
    }

    // ── CRUD ──────────────────────────────────────────────────────────────────

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

        // Stats dihitung di controller, bukan di blade
        $stats = [
            'total'     => Materi::where('guru_id', $guruId)->count(),
            'publish'   => Materi::where('guru_id', $guruId)->where('dipublikasikan', true)->count(),
            'draft'     => Materi::where('guru_id', $guruId)->where('dipublikasikan', false)->count(),
            'file'      => Materi::where('guru_id', $guruId)->where('jenis', Materi::JENIS_FILE)->count(),
        ];

        return view('guru.materi.index', compact('materi', 'kelasList', 'mapelList', 'stats'));
    }

    public function create()
    {
        $kelasList   = Kelas::aktif()->orderBy('nama_kelas')->get();
        $mapelList   = MataPelajaran::aktif()->orderBy('nama_mapel')->get();
        $tahunAjaran = TahunAjaran::orderByDesc('tahun')->get();
        $jenisMateri = Materi::JENIS_VALID;

        return view('guru.materi.create', compact('kelasList', 'mapelList', 'tahunAjaran', 'jenisMateri'));
    }

    public function store(Request $request)
    {
        $guruId = $this->getGuruId();

        $validated = $request->validate(
            $this->validationRules($request),
            $this->messages()
        );

        $validated['guru_id']       = $guruId;
        $validated['dipublikasikan'] = $request->boolean('dipublikasikan');

        // Upload file materi
        if ($request->hasFile('path_file')) {
            $validated['path_file'] = $request->file('path_file')
                ->store('materi/files', 'public');
        }

        // Upload thumbnail
        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')
                ->store('materi/thumbnails', 'public');
        }

        // Bersihkan field yang tidak relevan dengan jenis
        $validated = $this->sanitizeByJenis($validated, $validated['jenis']);

        // Set waktu publikasi
        if ($validated['dipublikasikan']) {
            $validated['dipublikasikan_pada'] = now();
        }

        Materi::create($validated);

        return redirect()->route('guru.materi.index')
            ->with('success', 'Materi berhasil ditambahkan.');
    }

    public function show(Materi $materi)
    {
        $this->authorizeMateri($materi);
        $materi->load(['mataPelajaran', 'kelas', 'tahunAjaran']);

        return view('guru.materi.show', compact('materi'));
    }

    public function edit(Materi $materi)
    {
        $this->authorizeMateri($materi);

        $kelasList   = Kelas::aktif()->orderBy('nama_kelas')->get();
        $mapelList   = MataPelajaran::aktif()->orderBy('nama_mapel')->get();
        $tahunAjaran = TahunAjaran::orderByDesc('tahun')->get();
        $jenisMateri = Materi::JENIS_VALID;

        return view('guru.materi.edit', compact('materi', 'kelasList', 'mapelList', 'tahunAjaran', 'jenisMateri'));
    }

    public function update(Request $request, Materi $materi)
    {
        $this->authorizeMateri($materi);

        $validated = $request->validate(
            $this->validationRules($request, $materi),
            $this->messages()
        );

        $validated['dipublikasikan'] = $request->boolean('dipublikasikan');

        // Ganti file materi jika ada upload baru
        if ($request->hasFile('path_file')) {
            if ($materi->path_file) {
                Storage::disk('public')->delete($materi->path_file);
            }
            $validated['path_file'] = $request->file('path_file')
                ->store('materi/files', 'public');
        }

        // Ganti thumbnail jika ada upload baru
        if ($request->hasFile('thumbnail')) {
            if ($materi->thumbnail) {
                Storage::disk('public')->delete($materi->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')
                ->store('materi/thumbnails', 'public');
        }

        // Bersihkan field yang tidak relevan dengan jenis
        $validated = $this->sanitizeByJenis($validated, $validated['jenis']);

        // Kelola timestamp publikasi
        if ($validated['dipublikasikan'] && ! $materi->dipublikasikan) {
            // Baru dipublikasikan
            $validated['dipublikasikan_pada'] = now();
        } elseif (! $validated['dipublikasikan']) {
            // Dicabut publikasinya
            $validated['dipublikasikan_pada'] = null;
        }
        // Jika sudah publish sebelumnya & masih publish → pertahankan timestamp lama

        $materi->update($validated);

        return redirect()->route('guru.materi.show', $materi)
            ->with('success', 'Materi berhasil diperbarui.');
    }

    public function destroy(Materi $materi)
    {
        $this->authorizeMateri($materi);

        // Hapus file dari storage
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
        $this->authorizeMateri($materi);

        if ($materi->dipublikasikan) {
            $materi->unpublish();
            $status = 'disembunyikan dari siswa';
        } else {
            $materi->publish();
            $status = 'berhasil dipublikasikan';
        }

        return back()->with('success', "Materi {$status}.");
    }

    // ── Private Helpers ───────────────────────────────────────────────────────

    /**
     * Bersihkan field yang tidak relevan sesuai jenis materi,
     * agar tidak ada data "sisa" yang tersimpan ke database.
     */
    private function sanitizeByJenis(array $data, string $jenis): array
    {
        switch ($jenis) {
            case Materi::JENIS_FILE:
                $data['url_eksternal'] = null;
                $data['konten_teks']   = null;
                break;

            case Materi::JENIS_LINK:
            case Materi::JENIS_VIDEO:
                // path_file tidak di-null di sini karena mungkin sudah diupload;
                // jika ganti jenis ke link/video, file lama dibiarkan (bisa dibersihkan manual)
                $data['konten_teks'] = null;
                break;

            case Materi::JENIS_TEKS:
                $data['url_eksternal'] = null;
                // path_file dibiarkan (tidak dihapus) — guru mungkin sudah upload
                break;
        }

        return $data;
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
            'path_file.required'         => 'File materi wajib diupload untuk jenis File.',
            'path_file.file'             => 'Format file tidak valid.',
            'path_file.max'              => 'Ukuran file materi maksimal 50MB.',
            'url_eksternal.required'     => 'URL wajib diisi untuk jenis Link atau Video.',
            'url_eksternal.url'          => 'Format URL eksternal tidak valid (harus diawali https://).',
            'url_eksternal.max'          => 'URL eksternal maksimal 500 karakter.',
            'konten_teks.required'       => 'Konten teks wajib diisi untuk jenis Teks.',
            'konten_teks.max'            => 'Konten teks terlalu panjang.',
            'thumbnail.image'            => 'Thumbnail harus berupa gambar.',
            'thumbnail.mimes'            => 'Format thumbnail harus jpg, jpeg, png, atau webp.',
            'thumbnail.max'              => 'Ukuran thumbnail maksimal 2MB.',
            'urutan.integer'             => 'Urutan harus berupa angka.',
            'urutan.min'                 => 'Urutan tidak boleh negatif.',
        ];
    }
}