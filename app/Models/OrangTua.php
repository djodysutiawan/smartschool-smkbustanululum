<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrangTua extends Model
{
    use HasFactory;

    protected $table = 'orang_tua';

    protected $fillable = [
        'pengguna_id', 'nama_lengkap', 'no_hp', 'email', 'alamat', 'pekerjaan',
    ];

    public function pengguna()
    {
        return $this->belongsTo(User::class, 'pengguna_id');
    }

    public function siswa()
    {
        return $this->belongsToMany(Siswa::class, 'siswa_orang_tua', 'orang_tua_id', 'siswa_id')
            ->withPivot('hubungan', 'kontak_utama')
            ->withTimestamps();
    }

    public function getKontakUtamaAttribute(): ?Siswa
    {
        return $this->siswa()->wherePivot('kontak_utama', true)->first();
    }

    public function getHasAkunAttribute(): bool
    {
        return !is_null($this->pengguna_id);
    }
}