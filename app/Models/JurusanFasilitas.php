<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;


class JurusanFasilitas extends Model
{
    protected $table = 'jurusan_fasilitas';
 
    protected $fillable = [
        'jurusan_id', 'nama_fasilitas', 'deskripsi',
        'foto_path', 'foto_url', 'jumlah', 'urutan',
    ];
 
    protected $casts = [
        'jumlah' => 'integer',
        'urutan' => 'integer',
    ];
 
    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class);
    }
 
    public function getFotoSrcAttribute(): ?string
    {
        if ($this->foto_path) return Storage::url($this->foto_path);
        return $this->foto_url;
    }
}
