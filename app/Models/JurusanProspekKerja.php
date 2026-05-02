<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JurusanProspekKerja extends Model
{
    protected $table = 'jurusan_prospek_kerja';
 
    protected $fillable = [
        'jurusan_id', 'jabatan', 'bidang_industri',
        'deskripsi', 'ikon', 'urutan',
    ];
 
    protected $casts = [
        'urutan' => 'integer',
    ];
 
    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class);
    }
}
