<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * Model BarcodeGerbang
 * ─────────────────────────────────────────────────────────────────────────────
 * Barcode TETAP per siswa untuk sistem absensi gerbang.
 * Satu siswa hanya boleh punya satu barcode aktif (is_aktif = true).
 * Barcode lama dinonaktifkan, bukan dihapus, agar riwayat scan tetap valid.
 *
 * @property int         $id
 * @property int         $siswa_id
 * @property string      $kode
 * @property bool        $is_aktif
 * @property \Carbon\Carbon $berlaku_mulai
 * @property \Carbon\Carbon|null $berlaku_sampai
 * @property string|null $keterangan
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 */
class BarcodeGerbang extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'barcode_gerbang';

    protected $fillable = [
        'siswa_id',
        'kode',
        'is_aktif',
        'berlaku_mulai',
        'berlaku_sampai',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'is_aktif'       => 'boolean',
            'berlaku_mulai'  => 'date',
            'berlaku_sampai' => 'date',
        ];
    }

    // ── Scopes ────────────────────────────────────────────────────────────────

    /** Hanya barcode yang sedang aktif */
    public function scopeAktif($query)
    {
        return $query->where('is_aktif', true);
    }

    /** Hanya barcode yang sudah dinonaktifkan */
    public function scopeNonaktif($query)
    {
        return $query->where('is_aktif', false);
    }

    /** Barcode yang masih berlaku hari ini berdasarkan tanggal berlaku */
    public function scopeBerlakuHariIni($query)
    {
        $today = now()->toDateString();
        return $query
            ->where('berlaku_mulai', '<=', $today)
            ->where(function ($q) use ($today) {
                $q->whereNull('berlaku_sampai')
                  ->orWhere('berlaku_sampai', '>=', $today);
            });
    }

    // ── Static Helpers ────────────────────────────────────────────────────────

    /**
     * Generate kode barcode unik.
     * Format: SIS-{NIS}-{YYYY} atau fallback ke SIS-{random}
     *
     * @param  Siswa  $siswa
     * @return string
     */
    public static function generateKode(Siswa $siswa): string
    {
        $tahun = now()->year;
        $base  = 'SIS-' . $siswa->nis . '-' . $tahun;

        // Pastikan unik
        if (! static::withTrashed()->where('kode', $base)->exists()) {
            return $base;
        }

        // Fallback: tambahkan suffix random jika kode sudah ada
        do {
            $kode = $base . '-' . strtoupper(Str::random(4));
        } while (static::withTrashed()->where('kode', $kode)->exists());

        return $kode;
    }

    /**
     * Buat barcode baru untuk siswa (nonaktifkan yang lama otomatis).
     * Gunakan method ini alih-alih create() langsung.
     *
     * @param  Siswa       $siswa
     * @param  array       $extra  Override nilai default (berlaku_mulai, keterangan, dll.)
     * @return static
     */
    public static function buatUntukSiswa(Siswa $siswa, array $extra = []): static
    {
        // Nonaktifkan semua barcode lama milik siswa ini
        static::where('siswa_id', $siswa->id)
              ->where('is_aktif', true)
              ->update(['is_aktif' => false]);

        return static::create(array_merge([
            'siswa_id'      => $siswa->id,
            'kode'          => static::generateKode($siswa),
            'is_aktif'      => true,
            'berlaku_mulai' => now()->toDateString(),
        ], $extra));
    }

    // ── Accessors ─────────────────────────────────────────────────────────────

    /** Apakah barcode ini masih berlaku hari ini? */
    public function getMasihBerlakuAttribute(): bool
    {
        if (! $this->is_aktif) return false;

        $today = now()->toDateString();

        if ($this->berlaku_mulai->toDateString() > $today) return false;

        if ($this->berlaku_sampai && $this->berlaku_sampai->toDateString() < $today) {
            return false;
        }

        return true;
    }

    /** Label status barcode */
    public function getLabelStatusAttribute(): string
    {
        if (! $this->is_aktif)          return 'Nonaktif';
        if (! $this->masih_berlaku)     return 'Kadaluarsa';
        return 'Aktif';
    }

    // ── Relations ─────────────────────────────────────────────────────────────

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    /** Semua log scan yang menggunakan barcode ini */
    public function absensiGerbang(): HasMany
    {
        return $this->hasMany(AbsensiGerbang::class);
    }
}