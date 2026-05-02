<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Jurusan extends Model
{
    protected $table = 'jurusan';

    protected $fillable = [
        'nama', 'singkatan', 'slug', 'kode_jurusan',
        'bidang_keahlian', 'program_keahlian', 'kompetensi_keahlian',
        'deskripsi_singkat', 'deskripsi_lengkap', 'tujuan_jurusan',
        'foto_cover_path', 'foto_cover_url', 'logo_path', 'logo_url',
        'lama_belajar', 'akreditasi', 'kapasitas_per_kelas',
        'jumlah_kelas_aktif', 'total_siswa',
        'nama_kajur', 'foto_kajur_path', 'foto_kajur_url',
        'is_published', 'is_penerimaan_buka', 'urutan', 'created_by',
    ];

    protected $casts = [
        'lama_belajar'         => 'integer',
        'kapasitas_per_kelas'  => 'integer',
        'jumlah_kelas_aktif'   => 'integer',
        'total_siswa'          => 'integer',
        'is_published'         => 'boolean',
        'is_penerimaan_buka'   => 'boolean',
        'urutan'               => 'integer',
    ];

    // ── Relasi ────────────────────────────────────────────────────────────
    public function kurikulum(): HasMany
    {
        return $this->hasMany(JurusanKurikulum::class)->orderBy('urutan');
    }

    public function kompetensi(): HasMany
    {
        return $this->hasMany(JurusanKompetensi::class)->orderBy('urutan');
    }

    public function prospekKerja(): HasMany
    {
        return $this->hasMany(JurusanProspekKerja::class)->orderBy('urutan');
    }

    public function fasilitas(): HasMany
    {
        return $this->hasMany(JurusanFasilitas::class)->orderBy('urutan');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // ── Scopes ────────────────────────────────────────────────────────────
    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderBy('urutan');
    }

    public function scopePenerimaanBuka($query)
    {
        return $query->where('is_penerimaan_buka', true)->where('is_published', true);
    }

    // ── Accessors ─────────────────────────────────────────────────────────
    public function getFotoCoverSrcAttribute(): ?string
    {
        if ($this->foto_cover_path) return Storage::url($this->foto_cover_path);
        return $this->foto_cover_url;
    }

    public function getLogoSrcAttribute(): ?string
    {
        if ($this->logo_path) return Storage::url($this->logo_path);
        return $this->logo_url;
    }

    public function getFotoKajurSrcAttribute(): ?string
    {
        if ($this->foto_kajur_path) return Storage::url($this->foto_kajur_path);
        return $this->foto_kajur_url;
    }
}