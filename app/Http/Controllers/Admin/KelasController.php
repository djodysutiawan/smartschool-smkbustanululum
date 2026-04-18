<?php

namespace App\Http\Controllers\Admin;

use App\Exports\KelasExport;
use App\Http\Controllers\Controller;
use App\Imports\KelasImport;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Ruang;
use App\Models\TahunAjaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException as ExcelValidationException;

class KelasController extends Controller
{
    // ─── INDEX ───────────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $query = Kelas::with(['waliKelas', 'ruang.gedung', 'tahunAjaran'])
            ->withCount('siswa');

        if ($request->filled('tahun_ajaran_id')) $query->where('tahun_ajaran_id', $request->tahun_ajaran_id);
        if ($request->filled('tingkat'))         $query->where('tingkat', $request->tingkat);
        if ($request->filled('status'))          $query->where('status', $request->status);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn ($q) => $q
                ->where('nama_kelas', 'like', "%{$s}%")
                ->orWhere('kode_kelas', 'like', "%{$s}%"));
        }

        $kelas        = $query->orderBy('tingkat')->orderBy('nama_kelas')->paginate(20)->withQueryString();
        $tahunAjarans = TahunAjaran::orderByDesc('id')->get();

        return view('admin.kelas.index', compact('kelas', 'tahunAjarans'));
    }

    // ─── CREATE & STORE ───────────────────────────────────────────────────────────

    public function create()
    {
        $gurus        = Guru::aktif()->orderBy('nama_lengkap')->get();
        $ruangs       = Ruang::tersedia()->with('gedung')->orderBy('nama_ruang')->get();
        $tahunAjarans = TahunAjaran::orderByDesc('id')->get();

        return view('admin.kelas.create', compact('gurus', 'ruangs', 'tahunAjarans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kelas'      => ['required', 'string', 'max:50'],
            'tingkat'         => ['required', 'string', 'in:X,XI,XII'],
            'jurusan'         => ['nullable', 'string', 'max:50'],
            'kode_kelas'      => ['required', 'string', 'max:15', 'unique:kelas'],
            'wali_kelas_id'   => ['nullable', 'exists:guru,id'],
            'ruang_id'        => ['nullable', 'exists:ruang,id'],
            'tahun_ajaran_id' => ['required', 'exists:tahun_ajaran,id'],
            'kapasitas_maks'  => ['required', 'integer', 'min:1', 'max:50'],
            'status'          => ['required', 'in:aktif,nonaktif'],
        ], $this->pesanValidasi());

        if (! empty($validated['ruang_id'])) {
            $sudahDipakai = Kelas::where('ruang_id', $validated['ruang_id'])
                ->where('tahun_ajaran_id', $validated['tahun_ajaran_id'])
                ->where('status', 'aktif')
                ->exists();

            if ($sudahDipakai) {
                return back()->withInput()
                    ->with('error', 'Ruangan sudah digunakan oleh kelas lain pada tahun ajaran ini.');
            }
        }

        Kelas::create($validated);

        return redirect()->route('admin.kelas.index')
            ->with('success', 'Kelas berhasil ditambahkan.');
    }

    // ─── SHOW ─────────────────────────────────────────────────────────────────────

    public function show(Kelas $kelas)
    {
        $kelas->load([
            'waliKelas',
            'ruang.gedung',
            'tahunAjaran',
            'siswa'            => fn ($q) => $q->orderBy('nama_lengkap'),
            'jadwalPelajaran.guru',
            'jadwalPelajaran.mataPelajaran',
        ]);

        $stats = [
            'total_siswa'    => $kelas->siswa()->count(),
            'sisa_kapasitas' => $kelas->kapasitas_maks - $kelas->siswa()->count(),
            'sudah_penuh'    => $kelas->isSudahPenuh(),
        ];

        return view('admin.kelas.show', compact('kelas', 'stats'));
    }

    // ─── EDIT & UPDATE ────────────────────────────────────────────────────────────

    public function edit(Kelas $kelas)
    {
        $gurus        = Guru::aktif()->orderBy('nama_lengkap')->get();
        $ruangs       = Ruang::with('gedung')->orderBy('nama_ruang')->get();
        $tahunAjarans = TahunAjaran::orderByDesc('id')->get();

        return view('admin.kelas.edit', compact('kelas', 'gurus', 'ruangs', 'tahunAjarans'));
    }

    public function update(Request $request, Kelas $kelas)
    {
        $validated = $request->validate([
            'nama_kelas'      => ['required', 'string', 'max:50'],
            'tingkat'         => ['required', 'string', 'in:X,XI,XII'],
            'jurusan'         => ['nullable', 'string', 'max:50'],
            'kode_kelas'      => ['required', 'string', 'max:15', Rule::unique('kelas')->ignore($kelas->id)],
            'wali_kelas_id'   => ['nullable', 'exists:guru,id'],
            'ruang_id'        => ['nullable', 'exists:ruang,id'],
            'tahun_ajaran_id' => ['required', 'exists:tahun_ajaran,id'],
            'kapasitas_maks'  => ['required', 'integer', 'min:1', 'max:50'],
            'status'          => ['required', 'in:aktif,nonaktif'],
        ], $this->pesanValidasi());

        if (! empty($validated['ruang_id'])) {
            $sudahDipakai = Kelas::where('ruang_id', $validated['ruang_id'])
                ->where('tahun_ajaran_id', $validated['tahun_ajaran_id'])
                ->where('status', 'aktif')
                ->where('id', '!=', $kelas->id)
                ->exists();

            if ($sudahDipakai) {
                return back()->withInput()
                    ->with('error', 'Ruangan sudah digunakan oleh kelas lain pada tahun ajaran ini.');
            }
        }

        $kelas->update($validated);

        return redirect()->route('admin.kelas.show', $kelas)
            ->with('success', 'Kelas berhasil diperbarui.');
    }

    // ─── DESTROY ─────────────────────────────────────────────────────────────────

    public function destroy(Kelas $kelas)
    {
        if ($kelas->siswa()->exists()) {
            return back()->with('error', 'Tidak dapat menghapus kelas yang masih memiliki siswa.');
        }
        if ($kelas->jadwalPelajaran()->exists()) {
            return back()->with('error', 'Tidak dapat menghapus kelas yang masih memiliki jadwal pelajaran.');
        }

        $kelas->delete();

        return redirect()->route('admin.kelas.index')
            ->with('success', 'Kelas berhasil dihapus.');
    }

    // ─── EXPORT PDF ──────────────────────────────────────────────────────────────

    public function exportPdf(Request $request)
    {
        $query = Kelas::with(['waliKelas', 'ruang', 'tahunAjaran'])->withCount('siswa');

        if ($request->filled('tahun_ajaran_id')) $query->where('tahun_ajaran_id', $request->tahun_ajaran_id);
        if ($request->filled('tingkat'))         $query->where('tingkat', $request->tingkat);
        if ($request->filled('status'))          $query->where('status', $request->status);

        $kelas = $query->orderBy('tingkat')->orderBy('nama_kelas')->get();

        $filterParts = [];
        if ($request->filled('tingkat')) $filterParts[] = 'Tingkat: ' . $request->tingkat;
        if ($request->filled('status'))  $filterParts[] = 'Status: ' . ucfirst($request->status);
        $filterLabel = implode(', ', $filterParts);

        $pdf = Pdf::loadView('admin.kelas.pdf', compact('kelas', 'filterLabel'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('data-kelas-' . now()->format('Ymd-His') . '.pdf');
    }

    // ─── EXPORT EXCEL ────────────────────────────────────────────────────────────

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new KelasExport($request->all()),
            'kelas-' . now()->format('Ymd-His') . '.xlsx'
        );
    }

    // ─── IMPORT ──────────────────────────────────────────────────────────────────

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:2048'],
        ], [
            'file.required' => 'File impor wajib diunggah.',
            'file.mimes'    => 'Format file harus xlsx, xls, atau csv.',
            'file.max'      => 'Ukuran file tidak boleh melebihi 2 MB.',
        ]);

        try {
            Excel::import(new KelasImport, $request->file('file'));
        } catch (ExcelValidationException $e) {
            $errors = collect($e->failures())->map(
                fn ($f) => "Baris {$f->row()}: " . implode(', ', $f->errors())
            )->implode(' | ');

            return back()->with('error', 'Import gagal: ' . $errors);
        } catch (\Throwable $e) {
            return back()->with('error', 'Import gagal: ' . $e->getMessage());
        }

        return back()->with('success', 'Data kelas berhasil diimpor.');
    }

    // ─── PRIVATE HELPERS ─────────────────────────────────────────────────────────

    private function pesanValidasi(): array
    {
        return [
            'nama_kelas.required'      => 'Nama kelas wajib diisi.',
            'nama_kelas.max'           => 'Nama kelas maksimal 50 karakter.',
            'tingkat.required'         => 'Tingkat wajib dipilih.',
            'tingkat.in'               => 'Tingkat harus berupa X, XI, atau XII.',
            'jurusan.max'              => 'Nama jurusan maksimal 50 karakter.',
            'kode_kelas.required'      => 'Kode kelas wajib diisi.',
            'kode_kelas.max'           => 'Kode kelas maksimal 15 karakter.',
            'kode_kelas.unique'        => 'Kode kelas sudah digunakan.',
            'wali_kelas_id.exists'     => 'Guru wali kelas yang dipilih tidak ditemukan.',
            'ruang_id.exists'          => 'Ruangan yang dipilih tidak ditemukan.',
            'tahun_ajaran_id.required' => 'Tahun ajaran wajib dipilih.',
            'tahun_ajaran_id.exists'   => 'Tahun ajaran yang dipilih tidak ditemukan.',
            'kapasitas_maks.required'  => 'Kapasitas maksimal wajib diisi.',
            'kapasitas_maks.integer'   => 'Kapasitas maksimal harus berupa angka.',
            'kapasitas_maks.min'       => 'Kapasitas maksimal minimal 1 siswa.',
            'kapasitas_maks.max'       => 'Kapasitas maksimal tidak boleh melebihi 50 siswa.',
            'status.required'          => 'Status wajib dipilih.',
            'status.in'                => 'Status harus berupa aktif atau nonaktif.',
        ];
    }
}