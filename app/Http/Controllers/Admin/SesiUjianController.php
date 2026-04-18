<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JawabanSiswa;
use App\Models\SesiUjian;
use App\Models\Ujian;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SesiUjianExport;

class SesiUjianController extends Controller
{
    private function getSiswaId(): int
    {
        $siswa = Auth::user()->siswa;
        abort_if(!$siswa, 403, 'Akun Anda tidak terhubung dengan data siswa.');

        return $siswa->id;
    }

    public function index()
    {
        $siswaId = $this->getSiswaId();
        $siswa   = Auth::user()->siswa;

        $ujians = Ujian::aktif()
            ->where('kelas_id', $siswa->kelas_id)
            ->with(['mataPelajaran', 'guru'])
            ->get()
            ->map(function ($u) use ($siswaId) {
                $u->sesi_saya  = $u->getSesiSiswa($siswaId);
                $u->boleh_ikut = $u->bolehIkut($siswaId);
                return $u;
            });

        return view('siswa.ujian.index', compact('ujians'));
    }

    public function mulai(Ujian $ujian)
    {
        $siswaId = $this->getSiswaId();
        $this->authorizeUjian($ujian, $siswaId);

        $sesi = $ujian->getSesiSiswa($siswaId);

        if ($sesi && $sesi->status === 'berlangsung' && !$sesi->isHabisWaktu()) {
            return redirect()->route('admin.ujian.sesi.kerjakan', $ujian);
        }

        return view('siswa.ujian.mulai', compact('ujian', 'sesi'));
    }

    public function start(Request $request, Ujian $ujian)
    {
        $siswaId = $this->getSiswaId();
        $this->authorizeUjian($ujian, $siswaId);

        $sesiAktif = $ujian->sesi()
            ->where('siswa_id', $siswaId)
            ->where('status', 'berlangsung')
            ->first();

        if ($sesiAktif && !$sesiAktif->isHabisWaktu()) {
            return redirect()->route('admin.ujian.sesi.kerjakan', $ujian);
        }

        DB::transaction(function () use ($ujian, $siswaId) {
            $sesi = SesiUjian::create([
                'ujian_id' => $ujian->id,
                'siswa_id' => $siswaId,
                'status'   => 'belum_mulai',
            ]);
            $sesi->mulai();
        });

        return redirect()->route('admin.ujian.sesi.kerjakan', $ujian)
            ->with('info', 'Ujian dimulai. Waktu berjalan!');
    }

    public function kerjakan(Ujian $ujian)
    {
        $siswaId = $this->getSiswaId();
        $sesi    = $ujian->getSesiSiswa($siswaId);

        if (!$sesi || $sesi->status === 'belum_mulai') {
            return redirect()->route('admin.ujian.sesi.mulai', $ujian);
        }

        if (in_array($sesi->status, ['selesai', 'habis_waktu'])) {
            return redirect()->route('admin.ujian.sesi.hasil', $ujian);
        }

        if ($sesi->isHabisWaktu()) {
            $sesi->selesaikan(habisWaktu: true);
            return redirect()->route('admin.ujian.sesi.hasil', $ujian)
                ->with('warning', 'Waktu habis. Ujian diselesaikan secara otomatis.');
        }

        $soals = $ujian->soal()->with('pilihan')->get();

        if ($ujian->acak_soal) {
            $soals = $soals->shuffle();
        }

        $jawabanMap = $sesi->jawaban()
            ->pluck('pilihan_jawaban_id', 'soal_ujian_id')
            ->toArray();

        return view('siswa.ujian.kerjakan', compact('ujian', 'sesi', 'soals', 'jawabanMap'));
    }

    public function jawab(Request $request, Ujian $ujian, int $soalId)
    {
        $siswaId = $this->getSiswaId();
        $sesi    = $ujian->getSesiSiswa($siswaId);

        if (!$sesi || $sesi->status !== 'berlangsung') {
            return response()->json(['error' => 'Sesi ujian tidak aktif.'], 422);
        }

        if ($sesi->isHabisWaktu()) {
            $sesi->selesaikan(habisWaktu: true);
            return response()->json(['error' => 'Waktu ujian telah habis.'], 422);
        }

        $request->validate([
            'pilihan_jawaban_id' => ['nullable', 'exists:pilihan_jawaban,id'],
            'jawaban_essay'      => ['nullable', 'string', 'max:5000'],
        ], [
            'pilihan_jawaban_id.exists' => 'Pilihan jawaban tidak valid.',
            'jawaban_essay.max'         => 'Jawaban essay maksimal 5000 karakter.',
        ]);

        $jawaban = JawabanSiswa::updateOrCreate(
            ['sesi_ujian_id' => $sesi->id, 'soal_ujian_id' => $soalId],
            [
                'pilihan_jawaban_id' => $request->pilihan_jawaban_id,
                'jawaban_essay'      => $request->jawaban_essay,
            ]
        );

        return response()->json([
            'success'    => true,
            'jawaban_id' => $jawaban->id,
            'sisa_detik' => $sesi->fresh()->sisa_detik,
        ]);
    }

    public function selesai(Request $request, Ujian $ujian)
    {
        $siswaId = $this->getSiswaId();
        $sesi    = $ujian->getSesiSiswa($siswaId);

        if (!$sesi || $sesi->status !== 'berlangsung') {
            return redirect()->route('admin.ujian.sesi.index');
        }

        $sesi->selesaikan();

        return redirect()->route('admin.ujian.sesi.hasil', $ujian)
            ->with('success', 'Ujian berhasil dikumpulkan!');
    }

    public function hasil(Ujian $ujian)
    {
        $siswaId = $this->getSiswaId();
        $sesi    = $ujian->getSesiSiswa($siswaId);

        if (!$sesi || $sesi->status === 'berlangsung') {
            return redirect()->route('admin.ujian.sesi.kerjakan', $ujian);
        }

        $sesi->load(['jawaban.soal.pilihan', 'jawaban.pilihan']);

        return view('siswa.ujian.hasil', compact('ujian', 'sesi'));
    }

    public function exportPdf(Ujian $ujian)
    {
        $sesiList = $ujian->sesi()
            ->with(['siswa', 'jawaban'])
            ->whereIn('status', ['selesai', 'habis_waktu'])
            ->orderByDesc('nilai_akhir')
            ->get();

        $pdf = Pdf::loadView('admin.ujian.sesi-export-pdf', compact('ujian', 'sesiList'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('hasil-ujian-' . $ujian->id . '-' . now()->format('YmdHis') . '.pdf');
    }

    public function exportExcel(Ujian $ujian)
    {
        return Excel::download(
            new SesiUjianExport($ujian),
            'hasil-ujian-' . $ujian->id . '-' . now()->format('YmdHis') . '.xlsx'
        );
    }

    private function authorizeUjian(Ujian $ujian, int $siswaId): void
    {
        $siswa = Auth::user()->siswa;

        abort_if($ujian->kelas_id !== $siswa->kelas_id, 403, 'Ujian ini bukan untuk kelas Anda.');
        abort_if(!$ujian->is_active, 403, 'Ujian tidak aktif.');
        abort_if(!$ujian->sudahDimulai(), 403, 'Ujian belum dibuka.');
        abort_if($ujian->sudahBerakhir(), 403, 'Ujian sudah berakhir.');
        abort_if(!$ujian->bolehIkut($siswaId), 403, 'Anda sudah melebihi batas percobaan untuk ujian ini.');
    }
}