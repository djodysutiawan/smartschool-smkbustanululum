<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = [
        'nama_kelas', 'tingkat', 'jurusan', 'kode_kelas',
        'wali_kelas_id', 'ruang_id', 'tahun_ajaran_id', 'kapasitas_maks', 'status',
    ];

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeTingkat($query, string $tingkat)
    {
        return $query->where('tingkat', $tingkat);
    }

    public function isAktif(): bool
    {
        return $this->status === 'aktif';
    }

    public function isSudahPenuh(): bool
    {
        return $this->siswa()->count() >= $this->kapasitas_maks;
    }

    public function waliKelas()
    {
        return $this->belongsTo(Guru::class, 'wali_kelas_id');
    }

    public function ruang()
    {
        return $this->belongsTo(Ruang::class);
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }

    public function jadwalPelajaran()
    {
        return $this->hasMany(JadwalPelajaran::class);
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }

    public function materi()
    {
        return $this->hasMany(Materi::class);
    }

    public function tugas()
    {
        return $this->hasMany(Tugas::class);
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }
}
