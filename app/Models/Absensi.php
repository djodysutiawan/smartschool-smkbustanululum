<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';

    protected $fillable = [
        'siswa_id', 'kelas_id', 'jadwal_pelajaran_id', 'dicatat_oleh',
        'tanggal', 'status', 'metode', 'jam_masuk', 'jam_keluar', 'keterangan', 'path_surat_izin',
    ];

    protected function casts(): array
    {
        return ['tanggal' => 'date'];
    }

    public function isHadir(): bool
    {
        return in_array($this->status, ['hadir', 'telat']);
    }

    public function isTidakHadir(): bool
    {
        return in_array($this->status, ['izin', 'sakit', 'alfa']);
    }

    public function getSuratIzinUrlAttribute(): ?string
    {
        return $this->path_surat_izin ? asset('storage/' . $this->path_surat_izin) : null;
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function jadwalPelajaran()
    {
        return $this->belongsTo(JadwalPelajaran::class);
    }

    public function dicatatOleh()
    {
        return $this->belongsTo(User::class, 'dicatat_oleh');
    }
}
