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
    protected array $statusList = [
        'belum_dikumpulkan' => 'Belum Dikumpulkan',
        'dikumpulkan'       => 'Dikumpulkan',
        'terlambat'         => 'Terlambat',
        'sudah_dinilai'     => 'Sudah Dinilai',
    ];

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
            $query->whereHas('siswa', fn ($q) =>
                $q->where('nama_lengkap', 'like', "%{$request->search}%")
            );
        }

        $pengumpulan = $query->latest()->paginate(20)->withQueryString();
        $tugasList   = Tugas::orderByDesc('batas_waktu')->get();

        return view('admin.pengumpulan_tugas.index', [
            'pengumpulan' => $pengumpulan,
            'tugasList'   => $tugasList,
            'statusList'  => $this->statusList,
        ]);
    }

    public function show(PengumpulanTugas $pengumpulanTugas)
    {
        $pengumpulanTugas->load(['tugas.mataPelajaran', 'siswa.kelas']);

        return view('admin.pengumpulan_tugas.show', compact('pengumpulanTugas'));
    }

    public function beriNilai(Request $request, PengumpulanTugas $pengumpulanTugas)
    {
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

        $pengumpulanTugas->beriNilai($validated['nilai'], $validated['umpan_balik'] ?? null);

        return back()->with('success', 'Nilai berhasil diberikan.');
    }

    public function kembalikan(PengumpulanTugas $pengumpulanTugas)
    {
        if (!in_array($pengumpulanTugas->status, ['dikumpulkan', 'terlambat', 'sudah_dinilai'])) {
            return back()->with('error', 'Status pengumpulan tidak dapat dikembalikan.');
        }

        $pengumpulanTugas->update([
            'nilai'        => null,
            'umpan_balik'  => null,
            'status'       => $pengumpulanTugas->isTerlambat() ? 'terlambat' : 'dikumpulkan',
            'dinilai_pada' => null,
        ]);

        return back()->with('success', 'Penilaian berhasil dikembalikan.');
    }

    public function destroy(PengumpulanTugas $pengumpulanTugas)
    {
        $pengumpulanTugas->delete();

        return redirect()->route('admin.pengumpulan-tugas.index')
            ->with('success', 'Data pengumpulan tugas berhasil dihapus.');
    }

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
            $query->whereHas('siswa', fn ($q) =>
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
}