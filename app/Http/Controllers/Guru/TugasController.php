<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\TahunAjaran;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class TugasController extends Controller
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

        $query = Tugas::with(['mataPelajaran', 'kelas', 'tahunAjaran'])
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

        $tugas     = $query->latest()->paginate(20)->withQueryString();
        $kelasList = Kelas::aktif()->orderBy('nama_kelas')->get();
        $mapelList = MataPelajaran::aktif()->orderBy('nama_mapel')->get();

        // PERBAIKAN: Hitung stats di controller, bukan di blade.
        // Ini mencegah potensi fatal error auth()->user()->guru di blade
        // dan menjaga blade tetap bersih dari logika bisnis.
        $stats = [
            'total_aktif'   => Tugas::where('guru_id', $guruId)
                ->where('dipublikasikan', true)
                ->where('batas_waktu', '>=', now())
                ->count(),
            'total_expired' => Tugas::where('guru_id', $guruId)
                ->where('batas_waktu', '<', now())
                ->count(),
            'total_draft'   => Tugas::where('guru_id', $guruId)
                ->where('dipublikasikan', false)
                ->count(),
        ];

        return view('guru.tugas.index', compact('tugas', 'kelasList', 'mapelList', 'stats'));
    }

    public function create()
    {
        $kelasList        = Kelas::aktif()->orderBy('nama_kelas')->get();
        $mapelList        = MataPelajaran::aktif()->orderBy('nama_mapel')->get();
        $tahunAjaran      = TahunAjaran::orderByDesc('tahun')->get();
        $jenisPengumpulan = Tugas::JENIS_PENGUMPULAN;

        return view('guru.tugas.create', compact('kelasList', 'mapelList', 'tahunAjaran', 'jenisPengumpulan'));
    }

    public function store(Request $request)
    {
        $guruId = $this->getGuruId();

        $validated = $request->validate([
            'mata_pelajaran_id' => ['required', 'exists:mata_pelajaran,id'],
            'kelas_id'          => ['required', 'exists:kelas,id'],
            'tahun_ajaran_id'   => ['required', 'exists:tahun_ajaran,id'],
            'judul'             => ['required', 'string', 'max:255'],
            'deskripsi'         => ['nullable', 'string', 'max:5000'],
            'path_file_soal'    => ['nullable', 'file', 'mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip,rar', 'max:10240'],
            'jenis_pengumpulan' => ['required', Rule::in(Tugas::JENIS_PENGUMPULAN)],
            'batas_waktu'       => ['required', 'date', 'after:now'],
            'nilai_maksimal'    => ['nullable', 'numeric', 'min:0', 'max:100'],
            'izinkan_terlambat' => ['boolean'],
            'dipublikasikan'    => ['boolean'],
        ], $this->messages());

        $validated['guru_id'] = $guruId;

        // Nilai maksimal default 100 jika tidak diisi
        $validated['nilai_maksimal'] = $validated['nilai_maksimal'] ?? 100;

        if ($request->hasFile('path_file_soal')) {
            $validated['path_file_soal'] = $request->file('path_file_soal')
                ->store('tugas/soal', 'public');
        }

        Tugas::create($validated);

        return redirect()->route('guru.tugas.index')
            ->with('success', 'Tugas berhasil ditambahkan.');
    }

    public function show(Tugas $tugas)
    {
        $guruId = $this->getGuruId();
        abort_if($tugas->guru_id !== $guruId, 403, 'Anda tidak memiliki akses ke tugas ini.');

        $tugas->load(['mataPelajaran', 'kelas', 'tahunAjaran', 'pengumpulan.siswa']);

        // PERBAIKAN: Gunakan kelas_id langsung agar tidak bergantung pada withDefault()
        // yang mengembalikan instance Kelas kosong (tanpa id) — bisa menyebabkan
        // error pada ->siswa()->count() karena query WHERE kelas_id = null.
        $totalSiswa = $tugas->kelas_id
            ? Kelas::find($tugas->kelas_id)?->siswa()->count() ?? 0
            : 0;

        $stats = [
            'total_siswa'   => $totalSiswa,
            'terkumpul'     => $tugas->jumlah_terkumpul,
            'sudah_dinilai' => $tugas->jumlah_dinilai,
        ];

        return view('guru.tugas.show', compact('tugas', 'stats'));
    }

    public function edit(Tugas $tugas)
    {
        $guruId = $this->getGuruId();
        abort_if($tugas->guru_id !== $guruId, 403, 'Anda tidak memiliki akses ke tugas ini.');

        $kelasList        = Kelas::aktif()->orderBy('nama_kelas')->get();
        $mapelList        = MataPelajaran::aktif()->orderBy('nama_mapel')->get();
        $tahunAjaran      = TahunAjaran::orderByDesc('tahun')->get();
        $jenisPengumpulan = Tugas::JENIS_PENGUMPULAN;

        return view('guru.tugas.edit',
            compact('tugas', 'kelasList', 'mapelList', 'tahunAjaran', 'jenisPengumpulan'));
    }

    public function update(Request $request, Tugas $tugas)
    {
        $guruId = $this->getGuruId();
        abort_if($tugas->guru_id !== $guruId, 403, 'Anda tidak memiliki akses ke tugas ini.');

        $validated = $request->validate([
            'mata_pelajaran_id' => ['required', 'exists:mata_pelajaran,id'],
            'kelas_id'          => ['required', 'exists:kelas,id'],
            'tahun_ajaran_id'   => ['required', 'exists:tahun_ajaran,id'],
            'judul'             => ['required', 'string', 'max:255'],
            'deskripsi'         => ['nullable', 'string', 'max:5000'],
            'path_file_soal'    => ['nullable', 'file', 'mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip,rar', 'max:10240'],
            'jenis_pengumpulan' => ['required', Rule::in(Tugas::JENIS_PENGUMPULAN)],
            'batas_waktu'       => ['required', 'date'],
            'nilai_maksimal'    => ['nullable', 'numeric', 'min:0', 'max:100'],
            'izinkan_terlambat' => ['boolean'],
            'dipublikasikan'    => ['boolean'],
        ], $this->messages());

        if ($request->hasFile('path_file_soal')) {
            // Hapus file lama sebelum simpan yang baru
            if ($tugas->path_file_soal) {
                Storage::disk('public')->delete($tugas->path_file_soal);
            }
            $validated['path_file_soal'] = $request->file('path_file_soal')
                ->store('tugas/soal', 'public');
        }

        $tugas->update($validated);

        return redirect()->route('guru.tugas.show', $tugas)
            ->with('success', 'Tugas berhasil diperbarui.');
    }

    public function destroy(Tugas $tugas)
    {
        $guruId = $this->getGuruId();
        abort_if($tugas->guru_id !== $guruId, 403, 'Anda tidak memiliki akses ke tugas ini.');

        if ($tugas->path_file_soal) {
            Storage::disk('public')->delete($tugas->path_file_soal);
        }

        $tugas->delete();

        return redirect()->route('guru.tugas.index')
            ->with('success', 'Tugas berhasil dihapus.');
    }

    public function toggleStatus(Tugas $tugas)
    {
        $guruId = $this->getGuruId();
        abort_if($tugas->guru_id !== $guruId, 403, 'Anda tidak memiliki akses ke tugas ini.');

        $tugas->update(['dipublikasikan' => ! $tugas->dipublikasikan]);
        $status = $tugas->dipublikasikan ? 'dipublikasikan' : 'disembunyikan';

        return back()->with('success', "Tugas berhasil {$status}.");
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
            'judul.required'             => 'Judul tugas wajib diisi.',
            'judul.max'                  => 'Judul tugas maksimal 255 karakter.',
            'deskripsi.max'              => 'Deskripsi maksimal 5000 karakter.',
            'jenis_pengumpulan.required' => 'Jenis pengumpulan wajib dipilih.',
            'jenis_pengumpulan.in'       => 'Jenis pengumpulan tidak valid.',
            'batas_waktu.required'       => 'Batas waktu pengumpulan wajib diisi.',
            'batas_waktu.date'           => 'Format batas waktu tidak valid.',
            'batas_waktu.after'          => 'Batas waktu harus setelah waktu sekarang.',
            'nilai_maksimal.numeric'     => 'Nilai maksimal harus berupa angka.',
            'nilai_maksimal.min'         => 'Nilai maksimal tidak boleh negatif.',
            'nilai_maksimal.max'         => 'Nilai maksimal tidak boleh lebih dari 100.',
            'path_file_soal.file'        => 'File soal tidak valid.',
            'path_file_soal.mimes'       => 'Format file soal tidak didukung (PDF, DOC, DOCX, PPT, XLS, ZIP).',
            'path_file_soal.max'         => 'Ukuran file soal maksimal 10MB.',
        ];
    }
}