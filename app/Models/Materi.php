<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Materi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'materi';

    /**
     * Jenis konten yang didukung.
     */
    const JENIS_FILE  = 'file';
    const JENIS_VIDEO = 'video';
    const JENIS_LINK  = 'link';
    const JENIS_TEKS  = 'teks';

    protected $fillable = [
        'guru_id',
        'mata_pelajaran_id',
        'kelas_id',
        'tahun_ajaran_id',
        'judul',
        'deskripsi',
        'jenis',               // file | video | link | teks
        'path_file',
        'url_eksternal',
        'thumbnail',
        'urutan',
        'dipublikasikan',
        'dipublikasikan_pada',
    ];

    protected function casts(): array
    {
        return [
            'dipublikasikan'     => 'boolean',
            'dipublikasikan_pada'=> 'datetime',
            'urutan'             => 'integer',
        ];
    }

    // ── Scopes ─────────────────────────────────────────────────────────────────

    public function scopeDipublikasikan($query)
    {
        return $query->where('dipublikasikan', true);
    }

    // ── Business Logic ─────────────────────────────────────────────────────────

    public function publish(): void
    {
        $this->update([
            'dipublikasikan'     => true,
            'dipublikasikan_pada'=> now(),
        ]);
    }

    public function unpublish(): void
    {
        $this->update([
            'dipublikasikan'     => false,
            'dipublikasikan_pada'=> null,
        ]);
    }

    // ── Accessors ─────────────────────────────────────────────────────────────

    /**
     * URL akses konten materi:
     * - link  → url_eksternal
     * - video → url_eksternal (embed YouTube/Vimeo) atau path_file
     * - file  → URL storage
     * - teks  → null (konten ada di deskripsi)
     */
    public function getFileUrlAttribute(): ?string
    {
        if ($this->jenis === self::JENIS_LINK || $this->jenis === self::JENIS_VIDEO) {
            return $this->url_eksternal ?: ($this->path_file ? asset('storage/' . $this->path_file) : null);
        }

        return $this->path_file ? asset('storage/' . $this->path_file) : null;
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->thumbnail
            ? asset('storage/' . $this->thumbnail)
            : null;
    }

    public function getLabelJenisAttribute(): string
    {
        return match ($this->jenis) {
            self::JENIS_FILE  => 'File',
            self::JENIS_VIDEO => 'Video',
            self::JENIS_LINK  => 'Link Eksternal',
            self::JENIS_TEKS  => 'Teks',
            default           => ucfirst($this->jenis ?? '-'),
        };
    }

    // ── Relationships ──────────────────────────────────────────────────────────

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class);
    }

    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }

    public function tahunAjaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class);
    }
}