<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ujian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('guru')->cascadeOnDelete();
            $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajaran')->cascadeOnDelete();
            $table->foreignId('kelas_id')->constrained('kelas')->cascadeOnDelete();
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajaran')->cascadeOnDelete();
            $table->string('judul');
            $table->enum('jenis', ['ulangan_harian', 'uts', 'uas', 'remedial', 'quiz'])->default('ulangan_harian');
            $table->date('tanggal');
            $table->time('jam_mulai')->nullable();
            $table->unsignedSmallInteger('durasi_menit')->default(90);
            $table->unsignedTinyInteger('nilai_kkm')->default(75);
            $table->boolean('acak_soal')->default(false);
            $table->boolean('acak_pilihan')->default(false);
            $table->boolean('tampilkan_nilai')->default(true);
            $table->unsignedTinyInteger('maks_percobaan')->default(1);
            $table->text('keterangan')->nullable();
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();
 
            $table->index(['kelas_id', 'tanggal']);
            $table->index(['tahun_ajaran_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ujian');
    }
};
