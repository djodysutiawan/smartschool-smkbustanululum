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
        Schema::create('pelanggaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->cascadeOnDelete();
            $table->foreignId('dicatat_oleh')
                ->constrained('users')
                ->restrictOnDelete(); // jangan hapus user kalau masih ada data
            $table->foreignId('kategori_pelanggaran_id')
                ->constrained('kategori_pelanggaran')
                ->restrictOnDelete();
            $table->integer('poin');
            $table->text('deskripsi');
            $table->date('tanggal');
            $table->text('tindakan')->nullable();        // tindak lanjut yang sudah dilakukan
            $table->enum('status', [
                'pending',
                'diproses',
                'selesai',
                'banding'
            ])->default('pending');
            $table->foreignId('ditangani_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('diselesaikan_pada')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggaran');
    }
};
