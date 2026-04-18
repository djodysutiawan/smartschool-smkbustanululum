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
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->cascadeOnDelete();
            $table->foreignId('kelas_id')->constrained('kelas')->cascadeOnDelete();
            $table->foreignId('jadwal_pelajaran_id')->nullable()->constrained('jadwal_pelajaran')->nullOnDelete();
            $table->foreignId('dicatat_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->date('tanggal');
            $table->enum('status', ['hadir', 'telat', 'izin', 'sakit', 'alfa']);
            $table->enum('metode', ['manual', 'qr'])->default('manual');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_keluar')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('path_surat_izin')->nullable();
            $table->timestamps();
            $table->unique(['siswa_id', 'tanggal', 'kelas_id'], 'uq_absensi_siswa_tanggal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};
