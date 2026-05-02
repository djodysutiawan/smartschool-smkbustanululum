<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JurusanKurikulum extends Model
{
    protected $table = 'jurusan_kurikulum';
 
    protected $fillable = [
        'jurusan_id', 'nama_mapel', 'kelompok',
        'kelas', 'semester', 'jam_per_minggu', 'deskripsi', 'urutan',
    ];
 
    protected $casts = [
        'kelas'          => 'integer',
        'semester'       => 'integer',
        'jam_per_minggu' => 'integer',
        'urutan'         => 'integer',
    ];
 
    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class);
    }
}
