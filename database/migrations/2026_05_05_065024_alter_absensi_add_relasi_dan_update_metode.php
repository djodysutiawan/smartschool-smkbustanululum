<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('absensi', function (Blueprint $table) {
            $table->foreignId('tahun_ajaran_id')
                  ->nullable()
                  ->after('kelas_id')
                  ->constrained('tahun_ajaran')
                  ->nullOnDelete();

            $table->foreignId('mata_pelajaran_id')
                  ->nullable()
                  ->after('tahun_ajaran_id')
                  ->constrained('mata_pelajaran')
                  ->nullOnDelete();

            $table->foreignId('sesi_qr_id')
                  ->nullable()
                  ->after('mata_pelajaran_id')
                  ->constrained('sesi_qr')
                  ->nullOnDelete();
        });

        DB::statement("ALTER TABLE absensi MODIFY COLUMN metode 
            ENUM('manual','qr_scan','wajah','rfid','import') 
            NOT NULL DEFAULT 'manual'");
    }

    public function down(): void
    {
        Schema::table('absensi', function (Blueprint $table) {
            $table->dropForeign(['tahun_ajaran_id']);
            $table->dropForeign(['mata_pelajaran_id']);
            $table->dropForeign(['sesi_qr_id']);
            $table->dropColumn(['tahun_ajaran_id', 'mata_pelajaran_id', 'sesi_qr_id']);
        });
    }
};