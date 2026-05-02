<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class BeritaPublik extends Model
{
    protected $table = 'berita_publik';
 
    protected $fillable = [
        'berita_kategori_id', 'judul', 'slug', 'ringkasan', 'konten',
        'thumbnail_path', 'thumbnail_url', 'thumbnail_alt',
        'meta_title', 'meta_description', 'tags',
        'author_id', 'nama_penulis',
        'status', 'published_at', 'views',
        'is_featured', 'allow_comment',
    ];
 
    protected $casts = [
        'published_at'  => 'datetime',
        'views'         => 'integer',
        'is_featured'   => 'boolean',
        'allow_comment' => 'boolean',
    ];
 
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(BeritaKategori::class, 'berita_kategori_id');
    }
 
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }
 
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                     ->where('published_at', '<=', now())
                     ->orderByDesc('published_at');
    }
 
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->published();
    }
 
    public function getThumbnailSrcAttribute(): ?string
    {
        if ($this->thumbnail_path) return Storage::url($this->thumbnail_path);
        return $this->thumbnail_url;
    }
 
    public function getTagsArrayAttribute(): array
    {
        return $this->tags ? array_map('trim', explode(',', $this->tags)) : [];
    }
 
    /**
     * Increment view counter (call dari controller show).
     */
    public function incrementViews(): void
    {
        $this->increment('views');
    }
}
