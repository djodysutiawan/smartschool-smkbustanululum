<?php

namespace App\Http\Controllers\Piket;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Piket\Concerns\PiketActiveGuru;
use App\Models\JadwalPiketGuru;
use App\Models\LogPiket;
use App\Models\TahunAjaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class JadwalController extends Controller
{
    use PiketActiveGuru;

    // ─── INDEX ────────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $guruId = $this->resolveActiveGuruId();

        // ── Belum check-in: tampilkan halaman dengan data kosong + banner ──
        if (! $guruId) {
            return view('piket.jadwal.index', [
                'jadwal'          => new LengthAwarePaginator([], 0, 15),
                'jadwalHariIni'   => null,
                'logBulanIni'     => collect(),
                'rekapBulanIni'   => ['hadir' => 0, 'total' => 0],
                'tahunAjaranList' => collect(),   // view butuh ini untuk dropdown filter
                'belumCheckin'    => true,
            ]);
        }

        // ── Query jadwal (diurutkan hari lalu jam) ─────────────────────────
        $query = JadwalPiketGuru::with('tahunAjaran')
            ->where('guru_id', $guruId)
            ->orderByRaw("FIELD(hari,'senin','selasa','rabu','kamis','jumat','sabtu','minggu')")
            ->orderBy('jam_mulai');

        // Filter tahun ajaran
        if ($request->filled('tahun_ajaran_id')) {
            $query->where('tahun_ajaran_id', $request->tahun_ajaran_id);
        }

        // Filter status aktif/nonaktif
        // request('is_active') bisa '1', '0', atau '' (kosong = semua)
        if ($request->filled('is_active')) {
            $query->where('is_active', (bool) $request->input('is_active'));
        }

        $jadwal = $query->paginate(15)->withQueryString();

        // ── Jadwal hari ini ─────────────────────────────────────────────────
        $hariIni = JadwalPiketGuru::getNamaHari(now());

        $jadwalHariIni = JadwalPiketGuru::where('guru_id', $guruId)
            ->where('hari', $hariIni)
            ->where('is_active', true)
            ->with('tahunAjaran')
            ->first();

        // ── Log bulan ini (paginate agar tidak berat jika banyak) ──────────
        // Diambil sebagai Collection karena view hanya menampilkan 10 teratas
        $logBulanIni = LogPiket::where('guru_id', $guruId)
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->orderByDesc('tanggal')
            ->orderByDesc('masuk_pada')
            ->get();

        $rekapBulanIni = [
            'hadir' => $logBulanIni->whereNotNull('masuk_pada')->count(),
            'total' => $logBulanIni->count(),
        ];

        // ── Dropdown tahun ajaran untuk filter ─────────────────────────────
        $tahunAjaranList = TahunAjaran::orderByDesc('id')->get();

        return view('piket.jadwal.index', [
            'jadwal'          => $jadwal,
            'jadwalHariIni'   => $jadwalHariIni,
            'logBulanIni'     => $logBulanIni,
            'rekapBulanIni'   => $rekapBulanIni,
            'tahunAjaranList' => $tahunAjaranList,
            'belumCheckin'    => false,
        ]);
    }

    // ─── SHOW ─────────────────────────────────────────────────────────────────

    public function show(JadwalPiketGuru $jadwal)
    {
        $guruId = $this->resolveActiveGuruId();

        // Belum check-in → redirect ke halaman check-in dengan pesan
        if (! $guruId) {
            return $this->redirectBelumCheckin(
                'Check-in terlebih dahulu untuk melihat detail jadwal.'
            );
        }

        // Guru hanya bisa lihat jadwal miliknya sendiri
        // Gunakan strict comparison (===) karena keduanya int
        if ($jadwal->guru_id !== $guruId) {
            abort(403, 'Anda tidak berhak mengakses jadwal ini.');
        }

        $jadwal->load('tahunAjaran', 'guru');

        // ── Riwayat log 3 bulan terakhir ───────────────────────────────────
        // Filter per hari yang sama dengan jadwal ini agar relevan dengan
        // kolom "Hari" yang ditampilkan di tabel view show.
        //
        // Catatan: LogPiket tidak punya kolom 'hari', filter dilakukan via
        // DAYOFWEEK MySQL yang dipetakan ke nama hari Indonesia.
        //
        // Mapping DAYOFWEEK MySQL: 1=Minggu, 2=Senin, …, 7=Sabtu
        $mysqlDayMap = [
            'minggu'  => 1,
            'senin'   => 2,
            'selasa'  => 3,
            'rabu'    => 4,
            'kamis'   => 5,
            'jumat'   => 6,
            'sabtu'   => 7,
        ];

        $mysqlDay = $mysqlDayMap[strtolower($jadwal->hari)] ?? null;

        $riwayatQuery = LogPiket::where('guru_id', $guruId)
            ->whereDate('tanggal', '>=', now()->subMonths(3)->startOfDay());

        // Jika hari jadwal valid, filter hanya log di hari yang sama
        if ($mysqlDay !== null) {
            $riwayatQuery->whereRaw('DAYOFWEEK(tanggal) = ?', [$mysqlDay]);
        }

        $riwayatLog = $riwayatQuery
            ->orderByDesc('tanggal')
            ->paginate(10, ['*'], 'log_page')  // page key unik agar tidak konflik dengan ?page jadwal
            ->withQueryString();

        return view('piket.jadwal.show', compact('jadwal', 'riwayatLog'));
    }
}