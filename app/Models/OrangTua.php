<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;   // ← TAMBAHAN

class OrangTua extends Model
{
    use HasFactory, SoftDeletes;   // ← tambahkan SoftDeletes

    protected $table = 'orang_tua';

    protected $fillable = [
        'pengguna_id', 'nama_lengkap', 'no_hp', 'email', 'alamat', 'pekerjaan',
    ];

    // ─── Relasi ───────────────────────────────────────────────────────────────

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

    // ─── Accessor ─────────────────────────────────────────────────────────────

    /**
     * PERBAIKAN: accessor lama memanggil query baru setiap kali diakses
     * (N+1 problem). Sekarang pakai koleksi yang sudah di-load lewat
     * eager load (->with('siswa')) sehingga tidak ada query tambahan.
     *
     * Cara pakai di controller:
     *   $orangTua->load('siswa');
     *   $kontakUtama = $orangTua->kontak_utama; // tidak ada query baru
     */
    public function getKontakUtamaAttribute(): ?Siswa
    {
        // Gunakan koleksi yang sudah di-load, bukan query baru
        return $this->relationLoaded('siswa')
            ? $this->siswa->firstWhere('pivot.kontak_utama', true)
            : $this->siswa()->wherePivot('kontak_utama', true)->first();
    }

    public function getHasAkunAttribute(): bool
    {
        return !is_null($this->pengguna_id);
    }

    // ─── Scopes ───────────────────────────────────────────────────────────────

    /** TAMBAHAN: filter orang tua yang punya akun sistem */
    public function scopeDenganAkun($query)
    {
        return $query->whereNotNull('pengguna_id');
    }

    /** TAMBAHAN: filter orang tua yang belum punya akun sistem */
    public function scopeTanpaAkun($query)
    {
        return $query->whereNull('pengguna_id');
    }
}