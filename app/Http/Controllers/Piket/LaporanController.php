<?php

namespace App\Http\Controllers\Piket;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Piket\Concerns\PiketActiveGuru;
use App\Models\IzinKeluarSiswa;
use App\Models\LaporanHarianPiket;
use App\Models\LogPiket;
use App\Models\Pelanggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    use PiketActiveGuru;

    // ── FORM BUAT LAPORAN HARIAN ──────────────────────────────────────────────

    public function harian()
    {
        $guruAktif   = $this->resolveActiveGuru();
        $guruAktifId = $guruAktif?->id;

        if (! $guruAktifId) {
            return $this->redirectBelumCheckin('Check-in terlebih dahulu untuk membuat laporan harian.');
        }

        // Log piket hari ini
        $logHariIni = $this->resolveActiveLog()
            ?? LogPiket::where('guru_id', $guruAktifId)
                ->whereDate('tanggal', today())
                ->latest()
                ->first();

        // Laporan hari ini (jika sudah ada)
        $laporanHariIni = LaporanHarianPiket::where('dibuat_oleh', Auth::id())
            ->whereDate('tanggal', today())
            ->first();

        // Pelanggaran yang dicatat oleh user yang sedang login hari ini
        $pelanggaranHariIni = Pelanggaran::with(['siswa.kelas', 'kategori'])
            ->where('dicatat_oleh', Auth::id())
            ->whereDate('tanggal', today())
            ->get();

        // Izin keluar yang diproses hari ini
        $izinHariIni = IzinKeluarSiswa::with('siswa.kelas')
            ->whereDate('tanggal', today())
            ->get();

        $ringkasanOtomatis = $this->buatRingkasanOtomatis(
            $logHariIni,
            $pelanggaranHariIni,
            $izinHariIni,
        );

        return view('piket.laporan.harian', compact(
            'guruAktif',
            'laporanHariIni',
            'logHariIni',
            'pelanggaranHariIni',
            'izinHariIni',
            'ringkasanOtomatis',
        ));
    }

    // ── SIMPAN LAPORAN HARIAN ─────────────────────────────────────────────────

    public function simpanHarian(Request $request)
    {
        $guruAktifId = $this->resolveActiveGuruId();

        if (! $guruAktifId) {
            return $this->redirectBelumCheckin('Check-in terlebih dahulu untuk menyimpan laporan.');
        }

        $validated = $request->validate([
            'tanggal'          => ['required', 'date'],
            'kondisi_sekolah'  => ['required', 'string'],
            'catatan_umum'     => ['nullable', 'string'],
            'kejadian_khusus'  => ['nullable', 'string'],
            'tamu_penting'     => ['nullable', 'string'],
        ], [
            'tanggal.required'         => 'Tanggal laporan wajib diisi.',
            'kondisi_sekolah.required' => 'Kondisi sekolah wajib diisi.',
        ]);

        $validated['dibuat_oleh'] = Auth::id();

        LaporanHarianPiket::updateOrCreate(
            [
                'dibuat_oleh' => Auth::id(),
                'tanggal'     => $validated['tanggal'],
            ],
            $validated
        );

        return redirect()->route('piket.laporan.riwayat')
            ->with('success', 'Laporan harian berhasil disimpan.');
    }

    // ── RIWAYAT LAPORAN ───────────────────────────────────────────────────────

    public function riwayat(Request $request)
    {
        $guruAktifId = $this->resolveActiveGuruId();

        if (! $guruAktifId) {
            return $this->redirectBelumCheckin('Check-in terlebih dahulu untuk melihat riwayat laporan.');
        }

        $query = LaporanHarianPiket::where('dibuat_oleh', Auth::id())
            ->orderByDesc('tanggal');

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $laporan = $query->paginate(15)->withQueryString();

        $tahunList = LaporanHarianPiket::where('dibuat_oleh', Auth::id())
            ->selectRaw('YEAR(tanggal) as tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

        return view('piket.laporan.riwayat', compact('laporan', 'tahunList'));
    }

    // ── SHOW DETAIL LAPORAN ───────────────────────────────────────────────────

    public function show(LaporanHarianPiket $laporan)
    {
        // Hanya pembuat laporan yang boleh melihat
        abort_unless(
            $laporan->dibuat_oleh === Auth::id(),
            403,
            'Anda tidak berhak mengakses laporan ini.'
        );

        $laporan->load('dibuatOleh');

        // Ambil izin keluar pada hari yang sama via helper model
        $izinHariIni       = $laporan->getIzinKeluarSiswa();
        $ringkasanIzin     = $laporan->getRingkasanIzinKeluar();

        return view('piket.laporan.show', compact('laporan', 'izinHariIni', 'ringkasanIzin'));
    }

    // ── Helper ────────────────────────────────────────────────────────────────

    private function buatRingkasanOtomatis(
        ?LogPiket $log,
        \Illuminate\Support\Collection $pelanggaran,
        \Illuminate\Support\Collection $izin,
    ): string {
        $parts = [];

        if ($log) {
            $masuk  = $log->masuk_pada
                ? \Carbon\Carbon::parse($log->masuk_pada)->format('H:i')
                : '-';
            $keluar = $log->keluar_pada
                ? \Carbon\Carbon::parse($log->keluar_pada)->format('H:i')
                : 'belum checkout';
            $parts[] = "Piket dilaksanakan pukul {$masuk} s.d. {$keluar}.";
        }

        if ($pelanggaran->count() > 0) {
            $parts[] = "Terdapat {$pelanggaran->count()} pelanggaran siswa yang dicatat.";
        }

        if ($izin->count() > 0) {
            $disetujui = $izin->where('status', IzinKeluarSiswa::STATUS_DISETUJUI)->count()
                       + $izin->where('status', IzinKeluarSiswa::STATUS_SUDAH_KEMBALI)->count();
            $parts[]   = "Izin keluar siswa: {$izin->count()} pengajuan, {$disetujui} disetujui.";
        }

        return implode(' ', $parts) ?: 'Tidak ada kejadian khusus hari ini.';
    }
}