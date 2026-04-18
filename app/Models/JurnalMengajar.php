<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurnalMengajar extends Model
{
    use HasFactory;

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
        'diverifikasi_oleh',   // ← tambahan
        'diverifikasi_pada',   // ← tambahan
    ];

    protected function casts(): array
    {
        return [
            'tanggal'          => 'date',
            'diverifikasi_pada' => 'datetime',
        ];
    }

    // ── Accessors ────────────────────────────────────────────────────────────

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

    // ── Relationships ─────────────────────────────────────────────────────────

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function jadwalPelajaran()
    {
        return $this->belongsTo(JadwalPelajaran::class);
    }

    public function diverifikasiOleh()
    {
        return $this->belongsTo(User::class, 'diverifikasi_oleh');
    }
}