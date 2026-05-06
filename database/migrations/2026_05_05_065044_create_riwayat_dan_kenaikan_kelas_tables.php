<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Dua tabel untuk proses naik kelas:
 *
 * 1. riwayat_kelas_siswa
 *    - Mencatat histori kelas siswa per tahun ajaran
 *    - Siswa bisa pindah kelas, naik kelas, tidak naik, atau lulus
 *
 * 2. kenaikan_kelas
 *    - Batch proses kenaikan kelas oleh admin/wali kelas
 *    - Satu record = satu proses batch (misal: naik kelas X → XI TA 2024/2025)
 *    - Detail per siswa ada di kenaikan_kelas_detail
 *
 * 3. kenaikan_kelas_detail
 *    - Detail per siswa dalam satu batch kenaikan kelas
 */
return new class extends Migration
{
    public function up(): void
    {
        // ── 1. Riwayat kelas siswa ────────────────────────────────────────────
        Schema::create('riwayat_kelas_siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->cascadeOnDelete();
            $table->foreignId('kelas_id')->constrained('kelas')->cascadeOnDelete();
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajaran')->cascadeOnDelete();

            $table->enum('tingkat', ['X', 'XI', 'XII']);
            $table->enum('status_akhir', [
                'naik_kelas',      // Lanjut ke tingkat berikutnya
                'tidak_naik',      // Mengulang tingkat yang sama
                'lulus',           // Selesai XII
                'pindah_keluar',   // Pindah ke sekolah lain
                'dikeluarkan',     // Drop out
                'aktif',           // Masih berjalan (tahun ajaran ini)
            ])->default('aktif');

            $table->date('tanggal_masuk_kelas');
            $table->date('tanggal_keluar_kelas')->nullable();
            $table->text('keterangan')->nullable();
            $table->foreignId('dicatat_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['siswa_id', 'tahun_ajaran_id'], 'uniq_siswa_tahun_ajaran');
        });

        // ── 2. Batch kenaikan kelas ───────────────────────────────────────────
        Schema::create('kenaikan_kelas', function (Blueprint $table) {
            $table->id();

            // Dari TA ini ...
            $table->foreignId('tahun_ajaran_asal_id')
                  ->constrained('tahun_ajaran')->cascadeOnDelete();
            // ... ke TA ini
            $table->foreignId('tahun_ajaran_tujuan_id')
                  ->constrained('tahun_ajaran')->cascadeOnDelete();

            $table->enum('dari_tingkat', ['X', 'XI', 'XII']);
            $table->enum('ke_tingkat', ['XI', 'XII', 'lulus']); // XII lulus → 'lulus'

            // Siapa yang memproses
            $table->foreignId('diproses_oleh')->constrained('users')->cascadeOnDelete();
            $table->timestamp('diproses_pada')->useCurrent();

            $table->enum('status', ['draft', 'diproses', 'selesai', 'dibatalkan'])->default('draft');

            // Ringkasan hasil
            $table->unsignedSmallInteger('total_siswa')->default(0);
            $table->unsignedSmallInteger('naik_kelas')->default(0);
            $table->unsignedSmallInteger('tidak_naik')->default(0);
            $table->unsignedSmallInteger('lulus')->default(0);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        // ── 3. Detail kenaikan kelas per siswa ───────────────────────────────
        Schema::create('kenaikan_kelas_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kenaikan_kelas_id')
                  ->constrained('kenaikan_kelas')->cascadeOnDelete();
            $table->foreignId('siswa_id')->constrained('siswa')->cascadeOnDelete();

            // Kelas asal
            $table->foreignId('kelas_asal_id')->constrained('kelas')->cascadeOnDelete();
            // Kelas tujuan (null jika tidak naik / lulus)
            $table->foreignId('kelas_tujuan_id')->nullable()->constrained('kelas')->nullOnDelete();

            $table->enum('keputusan', ['naik_kelas', 'tidak_naik', 'lulus']);

            // Data pendukung keputusan (snapshot saat proses)
            $table->decimal('rata_rata_nilai', 5, 2)->nullable();
            $table->unsignedSmallInteger('total_hadir')->default(0);
            $table->unsignedSmallInteger('total_pertemuan')->default(0);
            $table->decimal('persentase_kehadiran', 5, 2)->nullable();

            // Syarat minimum (bisa di-override per siswa)
            $table->boolean('memenuhi_syarat_nilai')->default(true);
            $table->boolean('memenuhi_syarat_kehadiran')->default(true);

            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->unique(['kenaikan_kelas_id', 'siswa_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kenaikan_kelas_detail');
        Schema::dropIfExists('kenaikan_kelas');
        Schema::dropIfExists('riwayat_kelas_siswa');
    }
};