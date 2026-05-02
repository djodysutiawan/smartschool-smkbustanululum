<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SliderBeranda extends Model
{
    protected $table = 'slider_beranda';
 
    protected $fillable = [
        'judul', 'subjudul',
        'foto_path', 'foto_url', 'foto_alt',
        'tombol_label', 'tombol_url',
        'is_published', 'urutan', 'created_by',
    ];
 
    protected $casts = [
        'is_published' => 'boolean',
        'urutan'       => 'integer',
    ];
 
    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderBy('urutan');
    }
 
    public function getFotoSrcAttribute(): ?string
    {
        if ($this->foto_path) return Storage::url($this->foto_path);
        return $this->foto_url;
    }
}
