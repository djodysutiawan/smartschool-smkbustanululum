<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'subject_id',
        'kode_qr',
        'expired_at',
    ];

    protected $casts = [
        'expired_at' => 'datetime',
    ];

    /**
     * Relasi ke kelas
     */
    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    /**
     * Relasi ke mapel
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}