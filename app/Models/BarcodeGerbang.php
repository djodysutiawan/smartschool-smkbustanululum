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
 * @property int                  $id
 * @property int                  $siswa_id
 * @property string               $kode
 * @property bool                 $is_aktif
 * @property \Carbon\Carbon       $berlaku_mulai
 * @property \Carbon\Carbon|null  $berlaku_sampai
 * @property string|null          $keterangan
 * @property \Carbon\Carbon       $created_at
 * @property \Carbon\Carbon       $updated_at
 * @property \Carbon\Carbon|null  $deleted_at
 *
 * @property-read bool    $masih_berlaku
 * @property-read string  $label_status
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

    protected $casts = [
        'is_aktif'       => 'boolean',
        'berlaku_mulai'  => 'date',
        'berlaku_sampai' => 'date',
    ];

    // ── Scopes ────────────────────────────────────────────────────────────────

    /**
     * Hanya barcode yang is_aktif = true.
     */
    public function scopeAktif($query)
    {
        return $query->where('is_aktif', true);
    }

    /**
     * Hanya barcode yang is_aktif = false.
     */
    public function scopeNonaktif($query)
    {
        return $query->where('is_aktif', false);
    }

    /**
     * Barcode yang masa berlakunya mencakup hari ini.
     */
    public function scopeBerlakuHariIni($query)
    {
        return $query
            ->where('berlaku_mulai', '<=', today())
            ->where(function ($q) {
                $q->whereNull('berlaku_sampai')
                  ->orWhere('berlaku_sampai', '>=', today());
            });
    }

    /**
     * Barcode yang aktif DAN masa berlakunya mencakup hari ini.
     * Shortcut dari scopeAktif + scopeBerlakuHariIni.
     */
    public function scopeMasihBerlaku($query)
    {
        return $query->aktif()->berlakuHariIni();
    }

    // ── Static Helpers ────────────────────────────────────────────────────────

    /**
     * Generate kode barcode unik.
     *
     * Strategi: coba format pendek "SIS-{NIS}-{YYYY}" terlebih dahulu.
     * Jika sudah terpakai (termasuk yang soft-deleted), tambahkan suffix
     * random 4 karakter hingga benar-benar unik.
     *
     * Contoh output: SIS-202401001-2025  atau  SIS-202401001-2025-A3F9
     *
     * @param  Siswa  $siswa
     * @return string
     */
    public static function generateKode(Siswa $siswa): string
    {
        $base = implode('-', ['SIS', $siswa->nis ?? 'X', now()->year]);

        if (! static::withTrashed()->where('kode', $base)->exists()) {
            return $base;
        }

        do {
            $kode = $base . '-' . strtoupper(Str::random(4));
        } while (static::withTrashed()->where('kode', $kode)->exists());

        return $kode;
    }

    /**
     * Buat barcode baru untuk satu siswa.
     *
     * Semua barcode aktif milik siswa tersebut otomatis dinonaktifkan terlebih
     * dahulu, kemudian barcode baru dibuat dengan is_aktif = true.
     * Gunakan method ini alih-alih create() langsung agar invariant
     * "satu siswa, satu barcode aktif" selalu terjaga.
     *
     * @param  Siswa  $siswa
     * @param  array  $data   Override nilai default: berlaku_mulai, berlaku_sampai, keterangan
     * @return static
     */
    public static function buatUntukSiswa(Siswa $siswa, array $data = []): static
    {
        static::where('siswa_id', $siswa->id)
            ->where('is_aktif', true)
            ->update(['is_aktif' => false]);

        return static::create([
            'siswa_id'       => $siswa->id,
            'kode'           => static::generateKode($siswa),
            'is_aktif'       => true,
            'berlaku_mulai'  => $data['berlaku_mulai']  ?? today(),
            'berlaku_sampai' => $data['berlaku_sampai'] ?? null,
            'keterangan'     => $data['keterangan']     ?? null,
        ]);
    }

    // ── Accessors ─────────────────────────────────────────────────────────────

    /**
     * True jika barcode aktif DAN masa berlakunya mencakup hari ini.
     */
    public function getMasihBerlakuAttribute(): bool
    {
        if (! $this->is_aktif) {
            return false;
        }

        if ($this->berlaku_mulai && $this->berlaku_mulai->isAfter(today())) {
            return false;
        }

        if ($this->berlaku_sampai && $this->berlaku_sampai->isBefore(today())) {
            return false;
        }

        return true;
    }

    /**
     * Label status yang ramah untuk tampilan UI.
     *
     * Prioritas pengecekan:
     *   1. Dihapus (soft-deleted)  → "Dihapus"
     *   2. is_aktif = false        → "Nonaktif"
     *   3. Aktif & masa berlaku OK → "Aktif & Berlaku"
     *   4. Aktif tapi kadaluarsa  → "Kadaluarsa"
     */
    public function getLabelStatusAttribute(): string
    {
        if ($this->trashed()) {
            return 'Dihapus';
        }

        if (! $this->is_aktif) {
            return 'Nonaktif';
        }

        if ($this->masih_berlaku) {
            return 'Aktif & Berlaku';
        }

        return 'Kadaluarsa';
    }

    // ── Relations ─────────────────────────────────────────────────────────────

    /**
     * Siswa pemilik barcode ini.
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    /**
     * Semua log scan absensi gerbang yang menggunakan barcode ini.
     */
    public function absensiGerbang(): HasMany
    {
        return $this->hasMany(AbsensiGerbang::class, 'barcode_gerbang_id');
    }
}