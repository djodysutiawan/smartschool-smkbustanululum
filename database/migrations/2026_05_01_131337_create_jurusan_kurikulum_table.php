<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel-tabel detail jurusan:
     *  - jurusan_kurikulum   : daftar mata pelajaran / struktur kurikulum per jurusan
     *  - jurusan_kompetensi  : kompetensi/keahlian yang diajarkan
     *  - jurusan_prospek_kerja : daftar prospek karir lulusan
     *  - jurusan_fasilitas   : fasilitas khusus yang dimiliki jurusan
     */
    public function up(): void
    {
        // ── Kurikulum ──────────────────────────────────────────────────
        Schema::create('jurusan_kurikulum', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jurusan_id')->constrained('jurusan')->cascadeOnDelete();

            $table->string('nama_mapel');                           // Pemrograman Web
            $table->string('kelompok')->nullable();                 // C1/C2/C3 atau Umum/Kejuruan
            $table->tinyInteger('kelas')->nullable();               // 10 / 11 / 12
            $table->tinyInteger('semester')->nullable();            // 1 / 2 / ganjil+genap
            $table->unsignedSmallInteger('jam_per_minggu')->nullable();
            $table->text('deskripsi')->nullable();
            $table->unsignedSmallInteger('urutan')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jurusan_fasilitas');
        Schema::dropIfExists('jurusan_prospek_kerja');
        Schema::dropIfExists('jurusan_kompetensi');
        Schema::dropIfExists('jurusan_kurikulum');
    }
};