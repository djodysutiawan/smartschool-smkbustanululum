<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\IzinKeluarSiswa;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruIzinController extends Controller
{
    /**
     * Ambil guru yang sedang login. Abort 403 jika tidak terhubung ke data guru.
     */
    private function getGuru()
    {
        $guru = Auth::user()->guru;
        abort_if(! $guru, 403, 'Akun Anda tidak terhubung dengan data guru.');
        return $guru;
    }

    /**
     * Ambil semua kelas_id yang diajar guru ini (lintas tahun ajaran, unique).
     * Menggunakan eager-loaded guru agar tidak double query.
     */
    private function getKelasIds($guru): \Illuminate\Support\Collection
    {
        return JadwalPelajaran::where('guru_id', $guru->id)
            ->pluck('kelas_id')
            ->unique()
            ->values();
    }

    /**
     * Daftar izin keluar siswa dari kelas yang diajar guru ini.
     */
    public function index(Request $request)
    {
        $guru     = $this->getGuru();
        $kelasIds = $this->getKelasIds($guru);

        // Daftar kelas untuk filter dropdown
        $kelasList = Kelas::whereIn('id', $kelasIds)
            ->orderBy('nama_kelas')
            ->get();

        // Base query: hanya siswa yang kelasnya ada di daftar kelas guru
        $query = IzinKeluarSiswa::with([
                'siswa.kelas',
                'tahunAjaran',
                'diprosesOleh',
                'dicatatKembaliOleh',
            ])
            ->whereHas('siswa', fn ($q) => $q->whereIn('kelas_id', $kelasIds));

        // ── Filter ────────────────────────────────────────────────────────────

        if ($request->filled('kelas_id')) {
            $kelas = (int) $request->kelas_id;
            // Pastikan kelas yang diminta memang ada di daftar kelas guru
            abort_unless($kelasIds->contains($kelas), 403);
            $query->whereHas('siswa', fn ($q) => $q->where('kelas_id', $kelas));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        }

        if ($request->filled('search')) {
            $cari = $request->search;
            $query->whereHas('siswa', fn ($q) =>
                $q->where('nama_lengkap', 'like', "%{$cari}%")
                  ->orWhere('nis', 'like', "%{$cari}%")
            );
        }

        $izinList = $query
            ->orderByDesc('tanggal')
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        // ── Rekap stats hari ini ──────────────────────────────────────────────
        // Re-query setiap status agar tidak ada bug clone builder.
        $baseToday = fn () => IzinKeluarSiswa::whereHas('siswa', fn ($q) => $q->whereIn('kelas_id', $kelasIds))
            ->whereDate('tanggal', today());

        $rekap = [
            'menunggu'      => $baseToday()->where('status', IzinKeluarSiswa::STATUS_MENUNGGU)->count(),
            'disetujui'     => $baseToday()->where('status', IzinKeluarSiswa::STATUS_DISETUJUI)->count(),
            'sudah_kembali' => $baseToday()->where('status', IzinKeluarSiswa::STATUS_SUDAH_KEMBALI)->count(),
            'ditolak'       => $baseToday()->where('status', IzinKeluarSiswa::STATUS_DITOLAK)->count(),
        ];

        $statusList   = IzinKeluarSiswa::STATUS_LIST;
        $kategoriList = IzinKeluarSiswa::KATEGORI_LIST;

        return view('guru.izin-keluar-siswa.index', compact(
            'izinList', 'kelasList', 'statusList', 'kategoriList', 'rekap'
        ));
    }

    /**
     * Detail satu izin keluar siswa.
     * Guru hanya bisa melihat izin siswa dari kelas yang dia ajar.
     */
    public function show(IzinKeluarSiswa $izin)
    {
        $guru     = $this->getGuru();
        $kelasIds = $this->getKelasIds($guru);

        // Load relasi dulu agar $izin->siswa tidak null saat di-check
        $izin->load(['siswa.kelas', 'tahunAjaran', 'diprosesOleh', 'dicatatKembaliOleh']);

        // Guard: siswa harus ada dan kelasnya termasuk kelas yang diajar guru ini
        abort_if(
            ! $izin->siswa || ! $kelasIds->contains($izin->siswa->kelas_id),
            403,
            'Anda tidak memiliki akses ke data izin ini.'
        );

        return view('guru.izin-keluar-siswa.show', compact('izin'));
    }
}