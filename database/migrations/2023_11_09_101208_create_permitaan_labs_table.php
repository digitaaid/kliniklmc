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
        Schema::create('permitaan_labs', function (Blueprint $table) {
            $table->id();
            $table->string('antrian_id')->nullable();
            $table->string('kodebooking')->nullable();
            $table->string('kunjungan_id')->nullable();
            $table->string('kodekunjungan')->nullable();
            $table->string('kode')->unique();
            $table->datetime('waktu');
            $table->string('norm');
            $table->string('nama');
            $table->string('diagnosa')->nullable();
            $table->string('diagnosa_icd10')->nullable();
            $table->string('dpjp')->nullable();
            $table->text('catatan')->nullable();
            $table->string('status')->default(1);
            $table->string('user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permitaan_labs');
    }
};
