<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class SesiQrGuru extends Model
{
    use HasFactory;

    protected $table = 'sesi_qr_guru';

    protected $fillable = [
        'kode_qr',
        'dibuat_oleh',
        'tanggal',
        'berlaku_mulai',
        'kadaluarsa_pada',
        'radius_meter',
        'is_active',
    ];

    protected $casts = [
        'tanggal'         => 'date',
        'berlaku_mulai'   => 'datetime',
        'kadaluarsa_pada' => 'datetime',
        'is_active'       => 'boolean',
    ];

    // ─── Auto-generate kode_qr UUID ──────────────────────────────────────────

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            if (empty($model->kode_qr)) {
                $model->kode_qr = (string) Str::uuid();
            }
        });
    }

    // ─── Relasi ───────────────────────────────────────────────────────────────

    public function pembuat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function riwayatScan(): HasMany
    {
        return $this->hasMany(RiwayatScanGuru::class, 'sesi_qr_guru_id');
    }

    // ─── Scope ────────────────────────────────────────────────────────────────

    public function scopeAktif($query)
    {
        return $query->where('is_active', true)
                     ->where('berlaku_mulai', '<=', now())
                     ->where('kadaluarsa_pada', '>=', now());
    }

    // ─── Helpers ─────────────────────────────────────────────────────────────

    public function masihBerlaku(): bool
    {
        return $this->is_active
            && now()->between($this->berlaku_mulai, $this->kadaluarsa_pada);
    }

    public function nonaktifkan(): void
    {
        $this->update(['is_active' => false]);
    }
}