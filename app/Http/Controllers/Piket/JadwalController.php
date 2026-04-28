<?php

namespace App\Http\Controllers\Piket;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Piket\Concerns\PiketActiveGuru;
use App\Models\JadwalPiketGuru;
use App\Models\LogPiket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class JadwalController extends Controller
{
    use PiketActiveGuru;

    public function index(Request $request)
    {
        // Guru ditentukan dari log check-in aktif, bukan dari Auth::user()->guru
        $guruId = $this->resolveActiveGuruId();

        // Jika belum check-in, tetap bisa lihat halaman tapi dengan data kosong
        // dan banner "silakan check-in dulu"
        if (! $guruId) {
            return view('piket.jadwal.index', [
                'jadwal'          => new LengthAwarePaginator([], 0, 15),
                'jadwalHariIni'   => null,
                'logBulanIni'     => collect(),
                'rekapBulanIni'   => ['hadir' => 0, 'total' => 0],
                'belumCheckin'    => true,
            ]);
        }

        $query = JadwalPiketGuru::with('tahunAjaran')
            ->where('guru_id', $guruId)
            ->orderByRaw("FIELD(hari,'senin','selasa','rabu','kamis','jumat','sabtu')")
            ->orderBy('jam_mulai');

        if ($request->filled('tahun_ajaran_id')) {
            $query->where('tahun_ajaran_id', $request->tahun_ajaran_id);
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        $jadwal = $query->paginate(15)->withQueryString();

        $hariIni       = strtolower(Carbon::now()->locale('id')->isoFormat('dddd'));
        $jadwalHariIni = JadwalPiketGuru::where('guru_id', $guruId)
            ->where('hari', $hariIni)
            ->where('is_active', true)
            ->first();

        // Log bulan ini untuk guru yang sedang check-in
        $logBulanIni = LogPiket::where('guru_id', $guruId)
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->orderByDesc('tanggal')
            ->get();

        $rekapBulanIni = [
            'hadir' => $logBulanIni->whereNotNull('masuk_pada')->count(),
            'total' => $logBulanIni->count(),
        ];

        return view('piket.jadwal.index', [
            'jadwal'        => $jadwal,
            'jadwalHariIni' => $jadwalHariIni,
            'logBulanIni'   => $logBulanIni,
            'rekapBulanIni' => $rekapBulanIni,
            'belumCheckin'  => false,
        ]);
    }

    public function show(JadwalPiketGuru $jadwal)
    {
        $guruId = $this->resolveActiveGuruId();

        if (! $guruId) {
            return $this->redirectBelumCheckin('Check-in terlebih dahulu untuk melihat detail jadwal.');
        }

        // Guru hanya bisa lihat jadwal miliknya sendiri
        abort_unless($jadwal->guru_id === $guruId, 403, 'Anda tidak berhak mengakses jadwal ini.');

        $jadwal->load('tahunAjaran');

        // Riwayat log 3 bulan terakhir untuk jadwal/hari yang sama
        $riwayatLog = LogPiket::where('guru_id', $guruId)
            ->whereDate('tanggal', '>=', now()->subMonths(3))
            ->orderByDesc('tanggal')
            ->paginate(10);

        return view('piket.jadwal.show', compact('jadwal', 'riwayatLog'));
    }
}