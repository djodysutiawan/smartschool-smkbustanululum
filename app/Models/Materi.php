<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Materi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'materi';

    protected $fillable = [
        'guru_id', 'mata_pelajaran_id', 'kelas_id', 'tahun_ajaran_id',
        'judul', 'deskripsi', 'jenis', 'path_file', 'url_eksternal',
        'thumbnail', 'urutan', 'dipublikasikan', 'dipublikasikan_pada',
    ];

    protected function casts(): array
    {
        return [
            'dipublikasikan'     => 'boolean',
            'dipublikasikan_pada'=> 'datetime',
        ];
    }

    public function scopeDipublikasikan($query)
    {
        return $query->where('dipublikasikan', true);
    }

    public function publish(): void
    {
        $this->update(['dipublikasikan' => true, 'dipublikasikan_pada' => now()]);
    }

    public function unpublish(): void
    {
        $this->update(['dipublikasikan' => false, 'dipublikasikan_pada' => null]);
    }

    public function getFileUrlAttribute(): ?string
    {
        if ($this->jenis === 'link') return $this->url_eksternal;
        return $this->path_file ? asset('storage/' . $this->path_file) : null;
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }
}
