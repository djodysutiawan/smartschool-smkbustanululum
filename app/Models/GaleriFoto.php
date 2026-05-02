<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class GaleriFoto extends Model
{
    protected $table = 'galeri_foto';

    protected $fillable = [
        'galeri_kategori_id', 'judul', 'keterangan',
        'foto_path', 'foto_url', 'foto_thumbnail_path',
        'alt_text', 'sumber', 'tanggal_foto',
        'is_published', 'is_featured', 'urutan', 'uploaded_by',
    ];

    protected $casts = [
        'tanggal_foto'  => 'date',
        'is_published'  => 'boolean',
        'is_featured'   => 'boolean',
        'urutan'        => 'integer',
    ];

    // ── Relasi ────────────────────────────────────────────────────────────
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(GaleriKategori::class, 'galeri_kategori_id');
    }

    public function uploadedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    // ── Scopes ────────────────────────────────────────────────────────────
    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderBy('urutan');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->where('is_published', true);
    }

    // ── Accessors ─────────────────────────────────────────────────────────
    public function getFotoSrcAttribute(): ?string
    {
        if ($this->foto_path) return Storage::url($this->foto_path);
        return $this->foto_url;
    }

    public function getThumbnailSrcAttribute(): ?string
    {
        if ($this->foto_thumbnail_path) return Storage::url($this->foto_thumbnail_path);
        return $this->getFotoSrcAttribute(); // fallback ke foto asli
    }
}