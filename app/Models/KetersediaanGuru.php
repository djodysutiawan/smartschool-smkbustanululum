<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KetersediaanGuru extends Model
{
    use HasFactory;

    protected $table = 'ketersediaan_guru';

    protected $fillable = [
        'guru_id',
        'mata_pelajaran_id', // null = semua mapel yang diampu
        'jurusan_id',        // null = semua jurusan
        'hari',
        'jam_mulai',
        'jam_selesai',
        'tersedia',
        'catatan',
        'berlaku_mulai',     // null = permanen (setiap minggu)
        'berlaku_selesai',   // null = permanen
    ];

    protected function casts(): array
    {
        return [
            'tersedia'        => 'boolean',
            'berlaku_mulai'   => 'date',
            'berlaku_selesai' => 'date',
        ];
    }

    // ── Scopes ────────────────────────────────────────────────────────────────

    public function scopeTersedia($query)
    {
        return $query->where('tersedia', true);
    }

    public function scopeHari($query, string $hari)
    {
        return $query->where('hari', $hari);
    }

    /**
     * Filter ketersediaan yang berlaku pada tanggal tertentu.
     * Slot permanen (berlaku_mulai NULL) selalu masuk.
     */
    public function scopeBerlakuPada($query, string $tanggal)
    {
        return $query->where(function ($q) use ($tanggal) {
            // Permanen
            $q->whereNull('berlaku_mulai')
              ->orWhere(function ($q2) use ($tanggal) {
                  // Temporer: tanggal dalam range
                  $q2->where('berlaku_mulai', '<=', $tanggal)
                     ->where(function ($q3) use ($tanggal) {
                         $q3->whereNull('berlaku_selesai')
                            ->orWhere('berlaku_selesai', '>=', $tanggal);
                     });
              });
        });
    }

    /**
     * Filter untuk mapel tertentu:
     * - Slot tanpa mapel spesifik (untuk semua mapel) SELALU masuk
     * - Slot dengan mapel spesifik: hanya yang cocok
     */
    public function scopeUntukMapel($query, int $mapelId)
    {
        return $query->where(function ($q) use ($mapelId) {
            $q->whereNull('mata_pelajaran_id')
              ->orWhere('mata_pelajaran_id', $mapelId);
        });
    }

    /**
     * Filter untuk jurusan tertentu.
     */
    public function scopeUntukJurusan($query, int $jurusanId)
    {
        return $query->where(function ($q) use ($jurusanId) {
            $q->whereNull('jurusan_id')
              ->orWhere('jurusan_id', $jurusanId);
        });
    }

    // ── Accessors ─────────────────────────────────────────────────────────────

    public function getDurasiMenitAttribute(): int
    {
        return (int) \Carbon\Carbon::parse($this->jam_mulai)
                                   ->diffInMinutes($this->jam_selesai);
    }

    public function getIsPermananAttribute(): bool
    {
        return is_null($this->berlaku_mulai);
    }

    public function getLabelWaktuAttribute(): string
    {
        return substr($this->jam_mulai, 0, 5) . ' – ' . substr($this->jam_selesai, 0, 5);
    }

    public function getLabelBerlakuAttribute(): string
    {
        if ($this->isPermanan) return 'Permanen';

        $mulai   = $this->berlaku_mulai->format('d/m/Y');
        $selesai = $this->berlaku_selesai?->format('d/m/Y') ?? '∞';
        return "{$mulai} s/d {$selesai}";
    }

    /**
     * Cek apakah slot ini berlaku pada tanggal tertentu.
     */
    public function berlakuPada(\Carbon\Carbon $tanggal): bool
    {
        if (is_null($this->berlaku_mulai)) return true; // permanen

        if ($tanggal->lt($this->berlaku_mulai)) return false;

        if ($this->berlaku_selesai && $tanggal->gt($this->berlaku_selesai)) return false;

        return true;
    }

    /**
     * Cek apakah slot ini overlap dengan jam tertentu.
     * Overlap: slot_mulai < jam_selesai AND slot_selesai > jam_mulai
     */
    public function overlapDengan(string $jamMulai, string $jamSelesai): bool
    {
        return $this->jam_mulai < $jamSelesai
            && $this->jam_selesai > $jamMulai;
    }

    /**
     * Cek apakah slot ini mencakup rentang jam tertentu sepenuhnya.
     * Slot harus mulai <= jamMulai DAN selesai >= jamSelesai.
     */
    public function mencakup(string $jamMulai, string $jamSelesai): bool
    {
        return $this->jam_mulai <= $jamMulai
            && $this->jam_selesai >= $jamSelesai;
    }

    // ── Relations ─────────────────────────────────────────────────────────────

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class);
    }

    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class);
    }
}