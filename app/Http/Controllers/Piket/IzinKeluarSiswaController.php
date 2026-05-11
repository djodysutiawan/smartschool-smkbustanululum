<?php

namespace App\Http\Controllers\Piket;

use App\Http\Controllers\Controller;
use App\Models\IzinKeluarSiswa;
use App\Models\LogPiket;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class IzinKeluarSiswaController extends Controller
{
    // =========================================================================
    // INDEX
    // =========================================================================

    public function index(Request $request): View
    {
        $query = IzinKeluarSiswa::with(['siswa.kelas', 'diprosesOleh'])
            ->orderByDesc('tanggal')
            ->orderByDesc('id');

        if ($request->filled('search')) {
            $s = trim($request->search);
            $query->where(function ($q) use ($s) {
                $q->whereHas('siswa', fn ($q2) => $q2->where('nama_lengkap', 'like', "%{$s}%"))
                  ->orWhere('nomor_surat', 'like', "%{$s}%")
                  ->orWhere('tujuan', 'like', "%{$s}%");
            });
        }

        if ($request->filled('status') && array_key_exists($request->status, IzinKeluarSiswa::STATUS_LIST)) {
            $query->where('status', $request->status);
        }

        if ($request->filled('kategori') && array_key_exists($request->kategori, IzinKeluarSiswa::KATEGORI_LIST)) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        }

        // ── Stats hari ini — selalu dihitung tanpa filter aktif ──
        $stats = [
            'menunggu'      => IzinKeluarSiswa::whereDate('tanggal', today())
                                ->where('status', IzinKeluarSiswa::STATUS_MENUNGGU)
                                ->count(),
            // "Sedang keluar" = sudah disetujui tapi belum kembali
            'sedang_keluar' => IzinKeluarSiswa::whereDate('tanggal', today())
                                ->where('status', IzinKeluarSiswa::STATUS_DISETUJUI)
                                ->count(),
            'sudah_kembali' => IzinKeluarSiswa::whereDate('tanggal', today())
                                ->where('status', IzinKeluarSiswa::STATUS_SUDAH_KEMBALI)
                                ->count(),
        ];

        $izins        = $query->paginate(15)->withQueryString();
        $statusList   = IzinKeluarSiswa::STATUS_LIST;
        $kategoriList = IzinKeluarSiswa::KATEGORI_LIST;
        $guruAktifId  = $this->getLogAktif(Auth::id()) ? Auth::id() : null;

        return view('piket.izin-keluar-siswa.index', compact(
            'izins',
            'statusList',
            'kategoriList',
            'stats',
            'guruAktifId',
        ));
    }

    // =========================================================================
    // CREATE
    // =========================================================================

    public function create(): View
    {
        $guruAktifId      = $this->getLogAktif(Auth::id()) ? Auth::id() : null;
        $siswas           = Siswa::with('kelas')->aktif()->orderBy('nama_lengkap')->get();
        $tahunAjarans     = TahunAjaran::orderByDesc('tahun')->orderByDesc('semester')->get();
        $kategoriList     = IzinKeluarSiswa::KATEGORI_LIST;
        $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->first();

        return view('piket.izin-keluar-siswa.create', compact(
            'siswas',
            'tahunAjarans',
            'kategoriList',
            'tahunAjaranAktif',
            'guruAktifId',
        ));
    }

    // =========================================================================
    // STORE
    // =========================================================================

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'siswa_id'        => 'required|exists:siswa,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'tanggal'         => 'required|date',
            'jam_keluar'      => 'required|date_format:H:i',
            'jam_kembali'     => [
                'nullable',
                'date_format:H:i',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value && $request->jam_keluar && $value <= $request->jam_keluar) {
                        $fail('Rencana jam kembali harus setelah jam keluar.');
                    }
                },
            ],
            'kategori'        => ['required', Rule::in(array_keys(IzinKeluarSiswa::KATEGORI_LIST))],
            'tujuan'          => 'required|string|max:255',
            'keterangan'      => 'nullable|string|max:1000',
        ]);

        IzinKeluarSiswa::create(array_merge($validated, [
            'status' => IzinKeluarSiswa::STATUS_MENUNGGU,
        ]));

        return redirect()
            ->route('piket.izin-keluar-siswa.index')
            ->with('success', 'Izin keluar siswa berhasil dibuat.');
    }

    // =========================================================================
    // SHOW
    // =========================================================================

    public function show(IzinKeluarSiswa $izinKeluarSiswa): View
    {
        $izin = $izinKeluarSiswa->load([
            'siswa.kelas',
            'tahunAjaran',
            'diprosesOleh',
            'dicatatKembaliOleh',
        ]);

        $guruAktifId = $this->getLogAktif(Auth::id()) ? Auth::id() : null;

        return view('piket.izin-keluar-siswa.show', compact('izin', 'guruAktifId'));
    }

    // =========================================================================
    // EDIT
    // =========================================================================

    public function edit(IzinKeluarSiswa $izinKeluarSiswa): View|RedirectResponse
    {
        if (! $izinKeluarSiswa->isMenunggu()) {
            return redirect()
                ->route('piket.izin-keluar-siswa.show', $izinKeluarSiswa->id)
                ->with('error', 'Hanya izin berstatus Menunggu yang dapat diedit.');
        }

        $izin         = $izinKeluarSiswa;
        $siswas       = Siswa::with('kelas')->aktif()->orderBy('nama_lengkap')->get();
        $tahunAjarans = TahunAjaran::orderByDesc('tahun')->orderByDesc('semester')->get();
        $kategoriList = IzinKeluarSiswa::KATEGORI_LIST;

        return view('piket.izin-keluar-siswa.edit', compact(
            'izin',
            'siswas',
            'tahunAjarans',
            'kategoriList',
        ));
    }

    // =========================================================================
    // UPDATE
    // =========================================================================

    public function update(Request $request, IzinKeluarSiswa $izinKeluarSiswa): RedirectResponse
    {
        if (! $izinKeluarSiswa->isMenunggu()) {
            return redirect()
                ->route('piket.izin-keluar-siswa.show', $izinKeluarSiswa->id)
                ->with('error', 'Hanya izin berstatus Menunggu yang dapat diedit.');
        }

        $validated = $request->validate([
            'siswa_id'        => 'required|exists:siswa,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'tanggal'         => 'required|date',
            'jam_keluar'      => 'required|date_format:H:i',
            'jam_kembali'     => [
                'nullable',
                'date_format:H:i',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value && $request->jam_keluar && $value <= $request->jam_keluar) {
                        $fail('Rencana jam kembali harus setelah jam keluar.');
                    }
                },
            ],
            'kategori'        => ['required', Rule::in(array_keys(IzinKeluarSiswa::KATEGORI_LIST))],
            'tujuan'          => 'required|string|max:255',
            'keterangan'      => 'nullable|string|max:1000',
        ]);

        $izinKeluarSiswa->update($validated);

        return redirect()
            ->route('piket.izin-keluar-siswa.show', $izinKeluarSiswa->id)
            ->with('success', 'Izin keluar berhasil diperbarui.');
    }

    // =========================================================================
    // DESTROY
    // =========================================================================

    public function destroy(IzinKeluarSiswa $izinKeluarSiswa): RedirectResponse
    {
        if ($izinKeluarSiswa->isDisetujui()) {
            return redirect()
                ->route('piket.izin-keluar-siswa.show', $izinKeluarSiswa->id)
                ->with('error', 'Izin yang sedang aktif (siswa masih di luar) tidak dapat dihapus.');
        }

        $izinKeluarSiswa->delete();

        return redirect()
            ->route('piket.izin-keluar-siswa.index')
            ->with('success', 'Izin keluar berhasil dihapus.');
    }

    // =========================================================================
    // APPROVE
    // =========================================================================

    public function approve(Request $request, IzinKeluarSiswa $izinKeluarSiswa): RedirectResponse
    {
        if (! $izinKeluarSiswa->isMenunggu()) {
            return back()->with('error', 'Izin ini sudah diproses sebelumnya.');
        }

        $request->validate([
            'catatan_piket' => 'nullable|string|max:500',
        ]);

        DB::transaction(function () use ($request, $izinKeluarSiswa) {
            $izinKeluarSiswa->update([
                'status'        => IzinKeluarSiswa::STATUS_DISETUJUI,
                'diproses_oleh' => Auth::id(),
                'diproses_pada' => now(),
                'catatan_piket' => $request->catatan_piket,
                'nomor_surat'   => IzinKeluarSiswa::generateNomorSurat(),
            ]);
        });

        return back()->with('success', 'Izin keluar berhasil disetujui dan nomor surat telah dibuat.');
    }

    // =========================================================================
    // TOLAK
    // =========================================================================

    public function tolak(Request $request, IzinKeluarSiswa $izinKeluarSiswa): RedirectResponse
    {
        if (! $izinKeluarSiswa->isMenunggu()) {
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

    // =========================================================================
    // KONFIRMASI KEMBALI
    // =========================================================================

    public function konfirmasiKembali(Request $request, IzinKeluarSiswa $izinKeluarSiswa): RedirectResponse
    {
        if (! $izinKeluarSiswa->isDisetujui()) {
            return back()->with('error', 'Hanya izin berstatus Disetujui yang dapat dicatat kembali.');
        }

        $request->validate([
            'jam_kembali_aktual' => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) use ($izinKeluarSiswa) {
                    if ($izinKeluarSiswa->jam_keluar && $value <= $izinKeluarSiswa->jam_keluar) {
                        $fail('Jam kembali aktual harus setelah jam keluar (' . $izinKeluarSiswa->jam_keluar . ').');
                    }
                },
            ],
            'catatan_piket' => 'nullable|string|max:500',
        ]);

        $izinKeluarSiswa->update([
            'status'               => IzinKeluarSiswa::STATUS_SUDAH_KEMBALI,
            'jam_kembali_aktual'   => $request->jam_kembali_aktual,
            'dicatat_kembali_oleh' => Auth::id(),
            'dicatat_kembali_pada' => now(),
            'catatan_piket'        => $request->filled('catatan_piket')
                                        ? $request->catatan_piket
                                        : $izinKeluarSiswa->catatan_piket,
        ]);

        return back()->with('success', 'Siswa berhasil dicatat kembali.');
    }

    // =========================================================================
    // CETAK SURAT
    // =========================================================================

    public function cetakSurat(IzinKeluarSiswa $izinKeluarSiswa)
    {
        if (! in_array($izinKeluarSiswa->status, [
            IzinKeluarSiswa::STATUS_DISETUJUI,
            IzinKeluarSiswa::STATUS_SUDAH_KEMBALI,
        ])) {
            return redirect()
                ->route('piket.izin-keluar-siswa.show', $izinKeluarSiswa->id)
                ->with('error', 'Surat hanya dapat dicetak untuk izin yang sudah disetujui.');
        }

        $izin = $izinKeluarSiswa->load([
            'siswa.kelas',
            'tahunAjaran',
            'diprosesOleh',
        ]);

        $profil = \App\Models\ProfilSekolah::instance();

        $nomorSurat = $izin->nomor_surat
            ? str_replace(['/', '\\', ' '], ['-', '-', ''], $izin->nomor_surat)
            : $izin->id;

        $pdf = Pdf::loadView(
            'piket.izin-keluar-siswa.cetak-surat',
            compact('izin', 'profil')
        )->setPaper('a5', 'portrait');

        return $pdf->stream('surat-izin-' . $nomorSurat . '.pdf');
    }

    // =========================================================================
    // PRIVATE HELPERS
    // =========================================================================

    /**
     * Cek log piket aktif hari ini (sudah check-in, belum checkout).
     */
    private function getLogAktif(int $userId): ?object
    {
        return LogPiket::where('pengguna_id', $userId)
            ->whereDate('tanggal', today())
            ->whereNotNull('masuk_pada')
            ->whereNull('keluar_pada')
            ->first();
    }
}