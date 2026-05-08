<?php

namespace App\Http\Traits;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * CascadeDropdownTrait
 *
 * Digunakan oleh: MateriController, TugasController, UjianController, JurnalMengajarController
 *
 * Menyediakan helper untuk cascade dropdown:
 * - Mapel berdasarkan guru (via pivot guru_mata_pelajaran)
 * - Kelas berdasarkan guru (via jadwal_pelajaran)
 *
 * Fallback: jika guru tidak punya data di pivot/jadwal, kembalikan semua data aktif.
 */
trait CascadeDropdownTrait
{
    /**
     * Ambil mata pelajaran yang diampu guru via pivot guru_mata_pelajaran.
     * Fallback ke semua mapel aktif jika pivot kosong.
     *
     * @param int $guruId
     * @return Collection  [{ id, nama_mapel, kode_mapel }]
     */
    protected function getMapelByGuru(int $guruId): Collection
    {
        $guru = Guru::find($guruId);

        if (! $guru) {
            return MataPelajaran::aktif()
                ->orderBy('nama_mapel')
                ->get(['id', 'nama_mapel', 'kode_mapel']);
        }

        try {
            $mapel = $guru->mataPelajaran()
                ->where('guru_mata_pelajaran.is_active', true)
                ->where('mata_pelajaran.is_active', true)
                ->orderBy('nama_mapel')
                ->get(['mata_pelajaran.id', 'mata_pelajaran.nama_mapel', 'mata_pelajaran.kode_mapel']);
        } catch (\Exception) {
            $mapel = collect();
        }

        if ($mapel->isEmpty()) {
            return MataPelajaran::aktif()
                ->orderBy('nama_mapel')
                ->get(['id', 'nama_mapel', 'kode_mapel']);
        }

        return $mapel;
    }

    /**
     * Ambil kelas yang diajar guru via jadwal_pelajaran aktif.
     * Fallback ke semua kelas aktif jika tidak ada jadwal.
     *
     * @param int $guruId
     * @return Collection  [{ id, nama_kelas, tingkat, kode_kelas }]
     */
    protected function getKelasByGuru(int $guruId): Collection
    {
        $kelasIds = DB::table('jadwal_pelajaran')
            ->where('guru_id', $guruId)
            ->where('is_active', true)
            ->pluck('kelas_id')
            ->unique();

        if ($kelasIds->isNotEmpty()) {
            $kelas = Kelas::whereIn('id', $kelasIds)
                ->where('status', 'aktif')
                ->orderBy('nama_kelas')
                ->get(['id', 'nama_kelas', 'tingkat', 'kode_kelas']);

            if ($kelas->isNotEmpty()) {
                return $kelas;
            }
        }

        return Kelas::aktif()
            ->orderBy('nama_kelas')
            ->get(['id', 'nama_kelas', 'tingkat', 'kode_kelas']);
    }

    /**
     * Validasi silang: mapel & kelas wajib sesuai guru yang dipilih.
     * Lempar ValidationException jika tidak sesuai.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateGuruRelasi(int $guruId, int $mapelId, int $kelasId): void
    {
        $guru = Guru::findOrFail($guruId);

        // Cek mapel via pivot guru_mata_pelajaran
        $mapelValid = $guru->mataPelajaran()
            ->where('mata_pelajaran.id', $mapelId)
            ->where('guru_mata_pelajaran.is_active', true)
            ->exists();

        // Fallback: jika guru tidak punya pivot sama sekali,
        // anggap valid (admin bisa input semua mapel)
        if (! $mapelValid) {
            $pivotCount = $guru->mataPelajaran()
                ->where('guru_mata_pelajaran.is_active', true)
                ->count();

            if ($pivotCount > 0) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'mata_pelajaran_id' => 'Mata pelajaran yang dipilih tidak sesuai dengan guru ini.',
                ]);
            }
        }

        // Cek kelas via jadwal_pelajaran
        $kelasValid = Kelas::where('id', $kelasId)
            ->whereHas('jadwalPelajaran', function ($q) use ($guruId) {
                $q->where('guru_id', $guruId)
                  ->where('is_active', true);
            })
            ->exists();

        // Fallback: jika guru tidak punya jadwal sama sekali, anggap valid
        if (! $kelasValid) {
            $jadwalCount = DB::table('jadwal_pelajaran')
                ->where('guru_id', $guruId)
                ->where('is_active', true)
                ->count();

            if ($jadwalCount > 0) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'kelas_id' => 'Kelas yang dipilih tidak sesuai dengan guru ini.',
                ]);
            }
        }
    }
}