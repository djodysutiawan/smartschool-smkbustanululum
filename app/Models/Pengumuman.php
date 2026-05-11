<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;

    protected $table = 'pengumuman';

    protected $fillable = [
        'judul',
        'isi',
        'path_lampiran',
        'target_role',
        'kadaluarsa_pada',
        'dipinned',
        'dibuat_oleh',
        'dipublikasikan_oleh',
        'dipublikasikan_pada',
    ];

    protected function casts(): array
    {
        return [
            'dipublikasikan_pada' => 'datetime',
            'kadaluarsa_pada'     => 'datetime',
            'dipinned'            => 'boolean',
        ];
    }

    // ─── Constants ────────────────────────────────────────────────────────────

    /**
     * Role yang boleh menerima pengumuman guru piket.
     * Digunakan di controller dan scope — satu sumber kebenaran.
     */
    public const ROLE_PIKET = ['semua', 'guru_piket'];

    // ─── Scopes ───────────────────────────────────────────────────────────────

    /**
     * Hanya pengumuman yang sudah dipublikasikan:
     * dipublikasikan_pada NOT NULL dan waktunya sudah ≤ now().
     *
     * FIX: scope ini sebelumnya tidak mengecek `<= now()` sehingga
     * pengumuman terjadwal di masa depan bisa lolos. Kedua kondisi wajib ada.
     */
    public function scopeDipublikasikan($query)
    {
        return $query
            ->whereNotNull('dipublikasikan_pada')
            ->where('dipublikasikan_pada', '<=', now());
    }

    /**
     * Filter berdasarkan target role; selalu sertakan target 'semua'.
     *
     * Contoh: scopeUntukRole($query, 'guru_piket') → tampilkan 'guru_piket' + 'semua'.
     */
    public function scopeUntukRole($query, string $role)
    {
        return $query->where(function ($q) use ($role) {
            $q->where('target_role', $role)
              ->orWhere('target_role', 'semua');
        });
    }

    /**
     * Hanya pengumuman yang belum kadaluarsa
     * (kadaluarsa_pada NULL atau masih di masa depan).
     */
    public function scopeBelumKadaluarsa($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('kadaluarsa_pada')
              ->orWhere('kadaluarsa_pada', '>', now());
        });
    }

    /**
     * Urutan standar: pinned dulu, lalu terbaru.
     * Digunakan di index dan sidebar show agar konsisten.
     */
    public function scopeUrutan($query)
    {
        return $query
            ->orderByDesc('dipinned')
            ->orderByDesc('dipublikasikan_pada');
    }

    /**
     * Scope komposit: semua filter standar untuk tampilan publik guru piket.
     * Menggabungkan: sudah publish + role sesuai + belum kadaluarsa.
     *
     * Contoh: Pengumuman::untukPiket()->urutan()->paginate(15)
     */
    public function scopeUntukPiket($query)
    {
        return $query
            ->dipublikasikan()
            ->untukRole('guru_piket')
            ->belumKadaluarsa();
    }

    // ─── Accessors ────────────────────────────────────────────────────────────

    /**
     * Apakah pengumuman sudah aktif dipublikasikan (bukan hanya ada tanggalnya).
     *
     * Accessor ini di-rename dari 'dipublikasikan' menjadi 'sudahDipublikasikan'
     * untuk menghindari naming collision dengan kolom 'dipublikasikan_pada'
     * dan cast yang dihasilkannya (pada beberapa versi Laravel, accessor
     * 'getDipublikasikanAttribute' bisa bentrok dengan magic getter dari
     * kolom 'dipublikasikan_pada' karena snake_case normalization).
     *
     * FIX: Gunakan ->isBefore(now()) atau isPast() yang keduanya ekuivalen,
     * tapi tambahkan cek explicit agar tidak tergantung short-circuit.
     */
    public function getSudahDipublikasikanAttribute(): bool
    {
        return $this->dipublikasikan_pada !== null
            && $this->dipublikasikan_pada->isPast();
    }

    /**
     * Apakah pengumuman sudah kadaluarsa.
     *
     * FIX: Pastikan null check dilakukan sebelum memanggil ->isPast()
     * meskipun cast sudah menjamin tipe; defensive check tetap dipertahankan.
     */
    public function getSudahKadaluarsaAttribute(): bool
    {
        return $this->kadaluarsa_pada !== null
            && $this->kadaluarsa_pada->isPast();
    }

    /**
     * URL lampiran yang sudah siap pakai (null jika tidak ada lampiran).
     */
    public function getLampiranUrlAttribute(): ?string
    {
        return $this->path_lampiran
            ? asset('storage/' . $this->path_lampiran)
            : null;
    }

    // ─── Actions ──────────────────────────────────────────────────────────────

    /**
     * Publikasikan pengumuman ini oleh user dengan ID tertentu.
     * Tidak melempar exception jika sudah dipublikasikan — idempotent.
     */
    public function publish(int $olehId): void
    {
        $this->update([
            'dipublikasikan_oleh' => $olehId,
            'dipublikasikan_pada' => now(),
        ]);
    }

    // ─── Relationships ────────────────────────────────────────────────────────

    public function dibuatOleh()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function dipublikasikanOleh()
    {
        return $this->belongsTo(User::class, 'dipublikasikan_oleh');
    }
}