<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tujuan:
 * - Tambah kolom 'scope' ke mata_pelajaran (umum = semua jurusan, jurusan = spesifik jurusan)
 * - Buat tabel pivot jurusan_mata_pelajaran
 *   Mapel 'produktif' diasosiasikan ke jurusan tertentu.
 *   Mapel 'normatif' / 'adaptif' bersifat lintas jurusan (scope=umum).
 */
return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambah kolom scope ke mata_pelajaran
        Schema::table('mata_pelajaran', function (Blueprint $table) {
            // 'umum' = untuk semua jurusan, 'jurusan' = hanya jurusan tertentu
            $table->enum('scope', ['umum', 'jurusan'])->default('umum')->after('kelompok');
        });

        // 2. Tabel pivot: jurusan ↔ mata_pelajaran
        Schema::create('jurusan_mata_pelajaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jurusan_id')
                  ->constrained('jurusan')->cascadeOnDelete();
            $table->foreignId('mata_pelajaran_id')
                  ->constrained('mata_pelajaran')->cascadeOnDelete();
            $table->unsignedSmallInteger('jam_per_minggu')->nullable()
                  ->comment('Override jam per minggu khusus jurusan ini, null = ikut mapel');
            $table->unsignedTinyInteger('tingkat')
                  ->nullable()
                  ->comment('Null = semua tingkat, 10/11/12 = spesifik tingkat');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['jurusan_id', 'mata_pelajaran_id', 'tingkat'], 'uniq_jurusan_mapel_tingkat');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jurusan_mata_pelajaran');
        Schema::table('mata_pelajaran', function (Blueprint $table) {
            $table->dropColumn('scope');
        });
    }
};