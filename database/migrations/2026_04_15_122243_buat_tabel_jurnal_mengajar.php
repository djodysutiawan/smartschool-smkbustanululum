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
        Schema::create('jurnal_mengajar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('guru')->cascadeOnDelete();
            $table->foreignId('kelas_id')->constrained('kelas')->cascadeOnDelete();
            $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajaran')->cascadeOnDelete();
            $table->foreignId('jadwal_pelajaran_id')->nullable()->constrained('jadwal_pelajaran')->nullOnDelete();
            $table->date('tanggal');
            $table->integer('pertemuan_ke')->nullable();
            $table->text('materi_ajar');
            $table->text('metode_pembelajaran')->nullable();
            $table->integer('jumlah_hadir')->nullable();
            $table->integer('jumlah_tidak_hadir')->nullable();
            $table->text('catatan_kelas')->nullable();
            $table->unsignedBigInteger('diverifikasi_oleh')->nullable();  // ← hapus ->after()
            $table->timestamp('diverifikasi_pada')->nullable();            // ← hapus ->after()
            $table->timestamps();
            $table->foreign('diverifikasi_oleh')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurnal_mengajar');
    }
};
