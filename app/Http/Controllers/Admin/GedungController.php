<?php

namespace App\Http\Controllers\Admin;

use App\Exports\GedungExport;
use App\Http\Controllers\Controller;
use App\Imports\GedungImport;
use App\Models\Gedung;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException as ExcelValidationException;

class GedungController extends Controller
{
    // ─── INDEX ───────────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $query = Gedung::withCount('ruang');

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn ($q) => $q
                ->where('nama_gedung', 'like', "%{$s}%")
                ->orWhere('kode_gedung', 'like', "%{$s}%"));
        }

        $gedung = $query->latest()->paginate(15)->withQueryString();

        return view('admin.gedung.index', compact('gedung'));
    }

    // ─── CREATE & STORE ───────────────────────────────────────────────────────────

    public function create()
    {
        return view('admin.gedung.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_gedung'   => ['required', 'string', 'max:10', 'unique:gedung'],
            'nama_gedung'   => ['required', 'string', 'max:100'],
            'jumlah_lantai' => ['required', 'integer', 'min:1', 'max:20'],
            'deskripsi'     => ['nullable', 'string', 'max:1000'],
            'is_active'     => ['boolean'],
        ], $this->pesanValidasi());

        Gedung::create($validated);

        return redirect()->route('admin.gedung.index')
            ->with('success', 'Gedung berhasil ditambahkan.');
    }

    // ─── SHOW ─────────────────────────────────────────────────────────────────────

    public function show(Gedung $gedung)
    {
        $gedung->load(['ruang' => fn ($q) => $q->orderBy('lantai')->orderBy('kode_ruang')]);

        $stats = [
            'total_ruang'    => $gedung->ruang->count(),
            'ruang_tersedia' => $gedung->ruangTersedia()->count(),
            'ruang_terpakai' => $gedung->ruang()->where('status', '!=', 'tersedia')->count(),
        ];

        return view('admin.gedung.show', compact('gedung', 'stats'));
    }

    // ─── EDIT & UPDATE ────────────────────────────────────────────────────────────

    public function edit(Gedung $gedung)
    {
        return view('admin.gedung.edit', compact('gedung'));
    }

    public function update(Request $request, Gedung $gedung)
    {
        $validated = $request->validate([
            'kode_gedung'   => ['required', 'string', 'max:10', Rule::unique('gedung')->ignore($gedung->id)],
            'nama_gedung'   => ['required', 'string', 'max:100'],
            'jumlah_lantai' => ['required', 'integer', 'min:1', 'max:20'],
            'deskripsi'     => ['nullable', 'string', 'max:1000'],
            'is_active'     => ['boolean'],
        ], $this->pesanValidasi());

        $gedung->update($validated);

        return redirect()->route('admin.gedung.show', $gedung)
            ->with('success', 'Gedung berhasil diperbarui.');
    }

    // ─── DESTROY ─────────────────────────────────────────────────────────────────

    public function destroy(Gedung $gedung)
    {
        if ($gedung->ruang()->exists()) {
            return back()->with('error', 'Tidak dapat menghapus gedung yang masih memiliki ruangan.');
        }

        $gedung->delete();

        return redirect()->route('admin.gedung.index')
            ->with('success', 'Gedung berhasil dihapus.');
    }

    // ─── TOGGLE STATUS ────────────────────────────────────────────────────────────

    public function toggleStatus(Gedung $gedung)
    {
        $gedung->update(['is_active' => ! $gedung->is_active]);
        $status = $gedung->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Gedung berhasil {$status}.");
    }

    // ─── EXPORT PDF ──────────────────────────────────────────────────────────────

    public function exportPdf(Request $request)
    {
        $query = Gedung::withCount('ruang');

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn ($q) => $q
                ->where('nama_gedung', 'like', "%{$s}%")
                ->orWhere('kode_gedung', 'like', "%{$s}%"));
        }

        $gedung = $query->orderBy('kode_gedung')->get();

        $filterParts = [];
        if ($request->filled('is_active')) {
            $filterParts[] = 'Status: ' . ($request->boolean('is_active') ? 'Aktif' : 'Nonaktif');
        }
        if ($request->filled('search')) {
            $filterParts[] = 'Cari: ' . $request->search;
        }
        $filterLabel = implode(', ', $filterParts);

        $pdf = Pdf::loadView('admin.gedung.pdf', compact('gedung', 'filterLabel'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('data-gedung-' . now()->format('Ymd-His') . '.pdf');
    }

    // ─── EXPORT EXCEL ────────────────────────────────────────────────────────────

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new GedungExport($request->all()),
            'gedung-' . now()->format('Ymd-His') . '.xlsx'
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
            Excel::import(new GedungImport, $request->file('file'));
        } catch (ExcelValidationException $e) {
            $errors = collect($e->failures())->map(
                fn ($f) => "Baris {$f->row()}: " . implode(', ', $f->errors())
            )->implode(' | ');

            return back()->with('error', 'Import gagal: ' . $errors);
        } catch (\Throwable $e) {
            return back()->with('error', 'Import gagal: ' . $e->getMessage());
        }

        return back()->with('success', 'Data gedung berhasil diimpor.');
    }

    // ─── PRIVATE HELPERS ─────────────────────────────────────────────────────────

    private function pesanValidasi(): array
    {
        return [
            'kode_gedung.required'   => 'Kode gedung wajib diisi.',
            'kode_gedung.max'        => 'Kode gedung maksimal 10 karakter.',
            'kode_gedung.unique'     => 'Kode gedung sudah digunakan.',
            'nama_gedung.required'   => 'Nama gedung wajib diisi.',
            'nama_gedung.max'        => 'Nama gedung maksimal 100 karakter.',
            'jumlah_lantai.required' => 'Jumlah lantai wajib diisi.',
            'jumlah_lantai.integer'  => 'Jumlah lantai harus berupa angka.',
            'jumlah_lantai.min'      => 'Jumlah lantai minimal 1.',
            'jumlah_lantai.max'      => 'Jumlah lantai maksimal 20.',
            'deskripsi.max'          => 'Deskripsi maksimal 1000 karakter.',
        ];
    }
}