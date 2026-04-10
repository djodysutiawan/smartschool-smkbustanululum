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
        Schema::create('qr_sessions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('class_id')->constrained();
            $table->foreignId('subject_id')->constrained();

            $table->string('kode_qr');
            $table->timestamp('expired_at');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qr_sessions');
    }
};
