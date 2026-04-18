<?php

namespace App\Http\Controllers\Admin;

use App\Exports\MataPelajaranExport;
use App\Http\Controllers\Controller;
use App\Imports\MataPelajaranImport;
use App\Models\MataPelajaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException as ExcelValidationException;

class MataPelajaranController extends Controller
{
    private const KELOMPOK_OPTIONS = ['normatif', 'adaptif', 'produktif', 'muatan_lokal', 'pengembangan_diri'];

    // ─── INDEX ───────────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $query = MataPelajaran::withCount('jadwalPelajaran');

        if ($request->filled('kelompok'))  $query->where('kelompok', $request->kelompok);
        if ($request->filled('is_active')) $query->where('is_active', $request->boolean('is_active'));

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn ($q) => $q
                ->where('nama_mapel', 'like', "%{$s}%")
                ->orWhere('kode_mapel', 'like', "%{$s}%"));
        }

        $mapel     = $query->orderBy('nama_mapel')->paginate(20)->withQueryString();
        $kelompoks = self::KELOMPOK_OPTIONS;

        return view('admin.mata-pelajaran.index', compact('mapel', 'kelompoks'));
    }

    // ─── CREATE & STORE ───────────────────────────────────────────────────────────

    public function create()
    {
        $kelompoks = self::KELOMPOK_OPTIONS;

        return view('admin.mata-pelajaran.create', compact('kelompoks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_mapel'      => ['required', 'string', 'max:100'],
            'kode_mapel'      => ['required', 'string', 'max:15', 'unique:mata_pelajaran'],
            'kelompok'        => ['nullable', Rule::in(self::KELOMPOK_OPTIONS)],
            'jam_per_minggu'  => ['required', 'integer', 'min:1', 'max:20'],
            'durasi_per_sesi' => ['required', 'integer', 'min:30', 'max:180'],
            'perlu_lab'       => ['boolean'],
            'keterangan'      => ['nullable', 'string', 'max:1000'],
            'is_active'       => ['boolean'],
        ], $this->pesanValidasi());

        MataPelajaran::create($validated);

        return redirect()->route('admin.mata-pelajaran.index')
            ->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    // ─── SHOW ─────────────────────────────────────────────────────────────────────

    public function show(MataPelajaran $mataPelajaran)
    {
        $mataPelajaran->load(['jadwalPelajaran.guru', 'jadwalPelajaran.kelas']);
        $guruPengampu = $mataPelajaran->guru()->distinct()->get();

        return view('admin.mata-pelajaran.show', compact('mataPelajaran', 'guruPengampu'));
    }

    // ─── EDIT & UPDATE ────────────────────────────────────────────────────────────

    public function edit(MataPelajaran $mataPelajaran)
    {
        $kelompoks = self::KELOMPOK_OPTIONS;

        return view('admin.mata-pelajaran.edit', compact('mataPelajaran', 'kelompoks'));
    }

    public function update(Request $request, MataPelajaran $mataPelajaran)
    {
        $validated = $request->validate([
            'nama_mapel'      => ['required', 'string', 'max:100'],
            'kode_mapel'      => ['required', 'string', 'max:15',
                Rule::unique('mata_pelajaran')->ignore($mataPelajaran->id)],
            'kelompok'        => ['nullable', Rule::in(self::KELOMPOK_OPTIONS)],
            'jam_per_minggu'  => ['required', 'integer', 'min:1', 'max:20'],
            'durasi_per_sesi' => ['required', 'integer', 'min:30', 'max:180'],
            'perlu_lab'       => ['boolean'],
            'keterangan'      => ['nullable', 'string', 'max:1000'],
            'is_active'       => ['boolean'],
        ], $this->pesanValidasi());

        $mataPelajaran->update($validated);

        return redirect()->route('admin.mata-pelajaran.show', $mataPelajaran)
            ->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    // ─── DESTROY ─────────────────────────────────────────────────────────────────

    public function destroy(MataPelajaran $mataPelajaran)
    {
        if ($mataPelajaran->jadwalPelajaran()->exists()) {
            return back()->with('error', 'Mata pelajaran masih digunakan dalam jadwal pelajaran dan tidak dapat dihapus.');
        }

        $mataPelajaran->delete();

        return redirect()->route('admin.mata-pelajaran.index')
            ->with('success', 'Mata pelajaran berhasil dihapus.');
    }

    // ─── TOGGLE STATUS ────────────────────────────────────────────────────────────

    public function toggleStatus(MataPelajaran $mataPelajaran)
    {
        $mataPelajaran->update(['is_active' => ! $mataPelajaran->is_active]);
        $status = $mataPelajaran->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Mata pelajaran berhasil {$status}.");
    }

    // ─── EXPORT PDF ──────────────────────────────────────────────────────────────

    public function exportPdf(Request $request)
    {
        $query = MataPelajaran::withCount('jadwalPelajaran');

        if ($request->filled('kelompok'))  $query->where('kelompok', $request->kelompok);
        if ($request->filled('is_active')) $query->where('is_active', $request->boolean('is_active'));

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn ($q) => $q
                ->where('nama_mapel', 'like', "%{$s}%")
                ->orWhere('kode_mapel', 'like', "%{$s}%"));
        }

        $mapel = $query->orderBy('nama_mapel')->get();

        $filterParts = [];
        if ($request->filled('kelompok'))  $filterParts[] = 'Kelompok: ' . ucfirst(str_replace('_', ' ', $request->kelompok));
        if ($request->filled('is_active')) $filterParts[] = 'Status: ' . ($request->boolean('is_active') ? 'Aktif' : 'Nonaktif');
        if ($request->filled('search'))    $filterParts[] = 'Cari: ' . $request->search;
        $filterLabel = implode(', ', $filterParts);

        $pdf = Pdf::loadView('admin.mata-pelajaran.pdf', compact('mapel', 'filterLabel'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('data-mata-pelajaran-' . now()->format('Ymd-His') . '.pdf');
    }

    // ─── EXPORT EXCEL ────────────────────────────────────────────────────────────

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new MataPelajaranExport($request->all()),
            'mata-pelajaran-' . now()->format('Ymd-His') . '.xlsx'
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
            Excel::import(new MataPelajaranImport, $request->file('file'));
        } catch (ExcelValidationException $e) {
            $errors = collect($e->failures())->map(
                fn ($f) => "Baris {$f->row()}: " . implode(', ', $f->errors())
            )->implode(' | ');

            return back()->with('error', 'Import gagal: ' . $errors);
        } catch (\Throwable $e) {
            return back()->with('error', 'Import gagal: ' . $e->getMessage());
        }

        return back()->with('success', 'Data mata pelajaran berhasil diimpor.');
    }

    // ─── PRIVATE HELPERS ─────────────────────────────────────────────────────────

    private function pesanValidasi(): array
    {
        return [
            'nama_mapel.required'      => 'Nama mata pelajaran wajib diisi.',
            'nama_mapel.max'           => 'Nama mata pelajaran maksimal 100 karakter.',
            'kode_mapel.required'      => 'Kode mata pelajaran wajib diisi.',
            'kode_mapel.max'           => 'Kode mata pelajaran maksimal 15 karakter.',
            'kode_mapel.unique'        => 'Kode mata pelajaran sudah digunakan.',
            'kelompok.in'              => 'Kelompok mata pelajaran tidak valid.',
            'jam_per_minggu.required'  => 'Jam per minggu wajib diisi.',
            'jam_per_minggu.integer'   => 'Jam per minggu harus berupa angka.',
            'jam_per_minggu.min'       => 'Jam per minggu minimal 1.',
            'jam_per_minggu.max'       => 'Jam per minggu maksimal 20.',
            'durasi_per_sesi.required' => 'Durasi per sesi wajib diisi.',
            'durasi_per_sesi.integer'  => 'Durasi per sesi harus berupa angka (menit).',
            'durasi_per_sesi.min'      => 'Durasi per sesi minimal 30 menit.',
            'durasi_per_sesi.max'      => 'Durasi per sesi maksimal 180 menit.',
            'keterangan.max'           => 'Keterangan maksimal 1000 karakter.',
        ];
    }
}