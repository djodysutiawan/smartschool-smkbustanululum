<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles;

    protected $fillable = [
        'name', 'email', 'password', 'role',
        'no_hp', 'avatar', 'is_active', 'last_login_at',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at'     => 'datetime',
            'is_active'         => 'boolean',
            'password'          => 'hashed',
        ];
    }

    public function guru()
    {
        return $this->hasOne(Guru::class, 'pengguna_id');
    }

    public function siswa()
    {
        return $this->hasOne(Siswa::class, 'pengguna_id');
    }

    public function orangTua()
    {
        return $this->hasOne(OrangTua::class, 'pengguna_id');
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class, 'pengguna_id');
    }

    public function notifikasiTidakTerbaca()
    {
        return $this->hasMany(Notifikasi::class, 'pengguna_id')
                    ->where('sudah_dibaca', false);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isGuru(): bool
    {
        return $this->role === 'guru';
    }

    public function isSiswa(): bool
    {
        return $this->role === 'siswa';
    }

    public function isOrangTua(): bool
    {
        return $this->role === 'orang_tua';
    }

    public function updateLastLogin(): void
    {
        $this->update(['last_login_at' => now()]);
    }

    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar
            ? asset('storage/' . $this->avatar)
            : asset('images/default-avatar.png');
    }
}