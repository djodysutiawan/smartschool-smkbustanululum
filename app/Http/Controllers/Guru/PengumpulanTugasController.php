<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\PengumpulanTugas;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengumpulanTugasController extends Controller
{
    // ── Helper ─────────────────────────────────────────────────────────────────

    private function getGuruId(): int
    {
        $guru = Auth::user()->guru;
        abort_if(! $guru, 403, 'Akun Anda tidak terhubung dengan data guru.');
        return $guru->id;
    }

    // Status ENUM valid di DB: 'belum_dikumpulkan','dikumpulkan','terlambat','dinilai'
    private const STATUS_BELUM       = 'belum_dikumpulkan';
    private const STATUS_DIKUMPULKAN = 'dikumpulkan';
    private const STATUS_TERLAMBAT   = 'terlambat';
    private const STATUS_DINILAI     = 'dinilai';  // bukan 'sudah_dinilai'!

    private const BISA_DINILAI = [self::STATUS_DIKUMPULKAN, self::STATUS_TERLAMBAT, self::STATUS_DINILAI];

    // ── Authorization helper ───────────────────────────────────────────────────

    private function authorizeGuru(PengumpulanTugas $pengumpulan): void
    {
        $guruId = $this->getGuruId();
        abort_if(
            $pengumpulan->tugas?->guru_id !== $guruId,
            403,
            'Anda tidak memiliki akses ke data pengumpulan ini.'
        );
    }

    // ── Index ──────────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $guruId    = $this->getGuruId();
        $tugasList = Tugas::where('guru_id', $guruId)->orderByDesc('created_at')->get();

        $query = PengumpulanTugas::with(['tugas', 'siswa'])
            ->whereHas('tugas', fn ($q) => $q->where('guru_id', $guruId));

        if ($request->filled('tugas_id')) {
            $query->where('tugas_id', $request->tugas_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('siswa', fn ($q) =>
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
            );
        }

        $totalData      = (clone $query)->count();
        $totalDinilai   = (clone $query)->where('status', self::STATUS_DINILAI)->count();
        $totalMasuk     = (clone $query)->whereIn('status', [self::STATUS_DIKUMPULKAN, self::STATUS_TERLAMBAT, self::STATUS_DINILAI])->count();
        $totalTerlambat = (clone $query)->where('status', self::STATUS_TERLAMBAT)->count();

        $pengumpulanList = $query->orderByDesc('dikumpulkan_pada')->paginate(20)->withQueryString();

        $statusList = [
            self::STATUS_BELUM       => 'Belum Dikumpulkan',
            self::STATUS_DIKUMPULKAN => 'Dikumpulkan',
            self::STATUS_TERLAMBAT   => 'Terlambat',
            self::STATUS_DINILAI     => 'Dinilai',
        ];

        return view('guru.pengumpulan-tugas.index', compact(
            'pengumpulanList', 'tugasList', 'statusList',
            'totalData', 'totalDinilai', 'totalMasuk', 'totalTerlambat'
        ));
    }

    // ── Show ───────────────────────────────────────────────────────────────────

    public function show(PengumpulanTugas $pengumpulan)
    {
        $this->authorizeGuru($pengumpulan);
        $pengumpulan->load(['tugas', 'siswa']);
        return view('guru.pengumpulan-tugas.show', compact('pengumpulan'));
    }

    // ── Form Nilai ─────────────────────────────────────────────────────────────

    public function formNilai(PengumpulanTugas $pengumpulan)
    {
        $this->authorizeGuru($pengumpulan);

        if (! in_array($pengumpulan->status, self::BISA_DINILAI)) {
            return redirect()->route('guru.pengumpulan-tugas.show', $pengumpulan)
                ->with('error', 'Tugas ini belum dikumpulkan oleh siswa, tidak bisa dinilai.');
        }

        $pengumpulan->load(['tugas', 'siswa']);
        return view('guru.pengumpulan-tugas.nilai', compact('pengumpulan'));
    }

    // ── Simpan Nilai (PUT) ─────────────────────────────────────────────────────

    public function simpanNilai(Request $request, PengumpulanTugas $pengumpulan)
    {
        $this->authorizeGuru($pengumpulan);

        if (! in_array($pengumpulan->status, self::BISA_DINILAI)) {
            return redirect()->route('guru.pengumpulan-tugas.index')
                ->with('error', 'Tugas ini belum dikumpulkan oleh siswa.');
        }

        $validated = $request->validate([
            'nilai'       => ['required', 'numeric', 'min:0', 'max:100'],
            'umpan_balik' => ['nullable', 'string', 'max:1000'],
        ], [
            'nilai.required'  => 'Nilai wajib diisi.',
            'nilai.numeric'   => 'Nilai harus berupa angka.',
            'nilai.min'       => 'Nilai minimal 0.',
            'nilai.max'       => 'Nilai maksimal 100.',
            'umpan_balik.max' => 'Umpan balik maksimal 1000 karakter.',
        ]);

        $pengumpulan->update([
            'nilai'        => $validated['nilai'],
            'umpan_balik'  => $validated['umpan_balik'] ?? null,
            'status'       => self::STATUS_DINILAI,  // 'dinilai', bukan 'sudah_dinilai'
            'dinilai_pada' => now(),
        ]);

        return redirect()->route('guru.pengumpulan-tugas.show', $pengumpulan)
            ->with('success', 'Nilai berhasil disimpan.');
    }

    // ── Beri Nilai (PATCH — alias route lama) ──────────────────────────────────

    public function beriNilai(Request $request, PengumpulanTugas $pengumpulan)
    {
        return $this->simpanNilai($request, $pengumpulan);
    }

    // ── Kembalikan (reset nilai) ───────────────────────────────────────────────

    public function kembalikan(PengumpulanTugas $pengumpulan)
    {
        $this->authorizeGuru($pengumpulan);

        if ($pengumpulan->status !== self::STATUS_DINILAI) {
            return redirect()->route('guru.pengumpulan-tugas.show', $pengumpulan)
                ->with('error', 'Hanya pengumpulan yang sudah dinilai yang bisa dikembalikan.');
        }

        // Tentukan status kembali: terlambat atau dikumpulkan
        $statusBaru = self::STATUS_DIKUMPULKAN;
        if ($pengumpulan->tugas?->batas_waktu && $pengumpulan->dikumpulkan_pada) {
            if ($pengumpulan->dikumpulkan_pada->gt($pengumpulan->tugas->batas_waktu)) {
                $statusBaru = self::STATUS_TERLAMBAT;
            }
        }

        $pengumpulan->update([
            'nilai'        => null,
            'umpan_balik'  => null,
            'status'       => $statusBaru,
            'dinilai_pada' => null,
        ]);

        return redirect()->route('guru.pengumpulan-tugas.show', $pengumpulan)
            ->with('success', 'Nilai berhasil direset.');
    }
}