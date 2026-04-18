<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    use HasFactory;

    protected $table = 'tahun_ajaran';

    protected $fillable = [
        'tahun', 'semester', 'tanggal_mulai', 'tanggal_selesai', 'status', 'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai'   => 'date',
            'tanggal_selesai' => 'date',
        ];
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public static function getAktif(): ?self
    {
        return static::where('status', 'aktif')->first();
    }

    public function aktifkan(): void
    {
        static::where('id', '!=', $this->id)->update(['status' => 'tidak_aktif']);
        $this->update(['status' => 'aktif']);
    }

    public function isAktif(): bool
    {
        return $this->status === 'aktif';
    }

    public function getLabelAttribute(): string
    {
        return $this->tahun . ' — ' . ucfirst($this->semester);
    }

    public function getDurasiAttribute(): string
    {
        $bulan = $this->tanggal_mulai->diffInMonths($this->tanggal_selesai);
        return $bulan . ' bulan';
    }

    public function kelas()
    {
        return $this->hasMany(Kelas::class);
    }

    public function jadwalPelajaran()
    {
        return $this->hasMany(JadwalPelajaran::class);
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }
}