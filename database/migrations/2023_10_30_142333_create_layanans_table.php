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
        Schema::create('layanans', function (Blueprint $table) {
            $table->id();
            $table->string('kodekunjungan');
            $table->string('kunjungan_id');
            $table->string('kodebooking');
            $table->string('antrian_id');
            $table->string('kode');
            $table->string('norm');
            $table->string('nama');
            $table->string('laboratorium')->default(0);
            $table->string('radiologi')->default(0);
            $table->string('kemoterapi')->default(0);
            $table->string('user');
            $table->string('status')->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanans');
    }
};
