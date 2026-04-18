<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;

    protected $table = 'notifikasi';

    protected $fillable = [
        'pengguna_id', 'judul', 'pesan', 'jenis', 'url_tujuan', 'sudah_dibaca', 'dibaca_pada',
    ];

    protected function casts(): array
    {
        return [
            'sudah_dibaca' => 'boolean',
            'dibaca_pada'  => 'datetime',
        ];
    }

    public function scopeBelumDibaca($query)
    {
        return $query->where('sudah_dibaca', false);
    }

    public function tandaiDibaca(): void
    {
        $this->update(['sudah_dibaca' => true, 'dibaca_pada' => now()]);
    }

    public static function kirim(int $penggunaId, string $judul, string $pesan, string $jenis, ?string $url = null): self
    {
        return static::create([
            'pengguna_id' => $penggunaId,
            'judul'       => $judul,
            'pesan'       => $pesan,
            'jenis'       => $jenis,
            'url_tujuan'  => $url,
        ]);
    }

    public function pengguna()
    {
        return $this->belongsTo(User::class, 'pengguna_id');
    }
}
