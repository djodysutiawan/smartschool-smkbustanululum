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
        Schema::create('jadwal_pelajaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajaran')->cascadeOnDelete();
            $table->foreignId('guru_id')->constrained('guru')->cascadeOnDelete();
            $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajaran')->cascadeOnDelete();
            $table->foreignId('kelas_id')->constrained('kelas')->cascadeOnDelete();
            $table->foreignId('ruang_id')->nullable()->constrained('ruang')->nullOnDelete();
            $table->enum('hari', ['senin','selasa','rabu','kamis','jumat','sabtu']);
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->integer('pertemuan_ke')->nullable();
            $table->enum('sumber_jadwal', ['manual', 'otomatis'])->default('manual');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
 
            // Mencegah ruang & guru dipakai 2 kelas di waktu bersamaan
            $table->unique(['ruang_id', 'hari', 'jam_mulai', 'tahun_ajaran_id'], 'uq_jadwal_ruang_waktu');
            $table->unique(['guru_id', 'hari', 'jam_mulai', 'tahun_ajaran_id'], 'uq_jadwal_guru_waktu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_pelajaran');
    }
};
