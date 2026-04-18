<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KetersediaanGuru extends Model
{
    use HasFactory;

    protected $table = 'ketersediaan_guru';

    protected $fillable = [
        'guru_id', 'hari', 'jam_mulai', 'jam_selesai', 'tersedia',
    ];

    protected function casts(): array
    {
        return ['tersedia' => 'boolean'];
    }

    public function scopeTersedia($query)
    {
        return $query->where('tersedia', true);
    }

    public function scopeHari($query, string $hari)
    {
        return $query->where('hari', $hari);
    }

    public function getDurasiMenitAttribute(): int
    {
        return (int) \Carbon\Carbon::parse($this->jam_mulai)->diffInMinutes($this->jam_selesai);
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
}
