<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\JadwalPelajaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    // ── Map nama hari PHP → Indonesia ─────────────────────────────────────────
    private const HARI_MAP = [
        'Sunday'    => 'minggu',
        'Monday'    => 'senin',
        'Tuesday'   => 'selasa',
        'Wednesday' => 'rabu',
        'Thursday'  => 'kamis',
        'Friday'    => 'jumat',
        'Saturday'  => 'sabtu',
    ];

    private function getSiswa(): \App\Models\Siswa
    {
        $siswa = Auth::user()?->siswa;
        abort_if(! $siswa, 403, 'Akun Anda tidak terhubung dengan data siswa.');
        return $siswa;
    }

    /**
     * Tampilkan jadwal pelajaran sesuai kelas siswa (read-only).
     * Dikelompokkan per hari untuk tampilan tabel mingguan.
     */
    public function index(Request $request)
    {
        $siswa = $this->getSiswa();

        // Pastikan siswa punya kelas
        abort_if(! $siswa->kelas_id, 403, 'Anda belum terdaftar di kelas manapun.');

        $hariList = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];

        // ── Ambil SEMUA jadwal kelas siswa (tanpa filter hari) ─────────────────
        // Tujuan: jadwalHariIni & weekly grid tetap lengkap meski ada filter tab.
        $allJadwal = JadwalPelajaran::with(['mataPelajaran', 'guru', 'ruang', 'tahunAjaran'])
            ->where('kelas_id', $siswa->kelas_id)
            ->orderByRaw("FIELD(hari, 'senin','selasa','rabu','kamis','jumat','sabtu')")
            ->orderBy('jam_mulai')
            ->get();

        // Kelompokkan semua jadwal per hari (untuk weekly grid & today banner)
        $jadwalPerHari = $allJadwal->groupBy('hari');

        // ── Jadwal yang ditampilkan di list view (bisa di-filter) ──────────────
        $filterHari = $request->filled('hari') && in_array($request->hari, $hariList)
            ? $request->hari
            : null;

        $jadwal = $filterHari
            ? $allJadwal->where('hari', $filterHari)->values()
            : $allJadwal;

        // ── Hari ini (konsisten, pakai map nama hari PHP) ──────────────────────
        $hariIni = self::HARI_MAP[Carbon::now()->format('l')] ?? 'senin';

        // Jadwal hari ini (selalu dari data lengkap)
        $jadwalHariIni = $jadwalPerHari->get($hariIni, collect());

        // Jam sekarang — format H:i:s agar kompatibel dengan kolom time di DB
        $jamSekarang = Carbon::now()->format('H:i:s');

        return view('siswa.jadwal.index', compact(
            'jadwal',
            'jadwalPerHari',
            'hariList',
            'hariIni',
            'jadwalHariIni',
            'jamSekarang',
            'siswa',
        ));
    }

    /**
     * Detail satu slot jadwal pelajaran.
     */
    public function show(JadwalPelajaran $jadwal)
    {
        $siswa = $this->getSiswa();

        abort_if($jadwal->kelas_id !== $siswa->kelas_id, 403, 'Jadwal ini bukan untuk kelas Anda.');

        $jadwal->load(['mataPelajaran', 'guru', 'ruang', 'kelas', 'tahunAjaran']);

        // Jadwal lain mapel yang sama (referensi pertemuan lain dalam seminggu)
        $jadwalSamMapel = JadwalPelajaran::with(['ruang'])
            ->where('kelas_id', $siswa->kelas_id)
            ->where('mata_pelajaran_id', $jadwal->mata_pelajaran_id)
            ->where('id', '!=', $jadwal->id)
            ->orderByRaw("FIELD(hari, 'senin','selasa','rabu','kamis','jumat','sabtu')")
            ->orderBy('jam_mulai')
            ->get();

        return view('siswa.jadwal.show', compact('jadwal', 'jadwalSamMapel', 'siswa'));
    }
}