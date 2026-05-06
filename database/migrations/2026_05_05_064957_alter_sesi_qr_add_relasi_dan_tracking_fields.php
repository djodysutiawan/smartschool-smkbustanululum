<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Perbaikan tabel sesi_qr:
 * - Tambah guru_id (siapa yang generate QR)
 * - Tambah jadwal_pelajaran_id (QR terkait jadwal spesifik)
 * - Ganti mata_pelajaran_id + kelas_id menjadi optional (sudah bisa diambil dari jadwal)
 * - Tambah lokasi (lat/lng) untuk validasi radius
 * - Tambah jumlah_scan untuk monitoring
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sesi_qr', function (Blueprint $table) {
            // Tambah relasi ke jadwal_pelajaran (opsional, jika QR di-generate dari jadwal)
            $table->foreignId('jadwal_pelajaran_id')
                  ->nullable()
                  ->after('mata_pelajaran_id')
                  ->constrained('jadwal_pelajaran')
                  ->nullOnDelete();

            // Tambah guru yang membuat QR (bisa berbeda dengan 'dibuat_oleh' yang User)
            $table->foreignId('guru_id')
                  ->nullable()
                  ->after('jadwal_pelajaran_id')
                  ->constrained('guru')
                  ->nullOnDelete();

            // Lokasi GPS untuk validasi radius
            $table->decimal('latitude', 10, 8)->nullable()->after('radius_meter');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');

            // Counter scan untuk monitoring
            $table->unsignedSmallInteger('jumlah_scan')->default(0)->after('longitude');

            // Maksimal scan (0 = unlimited)
            $table->unsignedSmallInteger('maks_scan')->default(0)->after('jumlah_scan');
        });
    }

    public function down(): void
    {
        Schema::table('sesi_qr', function (Blueprint $table) {
            $table->dropForeign(['jadwal_pelajaran_id']);
            $table->dropForeign(['guru_id']);
            $table->dropColumn([
                'jadwal_pelajaran_id',
                'guru_id',
                'latitude',
                'longitude',
                'jumlah_scan',
                'maks_scan',
            ]);
        });
    }
};