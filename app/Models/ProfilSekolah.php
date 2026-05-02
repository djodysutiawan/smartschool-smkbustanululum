<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProfilSekolah extends Model
{
    protected $table = 'profil_sekolah';

    protected $fillable = [
        'nama_sekolah', 'singkatan', 'npsn', 'nss', 'akreditasi',
        'tahun_berdiri', 'status_sekolah', 'jenjang',
        // Logo & Gambar
        'logo_path', 'logo_url', 'favicon_path', 'cover_path', 'cover_url',
        // Alamat
        'alamat_lengkap', 'desa_kelurahan', 'kecamatan', 'kabupaten_kota',
        'provinsi', 'kode_pos', 'latitude', 'longitude', 'embed_maps_url',
        // Kontak
        'telepon', 'whatsapp', 'fax', 'email_sekolah', 'website',
        // Media Sosial
        'facebook_url', 'instagram_url', 'twitter_url', 'youtube_url',
        'tiktok_url', 'linkedin_url', 'telegram_url',
        // Kepala Sekolah
        'nama_kepsek', 'nip_kepsek', 'foto_kepsek_path', 'foto_kepsek_url', 'sambutan_kepsek',
        // Teks Umum
        'visi', 'misi', 'tujuan_sekolah', 'sejarah_singkat', 'deskripsi_singkat',
        // SEO
        'meta_title', 'meta_description', 'meta_keywords',
    ];

    protected $casts = [
        'tahun_berdiri' => 'integer',
        'latitude'      => 'float',
        'longitude'     => 'float',
    ];

    // ── Singleton Helper ──────────────────────────────────────────────────

    /**
     * Ambil profil sekolah (selalu 1 row). Buat jika belum ada.
     * Default nama_sekolah diberikan agar kolom NOT NULL tidak error saat insert pertama.
     */
    public static function instance(): static
    {
        return static::firstOrCreate(
            ['id' => 1],
            ['nama_sekolah' => '-']
        );
    }

    // ── Accessors ─────────────────────────────────────────────────────────

    public function getLogoSrcAttribute(): ?string
    {
        if ($this->logo_path) return Storage::url($this->logo_path);
        return $this->logo_url;
    }

    public function getCoverSrcAttribute(): ?string
    {
        if ($this->cover_path) return Storage::url($this->cover_path);
        return $this->cover_url;
    }

    public function getFotoKepsekSrcAttribute(): ?string
    {
        if ($this->foto_kepsek_path) return Storage::url($this->foto_kepsek_path);
        return $this->foto_kepsek_url;
    }

    public function getFaviconSrcAttribute(): ?string
    {
        if ($this->favicon_path) return Storage::url($this->favicon_path);
        return null;
    }

    /**
     * Daftar sosmed yang terisi saja (untuk looping di view).
     */
    public function getSosmedListAttribute(): array
    {
        $map = [
            'instagram'  => ['label' => 'Instagram',  'url' => $this->instagram_url,  'icon' => 'instagram'],
            'facebook'   => ['label' => 'Facebook',   'url' => $this->facebook_url,   'icon' => 'facebook'],
            'youtube'    => ['label' => 'YouTube',    'url' => $this->youtube_url,    'icon' => 'youtube'],
            'tiktok'     => ['label' => 'TikTok',     'url' => $this->tiktok_url,     'icon' => 'tiktok'],
            'twitter'    => ['label' => 'Twitter/X',  'url' => $this->twitter_url,    'icon' => 'twitter'],
            'linkedin'   => ['label' => 'LinkedIn',   'url' => $this->linkedin_url,   'icon' => 'linkedin'],
            'telegram'   => ['label' => 'Telegram',   'url' => $this->telegram_url,   'icon' => 'telegram'],
        ];
        return array_filter($map, fn($s) => !empty($s['url']));
    }
}