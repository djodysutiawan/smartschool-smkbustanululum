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
        Schema::create('sesi_qr_guru', function (Blueprint $table) {
            $table->id();
            $table->uuid('kode_qr')->unique();
            $table->foreignId('dibuat_oleh')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();
            $table->date('tanggal');
            $table->timestamp('berlaku_mulai');
            $table->timestamp('kadaluarsa_pada');
            $table->integer('radius_meter')->nullable()->comment('Radius GPS dalam meter, null = tidak dibatasi');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
 
            $table->index(['tanggal', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sesi_qr_guru');
    }
};
