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
 * Barcode TETAP per siswa atau per guru untuk sistem absensi gerbang.
 * Satu siswa/guru hanya boleh punya satu barcode aktif (is_aktif = true).
 * Barcode lama dinonaktifkan, bukan dihapus, agar riwayat scan tetap valid.
 *
 * Constraint pemilik:
 *   - siswa_id terisi, guru_id null  → barcode milik siswa
 *   - guru_id terisi, siswa_id null  → barcode milik guru
 *   - keduanya null                  → TIDAK VALID (dicegah di buatUntukSiswa/buatUntukGuru)
 *
 * @property int                  $id
 * @property int|null             $siswa_id
 * @property int|null             $guru_id
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
 * @property-read string  $tipe_pemilik   'siswa'|'guru'|'unknown'
 * @property-read string  $nama_pemilik
 */
class BarcodeGerbang extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'barcode_gerbang';

    protected $fillable = [
        'siswa_id',
        'guru_id',
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

    /** Hanya barcode yang is_aktif = true. */
    public function scopeAktif($query)
    {
        return $query->where('is_aktif', true);
    }

    /** Hanya barcode yang is_aktif = false. */
    public function scopeNonaktif($query)
    {
        return $query->where('is_aktif', false);
    }

    /** Barcode yang masa berlakunya mencakup hari ini. */
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

    /** Hanya barcode milik siswa. */
    public function scopeUntukSiswa($query)
    {
        return $query->whereNotNull('siswa_id')->whereNull('guru_id');
    }

    /** Hanya barcode milik guru. */
    public function scopeUntukGuru($query)
    {
        return $query->whereNotNull('guru_id')->whereNull('siswa_id');
    }

    // ── Static Helpers ────────────────────────────────────────────────────────

    /**
     * Generate kode barcode unik untuk SISWA.
     * Format: SIS-{NIS}-{YYYY}  atau  SIS-{NIS}-{YYYY}-{RAND4}
     */
    public static function generateKodeSiswa(Siswa $siswa): string
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
     * Generate kode barcode unik untuk GURU.
     * Format: GRU-{NIP}-{YYYY}  atau  GRU-{NIP}-{YYYY}-{RAND4}
     * Jika NIP kosong, gunakan ID guru sebagai pengganti.
     */
    public static function generateKodeGuru(Guru $guru): string
    {
        $identifier = $guru->nip ?? ('G' . $guru->id);
        $base = implode('-', ['GRU', $identifier, now()->year]);

        if (! static::withTrashed()->where('kode', $base)->exists()) {
            return $base;
        }

        do {
            $kode = $base . '-' . strtoupper(Str::random(4));
        } while (static::withTrashed()->where('kode', $kode)->exists());

        return $kode;
    }

    /**
     * Alias generateKode() untuk backward-compatibility (sebelumnya hanya untuk siswa).
     *
     * @deprecated  Gunakan generateKodeSiswa() atau generateKodeGuru() secara eksplisit.
     */
    public static function generateKode(Siswa $siswa): string
    {
        return static::generateKodeSiswa($siswa);
    }

    /**
     * Buat barcode baru untuk satu SISWA.
     *
     * Semua barcode aktif milik siswa tersebut otomatis dinonaktifkan terlebih
     * dahulu, kemudian barcode baru dibuat dengan is_aktif = true.
     *
     * @param  Siswa  $siswa
     * @param  array  $data   berlaku_mulai, berlaku_sampai, keterangan
     * @return static
     */
    public static function buatUntukSiswa(Siswa $siswa, array $data = []): static
    {
        static::where('siswa_id', $siswa->id)
            ->where('is_aktif', true)
            ->update(['is_aktif' => false]);

        return static::create([
            'siswa_id'       => $siswa->id,
            'guru_id'        => null,
            'kode'           => static::generateKodeSiswa($siswa),
            'is_aktif'       => true,
            'berlaku_mulai'  => $data['berlaku_mulai']  ?? today(),
            'berlaku_sampai' => $data['berlaku_sampai'] ?? null,
            'keterangan'     => $data['keterangan']     ?? null,
        ]);
    }

    /**
     * Buat barcode baru untuk satu GURU.
     *
     * Semua barcode aktif milik guru tersebut otomatis dinonaktifkan terlebih
     * dahulu, kemudian barcode baru dibuat dengan is_aktif = true.
     *
     * @param  Guru  $guru
     * @param  array $data  berlaku_mulai, berlaku_sampai, keterangan
     * @return static
     */
    public static function buatUntukGuru(Guru $guru, array $data = []): static
    {
        static::where('guru_id', $guru->id)
            ->where('is_aktif', true)
            ->update(['is_aktif' => false]);

        return static::create([
            'siswa_id'       => null,
            'guru_id'        => $guru->id,
            'kode'           => static::generateKodeGuru($guru),
            'is_aktif'       => true,
            'berlaku_mulai'  => $data['berlaku_mulai']  ?? today(),
            'berlaku_sampai' => $data['berlaku_sampai'] ?? null,
            'keterangan'     => $data['keterangan']     ?? null,
        ]);
    }

    // ── Accessors ─────────────────────────────────────────────────────────────

    /** True jika barcode aktif DAN masa berlakunya mencakup hari ini. */
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
     * Tipe pemilik barcode: 'siswa', 'guru', atau 'unknown'.
     */
    public function getTipePemilikAttribute(): string
    {
        if ($this->siswa_id !== null) return 'siswa';
        if ($this->guru_id  !== null) return 'guru';
        return 'unknown';
    }

    /**
     * Nama pemilik barcode (siswa atau guru).
     */
    public function getNamaPemilikAttribute(): string
    {
        if ($this->tipe_pemilik === 'siswa') {
            return $this->siswa?->nama_lengkap ?? '—';
        }

        if ($this->tipe_pemilik === 'guru') {
            return $this->guru?->nama_lengkap ?? '—';
        }

        return '—';
    }

    /**
     * Label status yang ramah untuk tampilan UI.
     *
     * Prioritas:
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

    /** Siswa pemilik barcode (null jika barcode milik guru). */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    /** Guru pemilik barcode (null jika barcode milik siswa). */
    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class);
    }

    /** Semua log scan absensi gerbang yang menggunakan barcode ini. */
    public function absensiGerbang(): HasMany
    {
        return $this->hasMany(AbsensiGerbang::class, 'barcode_gerbang_id');
    }
}