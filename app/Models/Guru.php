<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guru extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'guru';

    protected $fillable = [
        'pengguna_id', 'nip', 'nama_lengkap', 'jenis_kelamin', 'tempat_lahir',
        'tanggal_lahir', 'alamat', 'no_hp', 'email', 'foto',
        'pendidikan_terakhir', 'jurusan_pendidikan', 'universitas', 'tahun_lulus',
        'status_kepegawaian', 'tanggal_masuk', 'adalah_guru_piket', 'status',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir'     => 'date',
            'tanggal_masuk'     => 'date',
            'adalah_guru_piket' => 'boolean',
        ];
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopePiket($query)
    {
        return $query->where('adalah_guru_piket', true);
    }

    public function isAktif(): bool
    {
        return $this->status === 'aktif';
    }

    public function getFotoUrlAttribute(): string
    {
        return $this->foto
            ? asset('storage/' . $this->foto)
            : asset('images/default-guru.png');
    }

    public function getUmurAttribute(): ?int
    {
        return $this->tanggal_lahir ? $this->tanggal_lahir->age : null;
    }

    public function getLabelStatusAttribute(): string
    {
        return match ($this->status) {
            'aktif'      => 'Aktif',
            'tidak_aktif'=> 'Tidak Aktif',
            'cuti'       => 'Cuti',
            default      => ucfirst($this->status),
        };
    }

    public function getLabelStatusKepegawaianAttribute(): string
    {
        return match ($this->status_kepegawaian) {
            'pns'    => 'PNS',
            'p3k'    => 'P3K',
            'honorer'=> 'Honorer',
            'gtty'   => 'GTTY',
            default  => strtoupper($this->status_kepegawaian),
        };
    }

    public function pengguna()
    {
        return $this->belongsTo(User::class, 'pengguna_id');
    }

    public function kelasWali()
    {
        return $this->hasMany(Kelas::class, 'wali_kelas_id');
    }

    public function ketersediaan()
    {
        return $this->hasMany(KetersediaanGuru::class);
    }

    public function jadwalPelajaran()
    {
        return $this->hasMany(JadwalPelajaran::class);
    }

    public function jadwalPiket()
    {
        return $this->hasMany(JadwalPiketGuru::class);
    }

    public function logPiket()
    {
        return $this->hasMany(LogPiket::class);
    }

    public function materi()
    {
        return $this->hasMany(Materi::class);
    }

    public function tugas()
    {
        return $this->hasMany(Tugas::class);
    }

    public function jurnal()
    {
        return $this->hasMany(JurnalMengajar::class);
    }

    public function isTersediaHari(string $hari, string $jamMulai, string $jamSelesai): bool
    {
        return $this->ketersediaan()
            ->where('hari', $hari)
            ->where('jam_mulai', '<=', $jamMulai)
            ->where('jam_selesai', '>=', $jamSelesai)
            ->where('tersedia', true)
            ->exists();
    }

    public function isJadwalBentrok(string $hari, string $jamMulai, int $tahunAjaranId, ?int $excludeJadwalId = null): bool
    {
        $query = $this->jadwalPelajaran()
            ->where('hari', $hari)
            ->where('jam_mulai', $jamMulai)
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->where('is_active', true);

        if ($excludeJadwalId) {
            $query->where('id', '!=', $excludeJadwalId);
        }

        return $query->exists();
    }
}