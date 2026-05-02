<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Prestasi extends Model
{
    protected $table = 'prestasi';
 
    protected $fillable = [
        'judul', 'deskripsi', 'tingkat', 'bidang',
        'nama_event', 'penyelenggara', 'peringkat',
        'tanggal', 'tahun',
        'tipe_penerima', 'nama_penerima', 'siswa_id', 'jurusan_id',
        'foto_path', 'foto_url', 'sertifikat_path',
        'is_published', 'is_featured', 'urutan', 'created_by',
    ];
 
    protected $casts = [
        'tanggal'      => 'date',
        'tahun'        => 'integer',
        'is_published' => 'boolean',
        'is_featured'  => 'boolean',
        'urutan'       => 'integer',
    ];
 
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }
 
    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class);
    }
 
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
 
    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderByDesc('tanggal');
    }
 
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->where('is_published', true);
    }
 
    public function getFotoSrcAttribute(): ?string
    {
        if ($this->foto_path) return Storage::url($this->foto_path);
        return $this->foto_url;
    }
 
    public function getSertifikatSrcAttribute(): ?string
    {
        if ($this->sertifikat_path) return Storage::url($this->sertifikat_path);
        return null;
    }
 
    // Label badge tingkat
    public function getTingkatLabelAttribute(): string
    {
        return match($this->tingkat) {
            'sekolah'        => 'Tingkat Sekolah',
            'kecamatan'      => 'Tingkat Kecamatan',
            'kabupaten'      => 'Tingkat Kabupaten/Kota',
            'provinsi'       => 'Tingkat Provinsi',
            'nasional'       => 'Tingkat Nasional',
            'internasional'  => 'Tingkat Internasional',
            default          => ucfirst($this->tingkat),
        };
    }
}
