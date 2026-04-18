<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPiketGuru extends Model
{
    use HasFactory;

    protected $table = 'jadwal_piket_guru';

    protected $fillable = [
        'guru_id', 'tahun_ajaran_id', 'hari', 'jam_mulai', 'jam_selesai', 'catatan', 'is_active',
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

    public static function getPiketHariIni()
    {
        $hari = strtolower(now()->locale('id')->dayName);
        return static::aktif()->hari($hari)->with('guru')->get();
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }
}
