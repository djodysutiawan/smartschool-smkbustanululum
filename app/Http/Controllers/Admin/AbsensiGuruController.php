<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AbsensiGuru;
use App\Models\Guru;
use App\Models\JadwalPiketGuru;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class AbsensiGuruController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CATATAN KONSISTENSI ENUM DB
    |--------------------------------------------------------------------------
    | Kolom `status` : ENUM('hadir','telat','izin','sakit','alfa')
    | Kolom `metode` : ENUM('manual','qr')
    |
    | Nilai 'qr' dicatat otomatis oleh SesiQrGuruController::prosesQr().
    | Form admin hanya menggunakan 'manual'.
    |--------------------------------------------------------------------------
    */

    // ─── INDEX ────────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $query = AbsensiGuru::with(['guru', 'pencatat', 'jadwalPiket']);

        $this->applyFilters($query, $request);

        $absensi  = $query->orderByDesc('tanggal')->paginate(20)->withQueryString();
        $guruList = Guru::aktif()->orderBy('nama_lengkap')->get();

        $rekapRaw = AbsensiGuru::whereDate('tanggal', today())
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $rekap = [
            'hadir' => ($rekapRaw['hadir'] ?? 0) + ($rekapRaw['telat'] ?? 0),
            'izin'  => $rekapRaw['izin']  ?? 0,
            'sakit' => $rekapRaw['sakit'] ?? 0,
            'alfa'  => $rekapRaw['alfa']  ?? 0,
        ];

        return view('admin.absensi-guru.index', compact('absensi', 'guruList', 'rekap') + [
            'statusList' => AbsensiGuru::STATUS_LIST,
            'metodeList' => AbsensiGuru::METODE_LIST,
        ]);
    }

    // ─── CREATE & STORE ───────────────────────────────────────────────────────

    public function create()
    {
        $guruList   = Guru::aktif()->orderBy('nama_lengkap')->get();
        $jadwalList = JadwalPiketGuru::where('is_active', true)
                        ->with('guru')
                        ->orderBy('hari')
                        ->get();

        return view('admin.absensi-guru.create', compact('guruList', 'jadwalList') + [
            'statusList' => AbsensiGuru::STATUS_LIST,
            'metodeList' => ['manual'],        // form hanya izinkan manual
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'guru_id'         => ['required', 'exists:guru,id'],
            'jadwal_piket_id' => ['nullable', 'exists:jadwal_piket_guru,id'],
            'tanggal'         => [
                'required', 'date',
                Rule::unique('absensi_guru')->where(
                    fn ($q) => $q->where('guru_id', $request->guru_id)
                                 ->whereDate('tanggal', $request->tanggal)
                ),
            ],
            'jam_masuk'       => ['nullable', 'date_format:H:i'],
            'jam_keluar'      => ['nullable', 'date_format:H:i', 'after:jam_masuk'],
            'status'          => ['required', Rule::in(AbsensiGuru::STATUS_LIST)],
            'metode'          => ['nullable', Rule::in(AbsensiGuru::METODE_LIST)],
            'keterangan'      => ['nullable', 'string', 'max:500'],
            'path_surat_izin' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ], [
            'tanggal.unique' => 'Guru ini sudah memiliki data absensi pada tanggal tersebut.',
        ]);

        if ($request->hasFile('path_surat_izin')) {
            $validated['path_surat_izin'] = $request->file('path_surat_izin')
                ->store('absensi-guru/surat-izin', 'public');
        }

        $validated['dicatat_oleh'] = Auth::id();
        $validated['metode']       = $validated['metode'] ?? 'manual';

        AbsensiGuru::create($validated);

        return redirect()->route('admin.absensi-guru.index')
            ->with('success', 'Data absensi guru berhasil ditambahkan.');
    }

    // ─── SHOW ─────────────────────────────────────────────────────────────────

    public function show(AbsensiGuru $absensiGuru)
    {
        $absensiGuru->load(['guru', 'pencatat', 'jadwalPiket']);
        return view('admin.absensi-guru.show', compact('absensiGuru'));
    }

    // ─── EDIT & UPDATE ────────────────────────────────────────────────────────

    public function edit(AbsensiGuru $absensiGuru)
    {
        $guruList   = Guru::aktif()->orderBy('nama_lengkap')->get();
        $jadwalList = JadwalPiketGuru::where('is_active', true)->with('guru')->get();

        return view('admin.absensi-guru.edit', compact('absensiGuru', 'guruList', 'jadwalList') + [
            'statusList' => AbsensiGuru::STATUS_LIST,
            'metodeList' => AbsensiGuru::METODE_LIST,   // edit boleh lihat semua metode
        ]);
    }

    public function update(Request $request, AbsensiGuru $absensiGuru)
    {
        $validated = $request->validate([
            'status'          => ['required', Rule::in(AbsensiGuru::STATUS_LIST)],
            'metode'          => ['nullable', Rule::in(AbsensiGuru::METODE_LIST)],
            'jam_masuk'       => ['nullable', 'date_format:H:i'],
            'jam_keluar'      => ['nullable', 'date_format:H:i', 'after:jam_masuk'],
            'keterangan'      => ['nullable', 'string', 'max:500'],
            'path_surat_izin' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ]);

        if ($request->hasFile('path_surat_izin')) {
            // Hapus file lama sebelum menyimpan yang baru
            if ($absensiGuru->path_surat_izin) {
                Storage::disk('public')->delete($absensiGuru->path_surat_izin);
            }
            $validated['path_surat_izin'] = $request->file('path_surat_izin')
                ->store('absensi-guru/surat-izin', 'public');
        }

        $absensiGuru->update($validated);

        return redirect()->route('admin.absensi-guru.show', $absensiGuru)
            ->with('success', 'Data absensi guru berhasil diperbarui.');
    }

    // ─── DESTROY ─────────────────────────────────────────────────────────────

    public function destroy(AbsensiGuru $absensiGuru)
    {
        // Hapus file surat izin jika ada
        if ($absensiGuru->path_surat_izin) {
            Storage::disk('public')->delete($absensiGuru->path_surat_izin);
        }

        $absensiGuru->delete();

        return redirect()->route('admin.absensi-guru.index')
            ->with('success', 'Data absensi guru berhasil dihapus.');
    }

    // ─── REKAP PER GURU ───────────────────────────────────────────────────────

    public function rekapGuru(Request $request)
    {
        $guruList = Guru::aktif()->orderBy('nama_lengkap')->get();

        if (! $request->filled('tanggal_dari')) {
            return view('admin.absensi-guru.rekap', [
                'absensi'  => null,
                'guru'     => null,
                'guruList' => $guruList,
                'request'  => $request,
            ]);
        }

        $request->validate([
            'tanggal_dari'   => ['required', 'date'],
            'tanggal_sampai' => ['required', 'date', 'after_or_equal:tanggal_dari'],
        ]);

        $query = AbsensiGuru::with('guru')
            ->whereBetween('tanggal', [$request->tanggal_dari, $request->tanggal_sampai]);

        if ($request->filled('guru_id')) {
            $query->where('guru_id', $request->guru_id);
        }

        $absensi = $query->orderBy('tanggal')->get()->groupBy('guru_id');
        $guru    = $request->filled('guru_id') ? Guru::find($request->guru_id) : null;

        return view('admin.absensi-guru.rekap',
            compact('absensi', 'guru', 'guruList', 'request'));
    }

    // ─── EXPORT PDF ──────────────────────────────────────────────────────────

    public function exportPdf(Request $request)
    {
        $query = AbsensiGuru::with(['guru', 'pencatat']);
        $this->applyFilters($query, $request);
        $absensi = $query->orderByDesc('tanggal')->get();

        $pdf = Pdf::loadView('admin.absensi-guru.exports.pdf', compact('absensi'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('absensi_guru_' . now()->format('Ymd_His') . '.pdf');
    }

    public function exportRekapPdf(Request $request)
    {
        $request->validate([
            'tanggal_dari'   => ['required', 'date'],
            'tanggal_sampai' => ['required', 'date', 'after_or_equal:tanggal_dari'],
        ]);

        $query = AbsensiGuru::with('guru')
            ->whereBetween('tanggal', [$request->tanggal_dari, $request->tanggal_sampai]);

        if ($request->filled('guru_id')) {
            $query->where('guru_id', $request->guru_id);
        }

        $absensi = $query->orderBy('tanggal')->get()->groupBy('guru_id');
        $guru    = $request->filled('guru_id') ? Guru::find($request->guru_id) : null;

        $pdf = Pdf::loadView('admin.absensi-guru.exports.rekap-pdf', compact('absensi', 'guru', 'request'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('rekap_absensi_guru_' . now()->format('Ymd') . '.pdf');
    }

    // ─── HELPER PRIVATE ──────────────────────────────────────────────────────

    private function applyFilters(\Illuminate\Database\Eloquent\Builder $query, Request $request): void
    {
        if ($request->filled('guru_id'))        $query->where('guru_id', $request->guru_id);
        if ($request->filled('status'))         $query->where('status', $request->status);
        if ($request->filled('metode'))         $query->where('metode', $request->metode);
        if ($request->filled('tanggal_dari'))   $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        if ($request->filled('tanggal_sampai')) $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
    }
}