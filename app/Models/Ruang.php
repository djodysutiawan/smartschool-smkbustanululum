<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruang extends Model
{
    use HasFactory;

    protected $table = 'ruang';

    protected $fillable = [
        'gedung_id', 'kode_ruang', 'nama_ruang', 'lantai', 'jenis_ruang',
        'kapasitas', 'ada_proyektor', 'ada_ac', 'ada_wifi', 'ada_komputer',
        'fasilitas_lain', 'status', 'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'ada_proyektor' => 'boolean',
            'ada_ac'        => 'boolean',
            'ada_wifi'      => 'boolean',
            'ada_komputer'  => 'boolean',
        ];
    }

    public function scopeTersedia($query)
    {
        return $query->where('status', 'tersedia');
    }

    public function scopeJenis($query, string $jenis)
    {
        return $query->where('jenis_ruang', $jenis);
    }

    public function isTersedia(): bool
    {
        return $this->status === 'tersedia';
    }

    public function gedung()
    {
        return $this->belongsTo(Gedung::class);
    }

    public function kelas()
    {
        return $this->hasMany(Kelas::class);
    }

    public function jadwalPelajaran()
    {
        return $this->hasMany(JadwalPelajaran::class);
    }

    public function isSibukPada(string $hari, string $jamMulai, int $tahunAjaranId): bool
    {
        return $this->jadwalPelajaran()
            ->where('hari', $hari)
            ->where('jam_mulai', $jamMulai)
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->where('is_active', true)
            ->exists();
    }
}
