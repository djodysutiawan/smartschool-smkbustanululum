<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class TahunAjaran extends Model
{
    use HasFactory;

    protected $table = 'tahun_ajaran';

    protected $fillable = [
        'tahun',
        'semester',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai'   => 'date',
            'tanggal_selesai' => 'date',
        ];
    }

    // ── Scopes ────────────────────────────────────────────────────────────────

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    // ── Static Helpers ────────────────────────────────────────────────────────

    public static function getAktif(): ?self
    {
        return static::where('status', 'aktif')->first();
    }

    // ── Business Logic ────────────────────────────────────────────────────────

    public function aktifkan(): void
    {
        static::where('id', '!=', $this->id)->update(['status' => 'tidak_aktif']);
        $this->update(['status' => 'aktif']);
    }

    public function isAktif(): bool
    {
        return $this->status === 'aktif';
    }

    // ── Accessors ─────────────────────────────────────────────────────────────

    public function getLabelAttribute(): string
    {
        return $this->tahun . ' — ' . ucfirst($this->semester);
    }

    public function getDurasiAttribute(): string
    {
        $bulan = $this->tanggal_mulai->diffInMonths($this->tanggal_selesai);
        return $bulan . ' bulan';
    }

    // ── Relations ─────────────────────────────────────────────────────────────

    public function kelas(): HasMany
    {
        return $this->hasMany(Kelas::class);
    }

    public function jadwalPelajaran(): HasMany
    {
        return $this->hasMany(JadwalPelajaran::class);
    }

    public function nilai(): HasMany
    {
        return $this->hasMany(Nilai::class);
    }

    /**
     * PERBAIKAN: Relasi siswa() sebelumnya salah karena tabel siswa
     * tidak punya FK langsung tahun_ajaran_id yang reliable.
     * Ganti dengan HasManyThrough via kelas.
     *
     * Untuk mendapatkan siswa aktif di tahun ajaran ini:
     * gunakan $tahunAjaran->siswa() yang melewati tabel kelas.
     */
    public function siswa(): HasManyThrough
    {
        return $this->hasManyThrough(
            Siswa::class,   // Model tujuan
            Kelas::class,   // Model perantara
            'tahun_ajaran_id', // FK di tabel kelas
            'kelas_id',        // FK di tabel siswa
            'id',              // PK di tabel tahun_ajaran
            'id'               // PK di tabel kelas
        );
    }

    /**
     * TAMBAHAN: Relasi ke proses kenaikan kelas di mana tahun ini adalah asal.
     */
    public function kenaikanKelasAsal(): HasMany
    {
        return $this->hasMany(KenaikanKelas::class, 'tahun_ajaran_asal_id');
    }

    /**
     * TAMBAHAN: Relasi ke proses kenaikan kelas di mana tahun ini adalah tujuan.
     */
    public function kenaikanKelasTujuan(): HasMany
    {
        return $this->hasMany(KenaikanKelas::class, 'tahun_ajaran_tujuan_id');
    }

    /**
     * TAMBAHAN: Riwayat kelas siswa di tahun ajaran ini.
     */
    public function riwayatKelasSiswa(): HasMany
    {
        return $this->hasMany(RiwayatKelasSiswa::class);
    }
}