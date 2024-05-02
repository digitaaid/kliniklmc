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
        Schema::create('resep_obats', function (Blueprint $table) {
            $table->id();
            $table->string('kunjungan_id');
            $table->string('kodekunjungan');
            $table->string('antrian_id');
            $table->string('kodebooking');
            $table->string('kode');
            $table->string('dokter');
            $table->string('berat_badan')->nullable();
            $table->string('tinggi_badan')->nullable();
            $table->string('bsa')->nullable();
            $table->datetime('waktu');
            $table->string('norm');
            $table->string('nama');
            $table->string('tgl_lahir');
            $table->string('gender');
            $table->string('pic')->nullable();
            $table->string('user')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resep_obats');
    }
};
