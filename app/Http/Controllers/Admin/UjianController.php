<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\TahunAjaran;
use App\Models\Ujian;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UjianExport;
use App\Imports\UjianImport;

class UjianController extends Controller
{
    public function index(Request $request)
    {
        $query = Ujian::with(['guru', 'mataPelajaran', 'kelas', 'tahunAjaran']);

        if ($request->filled('tahun_ajaran_id')) {
            $query->where('tahun_ajaran_id', $request->tahun_ajaran_id);
        }
        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }
        if ($request->filled('guru_id')) {
            $query->where('guru_id', $request->guru_id);
        }
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }
        if ($request->filled('search')) {
            $query->where('judul', 'like', "%{$request->search}%");
        }

        $ujian       = $query->orderByDesc('tanggal')->paginate(20)->withQueryString();
        $tahunAjaran = TahunAjaran::orderByDesc('tahun')->get();
        $kelasList   = Kelas::aktif()->orderBy('nama_kelas')->get();
        $guruList    = Guru::aktif()->orderBy('nama_lengkap')->get();
        $jenisList   = ['ulangan_harian', 'uts', 'uas', 'remedial', 'quiz'];

        return view('admin.ujian.index',
            compact('ujian', 'tahunAjaran', 'kelasList', 'guruList', 'jenisList'));
    }

    public function create()
    {
        $guruList    = Guru::aktif()->orderBy('nama_lengkap')->get();
        $kelasList   = Kelas::aktif()->orderBy('nama_kelas')->get();
        $mapelList   = MataPelajaran::aktif()->orderBy('nama_mapel')->get();
        $tahunAjaran = TahunAjaran::orderByDesc('tahun')->get();
        $jenisList   = ['ulangan_harian', 'uts', 'uas', 'remedial', 'quiz'];

        return view('admin.ujian.create',
            compact('guruList', 'kelasList', 'mapelList', 'tahunAjaran', 'jenisList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'guru_id'           => ['required', 'exists:guru,id'],
            'mata_pelajaran_id' => ['required', 'exists:mata_pelajaran,id'],
            'kelas_id'          => ['required', 'exists:kelas,id'],
            'tahun_ajaran_id'   => ['required', 'exists:tahun_ajaran,id'],
            'judul'             => ['required', 'string', 'max:255'],
            'jenis'             => ['required', Rule::in(['ulangan_harian', 'uts', 'uas', 'remedial', 'quiz'])],
            'tanggal'           => ['required', 'date'],
            'jam_mulai'         => ['nullable', 'date_format:H:i'],
            'durasi_menit'      => ['required', 'integer', 'min:1', 'max:480'],
            'nilai_kkm'         => ['nullable', 'integer', 'min:0', 'max:100'],
            'acak_soal'         => ['boolean'],
            'acak_pilihan'      => ['boolean'],
            'tampilkan_nilai'   => ['boolean'],
            'maks_percobaan'    => ['nullable', 'integer', 'min:1', 'max:10'],
            'keterangan'        => ['nullable', 'string', 'max:1000'],
            'is_active'         => ['boolean'],
        ], $this->messages());

        Ujian::create($validated);

        return redirect()->route('admin.ujian.index')
            ->with('success', 'Ujian berhasil ditambahkan.');
    }

    public function show(Ujian $ujian)
    {
        $ujian->load(['guru', 'mataPelajaran', 'kelas', 'tahunAjaran', 'soal']);

        $stats = [
            'total_soal'     => $ujian->total_soal,
            'total_bobot'    => $ujian->total_bobot,
            'siswa_selesai'  => $ujian->siswaSelesai()->count(),
            'siswa_lulus'    => $ujian->sesi()->where('lulus', true)->count(),
            'rata_nilai'     => round($ujian->sesi()->whereNotNull('nilai_akhir')->avg('nilai_akhir') ?? 0, 2),
        ];

        return view('admin.ujian.show', compact('ujian', 'stats'));
    }

    public function edit(Ujian $ujian)
    {
        $guruList    = Guru::aktif()->orderBy('nama_lengkap')->get();
        $kelasList   = Kelas::aktif()->orderBy('nama_kelas')->get();
        $mapelList   = MataPelajaran::aktif()->orderBy('nama_mapel')->get();
        $tahunAjaran = TahunAjaran::orderByDesc('tahun')->get();
        $jenisList   = ['ulangan_harian', 'uts', 'uas', 'remedial', 'quiz'];

        return view('admin.ujian.edit',
            compact('ujian', 'guruList', 'kelasList', 'mapelList', 'tahunAjaran', 'jenisList'));
    }

    public function update(Request $request, Ujian $ujian)
    {
        $validated = $request->validate([
            'guru_id'           => ['required', 'exists:guru,id'],
            'mata_pelajaran_id' => ['required', 'exists:mata_pelajaran,id'],
            'kelas_id'          => ['required', 'exists:kelas,id'],
            'tahun_ajaran_id'   => ['required', 'exists:tahun_ajaran,id'],
            'judul'             => ['required', 'string', 'max:255'],
            'jenis'             => ['required', Rule::in(['ulangan_harian', 'uts', 'uas', 'remedial', 'quiz'])],
            'tanggal'           => ['required', 'date'],
            'jam_mulai'         => ['nullable', 'date_format:H:i'],
            'durasi_menit'      => ['required', 'integer', 'min:1', 'max:480'],
            'nilai_kkm'         => ['nullable', 'integer', 'min:0', 'max:100'],
            'acak_soal'         => ['boolean'],
            'acak_pilihan'      => ['boolean'],
            'tampilkan_nilai'   => ['boolean'],
            'maks_percobaan'    => ['nullable', 'integer', 'min:1', 'max:10'],
            'keterangan'        => ['nullable', 'string', 'max:1000'],
            'is_active'         => ['boolean'],
        ], $this->messages());

        $ujian->update($validated);

        return redirect()->route('admin.ujian.show', $ujian)
            ->with('success', 'Ujian berhasil diperbarui.');
    }

    public function destroy(Ujian $ujian)
    {
        $ujian->delete();

        return redirect()->route('admin.ujian.index')
            ->with('success', 'Ujian berhasil dihapus.');
    }

    public function toggleStatus(Ujian $ujian)
    {
        $ujian->update(['is_active' => !$ujian->is_active]);
        $status = $ujian->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Ujian berhasil {$status}.");
    }

    public function exportPdf(Request $request)
    {
        $query = Ujian::with(['guru', 'mataPelajaran', 'kelas', 'tahunAjaran']);

        if ($request->filled('tahun_ajaran_id')) {
            $query->where('tahun_ajaran_id', $request->tahun_ajaran_id);
        }
        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        $ujian = $query->orderByDesc('tanggal')->get();

        $pdf = Pdf::loadView('admin.ujian.export-pdf', compact('ujian'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('data-ujian-' . now()->format('YmdHis') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new UjianExport($request->all()),
            'data-ujian-' . now()->format('YmdHis') . '.xlsx'
        );
    }

    public function importTemplate()
    {
        return Excel::download(new \App\Exports\UjianTemplateExport(), 'template-ujian.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls', 'max:5120'],
        ], [
            'file.required' => 'File impor wajib diunggah.',
            'file.mimes'    => 'Format file harus berupa Excel (.xlsx atau .xls).',
            'file.max'      => 'Ukuran file tidak boleh lebih dari 5MB.',
        ]);

        try {
            Excel::import(new UjianImport(), $request->file('file'));
            return back()->with('success', 'Data ujian berhasil diimpor.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengimpor data: ' . $e->getMessage());
        }
    }

    private function messages(): array
    {
        return [
            'guru_id.required'           => 'Guru wajib dipilih.',
            'guru_id.exists'             => 'Guru yang dipilih tidak valid.',
            'mata_pelajaran_id.required' => 'Mata pelajaran wajib dipilih.',
            'mata_pelajaran_id.exists'   => 'Mata pelajaran yang dipilih tidak valid.',
            'kelas_id.required'          => 'Kelas wajib dipilih.',
            'kelas_id.exists'            => 'Kelas yang dipilih tidak valid.',
            'tahun_ajaran_id.required'   => 'Tahun ajaran wajib dipilih.',
            'tahun_ajaran_id.exists'     => 'Tahun ajaran yang dipilih tidak valid.',
            'judul.required'             => 'Judul ujian wajib diisi.',
            'judul.max'                  => 'Judul ujian maksimal 255 karakter.',
            'jenis.required'             => 'Jenis ujian wajib dipilih.',
            'jenis.in'                   => 'Jenis ujian yang dipilih tidak valid.',
            'tanggal.required'           => 'Tanggal ujian wajib diisi.',
            'tanggal.date'               => 'Format tanggal tidak valid.',
            'jam_mulai.date_format'      => 'Format jam mulai harus HH:MM.',
            'durasi_menit.required'      => 'Durasi ujian wajib diisi.',
            'durasi_menit.integer'       => 'Durasi harus berupa angka.',
            'durasi_menit.min'           => 'Durasi minimal 1 menit.',
            'durasi_menit.max'           => 'Durasi maksimal 480 menit.',
            'nilai_kkm.min'              => 'Nilai KKM minimal 0.',
            'nilai_kkm.max'              => 'Nilai KKM maksimal 100.',
            'maks_percobaan.min'         => 'Maksimal percobaan minimal 1.',
            'maks_percobaan.max'         => 'Maksimal percobaan tidak boleh lebih dari 10.',
        ];
    }
}