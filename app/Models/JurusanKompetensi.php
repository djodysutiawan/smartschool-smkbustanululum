<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;



class JurusanKompetensi extends Model
{
    protected $table = 'jurusan_kompetensi';
 
    protected $fillable = [
        'jurusan_id', 'nama_kompetensi', 'deskripsi',
        'ikon', 'badge_warna', 'urutan',
    ];
 
    protected $casts = [
        'urutan' => 'integer',
    ];
 
    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class);
    }
}
