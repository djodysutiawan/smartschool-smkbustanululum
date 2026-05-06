<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Jurusan extends Model
{
    protected $table = 'jurusan';

    protected $fillable = [
        'nama', 'singkatan', 'slug', 'kode_jurusan',
        'bidang_keahlian', 'program_keahlian', 'kompetensi_keahlian',
        'deskripsi_singkat', 'deskripsi_lengkap', 'tujuan_jurusan',
        'foto_cover_path', 'foto_cover_url', 'logo_path', 'logo_url',
        'lama_belajar', 'akreditasi', 'kapasitas_per_kelas',
        'jumlah_kelas_aktif', 'total_siswa',
        'nama_kajur', 'foto_kajur_path', 'foto_kajur_url',
        'is_published', 'is_penerimaan_buka', 'urutan', 'created_by',
    ];

    protected $casts = [
        'lama_belajar'        => 'integer',
        'kapasitas_per_kelas' => 'integer',
        'jumlah_kelas_aktif'  => 'integer',
        'total_siswa'         => 'integer',
        'is_published'        => 'boolean',
        'is_penerimaan_buka'  => 'boolean',
        'urutan'              => 'integer',
    ];

    // ── Relasi ────────────────────────────────────────────────────────────

    public function kelas(): HasMany
    {
        return $this->hasMany(Kelas::class);
    }

    public function kurikulum(): HasMany
    {
        return $this->hasMany(JurusanKurikulum::class)->orderBy('urutan');
    }

    public function kompetensi(): HasMany
    {
        return $this->hasMany(JurusanKompetensi::class)->orderBy('urutan');
    }

    public function prospekKerja(): HasMany
    {
        return $this->hasMany(JurusanProspekKerja::class)->orderBy('urutan');
    }

    public function fasilitas(): HasMany
    {
        return $this->hasMany(JurusanFasilitas::class)->orderBy('urutan');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // ── Scopes ────────────────────────────────────────────────────────────

    /**
     * FIX: Hapus orderBy dari dalam scope agar tidak konflik saat dirantai.
     * Panggil ->orderBy('urutan') secara eksplisit di pemanggil.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopePenerimaanBuka($query)
    {
        return $query->where('is_penerimaan_buka', true)->where('is_published', true);
    }

    // ── Accessors (Laravel 9+ Attribute style) ────────────────────────────

    /**
     * FIX: Gunakan Attribute::make() (modern Laravel 9+), 
     * gantikan getFotoCoverSrcAttribute() yang akan deprecated.
     */
    protected function fotoCoverSrc(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->foto_cover_path
                ? Storage::url($this->foto_cover_path)
                : $this->foto_cover_url,
        );
    }

    protected function logoSrc(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->logo_path
                ? Storage::url($this->logo_path)
                : $this->logo_url,
        );
    }

    protected function fotoKajurSrc(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->foto_kajur_path
                ? Storage::url($this->foto_kajur_path)
                : $this->foto_kajur_url,
        );
    }

    // ── Booted ────────────────────────────────────────────────────────────

    protected static function booted(): void
    {
        static::saving(function ($model) {
            /**
             * FIX: Cek keunikan slug sebelum assign.
             * Sebelumnya slug di-generate tanpa cek duplikat → crash jika
             * ada unique constraint di DB dan nama sama dibuat dari seeder/API.
             */
            if (empty($model->slug)) {
                $base = Str::slug($model->nama);
                $slug = $base;
                $i    = 1;

                while (
                    static::where('slug', $slug)
                           ->where('id', '!=', $model->id ?? 0)
                           ->exists()
                ) {
                    $slug = $base . '-' . $i++;
                }

                $model->slug = $slug;
            }
        });
    }
}