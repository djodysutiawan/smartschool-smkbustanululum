<?php

namespace App\Http\Controllers\Admin;

use App\Exports\RuangExport;
use App\Http\Controllers\Controller;
use App\Imports\RuangImport;
use App\Models\Gedung;
use App\Models\Ruang;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException as ExcelValidationException;

class RuangController extends Controller
{
    private const JENIS_RUANG = [
        'kelas', 'laboratorium_komputer', 'laboratorium_ipa',
        'laboratorium_bahasa', 'aula', 'perpustakaan', 'ruang_praktik', 'lainnya',
    ];

    private const STATUS_OPTIONS = ['tersedia', 'tidak_tersedia', 'perbaikan'];

    // ─── INDEX ───────────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $query = Ruang::with('gedung');

        if ($request->filled('gedung_id'))   $query->where('gedung_id', $request->gedung_id);
        if ($request->filled('jenis_ruang')) $query->where('jenis_ruang', $request->jenis_ruang);
        if ($request->filled('status'))      $query->where('status', $request->status);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn ($q) => $q
                ->where('nama_ruang', 'like', "%{$s}%")
                ->orWhere('kode_ruang', 'like', "%{$s}%"));
        }

        $ruang   = $query->orderBy('gedung_id')->orderBy('lantai')->orderBy('kode_ruang')
            ->paginate(20)->withQueryString();
        $gedungs = Gedung::aktif()->orderBy('nama_gedung')->get();

        return view('admin.ruang.index', compact('ruang', 'gedungs'));
    }

    // ─── CREATE & STORE ───────────────────────────────────────────────────────────

    public function create()
    {
        $gedungs       = Gedung::aktif()->orderBy('nama_gedung')->get();
        $jenisOptions  = self::JENIS_RUANG;
        $statusOptions = self::STATUS_OPTIONS;

        return view('admin.ruang.create', compact('gedungs', 'jenisOptions', 'statusOptions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'gedung_id'      => ['required', 'exists:gedung,id'],
            'kode_ruang'     => ['required', 'string', 'max:15', 'unique:ruang'],
            'nama_ruang'     => ['required', 'string', 'max:100'],
            'lantai'         => ['required', 'integer', 'min:1'],
            'jenis_ruang'    => ['required', Rule::in(self::JENIS_RUANG)],
            'kapasitas'      => ['required', 'integer', 'min:1', 'max:500'],
            'ada_proyektor'  => ['boolean'],
            'ada_ac'         => ['boolean'],
            'ada_wifi'       => ['boolean'],
            'ada_komputer'   => ['boolean'],
            'fasilitas_lain' => ['nullable', 'string', 'max:500'],
            'status'         => ['required', Rule::in(self::STATUS_OPTIONS)],
            'keterangan'     => ['nullable', 'string', 'max:500'],
        ], $this->pesanValidasi());

        Ruang::create($validated);

        return redirect()->route('admin.ruang.index')
            ->with('success', 'Ruangan berhasil ditambahkan.');
    }

    // ─── SHOW ─────────────────────────────────────────────────────────────────────

    public function show(Ruang $ruang)
    {
        $ruang->load(['gedung', 'kelas.tahunAjaran', 'jadwalPelajaran.guru', 'jadwalPelajaran.mataPelajaran']);

        return view('admin.ruang.show', compact('ruang'));
    }

    // ─── EDIT & UPDATE ────────────────────────────────────────────────────────────

    public function edit(Ruang $ruang)
    {
        $gedungs       = Gedung::aktif()->orderBy('nama_gedung')->get();
        $jenisOptions  = self::JENIS_RUANG;
        $statusOptions = self::STATUS_OPTIONS;

        return view('admin.ruang.edit', compact('ruang', 'gedungs', 'jenisOptions', 'statusOptions'));
    }

    public function update(Request $request, Ruang $ruang)
    {
        $validated = $request->validate([
            'gedung_id'      => ['required', 'exists:gedung,id'],
            'kode_ruang'     => ['required', 'string', 'max:15', Rule::unique('ruang')->ignore($ruang->id)],
            'nama_ruang'     => ['required', 'string', 'max:100'],
            'lantai'         => ['required', 'integer', 'min:1'],
            'jenis_ruang'    => ['required', Rule::in(self::JENIS_RUANG)],
            'kapasitas'      => ['required', 'integer', 'min:1', 'max:500'],
            'ada_proyektor'  => ['boolean'],
            'ada_ac'         => ['boolean'],
            'ada_wifi'       => ['boolean'],
            'ada_komputer'   => ['boolean'],
            'fasilitas_lain' => ['nullable', 'string', 'max:500'],
            'status'         => ['required', Rule::in(self::STATUS_OPTIONS)],
            'keterangan'     => ['nullable', 'string', 'max:500'],
        ], $this->pesanValidasi());

        $ruang->update($validated);

        return redirect()->route('admin.ruang.show', $ruang)
            ->with('success', 'Ruangan berhasil diperbarui.');
    }

    // ─── DESTROY ─────────────────────────────────────────────────────────────────

    public function destroy(Ruang $ruang)
    {
        if ($ruang->kelas()->exists()) {
            return back()->with('error', 'Tidak dapat menghapus ruangan yang masih digunakan oleh kelas.');
        }
        if ($ruang->jadwalPelajaran()->exists()) {
            return back()->with('error', 'Tidak dapat menghapus ruangan yang masih digunakan dalam jadwal pelajaran.');
        }

        $ruang->delete();

        return redirect()->route('admin.ruang.index')
            ->with('success', 'Ruangan berhasil dihapus.');
    }

    // ─── EXPORT PDF ──────────────────────────────────────────────────────────────

    public function exportPdf(Request $request)
    {
        $query = Ruang::with('gedung');

        if ($request->filled('gedung_id'))   $query->where('gedung_id', $request->gedung_id);
        if ($request->filled('jenis_ruang')) $query->where('jenis_ruang', $request->jenis_ruang);
        if ($request->filled('status'))      $query->where('status', $request->status);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn ($q) => $q
                ->where('nama_ruang', 'like', "%{$s}%")
                ->orWhere('kode_ruang', 'like', "%{$s}%"));
        }

        $ruang = $query->orderBy('gedung_id')->orderBy('lantai')->orderBy('kode_ruang')->get();

        $filterParts = [];
        if ($request->filled('gedung_id'))   $filterParts[] = 'Gedung: ' . optional(Gedung::find($request->gedung_id))->nama_gedung;
        if ($request->filled('jenis_ruang')) $filterParts[] = 'Jenis: ' . ucfirst(str_replace('_', ' ', $request->jenis_ruang));
        if ($request->filled('status'))      $filterParts[] = 'Status: ' . ucfirst(str_replace('_', ' ', $request->status));
        if ($request->filled('search'))      $filterParts[] = 'Cari: ' . $request->search;
        $filterLabel = implode(', ', $filterParts);

        $pdf = Pdf::loadView('admin.ruang.pdf', compact('ruang', 'filterLabel'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('data-ruang-' . now()->format('Ymd-His') . '.pdf');
    }

    // ─── EXPORT EXCEL ────────────────────────────────────────────────────────────

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new RuangExport($request->all()),
            'ruang-' . now()->format('Ymd-His') . '.xlsx'
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
            Excel::import(new RuangImport, $request->file('file'));
        } catch (ExcelValidationException $e) {
            $errors = collect($e->failures())->map(
                fn ($f) => "Baris {$f->row()}: " . implode(', ', $f->errors())
            )->implode(' | ');

            return back()->with('error', 'Import gagal: ' . $errors);
        } catch (\Throwable $e) {
            return back()->with('error', 'Import gagal: ' . $e->getMessage());
        }

        return back()->with('success', 'Data ruangan berhasil diimpor.');
    }

    // ─── PRIVATE HELPERS ─────────────────────────────────────────────────────────

    private function pesanValidasi(): array
    {
        return [
            'gedung_id.required'   => 'Gedung wajib dipilih.',
            'gedung_id.exists'     => 'Gedung yang dipilih tidak ditemukan.',
            'kode_ruang.required'  => 'Kode ruang wajib diisi.',
            'kode_ruang.max'       => 'Kode ruang maksimal 15 karakter.',
            'kode_ruang.unique'    => 'Kode ruang sudah digunakan.',
            'nama_ruang.required'  => 'Nama ruang wajib diisi.',
            'nama_ruang.max'       => 'Nama ruang maksimal 100 karakter.',
            'lantai.required'      => 'Lantai wajib diisi.',
            'lantai.integer'       => 'Lantai harus berupa angka.',
            'lantai.min'           => 'Lantai minimal 1.',
            'jenis_ruang.required' => 'Jenis ruang wajib dipilih.',
            'jenis_ruang.in'       => 'Jenis ruang yang dipilih tidak valid.',
            'kapasitas.required'   => 'Kapasitas ruang wajib diisi.',
            'kapasitas.integer'    => 'Kapasitas harus berupa angka.',
            'kapasitas.min'        => 'Kapasitas minimal 1.',
            'kapasitas.max'        => 'Kapasitas maksimal 500.',
            'fasilitas_lain.max'   => 'Keterangan fasilitas lain maksimal 500 karakter.',
            'status.required'      => 'Status wajib dipilih.',
            'status.in'            => 'Status yang dipilih tidak valid.',
            'keterangan.max'       => 'Keterangan maksimal 500 karakter.',
        ];
    }
}