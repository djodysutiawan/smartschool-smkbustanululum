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
        Schema::table('sesi_ujian', function (Blueprint $table) {
            // Hapus UNIQUE lama
            $table->dropUnique('sesi_ujian_ujian_id_siswa_id_unique');

            // Tambahkan index biasa
            $table->index(['ujian_id', 'siswa_id'], 'sesi_ujian_ujian_siswa_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sesi_ujian', function (Blueprint $table) {
            $table->dropIndex('sesi_ujian_ujian_siswa_index');

            // Balikin lagi jadi UNIQUE
            $table->unique(['ujian_id', 'siswa_id'], 'sesi_ujian_ujian_id_siswa_id_unique');
        });
    }
};
