<?php

namespace App\Http\Controllers\Admin;

use App\Exports\JadwalPelajaranExport;
use App\Http\Controllers\Controller;
use App\Imports\JadwalPelajaranImport;
use App\Models\Guru;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Ruang;
use App\Models\TahunAjaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException as ExcelValidationException;

class JadwalPelajaranController extends Controller
{
    private const HARI_OPTIONS = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];

    // ─── INDEX ───────────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $query = JadwalPelajaran::with(['guru', 'mataPelajaran', 'kelas', 'ruang', 'tahunAjaran']);

        if ($request->filled('tahun_ajaran_id')) $query->where('tahun_ajaran_id', $request->tahun_ajaran_id);
        if ($request->filled('kelas_id'))        $query->where('kelas_id', $request->kelas_id);
        if ($request->filled('guru_id'))         $query->where('guru_id', $request->guru_id);
        if ($request->filled('hari'))            $query->where('hari', $request->hari);
        if ($request->filled('is_active'))       $query->where('is_active', $request->boolean('is_active'));

        $jadwal      = $query->orderBy('hari')->orderBy('jam_mulai')->paginate(20)->withQueryString();
        $tahunAjaran = TahunAjaran::orderByDesc('id')->get();
        $kelasList   = Kelas::aktif()->orderBy('nama_kelas')->get();
        $guruList    = Guru::aktif()->orderBy('nama_lengkap')->get();
        $hariList    = self::HARI_OPTIONS;

        return view('admin.jadwal_pelajaran.index',
            compact('jadwal', 'tahunAjaran', 'kelasList', 'guruList', 'hariList'));
    }

    // ─── CREATE & STORE ───────────────────────────────────────────────────────────

    public function create()
    {
        $tahunAjaran = TahunAjaran::orderByDesc('id')->get();
        $kelasList   = Kelas::aktif()->orderBy('nama_kelas')->get();
        $guruList    = Guru::aktif()->orderBy('nama_lengkap')->get();
        $mapelList   = MataPelajaran::aktif()->orderBy('nama_mapel')->get();
        $ruangList   = Ruang::tersedia()->with('gedung')->orderBy('nama_ruang')->get();
        $hariList    = self::HARI_OPTIONS;

        return view('admin.jadwal_pelajaran.create',
            compact('tahunAjaran', 'kelasList', 'guruList', 'mapelList', 'ruangList', 'hariList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun_ajaran_id'   => ['required', 'exists:tahun_ajaran,id'],
            'guru_id'           => ['required', 'exists:guru,id'],
            'mata_pelajaran_id' => ['required', 'exists:mata_pelajaran,id'],
            'kelas_id'          => ['required', 'exists:kelas,id'],
            'ruang_id'          => ['nullable', 'exists:ruang,id'],
            'hari'              => ['required', Rule::in(self::HARI_OPTIONS)],
            'jam_mulai'         => ['required', 'date_format:H:i'],
            'jam_selesai'       => ['required', 'date_format:H:i', 'after:jam_mulai'],
            'pertemuan_ke'      => ['nullable', 'integer', 'min:1'],
            'sumber_jadwal'     => ['nullable', Rule::in(['manual', 'otomatis'])],
            'is_active'         => ['boolean'],
        ], $this->pesanValidasi());

        $konflik = $this->cekKonflikJadwal(
            $validated['guru_id'],
            $validated['kelas_id'],
            $validated['ruang_id'] ?? null,
            $validated['tahun_ajaran_id'],
            $validated['hari'],
            $validated['jam_mulai'],
            $validated['jam_selesai'],
        );

        if ($konflik) {
            return back()->withInput()->with('error', $konflik);
        }

        JadwalPelajaran::create($validated);

        return redirect()->route('admin.jadwal-pelajaran.index')
            ->with('success', 'Jadwal pelajaran berhasil ditambahkan.');
    }

    // ─── SHOW ─────────────────────────────────────────────────────────────────────

    public function show(JadwalPelajaran $jadwalPelajaran)
    {
        $jadwalPelajaran->load(['guru', 'mataPelajaran', 'kelas', 'ruang', 'tahunAjaran']);

        return view('admin.jadwal_pelajaran.show', compact('jadwalPelajaran'));
    }

    // ─── EDIT & UPDATE ────────────────────────────────────────────────────────────

    public function edit(JadwalPelajaran $jadwalPelajaran)
    {
        $tahunAjaran = TahunAjaran::orderByDesc('id')->get();
        $kelasList   = Kelas::aktif()->orderBy('nama_kelas')->get();
        $guruList    = Guru::aktif()->orderBy('nama_lengkap')->get();
        $mapelList   = MataPelajaran::aktif()->orderBy('nama_mapel')->get();
        $ruangList   = Ruang::with('gedung')->orderBy('nama_ruang')->get();
        $hariList    = self::HARI_OPTIONS;

        return view('admin.jadwal_pelajaran.edit',
            compact('jadwalPelajaran', 'tahunAjaran', 'kelasList', 'guruList', 'mapelList', 'ruangList', 'hariList'));
    }

    public function update(Request $request, JadwalPelajaran $jadwalPelajaran)
    {
        $validated = $request->validate([
            'tahun_ajaran_id'   => ['required', 'exists:tahun_ajaran,id'],
            'guru_id'           => ['required', 'exists:guru,id'],
            'mata_pelajaran_id' => ['required', 'exists:mata_pelajaran,id'],
            'kelas_id'          => ['required', 'exists:kelas,id'],
            'ruang_id'          => ['nullable', 'exists:ruang,id'],
            'hari'              => ['required', Rule::in(self::HARI_OPTIONS)],
            'jam_mulai'         => ['required', 'date_format:H:i'],
            'jam_selesai'       => ['required', 'date_format:H:i', 'after:jam_mulai'],
            'pertemuan_ke'      => ['nullable', 'integer', 'min:1'],
            'is_active'         => ['boolean'],
        ], $this->pesanValidasi());

        $konflik = $this->cekKonflikJadwal(
            $validated['guru_id'],
            $validated['kelas_id'],
            $validated['ruang_id'] ?? null,
            $validated['tahun_ajaran_id'],
            $validated['hari'],
            $validated['jam_mulai'],
            $validated['jam_selesai'],
            $jadwalPelajaran->id,
        );

        if ($konflik) {
            return back()->withInput()->with('error', $konflik);
        }

        $jadwalPelajaran->update($validated);

        return redirect()->route('admin.jadwal-pelajaran.show', $jadwalPelajaran)
            ->with('success', 'Jadwal pelajaran berhasil diperbarui.');
    }

    // ─── DESTROY ─────────────────────────────────────────────────────────────────

    public function destroy(JadwalPelajaran $jadwalPelajaran)
    {
        $jadwalPelajaran->delete();

        return redirect()->route('admin.jadwal-pelajaran.index')
            ->with('success', 'Jadwal pelajaran berhasil dihapus.');
    }

    // ─── TOGGLE STATUS ────────────────────────────────────────────────────────────

    public function toggleStatus(JadwalPelajaran $jadwalPelajaran)
    {
        $jadwalPelajaran->update(['is_active' => ! $jadwalPelajaran->is_active]);
        $status = $jadwalPelajaran->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Jadwal berhasil {$status}.");
    }

    // ─── EXPORT PDF ──────────────────────────────────────────────────────────────

    public function exportPdf(Request $request)
    {
        $query = JadwalPelajaran::with(['guru', 'mataPelajaran', 'kelas', 'ruang', 'tahunAjaran']);

        if ($request->filled('tahun_ajaran_id')) $query->where('tahun_ajaran_id', $request->tahun_ajaran_id);
        if ($request->filled('kelas_id'))        $query->where('kelas_id', $request->kelas_id);
        if ($request->filled('guru_id'))         $query->where('guru_id', $request->guru_id);
        if ($request->filled('hari'))            $query->where('hari', $request->hari);
        if ($request->filled('is_active'))       $query->where('is_active', $request->boolean('is_active'));

        $jadwal = $query->orderBy('hari')->orderBy('jam_mulai')->get();

        $filterParts = [];
        if ($request->filled('hari'))     $filterParts[] = 'Hari: ' . ucfirst($request->hari);
        if ($request->filled('kelas_id')) $filterParts[] = 'Kelas: ' . optional(Kelas::find($request->kelas_id))->nama_kelas;
        if ($request->filled('guru_id'))  $filterParts[] = 'Guru: ' . optional(Guru::find($request->guru_id))->nama_lengkap;
        $filterLabel = implode(', ', $filterParts);

        $pdf = Pdf::loadView('admin.jadwal_pelajaran.pdf', compact('jadwal', 'filterLabel'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('data-jadwal-pelajaran-' . now()->format('Ymd-His') . '.pdf');
    }

    // ─── EXPORT EXCEL ────────────────────────────────────────────────────────────

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new JadwalPelajaranExport($request->all()),
            'jadwal-pelajaran-' . now()->format('Ymd-His') . '.xlsx'
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
            Excel::import(new JadwalPelajaranImport, $request->file('file'));
        } catch (ExcelValidationException $e) {
            $errors = collect($e->failures())->map(
                fn ($f) => "Baris {$f->row()}: " . implode(', ', $f->errors())
            )->implode(' | ');

            return back()->with('error', 'Import gagal: ' . $errors);
        } catch (\Throwable $e) {
            return back()->with('error', 'Import gagal: ' . $e->getMessage());
        }

        return back()->with('success', 'Data jadwal pelajaran berhasil diimpor.');
    }

    // ─── PRIVATE HELPERS ─────────────────────────────────────────────────────────

    private function cekKonflikJadwal(
        int $guruId,
        int $kelasId,
        ?int $ruangId,
        int $tahunAjaranId,
        string $hari,
        string $jamMulai,
        string $jamSelesai,
        ?int $kecualiId = null,
    ): ?string {
        $base = JadwalPelajaran::where('tahun_ajaran_id', $tahunAjaranId)
            ->where('hari', $hari)
            ->where('is_active', true)
            ->where(fn ($q) => $q
                ->whereBetween('jam_mulai', [$jamMulai, $jamSelesai])
                ->orWhereBetween('jam_selesai', [$jamMulai, $jamSelesai])
                ->orWhere(fn ($q2) => $q2
                    ->where('jam_mulai', '<=', $jamMulai)
                    ->where('jam_selesai', '>=', $jamSelesai)
                )
            );

        if ($kecualiId) {
            $base->where('id', '!=', $kecualiId);
        }

        if ((clone $base)->where('guru_id', $guruId)->exists()) {
            return 'Guru yang dipilih sudah memiliki jadwal mengajar pada hari dan jam tersebut.';
        }

        if ((clone $base)->where('kelas_id', $kelasId)->exists()) {
            return 'Kelas yang dipilih sudah memiliki jadwal pelajaran pada hari dan jam tersebut.';
        }

        if ($ruangId && (clone $base)->where('ruang_id', $ruangId)->exists()) {
            return 'Ruangan yang dipilih sudah digunakan oleh kelas lain pada hari dan jam tersebut.';
        }

        return null;
    }

    private function pesanValidasi(): array
    {
        return [
            'tahun_ajaran_id.required'   => 'Tahun ajaran wajib dipilih.',
            'tahun_ajaran_id.exists'     => 'Tahun ajaran yang dipilih tidak ditemukan.',
            'guru_id.required'           => 'Guru wajib dipilih.',
            'guru_id.exists'             => 'Guru yang dipilih tidak ditemukan.',
            'mata_pelajaran_id.required' => 'Mata pelajaran wajib dipilih.',
            'mata_pelajaran_id.exists'   => 'Mata pelajaran yang dipilih tidak ditemukan.',
            'kelas_id.required'          => 'Kelas wajib dipilih.',
            'kelas_id.exists'            => 'Kelas yang dipilih tidak ditemukan.',
            'ruang_id.exists'            => 'Ruangan yang dipilih tidak ditemukan.',
            'hari.required'              => 'Hari wajib dipilih.',
            'hari.in'                    => 'Hari yang dipilih tidak valid.',
            'jam_mulai.required'         => 'Jam mulai wajib diisi.',
            'jam_mulai.date_format'      => 'Format jam mulai tidak valid. Gunakan format HH:MM.',
            'jam_selesai.required'       => 'Jam selesai wajib diisi.',
            'jam_selesai.date_format'    => 'Format jam selesai tidak valid. Gunakan format HH:MM.',
            'jam_selesai.after'          => 'Jam selesai harus setelah jam mulai.',
            'pertemuan_ke.integer'       => 'Pertemuan ke harus berupa angka.',
            'pertemuan_ke.min'           => 'Pertemuan ke minimal 1.',
        ];
    }

    public function importTemplate()
    {
        // Path template ada di storage/app/templates/
        $path = storage_path('app/templates/template-jadwal-pelajaran.xlsx');
    
        // Jika file template belum ada, generate otomatis pakai Maatwebsite
        if (! file_exists($path)) {
            $directory = storage_path('app/templates');
            if (! is_dir($directory)) {
                mkdir($directory, 0755, true);
            }
    
            \Maatwebsite\Excel\Facades\Excel::store(
                new \App\Exports\JadwalPelajaranTemplateExport,
                'templates/template-jadwal-pelajaran.xlsx'
            );
        }
    
        return response()->download(
            $path,
            'template-import-jadwal-pelajaran.xlsx',
            ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']
        );
    }
    
    // ─── FIX exportPdf — ganti nama view dari jadwal-pelajaran ke jadwal_pelajaran ─
    
    // public function exportPdf(Request $request)
    // {
    //     $query = JadwalPelajaran::with(['guru', 'mataPelajaran', 'kelas', 'ruang', 'tahunAjaran']);
    
    //     if ($request->filled('tahun_ajaran_id')) $query->where('tahun_ajaran_id', $request->tahun_ajaran_id);
    //     if ($request->filled('kelas_id'))        $query->where('kelas_id', $request->kelas_id);
    //     if ($request->filled('guru_id'))         $query->where('guru_id', $request->guru_id);
    //     if ($request->filled('hari'))            $query->where('hari', $request->hari);
    //     if ($request->filled('is_active'))       $query->where('is_active', $request->boolean('is_active'));
    
    //     $jadwal = $query->orderBy('hari')->orderBy('jam_mulai')->get();
    
    //     $filterParts = [];
    //     if ($request->filled('hari'))     $filterParts[] = 'Hari: ' . ucfirst($request->hari);
    //     if ($request->filled('kelas_id')) $filterParts[] = 'Kelas: ' . optional(Kelas::find($request->kelas_id))->nama_kelas;
    //     if ($request->filled('guru_id'))  $filterParts[] = 'Guru: ' . optional(Guru::find($request->guru_id))->nama_lengkap;
    //     $filterLabel = implode(', ', $filterParts);
    
    //     // ✅ FIX: underscore (_) sesuai nama folder di disk
    //     $pdf = Pdf::loadView('admin.jadwal_pelajaran.pdf', compact('jadwal', 'filterLabel'))
    //         ->setPaper('a4', 'landscape');
    
    //     return $pdf->download('data-jadwal-pelajaran-' . now()->format('Ymd-His') . '.pdf');
    // }

}