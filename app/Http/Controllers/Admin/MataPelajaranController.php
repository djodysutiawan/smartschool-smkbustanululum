<?php

namespace App\Http\Controllers\Admin;

use App\Exports\MataPelajaranExport;
use App\Http\Controllers\Controller;
use App\Imports\MataPelajaranImport;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\MataPelajaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException as ExcelValidationException;

class MataPelajaranController extends Controller
{
    private const KELOMPOK_OPTIONS = [
        'normatif', 'adaptif', 'produktif', 'muatan_lokal', 'pengembangan_diri',
    ];

    // ── INDEX ─────────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $query = MataPelajaran::withCount('jadwalPelajaran');

        if ($request->filled('kelompok'))  $query->where('kelompok', $request->kelompok);
        if ($request->filled('scope'))     $query->where('scope', $request->scope);

        // FIX #1: is_active filter — gunakan filled() + strict string check
        // agar '0' (nonaktif) tetap diproses (bukan dianggap empty)
        if ($request->has('is_active') && $request->input('is_active') !== '') {
            $query->where('is_active', $request->input('is_active') === '1');
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn ($q) => $q
                ->where('nama_mapel', 'like', "%{$s}%")
                ->orWhere('kode_mapel', 'like', "%{$s}%"));
        }

        $mapel     = $query->orderBy('nama_mapel')->paginate(20)->withQueryString();
        $kelompoks = self::KELOMPOK_OPTIONS;

        // Stats dihitung dari seluruh data (bukan dari hasil filter) agar konsisten
        $stats = [
            'total'     => MataPelajaran::count(),
            'aktif'     => MataPelajaran::where('is_active', true)->count(),
            'nonaktif'  => MataPelajaran::where('is_active', false)->count(),
            'perlu_lab' => MataPelajaran::where('perlu_lab', true)->count(),
        ];

        return view('admin.mata-pelajaran.index', compact('mapel', 'kelompoks', 'stats'));
    }

    // ── CREATE & STORE ────────────────────────────────────────────────────────

    public function create()
    {
        $kelompoks = self::KELOMPOK_OPTIONS;
        $jurusans  = Jurusan::where('is_published', true)->orderBy('urutan')->get();

        return view('admin.mata-pelajaran.create', compact('kelompoks', 'jurusans'));
    }

    public function store(Request $request)
    {
        // FIX #2: 'sometimes','boolean' agar field tidak wajib hadir
        // (checkbox yang tidak dicentang tidak dikirim browser).
        // 'perlu_lab' & 'is_active' pakai hidden input di view sehingga
        // selalu hadir, tapi 'sometimes' tetap lebih defensif.
        $validated = $request->validate([
            'nama_mapel'        => ['required', 'string', 'max:100'],
            'kode_mapel'        => ['required', 'string', 'max:15', 'unique:mata_pelajaran'],
            'kelompok'          => ['nullable', Rule::in(self::KELOMPOK_OPTIONS)],
            'scope'             => ['required', 'in:umum,jurusan'],
            'jam_per_minggu'    => ['required', 'integer', 'min:1', 'max:20'],
            'durasi_per_sesi'   => ['required', 'integer', 'min:30', 'max:180'],
            'perlu_lab'         => ['sometimes', 'boolean'],
            'keterangan'        => ['nullable', 'string', 'max:1000'],
            'is_active'         => ['sometimes', 'boolean'],
            'jurusan_ids'       => ['nullable', 'array'],
            'jurusan_ids.*'     => ['exists:jurusan,id'],
            'tingkat_jurusan'   => ['nullable', 'array'],
            'tingkat_jurusan.*' => ['nullable', 'in:10,11,12'],
            'jam_jurusan'       => ['nullable', 'array'],
            'jam_jurusan.*'     => ['nullable', 'integer', 'min:1', 'max:20'],
        ], $this->pesanValidasi());

        // FIX #3: Pastikan boolean selalu tersimpan dengan benar
        // walau hidden input mengirim "0"/"1" sebagai string
        $validated['perlu_lab'] = $request->boolean('perlu_lab');
        $validated['is_active'] = $request->boolean('is_active');

        $mapel = MataPelajaran::create($validated);

        // Sync pivot jurusan hanya jika scope=jurusan dan ada jurusan dipilih
        if ($validated['scope'] === 'jurusan' && ! empty($validated['jurusan_ids'])) {
            $this->syncJurusan($mapel, $request);
        }

        return redirect()->route('admin.mata-pelajaran.index')
            ->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    // ── SHOW ──────────────────────────────────────────────────────────────────

    public function show(MataPelajaran $mataPelajaran)
    {
        // FIX #4: Hapus 'jadwalPelajaran.kelas.tahunAjaran' dari eager load
        // karena tidak dipakai di view — mengurangi query tidak perlu
        $mataPelajaran->load([
            'jadwalPelajaran.guru',
            'jadwalPelajaran.kelas',
            'jurusan',
        ]);

        // FIX #5: Query builder dengan select + distinct agar tidak duplikat
        // dan tidak ambiguous column pada beberapa database engine
        $guruPengampu = Guru::select('guru.*')
            ->join('jadwal_pelajaran', 'guru.id', '=', 'jadwal_pelajaran.guru_id')
            ->where('jadwal_pelajaran.mata_pelajaran_id', $mataPelajaran->id)
            ->distinct()
            ->get();

        return view('admin.mata-pelajaran.show', compact('mataPelajaran', 'guruPengampu'));
    }

    // ── EDIT & UPDATE ─────────────────────────────────────────────────────────

    public function edit(MataPelajaran $mataPelajaran)
    {
        $kelompoks = self::KELOMPOK_OPTIONS;
        $jurusans  = Jurusan::where('is_published', true)->orderBy('urutan')->get();
        $mataPelajaran->load('jurusan');

        // Bentuk data pivot yang sudah ada untuk ditampilkan di form
        $pivotExisting = $mataPelajaran->jurusan->keyBy('id')->map(fn($j) => [
            'jam_per_minggu' => $j->pivot->jam_per_minggu,
            'tingkat'        => $j->pivot->tingkat,
            'is_active'      => $j->pivot->is_active,
        ]);

        return view('admin.mata-pelajaran.edit',
            compact('mataPelajaran', 'kelompoks', 'jurusans', 'pivotExisting'));
    }

    public function update(Request $request, MataPelajaran $mataPelajaran)
    {
        // FIX #6: Sama dengan store — pakai 'sometimes','boolean'
        $validated = $request->validate([
            'nama_mapel'        => ['required', 'string', 'max:100'],
            'kode_mapel'        => ['required', 'string', 'max:15',
                Rule::unique('mata_pelajaran')->ignore($mataPelajaran->id)],
            'kelompok'          => ['nullable', Rule::in(self::KELOMPOK_OPTIONS)],
            'scope'             => ['required', 'in:umum,jurusan'],
            'jam_per_minggu'    => ['required', 'integer', 'min:1', 'max:20'],
            'durasi_per_sesi'   => ['required', 'integer', 'min:30', 'max:180'],
            'perlu_lab'         => ['sometimes', 'boolean'],
            'keterangan'        => ['nullable', 'string', 'max:1000'],
            'is_active'         => ['sometimes', 'boolean'],
            'jurusan_ids'       => ['nullable', 'array'],
            'jurusan_ids.*'     => ['exists:jurusan,id'],
            'tingkat_jurusan'   => ['nullable', 'array'],
            'tingkat_jurusan.*' => ['nullable', 'in:10,11,12'],
            'jam_jurusan'       => ['nullable', 'array'],
            'jam_jurusan.*'     => ['nullable', 'integer', 'min:1', 'max:20'],
        ], $this->pesanValidasi());

        // FIX #7: Pastikan boolean tersimpan benar
        $validated['perlu_lab'] = $request->boolean('perlu_lab');
        $validated['is_active'] = $request->boolean('is_active');

        $mataPelajaran->update($validated);

        if ($validated['scope'] === 'jurusan') {
            $this->syncJurusan($mataPelajaran, $request);
        } else {
            // scope=umum → lepas semua pivot
            $mataPelajaran->jurusan()->detach();
        }

        return redirect()->route('admin.mata-pelajaran.show', $mataPelajaran)
            ->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    // ── DESTROY ───────────────────────────────────────────────────────────────

    public function destroy(MataPelajaran $mataPelajaran)
    {
        if ($mataPelajaran->jadwalPelajaran()->exists()) {
            return back()->with('error', 'Mata pelajaran masih digunakan dalam jadwal dan tidak dapat dihapus.');
        }

        $mataPelajaran->jurusan()->detach();
        $mataPelajaran->delete();

        return redirect()->route('admin.mata-pelajaran.index')
            ->with('success', 'Mata pelajaran berhasil dihapus.');
    }

    // ── TOGGLE STATUS ─────────────────────────────────────────────────────────

    public function toggleStatus(MataPelajaran $mataPelajaran)
    {
        $mataPelajaran->update(['is_active' => ! $mataPelajaran->is_active]);
        $status = $mataPelajaran->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Mata pelajaran berhasil {$status}.");
    }

    // ── EXPORT PDF ────────────────────────────────────────────────────────────

    public function exportPdf(Request $request)
    {
        $query = MataPelajaran::with('jurusan')->withCount('jadwalPelajaran');

        if ($request->filled('kelompok'))  $query->where('kelompok', $request->kelompok);
        if ($request->filled('scope'))     $query->where('scope', $request->scope);

        // FIX #8: Konsisten dengan filter index — pakai has() + strict check
        if ($request->has('is_active') && $request->input('is_active') !== '') {
            $query->where('is_active', $request->input('is_active') === '1');
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn ($q) => $q
                ->where('nama_mapel', 'like', "%{$s}%")
                ->orWhere('kode_mapel', 'like', "%{$s}%"));
        }

        $mapel = $query->orderBy('nama_mapel')->get();

        $filterParts = [];
        if ($request->filled('kelompok'))  $filterParts[] = 'Kelompok: ' . ucfirst(str_replace('_', ' ', $request->kelompok));
        if ($request->filled('scope'))     $filterParts[] = 'Scope: ' . ucfirst($request->scope);
        if ($request->has('is_active') && $request->input('is_active') !== '') {
            $filterParts[] = 'Status: ' . ($request->input('is_active') === '1' ? 'Aktif' : 'Nonaktif');
        }
        $filterLabel = implode(', ', $filterParts);

        $pdf = Pdf::loadView('admin.mata-pelajaran.pdf', compact('mapel', 'filterLabel'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('data-mata-pelajaran-' . now()->format('Ymd-His') . '.pdf');
    }

    // ── EXPORT EXCEL ──────────────────────────────────────────────────────────

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new MataPelajaranExport($request->all()),
            'mata-pelajaran-' . now()->format('Ymd-His') . '.xlsx'
        );
    }

    // ── IMPORT ────────────────────────────────────────────────────────────────

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

    // ── IMPORT TEMPLATE ───────────────────────────────────────────────────────

    public function importTemplate()
    {
        $templatePath = storage_path('app/templates/template-mata-pelajaran.xlsx');

        if (file_exists($templatePath)) {
            return response()->download($templatePath, 'template-mata-pelajaran.xlsx');
        }

        // Fallback: generate template dinamis
        return Excel::download(
            new \App\Exports\MataPelajaranTemplateExport,
            'template-mata-pelajaran.xlsx'
        );
    }

    // ── PRIVATE HELPERS ───────────────────────────────────────────────────────

    /**
     * Sync tabel pivot jurusan_mata_pelajaran dari form.
     * Form mengirim array: jurusan_ids[], tingkat_jurusan[id], jam_jurusan[id]
     */
    private function syncJurusan(MataPelajaran $mapel, Request $request): void
    {
        $jurusanIds = $request->input('jurusan_ids', []);

        $syncData = [];
        foreach ($jurusanIds as $jId) {
            // FIX #9: Cast jam_per_minggu ke int atau null secara eksplisit
            $jam = $request->input("jam_jurusan.{$jId}");
            $syncData[$jId] = [
                'tingkat'        => $request->input("tingkat_jurusan.{$jId}") ?: null,
                'jam_per_minggu' => ($jam !== null && $jam !== '') ? (int) $jam : null,
                'is_active'      => true,
            ];
        }

        $mapel->jurusan()->sync($syncData);
    }

    private function pesanValidasi(): array
    {
        return [
            'nama_mapel.required'      => 'Nama mata pelajaran wajib diisi.',
            'nama_mapel.max'           => 'Nama mata pelajaran maksimal 100 karakter.',
            'kode_mapel.required'      => 'Kode mata pelajaran wajib diisi.',
            'kode_mapel.max'           => 'Kode mata pelajaran maksimal 15 karakter.',
            'kode_mapel.unique'        => 'Kode mata pelajaran sudah digunakan.',
            'kelompok.in'              => 'Kelompok mata pelajaran tidak valid.',
            'scope.required'           => 'Scope wajib dipilih.',
            'scope.in'                 => 'Scope harus umum atau jurusan.',
            'jam_per_minggu.required'  => 'Jam per minggu wajib diisi.',
            'jam_per_minggu.min'       => 'Jam per minggu minimal 1.',
            'jam_per_minggu.max'       => 'Jam per minggu maksimal 20.',
            'durasi_per_sesi.required' => 'Durasi per sesi wajib diisi.',
            'durasi_per_sesi.min'      => 'Durasi per sesi minimal 30 menit.',
            'durasi_per_sesi.max'      => 'Durasi per sesi maksimal 180 menit.',
            'keterangan.max'           => 'Keterangan maksimal 1000 karakter.',
            'jurusan_ids.*.exists'     => 'Salah satu jurusan yang dipilih tidak ditemukan.',
        ];
    }
}