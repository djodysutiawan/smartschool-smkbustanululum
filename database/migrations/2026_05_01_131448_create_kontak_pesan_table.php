<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel: kontak_pesan
     * Menyimpan pesan masuk dari form kontak di website publik.
     */
    public function up(): void
    {
        Schema::create('kontak_pesan', function (Blueprint $table) {
            $table->id();

            $table->string('nama_pengirim');
            $table->string('email_pengirim')->nullable();
            $table->string('no_telepon')->nullable();
            $table->string('subjek')->nullable();
            $table->text('pesan');
            $table->string('ip_address', 45)->nullable();

            $table->enum('status', ['baru', 'dibaca', 'dibalas', 'arsip'])->default('baru');
            $table->text('catatan_admin')->nullable();              // catatan internal admin
            $table->timestamp('dibaca_at')->nullable();

            $table->foreignId('dibaca_oleh')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kontak_pesan');
    }
};