<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PelanggaranExport;
use App\Http\Controllers\Controller;
use App\Imports\PelanggaranImport;
use App\Models\KategoriPelanggaran;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException as ExcelValidationException;

class PelanggaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pelanggaran::with(['siswa.kelas', 'kategori', 'dicatatOleh']);

        if ($request->filled('kategori_id')) {
            $query->where('kategori_pelanggaran_id', $request->kategori_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('kelas_id')) {
            $query->whereHas('siswa', fn ($q) => $q->where('kelas_id', $request->kelas_id));
        }
        if ($request->filled('search')) {
            $s = $request->search;
            $query->whereHas('siswa', fn ($q) => $q
                ->where('nama_lengkap', 'like', "%{$s}%")
                ->orWhere('nis', 'like', "%{$s}%"));
        }

        $pelanggaran = $query->latest('tanggal')->paginate(20)->withQueryString();

        $stats = [
            'total'     => Pelanggaran::count(),
            'diproses'  => Pelanggaran::where('status', 'diproses')->count(),
            'bulan_ini' => Pelanggaran::whereMonth('tanggal', now()->month)->whereYear('tanggal', now()->year)->count(),
            'selesai'   => Pelanggaran::where('status', 'selesai')->count(),
        ];

        $kategoriList = KategoriPelanggaran::orderBy('nama')->get();
        $kelasList    = \App\Models\Kelas::aktif()->orderBy('nama_kelas')->get();

        return view('admin.pelanggaran.index', compact('pelanggaran', 'stats', 'kategoriList', 'kelasList'));
    }

    public function create()
    {
        $siswaList    = Siswa::aktif()->with('kelas')->orderBy('nama_lengkap')->get();
        $kategoriList = KategoriPelanggaran::aktif()->orderBy('nama')->get();

        return view('admin.pelanggaran.create', compact('siswaList', 'kategoriList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'siswa_id'                => ['required', 'exists:siswa,id'],
            'kategori_pelanggaran_id' => ['required', 'exists:kategori_pelanggaran,id'],
            'poin'                    => ['required', 'integer', 'min:1', 'max:100'],
            'deskripsi'               => ['required', 'string'],
            'tanggal'                 => ['required', 'date'],
            'tindakan'                => ['nullable', 'string'],
            'status'                  => ['required', Rule::in(['pending', 'diproses', 'selesai', 'banding'])],
        ], $this->messages());

        $validated['dicatat_oleh'] = Auth::id();

        Pelanggaran::create($validated);

        return redirect()->route('admin.pelanggaran.index')
            ->with('success', 'Data pelanggaran berhasil disimpan.');
    }

    public function show(Pelanggaran $pelanggaran)
    {
        $pelanggaran->load(['siswa.kelas', 'kategori', 'dicatatOleh']);

        $totalPoinSiswa = Pelanggaran::where('siswa_id', $pelanggaran->siswa_id)
            ->whereNotIn('status', ['banding'])
            ->sum('poin');

        return view('admin.pelanggaran.show', compact('pelanggaran', 'totalPoinSiswa'));
    }

    public function edit(Pelanggaran $pelanggaran)
    {
        $siswaList    = Siswa::aktif()->with('kelas')->orderBy('nama_lengkap')->get();
        $kategoriList = KategoriPelanggaran::aktif()->orderBy('nama')->get();

        return view('admin.pelanggaran.edit', compact('pelanggaran', 'siswaList', 'kategoriList'));
    }

    public function update(Request $request, Pelanggaran $pelanggaran)
    {
        $validated = $request->validate([
            'siswa_id'                => ['required', 'exists:siswa,id'],
            'kategori_pelanggaran_id' => ['required', 'exists:kategori_pelanggaran,id'],
            'poin'                    => ['required', 'integer', 'min:1', 'max:100'],
            'deskripsi'               => ['required', 'string'],
            'tanggal'                 => ['required', 'date'],
            'tindakan'                => ['nullable', 'string'],
            'status'                  => ['required', Rule::in(['pending', 'diproses', 'selesai', 'banding'])],
        ], $this->messages());

        $pelanggaran->update($validated);

        return redirect()->route('admin.pelanggaran.show', $pelanggaran)
            ->with('success', 'Data pelanggaran berhasil diperbarui.');
    }

    public function destroy(Pelanggaran $pelanggaran)
    {
        $pelanggaran->delete();

        return redirect()->route('admin.pelanggaran.index')
            ->with('success', 'Data pelanggaran berhasil dihapus.');
    }

    public function selesaikan(Request $request, Pelanggaran $pelanggaran)
    {
        $request->validate(['tindakan' => ['nullable', 'string']]);

        $pelanggaran->selesaikan($request->tindakan ?? $pelanggaran->tindakan ?? '-');

        return back()->with('success', 'Pelanggaran berhasil diselesaikan.');
    }

    public function batalkan(Pelanggaran $pelanggaran)
    {
        $pelanggaran->batalkan();

        return back()->with('success', 'Pelanggaran berhasil dibatalkan.');
    }

    public function exportPdf(Request $request)
    {
        $query = Pelanggaran::with(['siswa.kelas', 'kategori', 'dicatatOleh']);

        if ($request->filled('kategori_id'))  $query->where('kategori_pelanggaran_id', $request->kategori_id);
        if ($request->filled('status'))       $query->where('status', $request->status);
        if ($request->filled('kelas_id'))     $query->whereHas('siswa', fn ($q) => $q->where('kelas_id', $request->kelas_id));
        if ($request->filled('search')) {
            $s = $request->search;
            $query->whereHas('siswa', fn ($q) => $q->where('nama_lengkap', 'like', "%{$s}%")->orWhere('nis', 'like', "%{$s}%"));
        }

        $pelanggaran = $query->latest('tanggal')->get();

        $filterParts = [];
        if ($request->filled('status'))    $filterParts[] = 'Status: ' . ucfirst($request->status);
        if ($request->filled('search'))    $filterParts[] = 'Cari: ' . $request->search;
        $filterLabel = implode(', ', $filterParts);

        $pdf = Pdf::loadView('admin.pelanggaran.pdf', compact('pelanggaran', 'filterLabel'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('pelanggaran-' . now()->format('Ymd-His') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new PelanggaranExport($request->all()),
            'pelanggaran-' . now()->format('Ymd-His') . '.xlsx'
        );
    }

    public function importTemplate()
    {
        return Excel::download(
            new \App\Exports\PelanggaranTemplateExport,
            'template-pelanggaran.xlsx'
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
            Excel::import(new PelanggaranImport, $request->file('file'));
        } catch (ExcelValidationException $e) {
            $errors = collect($e->failures())->map(
                fn ($f) => "Baris {$f->row()}: " . implode(', ', $f->errors())
            )->implode(' | ');
            return back()->with('error', 'Import gagal: ' . $errors);
        } catch (\Throwable $e) {
            return back()->with('error', 'Import gagal: ' . $e->getMessage());
        }

        return back()->with('success', 'Data pelanggaran berhasil diimpor.');
    }

    private function messages(): array
    {
        return [
            'siswa_id.required'                => 'Siswa wajib dipilih.',
            'siswa_id.exists'                  => 'Siswa tidak ditemukan.',
            'kategori_pelanggaran_id.required' => 'Kategori pelanggaran wajib dipilih.',
            'kategori_pelanggaran_id.exists'   => 'Kategori tidak ditemukan.',
            'poin.required'                    => 'Poin pelanggaran wajib diisi.',
            'poin.integer'                     => 'Poin harus berupa angka.',
            'poin.min'                         => 'Poin minimal 1.',
            'poin.max'                         => 'Poin maksimal 100.',
            'deskripsi.required'               => 'Deskripsi pelanggaran wajib diisi.',
            'tanggal.required'                 => 'Tanggal kejadian wajib diisi.',
            'tanggal.date'                     => 'Format tanggal tidak valid.',
            'status.required'                  => 'Status wajib dipilih.',
            'status.in'                        => 'Status tidak valid.',
        ];
    }
}