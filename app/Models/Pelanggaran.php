<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggaran extends Model
{
    use HasFactory;

    protected $table = 'pelanggaran';

    protected $fillable = [
        'siswa_id', 'dicatat_oleh', 'kategori_pelanggaran_id',
        'poin', 'deskripsi', 'tanggal', 'tindakan', 'status',
    ];

    protected function casts(): array
    {
        return ['tanggal' => 'date'];
    }

    public function scopeAktif($query)
    {
        return $query->where('status', '!=', 'dibatalkan');
    }

    public function selesaikan(string $tindakan): void
    {
        $this->update(['status' => 'selesai', 'tindakan' => $tindakan]);
    }

    public function batalkan(): void
    {
        $this->update(['status' => 'dibatalkan']);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function dicatatOleh()
    {
        return $this->belongsTo(User::class, 'dicatat_oleh');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriPelanggaran::class, 'kategori_pelanggaran_id');
    }
}
