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
        Schema::create('guru', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengguna_id')
                ->nullable()
                ->unique()
                ->constrained('users')
                ->nullOnDelete();
            $table->string('nip', 30)->nullable()->unique();
            $table->string('nama_lengkap', 150);
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('foto')->nullable();
            $table->string('pendidikan_terakhir', 20)->nullable();
            $table->string('jurusan_pendidikan', 100)->nullable();
            $table->string('universitas', 150)->nullable();
            $table->year('tahun_lulus')->nullable();
            $table->enum('status_kepegawaian', ['pns', 'p3k', 'honorer', 'gtty'])->default('honorer');
            $table->date('tanggal_masuk')->nullable();
            $table->boolean('adalah_guru_piket')->default(false);
            $table->enum('status', ['aktif', 'tidak_aktif', 'cuti'])->default('aktif');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guru');
    }
};
