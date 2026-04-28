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

    /**
     * Daftar semua laporan harian piket dari seluruh guru piket.
     * Admin bisa filter by tanggal, guru piket, dan search.
     */
    public function index(Request $request)
    {
        $query = LaporanHarianPiket::with('dibuatOleh')
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
                                ->whereYear('tanggal', now()->year)->count(),
            'total_piket' => $guruPiketList->count(),
        ];

        return view('admin.laporan-harian-piket.index',
            compact('laporan', 'guruPiketList', 'stats'));
    }

    // ─── SHOW ─────────────────────────────────────────────────────────────────

    /**
     * Detail satu laporan harian piket.
     * Ditambahkan: ringkasan izin keluar siswa pada hari yang sama.
     */
    public function show(LaporanHarianPiket $laporanHarianPiket)
    {
        $laporanHarianPiket->load('dibuatOleh');

        $tanggal = $laporanHarianPiket->tanggal;

        // ── Data yang sudah ada ──────────────────────────────────────────────

        $pelanggaranHariItu = Pelanggaran::with(['siswa.kelas', 'kategori'])
            ->where('dicatat_oleh', $laporanHarianPiket->dibuat_oleh)
            ->whereDate('tanggal', $tanggal)
            ->get();

        $logPiket = LogPiket::where('pengguna_id', $laporanHarianPiket->dibuat_oleh)
            ->whereDate('tanggal', $tanggal)
            ->first();

        $rekapAbsensi = $laporanHarianPiket->rekap_absensi ?? [];

        $absensiHariItu = AbsensiGuru::with('guru')
            ->whereDate('tanggal', $tanggal)
            ->orderBy('guru_id')
            ->get();

        // ── Tambahan: Izin keluar siswa pada hari yang sama ──────────────────
        // Diambil dari seluruh data hari itu (bukan hanya yang dicatat piket
        // yang bersangkutan) karena izin bersifat data sekolah secara global.

        $izinKeluarHariItu = IzinKeluarSiswa::with(['siswa.kelas', 'diprosesOleh'])
            ->whereDate('tanggal', $tanggal)
            ->orderBy('jam_keluar')
            ->get();

        // Ringkasan izin untuk ditampilkan di header show
        $ringkasanIzin = [
            'total'         => $izinKeluarHariItu->count(),
            'disetujui'     => $izinKeluarHariItu->whereIn('status', [
                                    IzinKeluarSiswa::STATUS_DISETUJUI,
                                    IzinKeluarSiswa::STATUS_SUDAH_KEMBALI,
                               ])->count(),
            'ditolak'       => $izinKeluarHariItu->where('status', IzinKeluarSiswa::STATUS_DITOLAK)->count(),
            'belum_kembali' => $izinKeluarHariItu->where('status', IzinKeluarSiswa::STATUS_DISETUJUI)->count(),
            'sudah_kembali' => $izinKeluarHariItu->where('status', IzinKeluarSiswa::STATUS_SUDAH_KEMBALI)->count(),
        ];

        // Reset collection setelah where() agar view tetap dapat koleksi penuh
        $izinKeluarHariItu = IzinKeluarSiswa::with(['siswa.kelas', 'diprosesOleh'])
            ->whereDate('tanggal', $tanggal)
            ->orderBy('jam_keluar')
            ->get();

        return view('admin.laporan-harian-piket.show', compact(
            'laporanHarianPiket',
            'pelanggaranHariItu',
            'logPiket',
            'rekapAbsensi',
            'absensiHariItu',
            'izinKeluarHariItu',   // ← baru
            'ringkasanIzin'        // ← baru
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

    public function exportPdf(Request $request)
    {
        $query = LaporanHarianPiket::with('dibuatOleh')
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

        // Sertakan juga data izin keluar untuk setiap tanggal yang ada di laporan
        // agar PDF bisa menampilkan ringkasan per hari secara lengkap.
        $tanggalList    = $laporan->pluck('tanggal')->unique();
        $izinPerTanggal = IzinKeluarSiswa::with(['siswa.kelas'])
            ->whereIn(\Illuminate\Support\Facades\DB::raw('DATE(tanggal)'),
                $tanggalList->map(fn($t) => is_string($t) ? $t : $t->toDateString())
            )
            ->orderBy('tanggal')
            ->orderBy('jam_keluar')
            ->get()
            ->groupBy(fn($item) => $item->tanggal->toDateString());

        $pdf = Pdf::loadView('admin.laporan-harian-piket.exports.pdf', compact(
            'laporan',
            'izinPerTanggal'   // ← baru, opsional dipakai di blade PDF
        ))->setPaper('a4', 'landscape');

        return $pdf->download('laporan-harian-piket-' . now()->format('Ymd-His') . '.pdf');
    }
}