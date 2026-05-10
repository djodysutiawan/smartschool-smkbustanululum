<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    /**
     * Urutan hari yang konsisten dipakai di seluruh controller & view.
     */
    private const HARI_LIST = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];

    /**
     * Ambil ID guru dari user yang sedang login.
     * Abort 403 jika user tidak terhubung ke data guru.
     */
    private function getGuruId(): int
    {
        $guru = Auth::user()->guru;
        abort_if(! $guru, 403, 'Akun Anda tidak terhubung dengan data guru.');
        return (int) $guru->id;
    }

    /**
     * Daftar jadwal mengajar guru – tampilan mingguan & tabel.
     */
    public function index(Request $request)
    {
        $guruId = $this->getGuruId();

        // ── Validasi input filter (hindari injection & value tak valid) ────────
        $request->validate([
            'hari'      => ['nullable', 'in:' . implode(',', self::HARI_LIST)],
            'kelas_id'  => ['nullable', 'integer', 'min:1'],
            'is_active' => ['nullable', 'in:0,1'],
        ]);

        // ── Base query ────────────────────────────────────────────────────────
        $query = JadwalPelajaran::with(['mataPelajaran', 'kelas', 'ruang', 'tahunAjaran'])
            ->where('guru_id', $guruId);

        // ── Filter hari ────────────────────────────────────────────────────────
        if ($request->filled('hari')) {
            $query->where('hari', $request->input('hari'));
        }

        // ── Filter kelas ───────────────────────────────────────────────────────
        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', (int) $request->input('kelas_id'));
        }

        // ── Filter status aktif ────────────────────────────────────────────────
        // Pakai input() bukan boolean() agar nilai '0' (nonaktif) ditangani benar.
        if ($request->input('is_active') !== null && $request->input('is_active') !== '') {
            $query->where('is_active', (bool) $request->input('is_active'));
        }

        // ── Urutkan sesuai urutan hari kalender, lalu jam ─────────────────────
        // FIELD() didukung MySQL/MariaDB. Jika pakai SQLite (testing),
        // pengurutan dilakukan in-memory di bawah.
        $hariOrder = implode("','", self::HARI_LIST);
        $jadwal = $query
            ->orderByRaw("FIELD(hari, '{$hariOrder}')")
            ->orderBy('jam_mulai')
            ->get();

        // ── Daftar kelas untuk dropdown filter (dari semua jadwal guru,
        //    bukan dari $jadwal yang sudah difilter agar opsi tidak hilang) ──────
        $kelasOptions = JadwalPelajaran::with('kelas')
            ->where('guru_id', $guruId)
            ->get()
            ->pluck('kelas')
            ->filter()          // buang null
            ->unique('id')
            ->sortBy('nama_kelas')
            ->values();

        // ── Kelompokkan per hari, pertahankan urutan HARI_LIST ─────────────────
        $jadwalGrouped = $jadwal->groupBy('hari');
        $jadwalPerHari = collect(self::HARI_LIST)->mapWithKeys(
            fn ($hari) => [$hari => $jadwalGrouped->get($hari, collect())]
        );

        return view('guru.jadwal.index', [
            'jadwal'       => $jadwal,
            'jadwalPerHari'=> $jadwalPerHari,
            'hariList'     => self::HARI_LIST,
            'kelasOptions' => $kelasOptions,
        ]);
    }

    /**
     * Detail satu jadwal.
     */
    public function show(JadwalPelajaran $jadwal)
    {
        $guruId = $this->getGuruId();

        // Pastikan jadwal ini milik guru yang sedang login
        abort_if($jadwal->guru_id !== $guruId, 403, 'Anda tidak memiliki akses ke jadwal ini.');

        $jadwal->load(['mataPelajaran', 'kelas', 'ruang', 'tahunAjaran', 'guru']);

        return view('guru.jadwal.show', compact('jadwal'));
    }
}