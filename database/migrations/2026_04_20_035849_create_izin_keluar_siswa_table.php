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

        Schema::create('izin_keluar_siswa', function (Blueprint $table) {
            $table->id();
 
            // Relasi utama
            $table->foreignId('siswa_id')->constrained('siswa')->cascadeOnDelete();
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajaran')->restrictOnDelete();
 
            // Informasi izin
            $table->date('tanggal');
            $table->time('jam_keluar');
            $table->time('jam_kembali')->nullable();     // diisi saat siswa kembali
            $table->time('jam_kembali_aktual')->nullable(); // dicatat piket saat siswa benar-benar kembali
 
            $table->string('tujuan');                    // misal: "Ke dokter", "Keperluan keluarga"
            $table->enum('kategori', [
                'keperluan_keluarga',
                'berobat',
                'keperluan_sekolah',
                'lainnya',
            ])->default('lainnya');
 
            $table->text('keterangan')->nullable();      // detail tambahan
 
            // Status proses izin
            $table->enum('status', [
                'menunggu',     // baru diajukan, belum diproses piket
                'disetujui',    // disetujui oleh guru piket, surat bisa dicetak
                'ditolak',      // ditolak guru piket
                'sudah_kembali',// siswa sudah kembali ke sekolah
            ])->default('menunggu');
 
            // Siapa yang memproses
            $table->foreignId('diproses_oleh')->nullable()->constrained('users')->nullOnDelete(); // guru piket
            $table->timestamp('diproses_pada')->nullable();
 
            // Siapa yang mencatat kepulangan
            $table->foreignId('dicatat_kembali_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('dicatat_kembali_pada')->nullable();
 
            $table->text('catatan_piket')->nullable();   // catatan dari guru piket saat approve/tolak/kembali
 
            // Nomor surat (auto-generate saat disetujui)
            $table->string('nomor_surat')->nullable()->unique();
 
            $table->softDeletes();
            $table->timestamps();
 
            // Index untuk performa query
            $table->index(['tanggal', 'status']);
            $table->index(['siswa_id', 'tanggal']);
            $table->index(['tahun_ajaran_id', 'tanggal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izin_keluar_siswa');
    }
};
