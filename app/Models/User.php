<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable, SoftDeletes;

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

    // ── Relasi ─────────────────────────────────────────────────────────────

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

    // ── Helper methods ─────────────────────────────────────────────────────

    public function isAdmin(): bool    { return $this->role === 'admin'; }
    public function isGuru(): bool     { return $this->role === 'guru'; }
    public function isSiswa(): bool    { return $this->role === 'siswa'; }
    public function isOrangTua(): bool { return $this->role === 'orang_tua'; }

    public function updateLastLogin(): void
    {
        $this->update(['last_login_at' => now()]);
    }

    // ── Accessors ──────────────────────────────────────────────────────────

    /**
     * Return URL publik avatar.
     * File disimpan di storage/app/public/avatars/xxx.png
     * → public URL: APP_URL/storage/avatars/xxx.png
     *
     * Storage::disk('public')->url() otomatis pakai APP_URL dari .env,
     * sehingga konsisten dengan apapun yang diset (localhost atau 127.0.0.1).
     */
    public function getAvatarUrlAttribute(): ?string
    {
        if (! $this->avatar) {
            return null;
        }

        return asset('storage/' . $this->avatar);
    }
}