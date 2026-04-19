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
Schema::create('absensi_guru', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')
                  ->constrained('guru')
                  ->cascadeOnDelete();
            $table->foreignId('dicatat_oleh')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();
            $table->foreignId('jadwal_piket_id')
                  ->nullable()
                  ->constrained('jadwal_piket_guru')
                  ->nullOnDelete();
            $table->date('tanggal');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_keluar')->nullable();
            $table->enum('status', ['hadir', 'telat', 'izin', 'sakit', 'alfa']);
            $table->enum('metode', ['manual', 'qr'])->default('manual');
            $table->string('keterangan', 500)->nullable();
            $table->string('path_surat_izin')->nullable();
            $table->timestamps();
 
            // Satu guru hanya boleh satu record absensi per hari
            $table->unique(['guru_id', 'tanggal']);
            $table->index(['tanggal', 'status']);
            $table->index('guru_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi_guru');
    }
};
