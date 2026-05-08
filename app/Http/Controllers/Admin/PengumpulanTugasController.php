<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengumpulanTugas;
use App\Models\Tugas;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PengumpulanTugasExport;

class PengumpulanTugasController extends Controller
{
    // ─────────────────────────────────────────────────────────────────────────
    // INDEX
    // ─────────────────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $query = PengumpulanTugas::with(['tugas.mataPelajaran', 'siswa.kelas']);

        if ($request->filled('tugas_id')) {
            $query->where('tugas_id', $request->tugas_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->whereHas('siswa', fn($q) =>
                $q->where('nama_lengkap', 'like', "%{$request->search}%")
            );
        }

        $pengumpulan = $query->latest()->paginate(20)->withQueryString();

        // Ambil daftar tugas untuk filter dropdown (hanya yang ada pengumpulan)
        $tugasList = Tugas::withCount('pengumpulan')
            ->having('pengumpulan_count', '>', 0)
            ->orderByDesc('batas_waktu')
            ->get(['id', 'judul', 'batas_waktu']);

        return view('admin.pengumpulan_tugas.index', [
            'pengumpulan' => $pengumpulan,
            'tugasList'   => $tugasList,
            'statusList'  => $this->statusList(),
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // SHOW
    // ─────────────────────────────────────────────────────────────────────────

    public function show(PengumpulanTugas $pengumpulanTugas)
    {
        $pengumpulanTugas->load(['tugas.mataPelajaran', 'siswa.kelas']);

        return view('admin.pengumpulan_tugas.show', compact('pengumpulanTugas'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    // BERI NILAI
    // ─────────────────────────────────────────────────────────────────────────

    public function beriNilai(Request $request, PengumpulanTugas $pengumpulanTugas)
    {
        // Pastikan tugas di-load agar nilai_maksimal tersedia
        $pengumpulanTugas->loadMissing('tugas');
        $nilaiMaks = (float) ($pengumpulanTugas->tugas->nilai_maksimal ?? 100);

        $validated = $request->validate([
            'nilai'       => ['required', 'numeric', 'min:0', "max:{$nilaiMaks}"],
            'umpan_balik' => ['nullable', 'string', 'max:1000'],
        ], [
            'nilai.required'  => 'Nilai wajib diisi.',
            'nilai.numeric'   => 'Nilai harus berupa angka.',
            'nilai.min'       => 'Nilai tidak boleh kurang dari 0.',
            'nilai.max'       => "Nilai tidak boleh lebih dari {$nilaiMaks}.",
            'umpan_balik.max' => 'Umpan balik maksimal 1000 karakter.',
        ]);

        $pengumpulanTugas->beriNilai(
            (float) $validated['nilai'],
            $validated['umpan_balik'] ?? null
        );

        return back()->with('success', 'Nilai berhasil diberikan.');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // KEMBALIKAN PENILAIAN
    // ─────────────────────────────────────────────────────────────────────────

    public function kembalikan(PengumpulanTugas $pengumpulanTugas)
    {
        $statusYangBisaDikembalikan = [
            PengumpulanTugas::STATUS_DIKUMPULKAN,
            PengumpulanTugas::STATUS_TERLAMBAT,
            PengumpulanTugas::STATUS_DINILAI,
        ];

        if (! in_array($pengumpulanTugas->status, $statusYangBisaDikembalikan)) {
            return back()->with('error', 'Status pengumpulan tidak dapat dikembalikan.');
        }

        // Gunakan method model agar logika terpusat
        $pengumpulanTugas->loadMissing('tugas');
        $pengumpulanTugas->kembalikanPenilaian();

        return back()->with('success', 'Penilaian berhasil dikembalikan.');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // DESTROY
    // ─────────────────────────────────────────────────────────────────────────

    public function destroy(PengumpulanTugas $pengumpulanTugas)
    {
        $pengumpulanTugas->delete();

        return redirect()->route('admin.pengumpulan-tugas.index')
            ->with('success', 'Data pengumpulan tugas berhasil dihapus.');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // EXPORT
    // ─────────────────────────────────────────────────────────────────────────

    public function exportPdf(Request $request)
    {
        $query = PengumpulanTugas::with(['tugas.mataPelajaran', 'siswa.kelas']);

        if ($request->filled('tugas_id')) {
            $query->where('tugas_id', $request->tugas_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->whereHas('siswa', fn($q) =>
                $q->where('nama_lengkap', 'like', "%{$request->search}%")
            );
        }

        $pengumpulan = $query->latest()->get();

        $pdf = Pdf::loadView('admin.pengumpulan_tugas.export-pdf', compact('pengumpulan'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('pengumpulan-tugas-' . now()->format('YmdHis') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new PengumpulanTugasExport($request->all()),
            'pengumpulan-tugas-' . now()->format('YmdHis') . '.xlsx'
        );
    }

    // ─────────────────────────────────────────────────────────────────────────
    // PRIVATE HELPERS
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Daftar label status untuk filter & tampilan.
     * Menggunakan konstanta dari model agar konsisten.
     */
    private function statusList(): array
    {
        return [
            PengumpulanTugas::STATUS_BELUM       => 'Belum Dikumpulkan',
            PengumpulanTugas::STATUS_DIKUMPULKAN => 'Dikumpulkan',
            PengumpulanTugas::STATUS_TERLAMBAT   => 'Terlambat',
            PengumpulanTugas::STATUS_DINILAI     => 'Sudah Dinilai',
        ];
    }
}