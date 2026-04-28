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
        Schema::create('laporan_harian_piket', function (Blueprint $table) {
            $table->id();
 
            $table->foreignId('dibuat_oleh')
                ->constrained('users')
                ->cascadeOnDelete();
 
            $table->date('tanggal');
 
            $table->text('catatan_umum')->nullable()
                ->comment('Catatan umum kondisi sekolah hari ini');
 
            $table->text('kejadian_khusus')->nullable()
                ->comment('Kejadian atau insiden khusus yang perlu dilaporkan');
 
            $table->text('tindak_lanjut')->nullable()
                ->comment('Tindak lanjut atau rekomendasi dari guru piket');
 
            // Snapshot rekap absensi guru pada saat laporan dibuat (JSON)
            $table->json('rekap_absensi')->nullable()
                ->comment('Snapshot: {hadir, izin, sakit, alfa} saat laporan disimpan');
 
            $table->unsignedSmallInteger('jumlah_pelanggaran')->default(0)
                ->comment('Jumlah pelanggaran yang dicatat guru piket ini hari itu');
 
            $table->timestamps();
 
            // Satu guru piket hanya bisa membuat satu laporan per hari
            $table->unique(['dibuat_oleh', 'tanggal'], 'laporan_piket_unique_per_hari');
 
            $table->index('tanggal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_harian_piket');
    }
};
