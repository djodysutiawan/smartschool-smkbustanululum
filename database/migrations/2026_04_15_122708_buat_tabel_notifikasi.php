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
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengguna_id')->constrained('users')->cascadeOnDelete();
            $table->string('judul');
            $table->text('pesan');
            $table->enum('jenis', [
                'info',
                'peringatan',
                'pelanggaran',
                'absensi',
                'nilai',
                'pengumuman',
                'tugas',
                'ujian'
            ])->default('info');
            $table->string('url_tujuan')->nullable(); // deep link ke halaman terkait
            $table->boolean('sudah_dibaca')->default(false);
            $table->timestamp('dibaca_pada')->nullable();
            $table->timestamps();
            $table->index(['pengguna_id', 'sudah_dibaca']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};
