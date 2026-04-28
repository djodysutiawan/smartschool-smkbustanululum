<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\PengumpulanTugas;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengumpulanTugasController extends Controller
{
    protected array $statusList = [
        'belum_dikumpulkan' => 'Belum Dikumpulkan',
        'dikumpulkan'       => 'Dikumpulkan',
        'terlambat'         => 'Terlambat',
        'sudah_dinilai'     => 'Sudah Dinilai',
    ];

    private function getGuruId(): int
    {
        $guru = Auth::user()->guru;
        abort_if(! $guru, 403, 'Akun Anda tidak terhubung dengan data guru.');
        return $guru->id;
    }

    public function index(Request $request)
    {
        $guruId = $this->getGuruId();

        $query = PengumpulanTugas::with(['tugas.mataPelajaran', 'siswa.kelas'])
            ->whereHas('tugas', fn ($q) => $q->where('guru_id', $guruId));

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

        // Hanya tampilkan tugas milik guru ini
        $tugasList = Tugas::where('guru_id', $guruId)
            ->orderByDesc('batas_waktu')
            ->get();

        return view('guru.pengumpulan-tugas.index', [
            'pengumpulan' => $pengumpulan,
            'tugasList'   => $tugasList,
            'statusList'  => $this->statusList,
        ]);
    }

    public function show(PengumpulanTugas $pengumpulan)
    {
        $guruId = $this->getGuruId();

        // Pastikan pengumpulan tugas ini untuk tugas milik guru yang sedang login
        abort_if($pengumpulan->tugas->guru_id !== $guruId, 403, 'Anda tidak memiliki akses ke data ini.');

        $pengumpulan->load(['tugas.mataPelajaran', 'siswa.kelas']);

        return view('guru.pengumpulan-tugas.show', compact('pengumpulan'));
    }

    public function beriNilai(Request $request, PengumpulanTugas $pengumpulan)
    {
        $guruId = $this->getGuruId();
        abort_if($pengumpulan->tugas->guru_id !== $guruId, 403, 'Anda tidak memiliki akses ke data ini.');

        $nilaiMaks = (float) ($pengumpulan->tugas->nilai_maksimal ?? 100);

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

        $pengumpulan->beriNilai($validated['nilai'], $validated['umpan_balik'] ?? null);

        return back()->with('success', 'Nilai berhasil diberikan.');
    }

    public function kembalikan(PengumpulanTugas $pengumpulan)
    {
        $guruId = $this->getGuruId();
        abort_if($pengumpulan->tugas->guru_id !== $guruId, 403, 'Anda tidak memiliki akses ke data ini.');

        if (! in_array($pengumpulan->status, ['dikumpulkan', 'terlambat', 'sudah_dinilai'])) {
            return back()->with('error', 'Status pengumpulan tidak dapat dikembalikan.');
        }

        $pengumpulan->update([
            'nilai'        => null,
            'umpan_balik'  => null,
            'status'       => $pengumpulan->isTerlambat() ? 'terlambat' : 'dikumpulkan',
            'dinilai_pada' => null,
        ]);

        return back()->with('success', 'Penilaian berhasil dikembalikan.');
    }
}