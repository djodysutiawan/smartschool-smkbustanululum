<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('riwayat_scan_qr', function (Blueprint $table) {

            // Relasi ke absensi
            $table->foreignId('absensi_id')
                  ->nullable()
                  ->after('siswa_id')
                  ->constrained('absensi')
                  ->nullOnDelete();

            // Jarak dari titik QR
            $table->unsignedSmallInteger('jarak_meter')
                  ->nullable()
                  ->after('longitude');

            // Status hasil scan (menggantikan 'hasil' lama kalau perlu)
            $table->enum('status', [
                'valid',
                'ditolak_radius',
                'ditolak_kadaluarsa',
                'ditolak_nonaktif',
                'ditolak_duplikat',
                'ditolak_bukan_anggota',
            ])->default('valid')->after('hasil');

            // Keterangan tambahan
            $table->string('keterangan')->nullable()->after('status');

            // Rename kolom biar konsisten (opsional tapi disarankan)
            $table->renameColumn('dipindai_pada', 'di_scan_pada');
            $table->renameColumn('info_perangkat', 'user_agent');
        });

        // OPTIONAL: update enum 'hasil' jadi tidak dipakai lagi
        // atau kamu bisa drop kalau sudah pindah ke 'status'
        // DB::statement("ALTER TABLE riwayat_scan_qr DROP COLUMN hasil");
    }

    public function down(): void
    {
        Schema::table('riwayat_scan_qr', function (Blueprint $table) {

            $table->dropForeign(['absensi_id']);
            $table->dropColumn([
                'absensi_id',
                'jarak_meter',
                'status',
                'keterangan',
            ]);

            // balikkan nama kolom
            $table->renameColumn('di_scan_pada', 'dipindai_pada');
            $table->renameColumn('user_agent', 'info_perangkat');
        });
    }
};