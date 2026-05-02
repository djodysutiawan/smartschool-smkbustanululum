<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinkCepat extends Model
{
    protected $table = 'link_cepat';
 
    protected $fillable = [
        'label', 'url', 'ikon', 'warna', 'buka_tab_baru', 'is_published', 'urutan',
    ];
 
    protected $casts = [
        'buka_tab_baru' => 'boolean',
        'is_published'  => 'boolean',
        'urutan'        => 'integer',
    ];
 
    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderBy('urutan');
    }
}
