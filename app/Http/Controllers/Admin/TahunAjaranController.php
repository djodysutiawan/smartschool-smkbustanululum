<?php

namespace App\Http\Controllers\Admin;

use App\Exports\TahunAjaranExport;
use App\Http\Controllers\Controller;
use App\Imports\TahunAjaranImport;
use App\Models\TahunAjaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;          // ← TAMBAHAN: untuk transaction
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException as ExcelValidationException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
// use Symfony\Component\HttpFoundation\StreamedResponse;

class TahunAjaranController extends Controller
{
    // ── Index ─────────────────────────────────────────────────────────────────

    public function index(Request $request): View
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
        $aktif       = TahunAjaran::getAktif();   // bisa null — view sudah handle dengan ternary

        // FIX: tambah kunci 'aktif' agar view punya data lengkap jika diperlukan
        $stats = [
            'total'       => TahunAjaran::count(),
            'aktif'       => TahunAjaran::where('status', 'aktif')->count(),
            'tidak_aktif' => TahunAjaran::where('status', 'tidak_aktif')->count(),
        ];

        return view('admin.tahun-ajaran.index', compact('tahunAjaran', 'aktif', 'stats'));
    }

    // ── Create ────────────────────────────────────────────────────────────────

    public function create(): View
    {
        return view('admin.tahun-ajaran.create');
    }

    // ── Store ─────────────────────────────────────────────────────────────────

    public function store(Request $request): RedirectResponse
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

        // FIX: bungkus dalam transaction agar aktifkan() atomik
        $tahun = DB::transaction(function () use ($validated) {
            $tahun = TahunAjaran::create($validated);

            if ($tahun->status === 'aktif') {
                $tahun->aktifkan();
            }

            return $tahun;
        });

        // FIX: redirect ke show (konsisten dengan update)
        return redirect()->route('admin.tahun-ajaran.show', $tahun)
            ->with('success', "Tahun ajaran {$tahun->label} berhasil ditambahkan.");
    }

    // ── Show ──────────────────────────────────────────────────────────────────

    public function show(TahunAjaran $tahunAjaran): View
    {
        // FIX: nama relasi harus konsisten (camelCase) — Laravel akan buat
        // accessor snake_case otomatis: jadwal_pelajaran_count, dst.
        $tahunAjaran->loadCount([
            'kelas',
            'jadwalPelajaran',   // → $tahunAjaran->jadwal_pelajaran_count
            'nilai',
            'siswa',
        ]);

        $stats = [
            'total_kelas'  => $tahunAjaran->kelas_count,
            'total_jadwal' => $tahunAjaran->jadwal_pelajaran_count,
            'total_nilai'  => $tahunAjaran->nilai_count,
            'total_siswa'  => $tahunAjaran->siswa_count,
        ];

        return view('admin.tahun-ajaran.show', compact('tahunAjaran', 'stats'));
    }

    // ── Edit ──────────────────────────────────────────────────────────────────

    public function edit(TahunAjaran $tahunAjaran): View
    {
        return view('admin.tahun-ajaran.edit', compact('tahunAjaran'));
    }

    // ── Update ────────────────────────────────────────────────────────────────

    public function update(Request $request, TahunAjaran $tahunAjaran): RedirectResponse
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

        // FIX: bungkus dalam transaction
        DB::transaction(function () use ($validated, $tahunAjaran) {
            $tahunAjaran->update($validated);

            if ($tahunAjaran->fresh()->status === 'aktif') {
                $tahunAjaran->aktifkan();
            }
        });

        return redirect()->route('admin.tahun-ajaran.show', $tahunAjaran)
            ->with('success', "Tahun ajaran {$tahunAjaran->label} berhasil diperbarui.");
    }

    // ── Destroy ───────────────────────────────────────────────────────────────

    public function destroy(TahunAjaran $tahunAjaran): RedirectResponse
    {
        if ($tahunAjaran->isAktif()) {
            return back()->with('error', 'Tidak dapat menghapus tahun ajaran yang sedang aktif.');
        }

        // FIX: cek relasi nilai juga, bukan hanya kelas dan jadwal
        if (
            $tahunAjaran->kelas()->exists() ||
            $tahunAjaran->jadwalPelajaran()->exists() ||
            $tahunAjaran->nilai()->exists()             // ← TAMBAHAN
        ) {
            return back()->with('error',
                'Tidak dapat menghapus tahun ajaran yang masih memiliki data kelas, jadwal pelajaran, atau nilai.');
        }

        $label = $tahunAjaran->label; // simpan dulu sebelum dihapus
        $tahunAjaran->delete();

        return redirect()->route('admin.tahun-ajaran.index')
            ->with('success', "Tahun ajaran {$label} berhasil dihapus.");
    }

    // ── Aktifkan ──────────────────────────────────────────────────────────────

    public function aktifkan(TahunAjaran $tahunAjaran): RedirectResponse
    {
        if ($tahunAjaran->isAktif()) {
            return back()->with('error', 'Tahun ajaran ini sudah aktif.');
        }

        // FIX: bungkus dalam transaction (aktifkan() melakukan 2 query)
        DB::transaction(fn () => $tahunAjaran->aktifkan());

        return back()->with('success', "Tahun ajaran {$tahunAjaran->label} berhasil diaktifkan.");
    }

    // ── Export PDF ────────────────────────────────────────────────────────────

    public function exportPdf(Request $request): mixed
    {
        // FIX: ikuti filter yang sedang aktif di halaman (konsisten dengan exportExcel)
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

        $tahunAjaran = $query->orderByDesc('id')->get();

        $pdf = Pdf::loadView('admin.tahun-ajaran.pdf', compact('tahunAjaran'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('data-tahun-ajaran-' . now()->format('Ymd-His') . '.pdf');
    }

    // ── Export Excel ──────────────────────────────────────────────────────────

    public function exportExcel(Request $request): BinaryFileResponse
    {
        return Excel::download(
            new TahunAjaranExport($request->all()),
            'tahun-ajaran-' . now()->format('Ymd-His') . '.xlsx'
        );
    }

    // ── Import ────────────────────────────────────────────────────────────────

    public function import(Request $request): RedirectResponse
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
                ->map(fn ($f) => "Baris {$f->row()}: " . implode(', ', $f->errors()))
                ->implode(' | ');

            return back()->with('error', 'Import gagal: ' . $errors);
        } catch (\Throwable $e) {
            return back()->with('error', 'Import gagal: ' . $e->getMessage());
        }

        return back()->with('success', 'Data tahun ajaran berhasil diimpor.');
    }

    // ── Private Helpers ───────────────────────────────────────────────────────

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