<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah kolom guru_id ke tabel absensi_gerbang.
     * siswa_id sudah nullable dari migration awal, tidak perlu diubah.
     */
    public function up(): void
    {
        Schema::table('absensi_gerbang', function (Blueprint $table) {

            $table->unsignedBigInteger('guru_id')
                  ->nullable()
                  ->after('siswa_id');

            $table->foreign('guru_id')
                  ->references('id')
                  ->on('guru')
                  ->nullOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('absensi_gerbang', function (Blueprint $table) {

            $table->dropForeign(['guru_id']);
            $table->dropColumn('guru_id');

        });
    }
};