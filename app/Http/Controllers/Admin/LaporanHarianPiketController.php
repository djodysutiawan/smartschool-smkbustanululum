<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AbsensiGuru;
use App\Models\IzinKeluarSiswa;
use App\Models\LaporanHarianPiket;
use App\Models\LogPiket;
use App\Models\Pelanggaran;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanHarianPiketController extends Controller
{
    // ─── INDEX ────────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        // FIX: tambahkan withCount('pelanggaran') agar $item->pelanggaran_count
        // tersedia di view. Tanpa ini, blade akan selalu mendapat null/0 dan
        // berpotensi error jika properti diakses langsung.
        $query = LaporanHarianPiket::with('dibuatOleh')
            ->withCount('pelanggaran')
            ->orderByDesc('tanggal');

        if ($request->filled('dibuat_oleh')) {
            $query->where('dibuat_oleh', $request->dibuat_oleh);
        }
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        }

        $laporan = $query->paginate(20)->withQueryString();

        $guruPiketList = User::where('role', 'guru_piket')
            ->orderBy('name')
            ->get();

        $stats = [
            'total'       => LaporanHarianPiket::count(),
            'hari_ini'    => LaporanHarianPiket::whereDate('tanggal', today())->count(),
            'bulan_ini'   => LaporanHarianPiket::whereMonth('tanggal', now()->month)
                                ->whereYear('tanggal', now()->year)
                                ->count(),
            'total_piket' => $guruPiketList->count(),
        ];

        return view('admin.laporan-harian-piket.index',
            compact('laporan', 'guruPiketList', 'stats'));
    }

    // ─── SHOW ─────────────────────────────────────────────────────────────────

    public function show(LaporanHarianPiket $laporanHarianPiket)
    {
        $laporanHarianPiket->load('dibuatOleh');

        $tanggal = $laporanHarianPiket->tanggal;

        $pelanggaranHariItu = Pelanggaran::with(['siswa.kelas', 'kategori'])
            ->where('dicatat_oleh', $laporanHarianPiket->dibuat_oleh)
            ->whereDate('tanggal', $tanggal)
            ->get();

        $logPiket = LogPiket::where('pengguna_id', $laporanHarianPiket->dibuat_oleh)
            ->whereDate('tanggal', $tanggal)
            ->first();

        $rekapAbsensi = $laporanHarianPiket->rekap_absensi ?? [];

        // FIX: eager-load relasi 'guru' (bukan 'user') sesuai relasi AbsensiGuru.
        // Sesuaikan nama relasi ('guru') dengan yang ada di model AbsensiGuru.
        $absensiHariItu = AbsensiGuru::with('guru')
            ->whereDate('tanggal', $tanggal)
            ->orderBy('guru_id')
            ->get();

        $izinKeluarHariItu = IzinKeluarSiswa::with(['siswa.kelas', 'diprosesOleh'])
            ->whereDate('tanggal', $tanggal)
            ->orderBy('jam_keluar')
            ->get();

        // FIX: Hitung dengan filter() agar collection tidak ter-mutate.
        $ringkasanIzin = [
            'total'         => $izinKeluarHariItu->count(),
            'disetujui'     => $izinKeluarHariItu->filter(fn($i) => in_array($i->status, [
                                    IzinKeluarSiswa::STATUS_DISETUJUI,
                                    IzinKeluarSiswa::STATUS_SUDAH_KEMBALI,
                               ]))->count(),
            'ditolak'       => $izinKeluarHariItu->filter(fn($i) =>
                                    $i->status === IzinKeluarSiswa::STATUS_DITOLAK
                               )->count(),
            'belum_kembali' => $izinKeluarHariItu->filter(fn($i) =>
                                    $i->status === IzinKeluarSiswa::STATUS_DISETUJUI
                               )->count(),
            'sudah_kembali' => $izinKeluarHariItu->filter(fn($i) =>
                                    $i->status === IzinKeluarSiswa::STATUS_SUDAH_KEMBALI
                               )->count(),
        ];

        return view('admin.laporan-harian-piket.show', compact(
            'laporanHarianPiket',
            'pelanggaranHariItu',
            'logPiket',
            'rekapAbsensi',
            'absensiHariItu',
            'izinKeluarHariItu',
            'ringkasanIzin'
        ));
    }

    // ─── DESTROY ─────────────────────────────────────────────────────────────

    public function destroy(LaporanHarianPiket $laporanHarianPiket)
    {
        $laporanHarianPiket->delete();

        return redirect()->route('admin.laporan-harian-piket.index')
            ->with('success', 'Laporan harian piket berhasil dihapus.');
    }

    // ─── EXPORT PDF ──────────────────────────────────────────────────────────

    /**
     * FIX utama export PDF:
     * 1. withCount('pelanggaran') agar $item->pelanggaran_count tersedia di blade
     *    (menggantikan $item->jumlah_pelanggaran yang tidak ada di model/DB).
     * 2. Pre-load semua LogPiket dalam satu query, di-key by pengguna_id+tanggal,
     *    menghilangkan N+1 query (sebelumnya LogPiket::where() dipanggil per baris
     *    di dalam loop @foreach di blade).
     */
    public function exportPdf(Request $request)
    {
        $query = LaporanHarianPiket::with('dibuatOleh')
            ->withCount('pelanggaran')
            ->orderByDesc('tanggal');

        if ($request->filled('dibuat_oleh')) {
            $query->where('dibuat_oleh', $request->dibuat_oleh);
        }
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        }

        $laporan = $query->get();

        $tanggalList = $laporan->pluck('tanggal')
            ->filter()
            ->map(fn($t) => $t->toDateString())
            ->unique()
            ->sort()
            ->values();

        // FIX: Pre-load semua LogPiket yang dibutuhkan dalam SATU query,
        // bukan N query di dalam loop blade. Di-key by "pengguna_id_tanggal"
        // agar lookup O(1) di blade.
        $logPiketMap = collect();
        if ($tanggalList->isNotEmpty()) {
            $logPiketMap = LogPiket::whereBetween('tanggal', [
                    $tanggalList->first(),
                    $tanggalList->last(),
                ])
                ->whereIn('pengguna_id', $laporan->pluck('dibuat_oleh')->unique()->filter())
                ->get()
                ->keyBy(fn($log) => $log->pengguna_id . '_' . $log->tanggal->toDateString());
        }

        $izinPerTanggal = collect();
        if ($tanggalList->isNotEmpty()) {
            $izinPerTanggal = IzinKeluarSiswa::with(['siswa.kelas'])
                ->whereBetween('tanggal', [
                    $tanggalList->first(),
                    $tanggalList->last(),
                ])
                ->orderBy('tanggal')
                ->orderBy('jam_keluar')
                ->get()
                ->groupBy(fn($item) => $item->tanggal->toDateString());
        }

        $pdf = Pdf::loadView('admin.laporan-harian-piket.exports.pdf', compact(
            'laporan',
            'izinPerTanggal',
            'logPiketMap'      // FIX: kirim map ke blade, bukan query per-row
        ))->setPaper('a4', 'landscape');

        return $pdf->download('laporan-harian-piket-' . now()->format('Ymd-His') . '.pdf');
    }
}