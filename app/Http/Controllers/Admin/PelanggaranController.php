<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PelanggaranExport;
use App\Http\Controllers\Controller;
use App\Imports\PelanggaranImport;
use App\Models\KategoriPelanggaran;
use App\Models\Kelas;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException as ExcelValidationException;

class PelanggaranController extends Controller
{
    // -------------------------------------------------------------------------
    // Status yang valid — satu sumber kebenaran, dipakai validasi & filter
    // -------------------------------------------------------------------------
    private const VALID_STATUSES = ['pending', 'diproses', 'selesai', 'banding', 'dibatalkan'];

    // =========================================================================
    // CRUD
    // =========================================================================

    public function index(Request $request)
    {
        $pelanggaran = $this->buildQuery($request)
            ->with(['siswa.kelas', 'kategori', 'dicatatOleh'])
            ->latest('tanggal')
            ->paginate(20)
            ->withQueryString();

        $stats = [
            'total'     => Pelanggaran::count(),
            'diproses'  => Pelanggaran::where('status', 'diproses')->count(),
            'bulan_ini' => Pelanggaran::whereMonth('tanggal', now()->month)
                                      ->whereYear('tanggal', now()->year)
                                      ->count(),
            'selesai'   => Pelanggaran::where('status', 'selesai')->count(),
        ];

        $kategoriList = KategoriPelanggaran::orderBy('nama')->get();
        $kelasList    = Kelas::aktif()->orderBy('nama_kelas')->get();

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
        $validated = $request->validate($this->rules(), $this->messages());

        $validated['dicatat_oleh'] = Auth::id();

        Pelanggaran::create($validated);

        return redirect()
            ->route('admin.pelanggaran.index')
            ->with('success', 'Data pelanggaran berhasil disimpan.');
    }

    public function show(Pelanggaran $pelanggaran)
    {
        $pelanggaran->load(['siswa.kelas', 'kategori', 'dicatatOleh']);

        // Exclude status 'dibatalkan' DAN 'banding' agar poin aktif akurat
        $totalPoinSiswa = Pelanggaran::where('siswa_id', $pelanggaran->siswa_id)
            ->whereNotIn('status', ['dibatalkan', 'banding'])
            ->sum('poin');

        // Riwayat pelanggaran lain milik siswa yang sama (selain record ini)
        $riwayatPelanggaran = Pelanggaran::where('siswa_id', $pelanggaran->siswa_id)
            ->where('id', '!=', $pelanggaran->id)
            ->with('kategori')
            ->latest('tanggal')
            ->limit(10)
            ->get();

        return view('admin.pelanggaran.show', compact('pelanggaran', 'totalPoinSiswa', 'riwayatPelanggaran'));
    }

    public function edit(Pelanggaran $pelanggaran)
    {
        $siswaList    = Siswa::aktif()->with('kelas')->orderBy('nama_lengkap')->get();
        $kategoriList = KategoriPelanggaran::aktif()->orderBy('nama')->get();

        return view('admin.pelanggaran.edit', compact('pelanggaran', 'siswaList', 'kategoriList'));
    }

    public function update(Request $request, Pelanggaran $pelanggaran)
    {
        $validated = $request->validate($this->rules(), $this->messages());

        $pelanggaran->update($validated);

        return redirect()
            ->route('admin.pelanggaran.show', $pelanggaran)
            ->with('success', 'Data pelanggaran berhasil diperbarui.');
    }

    public function destroy(Pelanggaran $pelanggaran)
    {
        // Guard: pelanggaran yang sudah selesai tidak boleh dihapus langsung
        if ($pelanggaran->status === 'selesai') {
            return back()->with('error', 'Pelanggaran yang sudah selesai tidak dapat dihapus. Gunakan fitur batalkan terlebih dahulu.');
        }

        $pelanggaran->delete();

        return redirect()
            ->route('admin.pelanggaran.index')
            ->with('success', 'Data pelanggaran berhasil dihapus.');
    }

    // =========================================================================
    // AKSI KHUSUS
    // =========================================================================

    public function selesaikan(Request $request, Pelanggaran $pelanggaran)
    {
        // Hanya bisa diselesaikan jika masih pending atau diproses
        if (! in_array($pelanggaran->status, ['pending', 'diproses'])) {
            return back()->with('error', 'Pelanggaran ini tidak dapat diselesaikan karena statusnya sudah ' . $pelanggaran->status . '.');
        }

        $request->validate(
            ['tindakan' => ['nullable', 'string', 'max:500']],
            ['tindakan.max' => 'Tindakan maksimal 500 karakter.']
        );

        $pelanggaran->selesaikan($request->tindakan ?? $pelanggaran->tindakan ?? '-');

        return back()->with('success', 'Pelanggaran berhasil diselesaikan.');
    }

    public function batalkan(Pelanggaran $pelanggaran)
    {
        // Tidak bisa batalkan yang sudah dibatalkan
        if ($pelanggaran->status === 'dibatalkan') {
            return back()->with('error', 'Pelanggaran ini sudah dibatalkan sebelumnya.');
        }

        $pelanggaran->batalkan();

        return back()->with('success', 'Pelanggaran berhasil dibatalkan.');
    }

    // =========================================================================
    // EXPORT & IMPORT
    // =========================================================================

    public function exportPdf(Request $request)
    {
        $pelanggaran = $this->buildQuery($request)
            ->with(['siswa.kelas', 'kategori', 'dicatatOleh'])
            ->latest('tanggal')
            ->get();

        $filterLabel = $this->buildFilterLabel($request);

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
            $errors = collect($e->failures())
                ->map(fn ($f) => "Baris {$f->row()}: " . implode(', ', $f->errors()))
                ->implode(' | ');

            return back()->with('error', 'Import gagal: ' . $errors);
        } catch (\Throwable $e) {
            return back()->with('error', 'Import gagal: ' . $e->getMessage());
        }

        return back()->with('success', 'Data pelanggaran berhasil diimpor.');
    }

    // =========================================================================
    // PRIVATE HELPERS
    // =========================================================================

    /**
     * Bangun query Pelanggaran berdasarkan filter request.
     * Dipakai bersama oleh index() dan exportPdf() agar tidak duplikasi.
     */
    private function buildQuery(Request $request): Builder
    {
        $query = Pelanggaran::query();

        if ($request->filled('kategori_id')) {
            $query->where('kategori_pelanggaran_id', $request->kategori_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('kelas_id')) {
            $query->whereHas('siswa', fn (Builder $q) => $q->where('kelas_id', $request->kelas_id));
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->whereHas('siswa', fn (Builder $q) => $q
                ->where('nama_lengkap', 'like', "%{$s}%")
                ->orWhere('nis', 'like', "%{$s}%")
            );
        }

        return $query;
    }

    /**
     * Buat label filter untuk header PDF.
     */
    private function buildFilterLabel(Request $request): string
    {
        $parts = [];

        if ($request->filled('status')) {
            $parts[] = 'Status: ' . ucfirst($request->status);
        }
        if ($request->filled('search')) {
            $parts[] = 'Cari: ' . $request->search;
        }
        if ($request->filled('kelas_id')) {
            $parts[] = 'Kelas ID: ' . $request->kelas_id;
        }
        if ($request->filled('kategori_id')) {
            $parts[] = 'Kategori ID: ' . $request->kategori_id;
        }

        return implode(', ', $parts);
    }

    /**
     * Aturan validasi — dipakai bersama store() dan update().
     */
    private function rules(): array
    {
        return [
            'siswa_id'                => ['required', 'exists:siswa,id'],
            'kategori_pelanggaran_id' => ['required', 'exists:kategori_pelanggaran,id'],
            'poin'                    => ['required', 'integer', 'min:1', 'max:100'],
            'deskripsi'               => ['required', 'string', 'max:1000'],
            'tanggal'                 => ['required', 'date', 'before_or_equal:today'],
            'tindakan'                => ['nullable', 'string', 'max:500'],
            'status'                  => ['required', Rule::in(self::VALID_STATUSES)],
        ];
    }

    /**
     * Pesan validasi kustom.
     */
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
            'deskripsi.max'                    => 'Deskripsi maksimal 1000 karakter.',
            'tanggal.required'                 => 'Tanggal kejadian wajib diisi.',
            'tanggal.date'                     => 'Format tanggal tidak valid.',
            'tanggal.before_or_equal'          => 'Tanggal tidak boleh melebihi hari ini.',
            'tindakan.max'                     => 'Tindakan maksimal 500 karakter.',
            'status.required'                  => 'Status wajib dipilih.',
            'status.in'                        => 'Status tidak valid.',
        ];
    }
}