<?php

namespace App\Http\Controllers\Piket;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Piket\Concerns\PiketActiveGuru;
use App\Models\IzinKeluarSiswa;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class IzinKeluarSiswaController extends Controller
{
    use PiketActiveGuru;

    // ─── Index ────────────────────────────────────────────────────────────────

    public function index(Request $request): View
    {
        $query = IzinKeluarSiswa::with(['siswa.kelas', 'diprosesOleh'])
            ->latest('tanggal')->latest('id');

        if ($request->filled('status'))        $query->where('status', $request->status);
        if ($request->filled('kategori'))       $query->where('kategori', $request->kategori);
        if ($request->filled('tanggal_dari'))   $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        if ($request->filled('tanggal_sampai')) $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn ($q) => $q
                ->whereHas('siswa', fn ($sq) => $sq->where('nama_lengkap', 'like', "%{$s}%"))
                ->orWhere('nomor_surat', 'like', "%{$s}%")
                ->orWhere('tujuan', 'like', "%{$s}%"));
        }

        $izins = $query->paginate(20)->withQueryString();

        $stats = [
            'menunggu'      => IzinKeluarSiswa::hariIni()->where('status', IzinKeluarSiswa::STATUS_MENUNGGU)->count(),
            'sedang_keluar' => IzinKeluarSiswa::hariIni()->belumKembali()->count(),
            'sudah_kembali' => IzinKeluarSiswa::hariIni()->where('status', IzinKeluarSiswa::STATUS_SUDAH_KEMBALI)->count(),
        ];

        return view('piket.izin-keluar-siswa.index', [
            'izins'        => $izins,
            'stats'        => $stats,
            'statusList'   => IzinKeluarSiswa::STATUS_LIST,
            'kategoriList' => IzinKeluarSiswa::KATEGORI_LIST,
            'guruAktifId'  => $this->resolveActiveGuruId(),
        ]);
    }

    // ─── Create ───────────────────────────────────────────────────────────────

    public function create(): View|RedirectResponse
    {
        if (! $this->resolveActiveGuruId()) {
            return $this->redirectBelumCheckin('Check-in terlebih dahulu untuk membuat izin keluar siswa.');
        }

        return view('piket.izin-keluar-siswa.create', [
            'siswas'       => Siswa::with('kelas')->aktif()->orderBy('nama_lengkap')->get(),
            'tahunAjarans' => TahunAjaran::orderByDesc('tanggal_mulai')->get(),
            'kategoriList' => IzinKeluarSiswa::KATEGORI_LIST,
        ]);
    }

    // ─── Store ────────────────────────────────────────────────────────────────

    public function store(Request $request): RedirectResponse
    {
        $guruAktifId = $this->resolveActiveGuruId();

        if (! $guruAktifId) {
            return $this->redirectBelumCheckin('Check-in terlebih dahulu untuk membuat izin keluar siswa.');
        }

        $validated = $request->validate([
            'siswa_id'        => 'required|exists:siswa,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'tanggal'         => 'required|date',
            'jam_keluar'      => 'required|date_format:H:i',
            'jam_kembali'     => 'nullable|date_format:H:i|after:jam_keluar',
            'tujuan'          => 'required|string|max:255',
            'kategori'        => 'required|in:' . implode(',', array_keys(IzinKeluarSiswa::KATEGORI_LIST)),
            'keterangan'      => 'nullable|string|max:1000',
        ]);

        $izin = IzinKeluarSiswa::create($validated);

        return redirect()
            ->route('piket.izin-keluar-siswa.show', $izin)
            ->with('success', 'Izin keluar siswa berhasil dibuat.');
    }

    // ─── Show ─────────────────────────────────────────────────────────────────

    public function show(IzinKeluarSiswa $izinKeluarSiswa): View
    {
        $izinKeluarSiswa->load(['siswa.kelas', 'tahunAjaran', 'diprosesOleh', 'dicatatKembaliOleh']);

        return view('piket.izin-keluar-siswa.show', [
            'izin'        => $izinKeluarSiswa,
            'guruAktifId' => $this->resolveActiveGuruId(),
        ]);
    }

    // ─── Edit ─────────────────────────────────────────────────────────────────

    public function edit(IzinKeluarSiswa $izinKeluarSiswa): View|RedirectResponse
    {
        if (! $this->resolveActiveGuruId()) {
            return $this->redirectBelumCheckin('Check-in terlebih dahulu untuk mengedit izin.');
        }

        abort_if(! $izinKeluarSiswa->isMenunggu(), 403, 'Hanya izin berstatus Menunggu yang dapat diedit.');

        return view('piket.izin-keluar-siswa.edit', [
            'izin'         => $izinKeluarSiswa,
            'siswas'       => Siswa::with('kelas')->aktif()->orderBy('nama_lengkap')->get(),
            'tahunAjarans' => TahunAjaran::orderByDesc('tanggal_mulai')->get(),
            'kategoriList' => IzinKeluarSiswa::KATEGORI_LIST,
        ]);
    }

    // ─── Update ───────────────────────────────────────────────────────────────

    public function update(Request $request, IzinKeluarSiswa $izinKeluarSiswa): RedirectResponse
    {
        if (! $this->resolveActiveGuruId()) {
            return $this->redirectBelumCheckin('Check-in terlebih dahulu untuk mengedit izin.');
        }

        abort_if(! $izinKeluarSiswa->isMenunggu(), 403, 'Hanya izin berstatus Menunggu yang dapat diedit.');

        $validated = $request->validate([
            'siswa_id'        => 'required|exists:siswa,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'tanggal'         => 'required|date',
            'jam_keluar'      => 'required|date_format:H:i',
            'jam_kembali'     => 'nullable|date_format:H:i|after:jam_keluar',
            'tujuan'          => 'required|string|max:255',
            'kategori'        => 'required|in:' . implode(',', array_keys(IzinKeluarSiswa::KATEGORI_LIST)),
            'keterangan'      => 'nullable|string|max:1000',
        ]);

        $izinKeluarSiswa->update($validated);

        return redirect()
            ->route('piket.izin-keluar-siswa.show', $izinKeluarSiswa)
            ->with('success', 'Izin keluar siswa berhasil diperbarui.');
    }

    // ─── Destroy ──────────────────────────────────────────────────────────────

    public function destroy(IzinKeluarSiswa $izinKeluarSiswa): RedirectResponse
    {
        if (! $this->resolveActiveGuruId()) {
            return $this->redirectBelumCheckin('Check-in terlebih dahulu untuk menghapus izin.');
        }

        $izinKeluarSiswa->delete();

        return redirect()
            ->route('piket.izin-keluar-siswa.index')
            ->with('success', 'Data izin keluar berhasil dihapus.');
    }

    // ─── Approve ──────────────────────────────────────────────────────────────

    public function approve(Request $request, IzinKeluarSiswa $izinKeluarSiswa): RedirectResponse
    {
        $guruAktifId = $this->resolveActiveGuruId();

        if (! $guruAktifId) {
            return $this->redirectBelumCheckin('Check-in terlebih dahulu untuk menyetujui izin.');
        }

        abort_if(! $izinKeluarSiswa->isMenunggu(), 422, 'Status tidak valid untuk disetujui.');

        $request->validate([
            'catatan_piket' => 'nullable|string|max:500',
        ]);

        $izinKeluarSiswa->update([
            'status'        => IzinKeluarSiswa::STATUS_DISETUJUI,
            'nomor_surat'   => IzinKeluarSiswa::generateNomorSurat(),
            'diproses_oleh' => Auth::id(),
            'diproses_pada' => now(),
            'catatan_piket' => $request->catatan_piket,
        ]);

        return redirect()
            ->route('piket.izin-keluar-siswa.show', $izinKeluarSiswa)
            ->with('success', 'Izin disetujui. Surat izin siap dicetak.');
    }

    // ─── Tolak ────────────────────────────────────────────────────────────────

    public function tolak(Request $request, IzinKeluarSiswa $izinKeluarSiswa): RedirectResponse
    {
        $guruAktifId = $this->resolveActiveGuruId();

        if (! $guruAktifId) {
            return $this->redirectBelumCheckin('Check-in terlebih dahulu untuk menolak izin.');
        }

        abort_if(! $izinKeluarSiswa->isMenunggu(), 422, 'Status tidak valid untuk ditolak.');

        $request->validate([
            'catatan_piket' => 'required|string|max:500',
        ]);

        $izinKeluarSiswa->update([
            'status'        => IzinKeluarSiswa::STATUS_DITOLAK,
            'diproses_oleh' => Auth::id(),
            'diproses_pada' => now(),
            'catatan_piket' => $request->catatan_piket,
        ]);

        return redirect()
            ->route('piket.izin-keluar-siswa.show', $izinKeluarSiswa)
            ->with('success', 'Izin keluar siswa ditolak.');
    }

    // ─── Konfirmasi Kembali ───────────────────────────────────────────────────

    public function konfirmasiKembali(Request $request, IzinKeluarSiswa $izinKeluarSiswa): RedirectResponse
    {
        $guruAktifId = $this->resolveActiveGuruId();

        if (! $guruAktifId) {
            return $this->redirectBelumCheckin('Check-in terlebih dahulu untuk konfirmasi kepulangan siswa.');
        }

        abort_if(! $izinKeluarSiswa->isDisetujui(), 422, 'Hanya izin berstatus Disetujui yang bisa dikonfirmasi kembali.');

        $request->validate([
            'jam_kembali_aktual' => 'required|date_format:H:i',
            'catatan_piket'      => 'nullable|string|max:500',
        ]);

        $izinKeluarSiswa->update([
            'status'               => IzinKeluarSiswa::STATUS_SUDAH_KEMBALI,
            'jam_kembali_aktual'   => $request->jam_kembali_aktual,
            'dicatat_kembali_oleh' => Auth::id(),
            'dicatat_kembali_pada' => now(),
            'catatan_piket'        => $request->catatan_piket ?? $izinKeluarSiswa->catatan_piket,
        ]);

        return redirect()
            ->route('piket.izin-keluar-siswa.show', $izinKeluarSiswa)
            ->with('success', 'Siswa telah dicatat kembali ke sekolah.');
    }

    // ─── Cetak Surat ──────────────────────────────────────────────────────────

    public function cetakSurat(IzinKeluarSiswa $izinKeluarSiswa)
    {
        abort_if(
            ! $izinKeluarSiswa->isDisetujui() && ! $izinKeluarSiswa->isSudahKembali(),
            403,
            'Surat hanya bisa dicetak untuk izin yang sudah disetujui.'
        );

        $izinKeluarSiswa->load(['siswa.kelas', 'tahunAjaran', 'diprosesOleh']);

        $logPiketAktif = \App\Models\LogPiket::with('guru')
            ->whereDate('tanggal', $izinKeluarSiswa->tanggal)
            ->whereNotNull('masuk_pada')
            ->whereNull('keluar_pada')
            ->orderByDesc('masuk_pada')
            ->first();

        if (! $logPiketAktif) {
            $logPiketAktif = \App\Models\LogPiket::with('guru')
                ->whereDate('tanggal', $izinKeluarSiswa->tanggal)
                ->whereNotNull('masuk_pada')
                ->orderByDesc('masuk_pada')
                ->first();
        }

        $guruPiketAktif = $logPiketAktif?->guru;
        $namaFile       = 'surat-izin-' . str_replace('/', '-', $izinKeluarSiswa->nomor_surat) . '.pdf';

        $pdf = Pdf::loadView('piket.izin-keluar-siswa.surat-pdf', [
            'izin'           => $izinKeluarSiswa,
            'guruPiketAktif' => $guruPiketAktif,
        ])->setPaper('a5', 'portrait');

        return $pdf->stream($namaFile);
    }
}