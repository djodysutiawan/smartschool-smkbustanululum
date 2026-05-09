<?php

namespace App\Http\Controllers\Piket;

use App\Http\Controllers\Controller;
use App\Models\AbsensiGerbang;
use App\Models\Kelas;
use App\Models\SesiGerbang;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SesiGerbangController extends Controller
{
    // ── index ─────────────────────────────────────────────────────────────────

    /**
     * Daftar sesi gerbang — piket melihat semua sesi (bukan hanya miliknya)
     * karena piket bisa bergantian jaga dan perlu melihat riwayat lengkap.
     *
     * Filter: tanggal, tipe, status.
     */
    public function index(Request $request): View
    {
        $query = SesiGerbang::with(['dibukaOleh', 'ditutupOleh'])
            ->withCount([
                'absensiGerbang as jumlah_scan' => fn ($q) =>
                    $q->whereIn('status', ['normal', 'manual', 'koreksi']),
            ]);

        // Default: tampilkan seminggu terakhir agar tidak overwhelming
        if ($request->filled('tanggal_dari')) {
            $query->where('tanggal', '>=', $request->tanggal_dari);
        } else {
            $query->where('tanggal', '>=', now()->subWeek()->toDateString());
        }

        if ($request->filled('tanggal_sampai')) {
            $query->where('tanggal', '<=', $request->tanggal_sampai);
        }

        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $sesiList = $query->orderByDesc('tanggal')
                          ->orderByDesc('dibuka_pada')
                          ->paginate(20)
                          ->withQueryString();

        // Sesi aktif sekarang — ditampilkan sebagai banner di atas tabel
        $sesiAktif = SesiGerbang::sesiAktifSekarang();

        return view('piket.sesi-gerbang.index', compact('sesiList', 'sesiAktif'));
    }

    // ── create ────────────────────────────────────────────────────────────────

    /**
     * Form buka sesi gerbang baru.
     * Tampilkan peringatan jika sesi aktif sudah ada untuk tipe yang sama.
     */
    public function create(): View
    {
        $sesiAktifMasuk  = SesiGerbang::aktif()->hariIni()->masuk()->first();
        $sesiAktifPulang = SesiGerbang::aktif()->hariIni()->pulang()->first();

        return view('piket.sesi-gerbang.create', compact(
            'sesiAktifMasuk',
            'sesiAktifPulang',
        ));
    }

    // ── store ─────────────────────────────────────────────────────────────────

    /**
     * Simpan & buka sesi gerbang baru.
     * Guard: tidak boleh ada dua sesi aktif untuk tipe yang sama di hari yang sama.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'tipe'    => ['required', 'in:masuk,pulang'],
            'catatan' => ['nullable', 'string', 'max:500'],
        ]);

        if (SesiGerbang::adaSesiAktif($request->tipe)) {
            $labelTipe = $request->tipe === 'masuk' ? 'Masuk Pagi' : 'Pulang Sore';

            return back()->withErrors([
                'tipe' => "Sudah ada sesi {$labelTipe} yang sedang aktif hari ini. "
                        . 'Tutup sesi tersebut terlebih dahulu.',
            ])->withInput();
        }

        /** @var \App\Models\User $authUser */
        $authUser = Auth::user();

        $sesi = SesiGerbang::create([
            'dibuka_oleh' => $authUser->id,
            'tipe'        => $request->tipe,
            'tanggal'     => now()->toDateString(),
            'dibuka_pada' => now(),
            'status'      => 'aktif',
            'catatan'     => $request->catatan,
        ]);

        return redirect()
            ->route('piket.sesi-gerbang.show', $sesi)
            ->with('success', "Sesi {$sesi->label_tipe} berhasil dibuka. Alat scanner sudah bisa digunakan.");
    }

    // ── show ──────────────────────────────────────────────────────────────────

    /**
     * Detail sesi + log scan yang masuk di sesi ini.
     * Piket bisa filter per tipe scan, status, dan kelas siswa.
     */
    public function show(SesiGerbang $sesiGerbang, Request $request): View
    {
        $sesiGerbang->load(['dibukaOleh', 'ditutupOleh']);

        $scanQuery = $sesiGerbang->absensiGerbang()
            ->with(['siswa.kelas', 'inputOleh:id,name'])
            ->orderByDesc('waktu_scan');

        if ($request->filled('status_scan')) {
            $scanQuery->where('status', $request->status_scan);
        }

        if ($request->filled('tipe_scan')) {
            $scanQuery->where('tipe', $request->tipe_scan);
        }

        if ($request->filled('kelas_id')) {
            $scanQuery->whereHas('siswa', fn ($q) =>
                $q->where('kelas_id', $request->kelas_id)
            );
        }

        $scanList  = $scanQuery->paginate(30)->withQueryString();
        $kelasList = Kelas::aktif()->orderBy('tingkat')->orderBy('nama_kelas')->get();

        $statistik = [
            'total_scan'    => $sesiGerbang->absensiGerbang()->count(),
            'scan_valid'    => $sesiGerbang->absensiGerbang()
                                ->whereIn('status', ['normal', 'manual', 'koreksi'])->count(),
            'scan_duplikat' => $sesiGerbang->absensiGerbang()->where('status', 'duplikat')->count(),
            'scan_manual'   => $sesiGerbang->absensiGerbang()->where('is_manual', true)->count(),
            'tidak_dikenal' => $sesiGerbang->absensiGerbang()->whereNull('siswa_id')->count(),
        ];

        return view('piket.sesi-gerbang.show', compact(
            'sesiGerbang',
            'scanList',
            'kelasList',
            'statistik',
        ));
    }

    // ── edit ──────────────────────────────────────────────────────────────────

    /**
     * Form edit sesi.
     * Piket hanya bisa mengubah catatan sesi yang masih aktif.
     * Sesi yang sudah ditutup = read-only.
     */
    public function edit(SesiGerbang $sesiGerbang): View|RedirectResponse
    {
        if ($sesiGerbang->status === 'ditutup') {
            return redirect()
                ->route('piket.sesi-gerbang.show', $sesiGerbang)
                ->with('info', 'Sesi yang sudah ditutup tidak bisa diedit. Menampilkan detail sesi.');
        }

        return view('piket.sesi-gerbang.edit', compact('sesiGerbang'));
    }

    // ── update ────────────────────────────────────────────────────────────────

    /**
     * Simpan perubahan catatan sesi.
     */
    public function update(Request $request, SesiGerbang $sesiGerbang): RedirectResponse
    {
        if ($sesiGerbang->status === 'ditutup') {
            return back()->with('error', 'Sesi yang sudah ditutup tidak bisa diubah.');
        }

        $request->validate([
            'catatan' => ['nullable', 'string', 'max:500'],
        ]);

        $sesiGerbang->update(['catatan' => $request->catatan]);

        return redirect()
            ->route('piket.sesi-gerbang.show', $sesiGerbang)
            ->with('success', 'Catatan sesi berhasil diperbarui.');
    }

    // ── tutup ─────────────────────────────────────────────────────────────────

    /**
     * Tutup sesi yang sedang aktif.
     * Piket bisa menutup sesi milik piket lain jika dibutuhkan (pergantian shift).
     */
    public function tutup(Request $request, SesiGerbang $sesiGerbang): RedirectResponse
    {
        $request->validate([
            'catatan' => ['nullable', 'string', 'max:500'],
        ]);

        if ($sesiGerbang->status === 'ditutup') {
            return back()->with('error', 'Sesi ini sudah ditutup sebelumnya.');
        }

        /** @var \App\Models\User $authUser */
        $authUser = Auth::user();

        $sesiGerbang->tutup($authUser->id, $request->catatan);

        $jumlahScan = $sesiGerbang->absensiGerbang()
            ->whereIn('status', ['normal', 'manual', 'koreksi'])
            ->count();

        return redirect()
            ->route('piket.sesi-gerbang.show', $sesiGerbang)
            ->with('success', "Sesi {$sesiGerbang->label_tipe} berhasil ditutup. Total scan valid: {$jumlahScan}.");
    }

    // ── buka ──────────────────────────────────────────────────────────────────

    /**
     * Buka kembali sesi yang sudah ditutup.
     * Berguna jika piket salah menutup sesi terlalu cepat.
     * Guard: tidak boleh ada sesi aktif lain dengan tipe yang sama hari ini.
     */
    public function buka(SesiGerbang $sesiGerbang): RedirectResponse
    {
        if ($sesiGerbang->status === 'aktif') {
            return back()->with('error', 'Sesi ini masih aktif, tidak perlu dibuka ulang.');
        }

        // Hanya bisa buka kembali sesi hari ini — sesi lama tidak boleh dibuka
        if ($sesiGerbang->tanggal !== now()->toDateString()) {
            return back()->with('error', 'Hanya sesi hari ini yang bisa dibuka kembali. Hubungi admin untuk sesi tanggal lain.');
        }

        $adaAktif = SesiGerbang::aktif()
            ->hariIni()
            ->where('tipe', $sesiGerbang->tipe)
            ->where('id', '!=', $sesiGerbang->id)
            ->exists();

        if ($adaAktif) {
            $labelTipe = $sesiGerbang->tipe === 'masuk' ? 'Masuk Pagi' : 'Pulang Sore';
            return back()->with('error', "Sudah ada sesi {$labelTipe} aktif hari ini. Tutup dulu sebelum membuka sesi ini kembali.");
        }

        $sesiGerbang->update([
            'status'       => 'aktif',
            'ditutup_pada' => null,
            'ditutup_oleh' => null,
        ]);

        return back()->with('success', "Sesi {$sesiGerbang->label_tipe} berhasil dibuka kembali.");
    }

    // ── exportPdf ─────────────────────────────────────────────────────────────

    /**
     * Export detail satu sesi ke PDF — untuk arsip laporan harian piket.
     * Piket butuh ini untuk keperluan administrasi fisik / tanda tangan.
     *
     * Berbeda dengan admin yang export daftar banyak sesi,
     * piket hanya export SATU sesi sekaligus (lebih praktis di lapangan).
     */
    public function exportPdf(SesiGerbang $sesiGerbang): mixed
    {
        $sesiGerbang->load(['dibukaOleh', 'ditutupOleh']);

        $scanList = $sesiGerbang->absensiGerbang()
            ->with(['siswa.kelas', 'inputOleh:id,name'])
            ->whereIn('status', ['normal', 'manual', 'koreksi'])
            ->orderBy('tipe')
            ->orderBy('waktu_scan')
            ->get();

        $statistik = [
            'total_scan'    => $sesiGerbang->absensiGerbang()->count(),
            'scan_valid'    => $scanList->count(),
            'scan_duplikat' => $sesiGerbang->absensiGerbang()->where('status', 'duplikat')->count(),
            'scan_manual'   => $sesiGerbang->absensiGerbang()->where('is_manual', true)->count(),
            'tidak_dikenal' => $sesiGerbang->absensiGerbang()->whereNull('siswa_id')->count(),
        ];

        /** @var \App\Models\User $authUser */
        $authUser = Auth::user();

        $meta = [
            'dicetak_pada' => now()->isoFormat('D MMMM Y, HH:mm'),
            'dicetak_oleh' => $authUser->name,
        ];

        $pdf = Pdf::loadView('piket.sesi-gerbang.export-pdf', compact(
            'sesiGerbang',
            'scanList',
            'statistik',
            'meta',
        ))->setPaper('a4', 'portrait');

        $namaFile = 'sesi-gerbang-'
            . $sesiGerbang->tipe . '-'
            . $sesiGerbang->tanggal . '.pdf';

        return $pdf->download($namaFile);
    }

    // ── ajaxSesiAktif ─────────────────────────────────────────────────────────

    /**
     * JSON — status sesi aktif saat ini.
     * Digunakan oleh live monitor piket untuk polling setiap N detik.
     */
    public function ajaxSesiAktif(): JsonResponse
    {
        $sesi = SesiGerbang::aktif()
            ->hariIni()
            ->with('dibukaOleh:id,name')
            ->orderByDesc('dibuka_pada')
            ->get()
            ->map(fn ($s) => [
                'id'          => $s->id,
                'tipe'        => $s->tipe,
                'label_tipe'  => $s->label_tipe,
                'status'      => $s->status,
                'dibuka_pada' => $s->dibuka_pada->format('H:i'),
                'dibuka_oleh' => $s->dibukaOleh?->name,
                'jumlah_scan' => $s->absensiGerbang()
                                   ->whereIn('status', ['normal', 'manual', 'koreksi'])
                                   ->count(),
            ]);

        return response()->json([
            'ada_sesi_aktif' => $sesi->isNotEmpty(),
            'sesi'           => $sesi,
            'timestamp'      => now()->format('H:i:s'),
        ]);
    }
}