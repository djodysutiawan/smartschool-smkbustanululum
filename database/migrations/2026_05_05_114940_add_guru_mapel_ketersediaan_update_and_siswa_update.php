<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * TIGA perubahan sekaligus:
 *
 * 1. Buat tabel guru_mata_pelajaran
 *    → "Puguh BISA / DITUGASKAN mengajar mapel ini di jurusan ini"
 *    → Terpisah dari jadwal (jadwal berubah tiap semester, kompetensi guru relatif tetap)
 *
 * 2. Update tabel ketersediaan_guru
 *    → Tambah mata_pelajaran_id (nullable = tersedia untuk semua mapel yang diampu)
 *    → Tambah jurusan_id (nullable = tersedia untuk semua jurusan)
 *    → Tambah catatan
 *    → Tambah berlaku_mulai / berlaku_selesai (ketersediaan temporer/periodik)
 *
 * 3. Tambah tanggal_lulus ke tabel siswa
 *    → Ada di $fillable model Siswa tapi belum ada di migrasi
 */
return new class extends Migration
{
    public function up(): void
    {
        // ── 1. Tabel pivot guru ↔ mata_pelajaran ─────────────────────────────
        Schema::create('guru_mata_pelajaran', function (Blueprint $table) {
            $table->id();

            $table->foreignId('guru_id')
                  ->constrained('guru')
                  ->cascadeOnDelete();

            $table->foreignId('mata_pelajaran_id')
                  ->constrained('mata_pelajaran')
                  ->cascadeOnDelete();

            // Opsional: mapel ini diajarkan untuk jurusan tertentu saja
            // null = bisa untuk semua jurusan
            $table->foreignId('jurusan_id')
                  ->nullable()
                  ->constrained('jurusan')
                  ->nullOnDelete();

            // Jam mengajar per minggu untuk guru ini di mapel ini
            // null = ikut default mapel
            $table->unsignedTinyInteger('jam_per_minggu')->nullable();

            // Apakah ini mapel utama guru (mapel yang paling sering diajarkan)
            $table->boolean('is_mapel_utama')->default(false);

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // Satu guru bisa mengajar satu mapel di banyak jurusan,
            // tapi tidak boleh duplikat guru+mapel+jurusan
            $table->unique(
                ['guru_id', 'mata_pelajaran_id', 'jurusan_id'],
                'uq_guru_mapel_jurusan'
            );
        });

        // ── 2. Update tabel ketersediaan_guru ────────────────────────────────
        Schema::table('ketersediaan_guru', function (Blueprint $table) {
            // Ketersediaan untuk mapel spesifik
            // null = tersedia untuk semua mapel yang diampu guru ini
            $table->foreignId('mata_pelajaran_id')
                  ->nullable()
                  ->after('guru_id')
                  ->constrained('mata_pelajaran')
                  ->nullOnDelete();

            // Ketersediaan untuk jurusan spesifik
            // null = tersedia untuk semua jurusan
            $table->foreignId('jurusan_id')
                  ->nullable()
                  ->after('mata_pelajaran_id')
                  ->constrained('jurusan')
                  ->nullOnDelete();

            // Catatan dari guru, misal: "Hanya jika tidak ada rapat dinas"
            $table->string('catatan', 255)->nullable()->after('tersedia');

            // Ketersediaan berlaku dari tanggal - sampai tanggal
            // null = berlaku permanen (setiap minggu)
            $table->date('berlaku_mulai')->nullable()->after('catatan');
            $table->date('berlaku_selesai')->nullable()->after('berlaku_mulai');
        });

        // ── 3. Tambah tanggal_lulus ke siswa ─────────────────────────────────
        // Kolom ini ada di $fillable & casts model Siswa tapi belum di migrasi
        if (! Schema::hasColumn('siswa', 'tanggal_lulus')) {
            Schema::table('siswa', function (Blueprint $table) {
                $table->date('tanggal_lulus')
                      ->nullable()
                      ->after('tanggal_keluar');
            });
        }
    }

    public function down(): void
    {
        // Reverse order
        Schema::table('siswa', function (Blueprint $table) {
            $table->dropColumn('tanggal_lulus');
        });

        Schema::table('ketersediaan_guru', function (Blueprint $table) {
            $table->dropForeign(['mata_pelajaran_id']);
            $table->dropForeign(['jurusan_id']);
            $table->dropColumn([
                'mata_pelajaran_id',
                'jurusan_id',
                'catatan',
                'berlaku_mulai',
                'berlaku_selesai',
            ]);
        });

        Schema::dropIfExists('guru_mata_pelajaran');
    }
};