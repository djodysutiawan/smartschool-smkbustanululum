<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AbsensiGuru;         // ← TAMBAHAN: untuk cek status hadir guru piket
use App\Models\Guru;
use App\Models\JadwalPiketGuru;
use App\Models\TahunAjaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\JadwalPiketGuruExport;
use App\Imports\JadwalPiketGuruImport;

class JadwalPiketGuruController extends Controller
{
    protected array $hariList = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];

    // ─── INDEX — MODIFIKASI: tambah info status hadir guru piket hari ini ─────

    public function index(Request $request)
    {
        $query = JadwalPiketGuru::with(['guru', 'tahunAjaran'])
            ->orderByRaw("FIELD(hari, 'senin','selasa','rabu','kamis','jumat','sabtu')")
            ->orderBy('jam_mulai');

        if ($request->filled('tahun_ajaran_id')) {
            $query->where('tahun_ajaran_id', $request->tahun_ajaran_id);
        }

        if ($request->filled('guru_id')) {
            $query->where('guru_id', $request->guru_id);
        }

        if ($request->filled('hari')) {
            $query->where('hari', $request->hari);
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        $jadwal      = $query->paginate(15)->withQueryString();
        $guruPiket   = Guru::orderBy('nama_lengkap')->get();
        $tahunAjaran = TahunAjaran::orderByDesc('tahun')->get();

        // Kode lama: guru yang bertugas piket hari ini
        $piketHariIni = JadwalPiketGuru::getPiketHariIni();

        // ─── TAMBAHAN: tandai siapa dari guru piket hari ini yang sudah absen ─
        $absensiHariIni = AbsensiGuru::whereDate('tanggal', today())
            ->whereIn('guru_id', $piketHariIni->pluck('guru_id')->filter()->unique())
            ->get()
            ->keyBy('guru_id');

        // Inject status hadir ke dalam koleksi piketHariIni (tanpa ubah struktur aslinya)
        $piketHariIni->each(function ($jadwalPiket) use ($absensiHariIni) {
            $absensi = $absensiHariIni->get($jadwalPiket->guru_id);
            $jadwalPiket->sudah_absen    = ! is_null($absensi);
            $jadwalPiket->status_absensi = $absensi?->status;
        });
        // ─────────────────────────────────────────────────────────────────────

        return view('admin.jadwal_piket_guru.index', compact(
            'jadwal', 'guruPiket', 'tahunAjaran', 'piketHariIni', 'absensiHariIni'
        ) + ['hariList' => $this->hariList]);
    }

    // ─── Semua method di bawah ini TIDAK DIUBAH dari versi asli ──────────────

    public function create()
    {
        $guruPiket   = Guru::orderBy('nama_lengkap')->get();
        $tahunAjaran = TahunAjaran::orderByDesc('tahun')->get();

        return view('admin.jadwal_piket_guru.create', [
            'guruPiket'   => $guruPiket,
            'tahunAjaran' => $tahunAjaran,
            'hariList'    => $this->hariList,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'guru_id'         => 'required|exists:guru,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'hari'            => 'required|in:' . implode(',', $this->hariList),
            'jam_mulai'       => 'required|date_format:H:i',
            'jam_selesai'     => 'required|date_format:H:i|after:jam_mulai',
            'catatan'         => 'nullable|string|max:500',
            'is_active'       => 'nullable|boolean',
        ], [
            'guru_id.required'         => 'Guru piket wajib dipilih.',
            'tahun_ajaran_id.required' => 'Tahun ajaran wajib dipilih.',
            'hari.required'            => 'Hari wajib dipilih.',
            'jam_mulai.required'       => 'Jam mulai wajib diisi.',
            'jam_selesai.required'     => 'Jam selesai wajib diisi.',
            'jam_selesai.after'        => 'Jam selesai harus lebih dari jam mulai.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        JadwalPiketGuru::create([
            'guru_id'         => $request->guru_id,
            'tahun_ajaran_id' => $request->tahun_ajaran_id,
            'hari'            => $request->hari,
            'jam_mulai'       => $request->jam_mulai,
            'jam_selesai'     => $request->jam_selesai,
            'catatan'         => $request->catatan,
            'is_active'       => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.jadwal-piket-guru.index')
            ->with('success', 'Jadwal piket guru berhasil ditambahkan.');
    }

    public function show(JadwalPiketGuru $jadwalPiketGuru)
    {
        $jadwalPiketGuru->load(['guru', 'tahunAjaran']);
        return view('admin.jadwal_piket_guru.show', compact('jadwalPiketGuru'));
    }

    public function edit(JadwalPiketGuru $jadwalPiketGuru)
    {
        $guruPiket   = Guru::orderBy('nama_lengkap')->get();
        $tahunAjaran = TahunAjaran::orderByDesc('tahun')->get();

        return view('admin.jadwal_piket_guru.edit', [
            'jadwalPiketGuru' => $jadwalPiketGuru,
            'guruPiket'       => $guruPiket,
            'tahunAjaran'     => $tahunAjaran,
            'hariList'        => $this->hariList,
        ]);
    }

    public function update(Request $request, JadwalPiketGuru $jadwalPiketGuru)
    {
        $validator = Validator::make($request->all(), [
            'guru_id'         => 'required|exists:guru,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'hari'            => 'required|in:' . implode(',', $this->hariList),
            'jam_mulai'       => 'required|date_format:H:i',
            'jam_selesai'     => 'required|date_format:H:i|after:jam_mulai',
            'catatan'         => 'nullable|string|max:500',
            'is_active'       => 'nullable|boolean',
        ], [
            'guru_id.required'         => 'Guru piket wajib dipilih.',
            'tahun_ajaran_id.required' => 'Tahun ajaran wajib dipilih.',
            'hari.required'            => 'Hari wajib dipilih.',
            'jam_mulai.required'       => 'Jam mulai wajib diisi.',
            'jam_selesai.required'     => 'Jam selesai wajib diisi.',
            'jam_selesai.after'        => 'Jam selesai harus lebih dari jam mulai.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $jadwalPiketGuru->update([
            'guru_id'         => $request->guru_id,
            'tahun_ajaran_id' => $request->tahun_ajaran_id,
            'hari'            => $request->hari,
            'jam_mulai'       => $request->jam_mulai,
            'jam_selesai'     => $request->jam_selesai,
            'catatan'         => $request->catatan,
            'is_active'       => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.jadwal-piket-guru.show', $jadwalPiketGuru->id)
            ->with('success', 'Jadwal piket guru berhasil diperbarui.');
    }

    public function destroy(JadwalPiketGuru $jadwalPiketGuru)
    {
        $jadwalPiketGuru->delete();

        return redirect()->route('admin.jadwal_piket_guru.index')
            ->with('success', 'Jadwal piket guru berhasil dihapus.');
    }

    public function toggleStatus(JadwalPiketGuru $jadwalPiketGuru)
    {
        $jadwalPiketGuru->update(['is_active' => !$jadwalPiketGuru->is_active]);
        $status = $jadwalPiketGuru->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Jadwal piket berhasil {$status}.");
    }

    public function export(Request $request)
    {
        $filename = 'jadwal_piket_guru_' . now()->format('Ymd_His') . '.xlsx';
        return Excel::download(new JadwalPiketGuruExport($request->all()), $filename);
    }

    public function exportPdf(Request $request)
    {
        $query = JadwalPiketGuru::with(['guru', 'tahunAjaran'])
            ->orderByRaw("FIELD(hari, 'senin','selasa','rabu','kamis','jumat','sabtu')")
            ->orderBy('jam_mulai');

        if ($request->filled('tahun_ajaran_id')) {
            $query->where('tahun_ajaran_id', $request->tahun_ajaran_id);
        }

        if ($request->filled('guru_id')) {
            $query->where('guru_id', $request->guru_id);
        }

        if ($request->filled('hari')) {
            $query->where('hari', $request->hari);
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        $jadwal = $query->get();

        $pdf = Pdf::loadView('admin.jadwal_piket_guru.pdf', compact('jadwal'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('jadwal_piket_guru_' . now()->format('Ymd') . '.pdf');
    }

    public function exportPdfSingle(JadwalPiketGuru $jadwalPiketGuru)
    {
        $jadwalPiketGuru->load(['guru', 'tahunAjaran']);
        $jadwal = collect([$jadwalPiketGuru]);

        $pdf = Pdf::loadView('admin.jadwal_piket_guru.pdf', compact('jadwal'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('jadwal_piket_' . $jadwalPiketGuru->id . '.pdf');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:5120',
        ], [
            'file.required' => 'File wajib diunggah.',
            'file.mimes'    => 'File harus berformat xlsx atau xls.',
            'file.max'      => 'Ukuran file maksimal 5MB.',
        ]);

        try {
            $import = new JadwalPiketGuruImport();
            Excel::import($import, $request->file('file'));

            $errors = $import->getErrors();

            if (!empty($errors)) {
                return redirect()->route('admin.jadwal_piket_guru.index')
                    ->with('import_errors', $errors)
                    ->with('success', 'Import selesai dengan beberapa peringatan.');
            }

            return redirect()->route('admin.jadwal_piket_guru.index')
                ->with('success', 'Data jadwal piket berhasil diimport.');

        } catch (\Exception $e) {
            return redirect()->route('admin.jadwal_piket_guru.index')
                ->with('error', 'Gagal mengimport data: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        $filename = 'template_jadwal_piket_guru.xlsx';
        return Excel::download(new \App\Exports\JadwalPiketGuruTemplateExport(), $filename);
    }
}