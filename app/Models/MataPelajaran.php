<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MataPelajaran extends Model
{
    use HasFactory;

    protected $table = 'mata_pelajaran';

    protected $fillable = [
        'nama_mapel',
        'kode_mapel',
        'kelompok',
        'scope',
        'jam_per_minggu',
        'durasi_per_sesi',
        'perlu_lab',
        'keterangan',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'perlu_lab'      => 'boolean',
            'is_active'      => 'boolean',
            // FIX #10: Cast numerik agar tidak ada perbandingan string vs int
            'jam_per_minggu' => 'integer',
            'durasi_per_sesi'=> 'integer',
        ];
    }

    // ── Scopes ────────────────────────────────────────────────────────────────

    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeUmum($query)
    {
        return $query->where('scope', 'umum');
    }

    public function scopeUntukJurusan($query, int $jurusanId, ?int $tingkat = null)
    {
        return $query->where(function ($q) use ($jurusanId, $tingkat) {
            $q->where('scope', 'umum')
              ->orWhere(function ($q2) use ($jurusanId, $tingkat) {
                  $q2->where('scope', 'jurusan')
                     ->whereHas('jurusan', function ($q3) use ($jurusanId, $tingkat) {
                         $q3->where('jurusan.id', $jurusanId)
                            ->where('jurusan_mata_pelajaran.is_active', true)
                            ->when($tingkat, fn($q4) =>
                                $q4->where(function ($q5) use ($tingkat) {
                                    $q5->whereNull('jurusan_mata_pelajaran.tingkat')
                                       ->orWhere('jurusan_mata_pelajaran.tingkat', $tingkat);
                                })
                            );
                     });
              });
        });
    }

    // ── Accessors ─────────────────────────────────────────────────────────────

    public function getTotalMenitPerMingguAttribute(): int
    {
        return $this->jam_per_minggu * $this->durasi_per_sesi;
    }

    public function getIsUmumAttribute(): bool
    {
        return $this->scope === 'umum';
    }

    public function getLabelKelompokAttribute(): string
    {
        return match ($this->kelompok) {
            'normatif'          => 'Normatif',
            'adaptif'           => 'Adaptif',
            'produktif'         => 'Produktif',
            'muatan_lokal'      => 'Muatan Lokal',
            'pengembangan_diri' => 'Pengembangan Diri',
            default             => ucfirst($this->kelompok ?? '-'),
        };
    }

    // ── Relations ─────────────────────────────────────────────────────────────

    /**
     * Jurusan yang menggunakan mapel ini (untuk scope='jurusan').
     */
    public function jurusan(): BelongsToMany
    {
        return $this->belongsToMany(Jurusan::class, 'jurusan_mata_pelajaran')
                    ->withPivot(['jam_per_minggu', 'tingkat', 'is_active'])
                    ->withTimestamps();
    }

    public function jadwalPelajaran(): HasMany
    {
        return $this->hasMany(JadwalPelajaran::class);
    }

    /**
     * FIX #11: Relasi guru() tidak dipakai langsung di view/controller untuk
     * daftar pengampu — controller pakai query builder + distinct().
     * Relasi ini tetap ada untuk keperluan lain (misal whereHas).
     * JANGAN gunakan ->get() langsung dari relasi ini karena bisa duplikat.
     */
    public function guru(): BelongsToMany
    {
        return $this->belongsToMany(Guru::class, 'jadwal_pelajaran', 'mata_pelajaran_id', 'guru_id');
    }

    /**
     * Accessor aman untuk daftar guru unik pengampu mapel ini.
     * Gunakan $mataPelajaran->guruPengampuUnik di blade jika dibutuhkan.
     * (Controller show() sudah pakai query builder langsung — lebih efisien)
     */
    public function getGuruPengampuUnikAttribute()
    {
        return Guru::select('guru.*')
            ->join('jadwal_pelajaran', 'guru.id', '=', 'jadwal_pelajaran.guru_id')
            ->where('jadwal_pelajaran.mata_pelajaran_id', $this->id)
            ->distinct()
            ->get();
    }

    public function materi(): HasMany
    {
        return $this->hasMany(Materi::class);
    }

    public function tugas(): HasMany
    {
        return $this->hasMany(Tugas::class);
    }

    public function nilai(): HasMany
    {
        return $this->hasMany(Nilai::class);
    }

    public function sesiQr(): HasMany
    {
        return $this->hasMany(SesiQr::class);
    }

    public function absensi(): HasMany
    {
        return $this->hasMany(Absensi::class);
    }
}