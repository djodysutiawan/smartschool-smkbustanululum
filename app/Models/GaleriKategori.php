<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class GaleriKategori extends Model
{
    protected $table = 'galeri_kategori';

    protected $fillable = [
        'nama', 'slug', 'deskripsi',
        'thumbnail_path', 'thumbnail_url',
        'tipe', 'is_published', 'urutan', 'created_by',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'urutan'       => 'integer',
    ];

    // ── Relasi ────────────────────────────────────────────────────────────
    public function foto(): HasMany
    {
        return $this->hasMany(GaleriFoto::class, 'galeri_kategori_id')->orderBy('urutan');
    }

    public function video(): HasMany
    {
        return $this->hasMany(GaleriVideo::class, 'galeri_kategori_id')->orderBy('urutan');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // ── Scopes ────────────────────────────────────────────────────────────
    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderBy('urutan');
    }

    public function scopeTipe($query, string $tipe)
    {
        return $query->where('tipe', $tipe)->orWhere('tipe', 'semua');
    }

    // ── Accessors ─────────────────────────────────────────────────────────
    public function getThumbnailSrcAttribute(): ?string
    {
        if ($this->thumbnail_path) return Storage::url($this->thumbnail_path);
        return $this->thumbnail_url;
    }
}