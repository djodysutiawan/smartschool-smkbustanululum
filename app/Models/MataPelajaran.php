<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;

    protected $table = 'mata_pelajaran';

    protected $fillable = [
        'nama_mapel', 'kode_mapel', 'kelompok', 'jam_per_minggu',
        'durasi_per_sesi', 'perlu_lab', 'keterangan', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'perlu_lab' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }

    public function getTotalMenitPerMingguAttribute(): int
    {
        return $this->jam_per_minggu * $this->durasi_per_sesi;
    }

    public function jadwalPelajaran()
    {
        return $this->hasMany(JadwalPelajaran::class);
    }

    public function guru()
    {
        return $this->belongsToMany(Guru::class, 'jadwal_pelajaran');
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
