<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SesiGerbang;
use App\Models\AbsensiGerbang;
use App\Models\Kelas;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SesiGerbangExport;

class SesiGerbangController extends Controller
{
    // ── index ─────────────────────────────────────────────────────────────────

    /**
     * Daftar semua sesi gerbang.
     * Filter: tanggal, tipe (masuk|pulang), status (aktif|ditutup).
     */
    public function index(Request $request): View
    {
        $query = SesiGerbang::with(['dibukaOleh', 'ditutupOleh'])
            ->withCount([
                // jumlah scan valid di setiap sesi
                'absensiGerbang as jumlah_scan' => fn ($q) =>
                    $q->whereIn('status', ['normal', 'manual', 'koreksi']),
            ]);

        // ── Filter ────────────────────────────────────────────────────────────
        if ($request->filled('tanggal_dari')) {
            $query->where('tanggal', '>=', $request->tanggal_dari);
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

        // Sesi aktif saat ini (untuk banner notifikasi di halaman daftar)
        $sesiAktif = SesiGerbang::sesiAktifSekarang();

        return view('admin.sesi-gerbang.index', compact('sesiList', 'sesiAktif'));
    }

    // ── create ────────────────────────────────────────────────────────────────

    /**
     * Form buka sesi baru.
     * Tampilkan peringatan jika sudah ada sesi aktif untuk tipe yang sama hari ini.
     */
    public function create(): View
    {
        $sesiAktifMasuk  = SesiGerbang::aktif()->hariIni()->masuk()->first();
        $sesiAktifPulang = SesiGerbang::aktif()->hariIni()->pulang()->first();

        return view('admin.sesi-gerbang.create', compact(
            'sesiAktifMasuk',
            'sesiAktifPulang',
        ));
    }

    // ── store ─────────────────────────────────────────────────────────────────

    /**
     * Simpan sesi baru.
     * Guard: tidak boleh membuka sesi dengan tipe yang sudah aktif hari ini.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'tipe'    => ['required', 'in:masuk,pulang'],
            'catatan' => ['nullable', 'string', 'max:500'],
        ]);

        // Cegah duplikasi sesi aktif untuk tipe yang sama di hari yang sama
        if (SesiGerbang::adaSesiAktif($request->tipe)) {
            $labelTipe = $request->tipe === 'masuk' ? 'Masuk Pagi' : 'Pulang Sore';

            return back()->withErrors([
                'tipe' => "Sudah ada sesi {$labelTipe} yang sedang aktif hari ini. Tutup sesi tersebut terlebih dahulu.",
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
            ->route('admin.sesi-gerbang.show', $sesi)
            ->with('success', "Sesi {$sesi->label_tipe} berhasil dibuka.");
    }

    // ── show ──────────────────────────────────────────────────────────────────

    /**
     * Detail sesi + log scan di sesi ini.
     * Filter: tipe scan, status scan, kelas siswa.
     */
    public function show(SesiGerbang $sesiGerbang, Request $request): View
    {
        $sesiGerbang->load(['dibukaOleh', 'ditutupOleh']);

        $scanQuery = $sesiGerbang->absensiGerbang()
            ->with(['siswa.kelas', 'inputOleh'])
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

        // Statistik ringkas sesi ini
        $statistik = [
            'total_scan'    => $sesiGerbang->absensiGerbang()->count(),
            'scan_valid'    => $sesiGerbang->absensiGerbang()->whereIn('status', ['normal', 'manual', 'koreksi'])->count(),
            'scan_duplikat' => $sesiGerbang->absensiGerbang()->where('status', 'duplikat')->count(),
            'scan_manual'   => $sesiGerbang->absensiGerbang()->where('is_manual', true)->count(),
            'tidak_dikenal' => $sesiGerbang->absensiGerbang()->whereNull('siswa_id')->count(),
        ];

        return view('admin.sesi-gerbang.show', compact(
            'sesiGerbang',
            'scanList',
            'kelasList',
            'statistik',
        ));
    }

    // ── destroy ───────────────────────────────────────────────────────────────

    /**
     * Hapus sesi (soft delete).
     * Hanya boleh jika sesi belum punya data scan sama sekali.
     */
    public function destroy(SesiGerbang $sesiGerbang): RedirectResponse
    {
        if ($sesiGerbang->absensiGerbang()->exists()) {
            return back()->with('error', 'Sesi tidak bisa dihapus karena sudah memiliki data scan.');
        }

        $sesiGerbang->delete();

        return redirect()
            ->route('admin.sesi-gerbang.index')
            ->with('success', 'Sesi gerbang berhasil dihapus.');
    }

    // ── tutup ─────────────────────────────────────────────────────────────────

    /**
     * Tutup sesi aktif.
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

        return back()->with('success', "Sesi {$sesiGerbang->label_tipe} berhasil ditutup. Total scan: {$sesiGerbang->jumlah_scan}.");
    }

    // ── toggleTipe ────────────────────────────────────────────────────────────

    /**
     * Toggle tipe sesi: masuk ↔ pulang.
     * Hanya bisa jika sesi masih aktif dan belum ada scan.
     */
    public function toggleTipe(SesiGerbang $sesiGerbang): RedirectResponse
    {
        try {
            $sesiGerbang->toggleTipe();
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', "Tipe sesi berhasil diubah menjadi {$sesiGerbang->label_tipe}.");
    }

    // ── exportPdf ─────────────────────────────────────────────────────────────

    /**
     * Export daftar sesi ke PDF.
     * Mengikuti filter yang sama dengan index().
     */
    public function exportPdf(Request $request)
    {
        $query = SesiGerbang::with(['dibukaOleh', 'ditutupOleh'])
            ->withCount([
                'absensiGerbang as jumlah_scan' => fn ($q) =>
                    $q->whereIn('status', ['normal', 'manual', 'koreksi']),
            ]);

        if ($request->filled('tanggal_dari'))   $query->where('tanggal', '>=', $request->tanggal_dari);
        if ($request->filled('tanggal_sampai')) $query->where('tanggal', '<=', $request->tanggal_sampai);
        if ($request->filled('tipe'))           $query->where('tipe', $request->tipe);
        if ($request->filled('status'))         $query->where('status', $request->status);

        $sesiList = $query->orderByDesc('tanggal')->orderByDesc('dibuka_pada')->get();

        /** @var \App\Models\User $authUser */
        $authUser = Auth::user();

        $filter = [
            'tanggal_dari'   => $request->tanggal_dari,
            'tanggal_sampai' => $request->tanggal_sampai,
            'tipe'           => $request->tipe,
            'status'         => $request->status,
            'dicetak_pada'   => now()->isoFormat('D MMMM Y, HH:mm'),
            'dicetak_oleh'   => $authUser->name,
        ];

        $pdf = Pdf::loadView('admin.sesi-gerbang.export-pdf', compact('sesiList', 'filter'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('sesi-gerbang-' . now()->format('Ymd-His') . '.pdf');
    }

    // ── exportExcel ───────────────────────────────────────────────────────────

    /**
     * Export daftar sesi ke Excel.
     */
    public function exportExcel(Request $request)
    {
        $fileName = 'sesi-gerbang-' . now()->format('Ymd-His') . '.xlsx';

        return Excel::download(new SesiGerbangExport($request->all()), $fileName);
    }

    // ── ajaxSesiAktif ─────────────────────────────────────────────────────────

    /**
     * JSON — status sesi aktif saat ini untuk live monitor (polling).
     * Dipanggil tiap N detik dari frontend.
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