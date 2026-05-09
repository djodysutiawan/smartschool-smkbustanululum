<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notifikasi extends Model
{
    use HasFactory;

    protected $table = 'notifikasi';

    protected $fillable = [
        'pengguna_id',
        'judul',
        'pesan',
        'jenis',
        'url_tujuan',
        'sudah_dibaca',
        'dibaca_pada',
    ];

    // FIX #1: Daftarkan jenis yang valid sebagai konstanta agar mudah di-reference
    // di controller, view, dan method kirim() tanpa magic string yang tersebar.
    public const JENIS_VALID = [
        'info',
        'peringatan',
        'nilai',
        'absensi',
        'tugas',
        'pengumuman',
    ];

    protected function casts(): array
    {
        return [
            'sudah_dibaca' => 'boolean',
            'dibaca_pada'  => 'datetime',
            // FIX #2: Cast created_at & updated_at secara eksplisit sebagai datetime
            // agar ->diffForHumans() dan ->translatedFormat() bisa dipanggil langsung
            // di view tanpa perlu Carbon::parse() yang tidak perlu.
            'created_at'   => 'datetime',
            'updated_at'   => 'datetime',
        ];
    }

    // ── Scopes ─────────────────────────────────────────────────────────────────

    public function scopeBelumDibaca($query)
    {
        return $query->where('sudah_dibaca', false);
    }

    // FIX #3: Tambah scope sudahDibaca() agar simetris dengan scopeBelumDibaca().
    // Controller tidak perlu menulis where('sudah_dibaca', true) secara manual.
    public function scopeSudahDibaca($query)
    {
        return $query->where('sudah_dibaca', true);
    }

    // ── Business Logic ─────────────────────────────────────────────────────────

    /**
     * Tandai notifikasi ini sebagai sudah dibaca.
     *
     * FIX #4: Guard jika sudah dibaca — hindari query UPDATE yang tidak perlu
     * dan perubahan timestamp dibaca_pada yang sudah ada.
     */
    public function tandaiDibaca(): void
    {
        if ($this->sudah_dibaca) {
            return;
        }

        $this->update([
            'sudah_dibaca' => true,
            'dibaca_pada'  => now(),
        ]);
    }

    /**
     * Kirim notifikasi ke seorang pengguna.
     *
     * FIX #5: Validasi $jenis terhadap JENIS_VALID agar tidak ada jenis sembarang
     * yang masuk DB dan menyebabkan CSS class tidak ditemukan di view (broken UI).
     * Fallback ke 'info' jika jenis tidak dikenal, dengan opsional log warning.
     *
     * FIX #6: Truncate $judul dan $pesan agar tidak overflow kolom DB
     * (sesuaikan panjang dengan migrasi Anda — default di sini 255 & 5000).
     */
    public static function kirim(
        int $penggunaId,
        string $judul,
        string $pesan,
        string $jenis,
        ?string $url = null,
    ): self {
        // Normalisasi dan validasi jenis
        $jenis = in_array($jenis, self::JENIS_VALID, true) ? $jenis : 'info';

        // Truncate untuk keamanan panjang kolom
        $judul = mb_substr($judul, 0, 255);
        $pesan = mb_substr($pesan, 0, 5000);

        return static::create([
            'pengguna_id'  => $penggunaId,
            'judul'        => $judul,
            'pesan'        => $pesan,
            'jenis'        => $jenis,
            'url_tujuan'   => $url,
            'sudah_dibaca' => false,
        ]);
    }

    // ── Relations ──────────────────────────────────────────────────────────────

    // FIX #7: Tambahkan return type BelongsTo agar IDE dan static analysis
    // (PHPStan / Larastan) tidak menganggap relasi ini untyped.
    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pengguna_id');
    }
}