<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KontakPesan extends Model
{
    protected $table = 'kontak_pesan';
 
    protected $fillable = [
        'nama_pengirim', 'email_pengirim', 'no_telepon',
        'subjek', 'pesan', 'ip_address',
        'status', 'catatan_admin', 'dibaca_at', 'dibaca_oleh',
    ];
 
    protected $casts = [
        'dibaca_at' => 'datetime',
    ];
 
    public function dibacaOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dibaca_oleh');
    }
 
    public function scopeBaru($query)
    {
        return $query->where('status', 'baru');
    }
 
    public function markAsRead(int $userId): void
    {
        $this->update([
            'status'      => 'dibaca',
            'dibaca_at'   => now(),
            'dibaca_oleh' => $userId,
        ]);
    }
}
