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
    | CATATAN KONSISTENSI ENUM DB
    |--------------------------------------------------------------------------
    | Kolom `metode` pada tabel absensi (setelah migrasi fix):
    |   ENUM('manual','qr','qr_scan','wajah','rfid','import')
    |
    | Kolom `status`:
    |   ENUM('hadir','telat','izin','sakit','alfa')
    |
    | Di form admin (create/edit), metode yang bisa dipilih hanya 'manual'.
    | Nilai lain ('qr','qr_scan','wajah','rfid','import') dicatat otomatis sistem.
    |
    | METODE_ALL dipakai untuk:
    |   - Validasi update (agar data lama tidak ditolak)
    |   - Filter di index (agar semua tipe bisa difilter)
    |--------------------------------------------------------------------------
    */

    private const STATUS_LIST = [
        Absensi::STATUS_HADIR,
        Absensi::STATUS_TELAT,
        Absensi::STATUS_IZIN,
        Absensi::STATUS_SAKIT,
        Absensi::STATUS_ALFA,
    ];

    // Metode yang tersedia di form input manual admin
    private const METODE_FORM = ['manual'];

    // Semua metode valid di DB — dipakai untuk validasi & filter
    private const METODE_ALL = Absensi::METODE_ALL;

    // ── INDEX ─────────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $query = Absensi::with(['siswa', 'kelas', 'jadwalPelajaran', 'dicatatOleh', 'mataPelajaran']);

        $this->applyFilters($query, $request);

        $absensi    = $query->orderByDesc('tanggal')->paginate(20)->withQueryString();
        $kelasList  = Kelas::aktif()->orderBy('nama_kelas')->get();
        $statusList = self::STATUS_LIST;

        // FIX: $metodeList untuk view index HANYA dipakai di form create/edit (jika perlu),
        // tapi filter dropdown di index.blade.php sudah pakai $metodeAllForFilter lokal.
        // Tetap kirim METODE_FORM agar konsisten dengan create/edit.
        $metodeList = self::METODE_FORM;

        $rekapRaw = Absensi::whereDate('tanggal', today())
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $rekap = [
            'hadir' => ($rekapRaw['hadir'] ?? 0) + ($rekapRaw['telat'] ?? 0),
            'izin'  => $rekapRaw['izin']  ?? 0,
            'sakit' => $rekapRaw['sakit'] ?? 0,
            'alfa'  => $rekapRaw['alfa']  ?? 0,
        ];

        return view('admin.absensi.index',
            compact('absensi', 'kelasList', 'statusList', 'metodeList', 'rekap'));
    }

    // ── CREATE & STORE ────────────────────────────────────────────────────────

    public function create()
    {
        $kelasList  = Kelas::aktif()->orderBy('nama_kelas')->get();
        $statusList = self::STATUS_LIST;
        $metodeList = self::METODE_FORM;

        // FIX: siswaList & jadwalList TIDAK dikirim — dimuat via AJAX (getByKelas).
        // View create.blade.php sudah diperbarui untuk pakai AJAX.
        return view('admin.absensi.create',
            compact('kelasList', 'statusList', 'metodeList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'siswa_id'            => ['required', 'exists:siswa,id'],
            'kelas_id'            => ['required', 'exists:kelas,id'],
            'jadwal_pelajaran_id' => ['nullable', 'exists:jadwal_pelajaran,id'],
            'tanggal'             => ['required', 'date'],
            'status'              => ['required', Rule::in(self::STATUS_LIST)],
            'metode'              => ['nullable', Rule::in(self::METODE_ALL)],
            'jam_masuk'           => ['nullable', 'date_format:H:i'],
            'jam_keluar'          => ['nullable', 'date_format:H:i', 'after:jam_masuk'],
            'keterangan'          => ['nullable', 'string', 'max:500'],
            'path_surat_izin'     => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ]);

        // FIX: Validasi relasi siswa ↔ kelas — pastikan siswa memang ada di kelas tersebut
        $siswa = Siswa::find($validated['siswa_id']);
        if ($siswa && $siswa->kelas_id !== (int) $validated['kelas_id']) {
            return back()->withInput()
                ->withErrors(['siswa_id' => 'Siswa ini tidak terdaftar di kelas yang dipilih.']);
        }

        // Cek duplikat absensi siswa di kelas & tanggal yang sama
        $sudahAda = Absensi::where('siswa_id', $validated['siswa_id'])
            ->where('kelas_id', $validated['kelas_id'])
            ->whereDate('tanggal', $validated['tanggal'])
            ->exists();

        if ($sudahAda) {
            return back()->withInput()
                ->with('error', 'Siswa ini sudah memiliki data absensi pada tanggal dan kelas tersebut.');
        }

        if ($request->hasFile('path_surat_izin')) {
            $validated['path_surat_izin'] = $request->file('path_surat_izin')
                ->store('absensi/surat_izin', 'public');
        }

        $validated['dicatat_oleh'] = Auth::id();
        $validated['metode']       = $validated['metode'] ?? Absensi::METODE_MANUAL;

        Absensi::create($validated);

        return redirect()->route('admin.absensi.index')
            ->with('success', 'Data absensi berhasil ditambahkan.');
    }

    // ── SHOW ──────────────────────────────────────────────────────────────────

    public function show(Absensi $absensi)
    {
        $absensi->load(['siswa', 'kelas', 'jadwalPelajaran', 'mataPelajaran', 'dicatatOleh']);
        return view('admin.absensi.show', compact('absensi'));
    }

    // ── EDIT & UPDATE ─────────────────────────────────────────────────────────

    public function edit(Absensi $absensi)
    {
        $kelasList  = Kelas::aktif()->orderBy('nama_kelas')->get();
        $statusList = self::STATUS_LIST;
        $metodeList = self::METODE_FORM;

        return view('admin.absensi.edit',
            compact('absensi', 'kelasList', 'statusList', 'metodeList'));
    }

    public function update(Request $request, Absensi $absensi)
    {
        $validated = $request->validate([
            'status'          => ['required', Rule::in(self::STATUS_LIST)],
            // Terima semua nilai DB agar data lama (qr, rfid, dll) tidak ditolak saat update
            'metode'          => ['nullable', Rule::in(self::METODE_ALL)],
            'jam_masuk'       => ['nullable', 'date_format:H:i'],
            'jam_keluar'      => ['nullable', 'date_format:H:i', 'after:jam_masuk'],
            'keterangan'      => ['nullable', 'string', 'max:500'],
            'path_surat_izin' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ]);

        if ($request->hasFile('path_surat_izin')) {
            // FIX: Hapus file lama jika ada sebelum menyimpan file baru
            if ($absensi->path_surat_izin) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($absensi->path_surat_izin);
            }
            $validated['path_surat_izin'] = $request->file('path_surat_izin')
                ->store('absensi/surat_izin', 'public');
        }

        $absensi->update($validated);

        return redirect()->route('admin.absensi.show', $absensi)
            ->with('success', 'Data absensi berhasil diperbarui.');
    }

    // ── DESTROY ───────────────────────────────────────────────────────────────

    public function destroy(Absensi $absensi)
    {
        // FIX: Hapus file surat izin dari storage sebelum delete record
        if ($absensi->path_surat_izin) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($absensi->path_surat_izin);
        }

        $absensi->delete();

        return redirect()->route('admin.absensi.index')
            ->with('success', 'Data absensi berhasil dihapus.');
    }

    // ── AJAX: GET SISWA & JADWAL BY KELAS ────────────────────────────────────

    /**
     * Endpoint AJAX untuk form create — mengisi dropdown siswa dan jadwal
     * secara dinamis ketika kelas dipilih.
     *
     * Route: GET /admin/absensi/kelas/{kelas}/data
     * Nama:  admin.absensi.by-kelas
     */
    public function getByKelas(Kelas $kelas, Request $request)
    {
        $siswa = $kelas->siswa()
            ->where('status', 'aktif')
            ->orderBy('nama_lengkap')
            ->get(['id', 'nama_lengkap', 'nis']);

        $jadwal = collect();
        if ($request->filled('tanggal')) {
            $hariIndo = [
                0 => 'minggu', 1 => 'senin', 2 => 'selasa',
                3 => 'rabu', 4 => 'kamis', 5 => 'jumat', 6 => 'sabtu',
            ];
            $hariAngka = (int) date('w', strtotime($request->tanggal));
            $hariStr   = $hariIndo[$hariAngka] ?? 'senin';

            $jadwal = JadwalPelajaran::with('mataPelajaran')
                ->where('kelas_id', $kelas->id)
                ->where('hari', $hariStr)
                ->where('is_active', true)
                ->orderBy('jam_mulai')
                ->get(['id', 'mata_pelajaran_id', 'jam_mulai', 'jam_selesai']);
        }

        return response()->json([
            'siswa'  => $siswa,
            'jadwal' => $jadwal,
        ]);
    }

    // ── REKAP KELAS ───────────────────────────────────────────────────────────

    public function rekapKelas(Request $request)
    {
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

    // ── EXPORT PDF ────────────────────────────────────────────────────────────

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

    // ── EXPORT EXCEL ──────────────────────────────────────────────────────────

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

    // ── IMPORT ────────────────────────────────────────────────────────────────

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

    // ── PRIVATE HELPER ────────────────────────────────────────────────────────

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