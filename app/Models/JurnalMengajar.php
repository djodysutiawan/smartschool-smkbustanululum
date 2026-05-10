<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JurnalMengajar extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'jurnal_mengajar';

    protected $fillable = [
        'guru_id',
        'kelas_id',
        'mata_pelajaran_id',
        'jadwal_pelajaran_id',
        'tanggal',
        'pertemuan_ke',
        'materi_ajar',
        'metode_pembelajaran',
        'jumlah_hadir',
        'jumlah_tidak_hadir',
        'catatan_kelas',
        'diverifikasi_oleh',
        'diverifikasi_pada',
    ];

    protected function casts(): array
    {
        return [
            'tanggal'            => 'date',
            'diverifikasi_pada'  => 'datetime',
            'pertemuan_ke'       => 'integer',
            'jumlah_hadir'       => 'integer',
            'jumlah_tidak_hadir' => 'integer',
        ];
    }

    // ── Scopes ────────────────────────────────────────────────────────────────

    public function scopeByGuru($query, int $guruId)
    {
        return $query->where('guru_id', $guruId);
    }

    public function scopeSudahDiverifikasi($query)
    {
        return $query->whereNotNull('diverifikasi_pada');
    }

    public function scopeBelumDiverifikasi($query)
    {
        return $query->whereNull('diverifikasi_pada');
    }

    // ── Accessors ─────────────────────────────────────────────────────────────

    /**
     * Hitung persentase kehadiran dari jumlah hadir & tidak hadir.
     * Return null jika total = 0 (belum ada data).
     */
    public function getPersentaseKehadiranAttribute(): ?float
    {
        $total = ($this->jumlah_hadir ?? 0) + ($this->jumlah_tidak_hadir ?? 0);

        if ($total === 0) {
            return null;
        }

        return round(($this->jumlah_hadir / $total) * 100, 2);
    }

    public function getSudahDiverifikasiAttribute(): bool
    {
        return $this->diverifikasi_pada !== null;
    }

    public function getTotalSiswaAttribute(): int
    {
        return ($this->jumlah_hadir ?? 0) + ($this->jumlah_tidak_hadir ?? 0);
    }

    // ── Relationships ──────────────────────────────────────────────────────────

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class);
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }

    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function jadwalPelajaran(): BelongsTo
    {
        return $this->belongsTo(JadwalPelajaran::class);
    }

    public function diverifikasiOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diverifikasi_oleh');
    }
}