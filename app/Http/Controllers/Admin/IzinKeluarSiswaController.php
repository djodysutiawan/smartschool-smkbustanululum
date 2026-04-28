<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IzinKeluarSiswa;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class IzinKeluarSiswaController extends Controller
{
    // ─── INDEX ────────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $query = IzinKeluarSiswa::with(['siswa.kelas', 'tahunAjaran'])
            ->orderByDesc('tanggal')
            ->orderByDesc('id');

        // Filter search
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->whereHas('siswa', fn ($q2) => $q2->where('nama_lengkap', 'like', "%{$s}%"))
                  ->orWhere('nomor_surat', 'like', "%{$s}%")
                  ->orWhere('tujuan', 'like', "%{$s}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        }

        // Filter tahun ajaran
        $tahunAjaranId = $request->tahun_ajaran_id;
        if ($tahunAjaranId) {
            $query->where('tahun_ajaran_id', $tahunAjaranId);
        }

        // Stats hari ini
        $hariIniTotal    = IzinKeluarSiswa::whereDate('tanggal', today())->count();
        $hariIniMenunggu = IzinKeluarSiswa::whereDate('tanggal', today())
                            ->where('status', IzinKeluarSiswa::STATUS_MENUNGGU)->count();
        $hariIniKeluar   = IzinKeluarSiswa::whereDate('tanggal', today())
                            ->where('status', IzinKeluarSiswa::STATUS_DISETUJUI)->count();

        $izins        = $query->paginate(15)->withQueryString();
        $tahunAjarans = TahunAjaran::orderByDesc('tahun')->orderByDesc('semester')->get();
        $statusList   = IzinKeluarSiswa::STATUS_LIST;
        $kategoriList = IzinKeluarSiswa::KATEGORI_LIST;

        return view('admin.izin-keluar-siswa.index', compact(
            'izins', 'tahunAjarans', 'tahunAjaranId',
            'statusList', 'kategoriList',
            'hariIniTotal', 'hariIniMenunggu', 'hariIniKeluar'
        ));
    }

    // ─── CREATE ───────────────────────────────────────────────────────────────

    public function create()
    {
        $siswas       = Siswa::with('kelas')->orderBy('nama_lengkap')->get();
        $tahunAjarans = TahunAjaran::orderByDesc('tahun')->orderByDesc('semester')->get();
        $kategoriList = IzinKeluarSiswa::KATEGORI_LIST;

        // Default ke tahun ajaran aktif
        $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->first();

        return view('admin.izin-keluar-siswa.create', compact(
            'siswas', 'tahunAjarans', 'kategoriList', 'tahunAjaranAktif'
        ));
    }

    // ─── STORE ────────────────────────────────────────────────────────────────

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id'        => 'required|exists:siswa,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'tanggal'         => 'required|date',
            'jam_keluar'      => 'required',
            'jam_kembali'     => 'nullable',
            'kategori'        => 'required|in:' . implode(',', array_keys(IzinKeluarSiswa::KATEGORI_LIST)),
            'tujuan'          => 'required|max:255',
            'keterangan'      => 'nullable|max:1000',
        ]);

        IzinKeluarSiswa::create([
            'siswa_id'        => $request->siswa_id,
            'tahun_ajaran_id' => $request->tahun_ajaran_id,
            'tanggal'         => $request->tanggal,
            'jam_keluar'      => $request->jam_keluar,
            'jam_kembali'     => $request->jam_kembali,
            'kategori'        => $request->kategori,
            'tujuan'          => $request->tujuan,
            'keterangan'      => $request->keterangan,
            'status'          => IzinKeluarSiswa::STATUS_MENUNGGU,
        ]);

        return redirect()->route('admin.izin-keluar-siswa.index')
            ->with('success', 'Izin keluar siswa berhasil dibuat.');
    }

    // ─── SHOW ─────────────────────────────────────────────────────────────────

    public function show(IzinKeluarSiswa $izinKeluarSiswa)
    {
        $izin = $izinKeluarSiswa->load(['siswa.kelas', 'tahunAjaran', 'diprosesOleh', 'dicatatKembaliOleh']);

        return view('admin.izin-keluar-siswa.show', compact('izin'));
    }

    // ─── EDIT ─────────────────────────────────────────────────────────────────

    public function edit(IzinKeluarSiswa $izinKeluarSiswa)
    {
        if ($izinKeluarSiswa->status !== IzinKeluarSiswa::STATUS_MENUNGGU) {
            return redirect()->route('admin.izin-keluar-siswa.show', $izinKeluarSiswa->id)
                ->with('error', 'Hanya izin berstatus Menunggu yang dapat diedit.');
        }

        $izin         = $izinKeluarSiswa;
        $siswas       = Siswa::with('kelas')->orderBy('nama_lengkap')->get();
        $tahunAjarans = TahunAjaran::orderByDesc('tahun')->orderByDesc('semester')->get();
        $kategoriList = IzinKeluarSiswa::KATEGORI_LIST;

        return view('admin.izin-keluar-siswa.edit', compact(
            'izin', 'siswas', 'tahunAjarans', 'kategoriList'
        ));
    }

    // ─── UPDATE ───────────────────────────────────────────────────────────────

    public function update(Request $request, IzinKeluarSiswa $izinKeluarSiswa)
    {
        if ($izinKeluarSiswa->status !== IzinKeluarSiswa::STATUS_MENUNGGU) {
            return redirect()->route('admin.izin-keluar-siswa.show', $izinKeluarSiswa->id)
                ->with('error', 'Hanya izin berstatus Menunggu yang dapat diedit.');
        }

        $request->validate([
            'siswa_id'        => 'required|exists:siswa,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'tanggal'         => 'required|date',
            'jam_keluar'      => 'required',
            'jam_kembali'     => 'nullable',
            'kategori'        => 'required|in:' . implode(',', array_keys(IzinKeluarSiswa::KATEGORI_LIST)),
            'tujuan'          => 'required|max:255',
            'keterangan'      => 'nullable|max:1000',
        ]);

        $izinKeluarSiswa->update([
            'siswa_id'        => $request->siswa_id,
            'tahun_ajaran_id' => $request->tahun_ajaran_id,
            'tanggal'         => $request->tanggal,
            'jam_keluar'      => $request->jam_keluar,
            'jam_kembali'     => $request->jam_kembali,
            'kategori'        => $request->kategori,
            'tujuan'          => $request->tujuan,
            'keterangan'      => $request->keterangan,
        ]);

        return redirect()->route('admin.izin-keluar-siswa.show', $izinKeluarSiswa->id)
            ->with('success', 'Izin keluar berhasil diperbarui.');
    }

    // ─── DESTROY ──────────────────────────────────────────────────────────────

    public function destroy(IzinKeluarSiswa $izinKeluarSiswa)
    {
        $izinKeluarSiswa->delete();

        return redirect()->route('admin.izin-keluar-siswa.index')
            ->with('success', 'Izin keluar berhasil dihapus.');
    }

    // ─── SETUJUI ──────────────────────────────────────────────────────────────

    public function setujui(Request $request, IzinKeluarSiswa $izinKeluarSiswa)
    {
        if ($izinKeluarSiswa->status !== IzinKeluarSiswa::STATUS_MENUNGGU) {
            return back()->with('error', 'Izin ini sudah diproses sebelumnya.');
        }

        $izinKeluarSiswa->update([
            'status'        => IzinKeluarSiswa::STATUS_DISETUJUI,
            'diproses_oleh' => Auth::id(),
            'diproses_pada' => now(),
            'catatan_piket' => $request->catatan_piket,
            'nomor_surat'   => IzinKeluarSiswa::generateNomorSurat(),
        ]);

        return back()->with('success', 'Izin keluar berhasil disetujui.');
    }

    // ─── TOLAK ────────────────────────────────────────────────────────────────

    public function tolak(Request $request, IzinKeluarSiswa $izinKeluarSiswa)
    {
        if ($izinKeluarSiswa->status !== IzinKeluarSiswa::STATUS_MENUNGGU) {
            return back()->with('error', 'Izin ini sudah diproses sebelumnya.');
        }

        $request->validate([
            'catatan_piket' => 'required|string|max:500',
        ]);

        $izinKeluarSiswa->update([
            'status'        => IzinKeluarSiswa::STATUS_DITOLAK,
            'diproses_oleh' => Auth::id(),
            'diproses_pada' => now(),
            'catatan_piket' => $request->catatan_piket,
        ]);

        return back()->with('success', 'Izin keluar berhasil ditolak.');
    }

    // ─── CATAT KEMBALI ────────────────────────────────────────────────────────

    public function catatKembali(Request $request, IzinKeluarSiswa $izinKeluarSiswa)
    {
        if ($izinKeluarSiswa->status !== IzinKeluarSiswa::STATUS_DISETUJUI) {
            return back()->with('error', 'Hanya izin berstatus Disetujui yang dapat dicatat kembali.');
        }

        $request->validate([
            'jam_kembali_aktual' => 'required',
        ]);

        $izinKeluarSiswa->update([
            'status'               => IzinKeluarSiswa::STATUS_SUDAH_KEMBALI,
            'jam_kembali_aktual'   => $request->jam_kembali_aktual,
            'dicatat_kembali_oleh' => Auth::id(),
            'dicatat_kembali_pada' => now(),
            'catatan_piket'        => $request->catatan_piket ?? $izinKeluarSiswa->catatan_piket,
        ]);

        return back()->with('success', 'Siswa berhasil dicatat kembali.');
    }

    // ─── CETAK SURAT ──────────────────────────────────────────────────────────────

    public function cetakSurat(IzinKeluarSiswa $izinKeluarSiswa)
    {
        $izin = $izinKeluarSiswa->load(['siswa.kelas', 'tahunAjaran', 'diprosesOleh']);

        // Bersihkan karakter / dan \ dari nomor surat agar tidak error di nama file
        $nomorSurat = $izin->nomor_surat
            ? str_replace(['/', '\\'], '-', $izin->nomor_surat)
            : $izin->id;

        $pdf = Pdf::loadView('admin.izin-keluar-siswa.cetak-surat', compact('izin'))
            ->setPaper('a5', 'portrait');

        return $pdf->stream('surat-izin-' . $nomorSurat . '.pdf');
    }

    // ─── EXPORT PDF ───────────────────────────────────────────────────────────

    public function exportPdf(Request $request)
    {
        $query = IzinKeluarSiswa::with(['siswa.kelas', 'tahunAjaran'])
            ->orderByDesc('tanggal')
            ->orderByDesc('id');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->whereHas('siswa', fn ($q2) => $q2->where('nama_lengkap', 'like', "%{$s}%"))
                  ->orWhere('nomor_surat', 'like', "%{$s}%")
                  ->orWhere('tujuan', 'like', "%{$s}%");
            });
        }
        if ($request->filled('status'))          $query->where('status', $request->status);
        if ($request->filled('kategori'))         $query->where('kategori', $request->kategori);
        if ($request->filled('tanggal_dari'))     $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        if ($request->filled('tanggal_sampai'))   $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        if ($request->filled('tahun_ajaran_id'))  $query->where('tahun_ajaran_id', $request->tahun_ajaran_id);

        $izins        = $query->get();
        $statusList   = IzinKeluarSiswa::STATUS_LIST;
        $kategoriList = IzinKeluarSiswa::KATEGORI_LIST;

        $pdf = Pdf::loadView('admin.izin-keluar-siswa.export-pdf', compact('izins', 'statusList', 'kategoriList'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('izin-keluar-siswa-' . now()->format('Ymd') . '.pdf');
    }
}