<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\IzinKeluarSiswa;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruIzinController extends Controller
{
    /**
     * Ambil semua kelas yang diajar oleh guru yang sedang login.
     */
    private function getKelasIds(): \Illuminate\Support\Collection
    {
        $guru = Auth::user()->guru;
        abort_if(! $guru, 403, 'Akun Anda tidak terhubung dengan data guru.');

        return JadwalPelajaran::where('guru_id', $guru->id)
            ->pluck('kelas_id')
            ->unique();
    }

    /**
     * Daftar izin keluar siswa dari kelas yang diajar guru ini.
     */
    public function index(Request $request)
    {
        $kelasIds  = $this->getKelasIds();
        $kelasList = Kelas::aktif()->whereIn('id', $kelasIds)->orderBy('nama_kelas')->get();

        $query = IzinKeluarSiswa::with(['siswa.kelas', 'tahunAjaran', 'diprosesOleh'])
            ->whereHas('siswa', fn ($q) => $q->whereIn('kelas_id', $kelasIds));

        // Filter kelas
        if ($request->filled('kelas_id')) {
            $query->whereHas('siswa', fn ($q) => $q->where('kelas_id', $request->kelas_id));
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter tanggal dari
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        }

        // Filter tanggal sampai
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        }

        // Filter pencarian nama siswa
        if ($request->filled('search')) {
            $query->whereHas('siswa', fn ($q) =>
                $q->where('nama_lengkap', 'like', "%{$request->search}%")
            );
        }

        $izinList = $query->orderByDesc('tanggal')->orderByDesc('created_at')
            ->paginate(20)->withQueryString();

        // Stats ringkasan
        $baseStats = IzinKeluarSiswa::whereHas('siswa', fn ($q) => $q->whereIn('kelas_id', $kelasIds));
        $rekap = [
            'menunggu'      => (clone $baseStats)->whereDate('tanggal', today())->where('status', IzinKeluarSiswa::STATUS_MENUNGGU)->count(),
            'disetujui'     => (clone $baseStats)->whereDate('tanggal', today())->where('status', IzinKeluarSiswa::STATUS_DISETUJUI)->count(),
            'sudah_kembali' => (clone $baseStats)->whereDate('tanggal', today())->where('status', IzinKeluarSiswa::STATUS_SUDAH_KEMBALI)->count(),
            'ditolak'       => (clone $baseStats)->whereDate('tanggal', today())->where('status', IzinKeluarSiswa::STATUS_DITOLAK)->count(),
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
        $kelasIds = $this->getKelasIds();

        // Pastikan siswa yang mengajukan izin ada di kelas yang diajar guru ini
        abort_unless(
            $kelasIds->contains($izin->siswa->kelas_id ?? null),
            403,
            'Anda tidak memiliki akses ke data izin ini.'
        );

        $izin->load(['siswa.kelas', 'tahunAjaran', 'diprosesOleh', 'dicatatKembaliOleh']);

        return view('guru.izin-keluar-siswa.show', compact('izin'));
    }
}