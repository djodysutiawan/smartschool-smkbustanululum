<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tugas extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'guru_id', 'mata_pelajaran_id', 'kelas_id', 'tahun_ajaran_id',
        'judul', 'deskripsi', 'path_file_soal', 'jenis_pengumpulan',
        'batas_waktu', 'nilai_maksimal', 'izinkan_terlambat', 'dipublikasikan',
    ];

    protected function casts(): array
    {
        return [
            'batas_waktu'      => 'datetime',
            'izinkan_terlambat'=> 'boolean',
            'dipublikasikan'   => 'boolean',
        ];
    }

    public function scopeDipublikasikan($query)
    {
        return $query->where('dipublikasikan', true);
    }

    public function isTelahBerakhir(): bool
    {
        return now()->isAfter($this->batas_waktu);
    }

    public function isMasihBisaDikumpulkan(): bool
    {
        if (!$this->isTelahBerakhir()) return true;
        return $this->izinkan_terlambat;
    }

    public function getFileSoalUrlAttribute(): ?string
    {
        return $this->path_file_soal ? asset('storage/' . $this->path_file_soal) : null;
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class)->withDefault();
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function pengumpulan()
    {
        return $this->hasMany(PengumpulanTugas::class);
    }

    public function pengumpulanSiswa(int $siswaId)
    {
        return $this->pengumpulan()->where('siswa_id', $siswaId)->first();
    }

    public function getJumlahTerkumpulAttribute(): int
    {
        return $this->pengumpulan()->where('status', '!=', 'belum_dikumpulkan')->count();
    }
}
