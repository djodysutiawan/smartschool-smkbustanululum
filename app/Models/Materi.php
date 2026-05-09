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

    /**
     * FIX: Daftar nilai jenis yang valid — digunakan untuk validasi & view guard.
     */
    const JENIS_VALID = [
        self::JENIS_FILE,
        self::JENIS_VIDEO,
        self::JENIS_LINK,
        self::JENIS_TEKS,
    ];

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
        'konten_teks',         // FIX: kolom dedicated untuk konten teks (bukan url_eksternal)
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
            // FIX: cast FK ke integer agar perbandingan strict (===) tidak gagal
            'guru_id'            => 'integer',
            'mata_pelajaran_id'  => 'integer',
            'kelas_id'           => 'integer',
            'tahun_ajaran_id'    => 'integer',
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

    /**
     * FIX: Helper untuk memeriksa apakah jenis konten valid.
     */
    public function isJenisValid(): bool
    {
        return in_array($this->jenis, self::JENIS_VALID, strict: true);
    }

    // ── Accessors ─────────────────────────────────────────────────────────────

    /**
     * URL akses konten materi:
     * - link  → url_eksternal
     * - video → url_eksternal (embed YouTube/Vimeo) atau storage path_file
     * - file  → URL storage
     * - teks  → null (konten ada di kolom konten_teks)
     *
     * FIX: Mengembalikan null secara eksplisit untuk jenis teks agar
     * view tidak salah mengambil url_eksternal sebagai konten teks.
     */
    public function getFileUrlAttribute(): ?string
    {
        return match ($this->jenis) {
            self::JENIS_LINK,
            self::JENIS_VIDEO => $this->url_eksternal
                ?: ($this->path_file ? asset('storage/' . $this->path_file) : null),

            self::JENIS_FILE  => $this->path_file
                ? asset('storage/' . $this->path_file)
                : null,

            default => null, // teks: tidak ada file/url
        };
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

    /**
     * FIX: Accessor untuk konten teks — fallback ke url_eksternal jika
     * kolom konten_teks belum tersedia (migrasi lama).
     * Prioritas: konten_teks > url_eksternal > null.
     */
    public function getKontenTeksDisplayAttribute(): ?string
    {
        if ($this->jenis !== self::JENIS_TEKS) {
            return null;
        }

        return $this->konten_teks
            ?? $this->url_eksternal
            ?? null;
    }

    /**
     * FIX: Ekstrak YouTube video ID dari berbagai format URL.
     * Mendukung: watch?v=, youtu.be/, /shorts/, /embed/, /live/
     */
    public function getYoutubeIdAttribute(): ?string
    {
        $url = $this->url_eksternal;
        if (! $url) {
            return null;
        }

        // Pattern komprehensif untuk berbagai format YouTube URL
        $pattern = '/(?:youtube\.com\/(?:watch\?(?:.*&)?v=|shorts\/|embed\/|live\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';

        if (preg_match($pattern, $url, $matches)) {
            return $matches[1];
        }

        return null;
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