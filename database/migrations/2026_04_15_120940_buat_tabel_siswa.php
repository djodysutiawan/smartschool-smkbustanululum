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
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengguna_id')
                ->nullable()
                ->unique()
                ->constrained('users')
                ->nullOnDelete();
            $table->string('nis', 20)->unique();
            $table->string('nisn', 20)->nullable()->unique();
            $table->string('nama_lengkap', 150);
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('agama', 20)->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->string('email')->nullable();
            $table->string('foto')->nullable();
            $table->string('nama_ayah', 150)->nullable();
            $table->string('pekerjaan_ayah', 100)->nullable();
            $table->string('no_hp_ayah', 20)->nullable();
            $table->string('nama_ibu', 150)->nullable();
            $table->string('pekerjaan_ibu', 100)->nullable();
            $table->string('no_hp_ibu', 20)->nullable();
            $table->string('nama_wali', 150)->nullable();
            $table->string('hubungan_wali', 50)->nullable();
            $table->string('pekerjaan_wali', 100)->nullable();
            $table->string('no_hp_wali', 20)->nullable();
            $table->foreignId('kelas_id')->nullable()->constrained('kelas')->nullOnDelete();
            $table->foreignId('tahun_ajaran_id')->nullable()->constrained('tahun_ajaran')->nullOnDelete();
            $table->enum('status', ['aktif', 'tidak_aktif', 'lulus', 'pindah', 'keluar'])->default('aktif');
            $table->date('tanggal_masuk')->nullable();
            $table->date('tanggal_keluar')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
