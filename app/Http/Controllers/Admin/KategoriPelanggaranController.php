<?php

namespace App\Http\Controllers\Admin;

use App\Exports\KategoriPelanggaranExport;
use App\Http\Controllers\Controller;
use App\Imports\KategoriPelanggaranImport;
use App\Models\KategoriPelanggaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException as ExcelValidationException;

class KategoriPelanggaranController extends Controller
{
    public function index(Request $request)
    {
        $query = KategoriPelanggaran::withCount('pelanggaran');

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('tingkat')) {
            $query->where('tingkat', $request->tingkat);
        }
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        $kategori = $query->orderBy('tingkat')->orderBy('nama')->paginate(15)->withQueryString();

        return view('admin.kategori-pelanggaran.index', compact('kategori'));
    }

    public function create()
    {
        return view('admin.kategori-pelanggaran.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'        => ['required', 'string', 'max:100', 'unique:kategori_pelanggaran,nama'],
            'deskripsi'   => ['nullable', 'string'],
            'tingkat'     => ['required', Rule::in(['ringan', 'sedang', 'berat'])],
            'poin_default'=> ['required', 'integer', 'min:1', 'max:100'],
            'batas_poin'  => ['nullable', 'integer', 'min:1'],
            'warna'       => ['nullable', 'string', 'max:30'],
            'is_active'   => ['boolean'],
        ], $this->messages());

        KategoriPelanggaran::create($validated);

        return redirect()->route('admin.kategori-pelanggaran.index')
            ->with('success', 'Kategori pelanggaran berhasil ditambahkan.');
    }

    public function show(KategoriPelanggaran $kategoriPelanggaran)
    {
        $totalKasus      = $kategoriPelanggaran->pelanggaran()->count();
        $siswaUnik       = $kategoriPelanggaran->pelanggaran()->distinct('siswa_id')->count();
        $pelanggaranTerbaru = $kategoriPelanggaran->pelanggaran()
            ->with(['siswa.kelas'])
            ->latest('tanggal')
            ->limit(10)
            ->get();

        return view('admin.kategori-pelanggaran.show',
            compact('kategoriPelanggaran', 'totalKasus', 'siswaUnik', 'pelanggaranTerbaru'));
    }

    public function edit(KategoriPelanggaran $kategoriPelanggaran)
    {
        return view('admin.kategori-pelanggaran.edit', compact('kategoriPelanggaran'));
    }

    public function update(Request $request, KategoriPelanggaran $kategoriPelanggaran)
    {
        $validated = $request->validate([
            'nama'        => ['required', 'string', 'max:100', Rule::unique('kategori_pelanggaran', 'nama')->ignore($kategoriPelanggaran->id)],
            'deskripsi'   => ['nullable', 'string'],
            'tingkat'     => ['required', Rule::in(['ringan', 'sedang', 'berat'])],
            'poin_default'=> ['required', 'integer', 'min:1', 'max:100'],
            'batas_poin'  => ['nullable', 'integer', 'min:1'],
            'warna'       => ['nullable', 'string', 'max:30'],
            'is_active'   => ['boolean'],
        ], $this->messages());

        $kategoriPelanggaran->update($validated);

        return redirect()->route('admin.kategori-pelanggaran.show', $kategoriPelanggaran)
            ->with('success', 'Kategori pelanggaran berhasil diperbarui.');
    }

    public function destroy(KategoriPelanggaran $kategoriPelanggaran)
    {
        if ($kategoriPelanggaran->pelanggaran()->exists()) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena sudah digunakan di data pelanggaran.');
        }

        $kategoriPelanggaran->delete();

        return redirect()->route('admin.kategori-pelanggaran.index')
            ->with('success', 'Kategori pelanggaran berhasil dihapus.');
    }

    public function toggleStatus(KategoriPelanggaran $kategoriPelanggaran)
    {
        $kategoriPelanggaran->update(['is_active' => ! $kategoriPelanggaran->is_active]);
        $status = $kategoriPelanggaran->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Kategori berhasil {$status}.");
    }

    public function exportPdf(Request $request)
    {
        $query = KategoriPelanggaran::withCount('pelanggaran');

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('tingkat')) {
            $query->where('tingkat', $request->tingkat);
        }
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        $kategori = $query->orderBy('tingkat')->orderBy('nama')->get();

        $filterParts = [];
        if ($request->filled('tingkat'))   $filterParts[] = 'Tingkat: ' . ucfirst($request->tingkat);
        if ($request->filled('is_active')) $filterParts[] = 'Status: ' . ($request->boolean('is_active') ? 'Aktif' : 'Nonaktif');
        if ($request->filled('search'))    $filterParts[] = 'Cari: ' . $request->search;
        $filterLabel = implode(', ', $filterParts);

        $pdf = Pdf::loadView('admin.kategori-pelanggaran.pdf', compact('kategori', 'filterLabel'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('kategori-pelanggaran-' . now()->format('Ymd-His') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new KategoriPelanggaranExport($request->all()),
            'kategori-pelanggaran-' . now()->format('Ymd-His') . '.xlsx'
        );
    }

    public function importTemplate()
    {
        return Excel::download(
            new \App\Exports\KategoriPelanggaranTemplateExport,
            'template-kategori-pelanggaran.xlsx'
        );
    }

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
            Excel::import(new KategoriPelanggaranImport, $request->file('file'));
        } catch (ExcelValidationException $e) {
            $errors = collect($e->failures())->map(
                fn ($f) => "Baris {$f->row()}: " . implode(', ', $f->errors())
            )->implode(' | ');
            return back()->with('error', 'Import gagal: ' . $errors);
        } catch (\Throwable $e) {
            return back()->with('error', 'Import gagal: ' . $e->getMessage());
        }

        return back()->with('success', 'Data kategori pelanggaran berhasil diimpor.');
    }

    private function messages(): array
    {
        return [
            'nama.required'         => 'Nama kategori wajib diisi.',
            'nama.max'              => 'Nama kategori maksimal 100 karakter.',
            'nama.unique'           => 'Nama kategori sudah digunakan.',
            'tingkat.required'      => 'Tingkat pelanggaran wajib dipilih.',
            'tingkat.in'            => 'Tingkat harus ringan, sedang, atau berat.',
            'poin_default.required' => 'Poin default wajib diisi.',
            'poin_default.integer'  => 'Poin default harus berupa angka.',
            'poin_default.min'      => 'Poin default minimal 1.',
            'poin_default.max'      => 'Poin default maksimal 100.',
            'batas_poin.integer'    => 'Batas poin harus berupa angka.',
            'batas_poin.min'        => 'Batas poin minimal 1.',
        ];
    }
}