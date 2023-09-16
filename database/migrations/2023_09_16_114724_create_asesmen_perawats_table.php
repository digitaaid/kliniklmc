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
        Schema::create('asesmen_perawats', function (Blueprint $table) {
            $table->id();
            $table->text('keluhan_utama')->nullable();
            $table->text('riwayat_penyakit')->nullable();
            $table->text('riwayat_alergi')->nullable();
            $table->text('riwayat_pengobatan')->nullable();
            $table->string('tingkat_kesadaran')->nullable();
            $table->string('berat_badan')->nullable();
            $table->string('tinggi_badan')->nullable();
            $table->string('bsa')->nullable();
            $table->string('denyut_jantung')->nullable();
            $table->string('pernapasan')->nullable();
            $table->string('sistole')->nullable();
            $table->string('distole')->nullable();
            $table->string('suhu')->nullable();
            $table->string('keadaan_tubuh')->nullable();
            $table->string('status_psikologi')->nullable();
            $table->text('status_sosial')->nullable();
            $table->text('status_spiritual')->nullable();
            $table->datetime('waktu');
            $table->string('kunjungan');
            $table->string('counter');
            $table->string('norm');
            $table->string('nama');
            $table->string('tgl_lahir');
            $table->string('gender');
            $table->string('user');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asesmen_perawats');
    }
};
