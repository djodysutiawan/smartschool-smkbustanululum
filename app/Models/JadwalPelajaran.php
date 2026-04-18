<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPelajaran extends Model
{
    use HasFactory;

    protected $table = 'jadwal_pelajaran';

    protected $fillable = [
        'tahun_ajaran_id', 'guru_id', 'mata_pelajaran_id', 'kelas_id', 'ruang_id',
        'hari', 'jam_mulai', 'jam_selesai', 'pertemuan_ke', 'sumber_jadwal', 'is_active',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeHari($query, string $hari)
    {
        return $query->where('hari', $hari);
    }

    public function getDurasiMenitAttribute(): int
    {
        return (int) \Carbon\Carbon::parse($this->jam_mulai)->diffInMinutes($this->jam_selesai);
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
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
        return $this->belongsTo(Kelas::class);
    }

    public function ruang()
    {
        return $this->belongsTo(Ruang::class);
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }

    public function jurnal()
    {
        return $this->hasMany(JurnalMengajar::class);
    }
}
