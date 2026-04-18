<?php

namespace App\Http\Controllers\Admin;

use App\Exports\TahunAjaranExport;
use App\Http\Controllers\Controller;
use App\Imports\TahunAjaranImport;
use App\Models\TahunAjaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException as ExcelValidationException;

class TahunAjaranController extends Controller
{
    public function index(Request $request)
    {
        $query = TahunAjaran::query();

        if ($request->filled('search')) {
            $query->where('tahun', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $tahunAjaran = $query->latest()->paginate(15)->withQueryString();
        $aktif       = TahunAjaran::getAktif();

        $stats = [
            'total'      => TahunAjaran::count(),
            'tidak_aktif'=> TahunAjaran::where('status', 'tidak_aktif')->count(),
        ];

        return view('admin.tahun-ajaran.index', compact('tahunAjaran', 'aktif', 'stats'));
    }

    public function create()
    {
        return view('admin.tahun-ajaran.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun'           => ['required', 'string', 'max:20',
                Rule::unique('tahun_ajaran')->where('semester', $request->semester)],
            'semester'        => ['required', 'in:ganjil,genap'],
            'tanggal_mulai'   => ['required', 'date'],
            'tanggal_selesai' => ['required', 'date', 'after:tanggal_mulai'],
            'status'          => ['required', 'in:aktif,tidak_aktif'],
            'keterangan'      => ['nullable', 'string', 'max:500'],
        ], $this->pesanValidasi());

        $tahun = TahunAjaran::create($validated);

        if ($tahun->status === 'aktif') {
            $tahun->aktifkan();
        }

        return redirect()->route('admin.tahun-ajaran.index')
            ->with('success', 'Tahun ajaran berhasil ditambahkan.');
    }

    public function show(TahunAjaran $tahunAjaran)
    {
        $tahunAjaran->loadCount(['kelas', 'jadwalPelajaran', 'nilai', 'siswa']);

        $stats = [
            'total_kelas'  => $tahunAjaran->kelas_count,
            'total_jadwal' => $tahunAjaran->jadwal_pelajaran_count,
            'total_nilai'  => $tahunAjaran->nilai_count,
            'total_siswa'  => $tahunAjaran->siswa_count,
        ];

        return view('admin.tahun-ajaran.show', compact('tahunAjaran', 'stats'));
    }

    public function edit(TahunAjaran $tahunAjaran)
    {
        return view('admin.tahun-ajaran.edit', compact('tahunAjaran'));
    }

    public function update(Request $request, TahunAjaran $tahunAjaran)
    {
        $validated = $request->validate([
            'tahun'           => ['required', 'string', 'max:20',
                Rule::unique('tahun_ajaran')
                    ->where('semester', $request->semester)
                    ->ignore($tahunAjaran->id)],
            'semester'        => ['required', 'in:ganjil,genap'],
            'tanggal_mulai'   => ['required', 'date'],
            'tanggal_selesai' => ['required', 'date', 'after:tanggal_mulai'],
            'status'          => ['required', 'in:aktif,tidak_aktif'],
            'keterangan'      => ['nullable', 'string', 'max:500'],
        ], $this->pesanValidasi());

        $tahunAjaran->update($validated);

        if ($tahunAjaran->fresh()->status === 'aktif') {
            $tahunAjaran->aktifkan();
        }

        return redirect()->route('admin.tahun-ajaran.show', $tahunAjaran)
            ->with('success', 'Tahun ajaran berhasil diperbarui.');
    }

    public function destroy(TahunAjaran $tahunAjaran)
    {
        if ($tahunAjaran->isAktif()) {
            return back()->with('error', 'Tidak dapat menghapus tahun ajaran yang sedang aktif.');
        }

        if ($tahunAjaran->kelas()->exists() || $tahunAjaran->jadwalPelajaran()->exists()) {
            return back()->with('error', 'Tidak dapat menghapus tahun ajaran yang masih memiliki data kelas atau jadwal pelajaran.');
        }

        $tahunAjaran->delete();

        return redirect()->route('admin.tahun-ajaran.index')
            ->with('success', 'Tahun ajaran berhasil dihapus.');
    }

    public function aktifkan(TahunAjaran $tahunAjaran)
    {
        if ($tahunAjaran->isAktif()) {
            return back()->with('error', 'Tahun ajaran ini sudah aktif.');
        }

        $tahunAjaran->aktifkan();

        return back()->with('success', "Tahun ajaran {$tahunAjaran->label} berhasil diaktifkan.");
    }

    public function exportPdf(Request $request)
    {
        $tahunAjaran = TahunAjaran::orderByDesc('id')->get();

        $pdf = Pdf::loadView('admin.tahun-ajaran.pdf', compact('tahunAjaran'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('data-tahun-ajaran-' . now()->format('Ymd-His') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new TahunAjaranExport($request->all()),
            'tahun-ajaran-' . now()->format('Ymd-His') . '.xlsx'
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
            Excel::import(new TahunAjaranImport, $request->file('file'));
        } catch (ExcelValidationException $e) {
            $errors = collect($e->failures())
                ->map(fn($f) => "Baris {$f->row()}: " . implode(', ', $f->errors()))
                ->implode(' | ');

            return back()->with('error', 'Import gagal: ' . $errors);
        } catch (\Throwable $e) {
            return back()->with('error', 'Import gagal: ' . $e->getMessage());
        }

        return back()->with('success', 'Data tahun ajaran berhasil diimpor.');
    }

    private function pesanValidasi(): array
    {
        return [
            'tahun.required'           => 'Tahun ajaran wajib diisi.',
            'tahun.max'                => 'Tahun ajaran maksimal 20 karakter.',
            'tahun.unique'             => 'Kombinasi tahun dan semester ini sudah terdaftar.',
            'semester.required'        => 'Semester wajib dipilih.',
            'semester.in'              => 'Semester harus ganjil atau genap.',
            'tanggal_mulai.required'   => 'Tanggal mulai wajib diisi.',
            'tanggal_mulai.date'       => 'Format tanggal mulai tidak valid.',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi.',
            'tanggal_selesai.date'     => 'Format tanggal selesai tidak valid.',
            'tanggal_selesai.after'    => 'Tanggal selesai harus setelah tanggal mulai.',
            'status.required'          => 'Status wajib dipilih.',
            'status.in'                => 'Status harus aktif atau tidak aktif.',
            'keterangan.max'           => 'Keterangan maksimal 500 karakter.',
        ];
    }
}