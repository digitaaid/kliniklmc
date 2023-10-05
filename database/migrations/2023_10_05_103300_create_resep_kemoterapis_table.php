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
        Schema::create('resep_kemoterapis', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->datetime('waktu');
            $table->string('norm');
            $table->string('nama');
            $table->string('diagnosa')->nullable();
            $table->string('diagnosa_icd10')->nullable();
            $table->string('regimen')->nullable();
            $table->string('dpjp')->nullable();
            $table->string('user');
            $table->string('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resep_kemoterapis');
    }
};
