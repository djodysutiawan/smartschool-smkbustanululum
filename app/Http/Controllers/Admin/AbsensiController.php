<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\JadwalPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AbsensiExport;
use App\Exports\AbsensiRekapExport;
use App\Imports\AbsensiImport;
use Barryvdh\DomPDF\Facade\Pdf;

class AbsensiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CATATAN KONSISTENSI MIGRASI
    |--------------------------------------------------------------------------
    | Kolom `metode` pada tabel absensi: enum('manual', 'qr') — bukan 'qr_code'.
    | Kolom `tanggal`: date (bukan timestamp).
    | Semua export rekap menggunakan GET agar parameter tersedia di request.
    |--------------------------------------------------------------------------
    */

    private const STATUS_LIST = ['hadir', 'telat', 'izin', 'sakit', 'alfa'];
    private const METODE_LIST = ['manual', 'qr'];

    // -------------------------------------------------------------------------
    // INDEX
    // -------------------------------------------------------------------------

    public function index(Request $request)
    {
        $query = Absensi::with(['siswa', 'kelas', 'jadwalPelajaran', 'dicatatOleh']);

        $this->applyFilters($query, $request);

        $absensi    = $query->orderByDesc('tanggal')->paginate(20)->withQueryString();
        $kelasList  = Kelas::aktif()->orderBy('nama_kelas')->get();
        $siswaList  = Siswa::aktif()->orderBy('nama_lengkap')->get();
        $statusList = self::STATUS_LIST;
        $metodeList = self::METODE_LIST;

        $rekap = [
            'hadir' => Absensi::whereIn('status', ['hadir', 'telat'])->whereDate('tanggal', today())->count(),
            'izin'  => Absensi::where('status', 'izin')->whereDate('tanggal', today())->count(),
            'sakit' => Absensi::where('status', 'sakit')->whereDate('tanggal', today())->count(),
            'alfa'  => Absensi::where('status', 'alfa')->whereDate('tanggal', today())->count(),
        ];

        return view('admin.absensi.index',
            compact('absensi', 'kelasList', 'siswaList', 'statusList', 'metodeList', 'rekap'));
    }

    // -------------------------------------------------------------------------
    // CREATE & STORE
    // -------------------------------------------------------------------------

    public function create()
    {
        $kelasList  = Kelas::aktif()->orderBy('nama_kelas')->get();
        $siswaList  = Siswa::aktif()->orderBy('nama_lengkap')->get();
        $jadwalList = JadwalPelajaran::aktif()->with(['mataPelajaran', 'kelas'])->get();
        $statusList = self::STATUS_LIST;
        $metodeList = self::METODE_LIST;

        return view('admin.absensi.create',
            compact('kelasList', 'siswaList', 'jadwalList', 'statusList', 'metodeList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'siswa_id'            => ['required', 'exists:siswa,id'],
            'kelas_id'            => ['required', 'exists:kelas,id'],
            'jadwal_pelajaran_id' => ['nullable', 'exists:jadwal_pelajaran,id'],
            'dicatat_oleh'        => ['nullable', 'exists:users,id'],
            'tanggal'             => ['required', 'date'],
            'status'              => ['required', Rule::in(self::STATUS_LIST)],
            'metode'              => ['nullable', Rule::in(self::METODE_LIST)],
            'jam_masuk'           => ['nullable', 'date_format:H:i'],
            'jam_keluar'          => ['nullable', 'date_format:H:i', 'after:jam_masuk'],
            'keterangan'          => ['nullable', 'string', 'max:500'],
            'path_surat_izin'     => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ]);

        if ($request->hasFile('path_surat_izin')) {
            $validated['path_surat_izin'] = $request->file('path_surat_izin')
                ->store('absensi/surat_izin', 'public');
        }

        $validated['dicatat_oleh'] = $validated['dicatat_oleh'] ?? Auth::id();

        Absensi::create($validated);

        return redirect()->route('admin.absensi.index')
            ->with('success', 'Data absensi berhasil ditambahkan.');
    }

    // -------------------------------------------------------------------------
    // SHOW
    // -------------------------------------------------------------------------

    public function show(Absensi $absensi)
    {
        $absensi->load(['siswa', 'kelas', 'jadwalPelajaran', 'dicatatOleh']);

        return view('admin.absensi.show', compact('absensi'));
    }

    // -------------------------------------------------------------------------
    // EDIT & UPDATE
    // -------------------------------------------------------------------------

    public function edit(Absensi $absensi)
    {
        $kelasList  = Kelas::aktif()->orderBy('nama_kelas')->get();
        $siswaList  = Siswa::aktif()->orderBy('nama_lengkap')->get();
        $jadwalList = JadwalPelajaran::aktif()->with(['mataPelajaran', 'kelas'])->get();
        $statusList = self::STATUS_LIST;
        $metodeList = self::METODE_LIST;

        return view('admin.absensi.edit',
            compact('absensi', 'kelasList', 'siswaList', 'jadwalList', 'statusList', 'metodeList'));
    }

    public function update(Request $request, Absensi $absensi)
    {
        $validated = $request->validate([
            'status'          => ['required', Rule::in(self::STATUS_LIST)],
            'metode'          => ['nullable', Rule::in(self::METODE_LIST)],
            'jam_masuk'       => ['nullable', 'date_format:H:i'],
            'jam_keluar'      => ['nullable', 'date_format:H:i', 'after:jam_masuk'],
            'keterangan'      => ['nullable', 'string', 'max:500'],
            'path_surat_izin' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ]);

        if ($request->hasFile('path_surat_izin')) {
            $validated['path_surat_izin'] = $request->file('path_surat_izin')
                ->store('absensi/surat_izin', 'public');
        }

        $absensi->update($validated);

        return redirect()->route('admin.absensi.show', $absensi)
            ->with('success', 'Data absensi berhasil diperbarui.');
    }

    // -------------------------------------------------------------------------
    // DESTROY
    // -------------------------------------------------------------------------

    public function destroy(Absensi $absensi)
    {
        $absensi->delete();

        return redirect()->route('admin.absensi.index')
            ->with('success', 'Data absensi berhasil dihapus.');
    }

    // -------------------------------------------------------------------------
    // REKAP KELAS
    // -------------------------------------------------------------------------

    /**
     * Tampilkan rekap absensi per kelas.
     * Menggunakan GET agar parameter query string tersedia
     * untuk link export PDF / Excel di view rekap.
     */
    public function rekapKelas(Request $request)
    {
        // Jika belum ada parameter, tampilkan halaman kosong (form saja)
        if (! $request->filled('kelas_id')) {
            $kelasList = Kelas::aktif()->orderBy('nama_kelas')->get();
            return view('admin.absensi.rekap', [
                'absensi'   => null,
                'kelas'     => null,
                'kelasList' => $kelasList,
                'request'   => $request,
            ]);
        }

        $request->validate([
            'kelas_id'       => ['required', 'exists:kelas,id'],
            'tanggal_dari'   => ['required', 'date'],
            'tanggal_sampai' => ['required', 'date', 'after_or_equal:tanggal_dari'],
        ]);

        $absensi = Absensi::with('siswa')
            ->where('kelas_id', $request->kelas_id)
            ->whereBetween('tanggal', [$request->tanggal_dari, $request->tanggal_sampai])
            ->get()
            ->groupBy('siswa_id');

        $kelas     = Kelas::findOrFail($request->kelas_id);
        $kelasList = Kelas::aktif()->orderBy('nama_kelas')->get();

        return view('admin.absensi.rekap',
            compact('absensi', 'kelas', 'kelasList', 'request'));
    }

    // -------------------------------------------------------------------------
    // EXPORT PDF
    // -------------------------------------------------------------------------

    public function exportPdf(Request $request)
    {
        $query = Absensi::with(['siswa', 'kelas', 'jadwalPelajaran', 'dicatatOleh']);

        $this->applyFilters($query, $request);

        $absensi    = $query->orderByDesc('tanggal')->get();
        $statusList = self::STATUS_LIST;

        $pdf = Pdf::loadView('admin.absensi.exports.pdf', compact('absensi', 'statusList'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('absensi_' . now()->format('Ymd_His') . '.pdf');
    }

    public function exportRekapPdf(Request $request)
    {
        $request->validate([
            'kelas_id'       => ['required', 'exists:kelas,id'],
            'tanggal_dari'   => ['required', 'date'],
            'tanggal_sampai' => ['required', 'date', 'after_or_equal:tanggal_dari'],
        ]);

        $absensi = Absensi::with('siswa')
            ->where('kelas_id', $request->kelas_id)
            ->whereBetween('tanggal', [$request->tanggal_dari, $request->tanggal_sampai])
            ->get()
            ->groupBy('siswa_id');

        $kelas = Kelas::findOrFail($request->kelas_id);

        $pdf = Pdf::loadView('admin.absensi.exports.rekap-pdf', compact('absensi', 'kelas', 'request'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('rekap_absensi_' . $kelas->nama_kelas . '_' . now()->format('Ymd') . '.pdf');
    }

    // -------------------------------------------------------------------------
    // EXPORT EXCEL
    // -------------------------------------------------------------------------

    public function exportExcel(Request $request)
    {
        $filters = $request->only([
            'kelas_id', 'siswa_id', 'status', 'metode',
            'tanggal_dari', 'tanggal_sampai',
        ]);

        return Excel::download(
            new AbsensiExport($filters),
            'absensi_' . now()->format('Ymd_His') . '.xlsx'
        );
    }

    public function exportRekapExcel(Request $request)
    {
        $request->validate([
            'kelas_id'       => ['required', 'exists:kelas,id'],
            'tanggal_dari'   => ['required', 'date'],
            'tanggal_sampai' => ['required', 'date', 'after_or_equal:tanggal_dari'],
        ]);

        return Excel::download(
            new AbsensiRekapExport(
                $request->kelas_id,
                $request->tanggal_dari,
                $request->tanggal_sampai
            ),
            'rekap_absensi_' . now()->format('Ymd_His') . '.xlsx'
        );
    }

    // -------------------------------------------------------------------------
    // IMPORT EXCEL
    // -------------------------------------------------------------------------

    public function importTemplate()
    {
        $path = storage_path('app/templates/absensi_template.xlsx');

        if (! file_exists($path)) {
            return Excel::download(new \App\Exports\AbsensiTemplateExport, 'absensi_template.xlsx');
        }

        return response()->download($path, 'absensi_template.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls', 'max:5120'],
        ]);

        $import = new AbsensiImport();
        Excel::import($import, $request->file('file'));

        $rowCount = $import->getRowCount();

        return redirect()->route('admin.absensi.index')
            ->with('success', "Import berhasil! {$rowCount} data absensi berhasil diimport.");
    }

    // -------------------------------------------------------------------------
    // HELPER
    // -------------------------------------------------------------------------

    private function applyFilters(\Illuminate\Database\Eloquent\Builder $query, Request $request): void
    {
        if ($request->filled('kelas_id'))       $query->where('kelas_id', $request->kelas_id);
        if ($request->filled('siswa_id'))       $query->where('siswa_id', $request->siswa_id);
        if ($request->filled('status'))         $query->where('status', $request->status);
        if ($request->filled('metode'))         $query->where('metode', $request->metode);
        if ($request->filled('tanggal_dari'))   $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        if ($request->filled('tanggal_sampai')) $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
    }
}