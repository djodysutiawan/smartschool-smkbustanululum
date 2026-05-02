<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class AgendaSekolah extends Model
{
    protected $table = 'agenda_sekolah';
 
    protected $fillable = [
        'judul', 'deskripsi', 'lokasi',
        'tanggal_mulai', 'tanggal_selesai',
        'jam_mulai', 'jam_selesai',
        'warna', 'tipe', 'is_published', 'created_by',
    ];
 
    protected $casts = [
        'tanggal_mulai'    => 'date',
        'tanggal_selesai'  => 'date',
        'is_published'     => 'boolean',
    ];
 
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
 
    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderBy('tanggal_mulai');
    }
 
    public function scopeMendatang($query)
    {
        return $query->where('tanggal_mulai', '>=', today())->published();
    }
 
    public function scopeBulanIni($query)
    {
        return $query->whereMonth('tanggal_mulai', now()->month)
                     ->whereYear('tanggal_mulai', now()->year)
                     ->published();
    }
 
    public function getIsMultiHariAttribute(): bool
    {
        return $this->tanggal_selesai && $this->tanggal_selesai->ne($this->tanggal_mulai);
    }
}
