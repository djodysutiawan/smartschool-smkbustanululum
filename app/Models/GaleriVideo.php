<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class GaleriVideo extends Model
{
    protected $table = 'galeri_video';

    protected $fillable = [
        'galeri_kategori_id', 'judul', 'deskripsi',
        'tipe_sumber', 'video_path', 'video_url',
        'video_embed_id', 'video_embed_url',
        'thumbnail_path', 'thumbnail_url',
        'durasi', 'tanggal_video', 'sumber',
        'is_published', 'is_featured', 'urutan', 'uploaded_by',
    ];

    protected $casts = [
        'tanggal_video' => 'date',
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

    /**
     * Thumbnail: custom upload → URL kustom → auto dari YouTube API.
     */
    public function getThumbnailSrcAttribute(): ?string
    {
        if ($this->thumbnail_path) return Storage::url($this->thumbnail_path);
        if ($this->thumbnail_url)  return $this->thumbnail_url;
        // Auto-generate thumbnail YouTube
        if ($this->tipe_sumber === 'youtube' && $this->video_embed_id) {
            return "https://img.youtube.com/vi/{$this->video_embed_id}/hqdefault.jpg";
        }
        return null;
    }

    /**
     * URL embed siap pakai untuk iframe.
     */
    public function getEmbedSrcAttribute(): ?string
    {
        if ($this->video_embed_url) return $this->video_embed_url;

        return match ($this->tipe_sumber) {
            'youtube' => $this->video_embed_id
                ? "https://www.youtube.com/embed/{$this->video_embed_id}"
                : null,
            'vimeo'   => $this->video_embed_id
                ? "https://player.vimeo.com/video/{$this->video_embed_id}"
                : null,
            'upload'  => $this->video_path ? Storage::url($this->video_path) : null,
            default   => $this->video_url,
        };
    }

    /**
     * Ekstrak YouTube ID dari berbagai format URL secara otomatis saat disimpan.
     */
    public static function extractYoutubeId(string $url): ?string
    {
        preg_match(
            '/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([A-Za-z0-9_-]{11})/',
            $url,
            $m
        );
        return $m[1] ?? null;
    }

    // ── Boot: auto-extract embed ID ───────────────────────────────────────
    protected static function booted(): void
    {
        static::saving(function (GaleriVideo $video) {
            if ($video->tipe_sumber === 'youtube' && $video->video_url && !$video->video_embed_id) {
                $video->video_embed_id  = static::extractYoutubeId($video->video_url);
                $video->video_embed_url = $video->video_embed_id
                    ? "https://www.youtube.com/embed/{$video->video_embed_id}"
                    : null;
            }
            if ($video->tipe_sumber === 'vimeo' && $video->video_url && !$video->video_embed_id) {
                preg_match('/vimeo\.com\/(\d+)/', $video->video_url, $m);
                $video->video_embed_id  = $m[1] ?? null;
                $video->video_embed_url = $video->video_embed_id
                    ? "https://player.vimeo.com/video/{$video->video_embed_id}"
                    : null;
            }
        });
    }
}