<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeritaKategori extends Model
{
    protected $table = 'berita_kategori';
 
    protected $fillable = [
        'nama', 'slug', 'deskripsi', 'warna', 'is_published', 'urutan',
    ];
 
    protected $casts = [
        'is_published' => 'boolean',
        'urutan'       => 'integer',
    ];
 
    public function berita()
    {
        return $this->hasMany(BeritaPublik::class, 'berita_kategori_id');
    }
 
    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderBy('urutan');
    }
}
