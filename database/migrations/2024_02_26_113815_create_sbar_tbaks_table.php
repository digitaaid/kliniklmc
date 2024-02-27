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
        Schema::create('sbar_tbaks', function (Blueprint $table) {
            $table->id();
            $table->string('kunjungan_id');
            $table->string('kodekunjungan');
            $table->string('antrian_id');
            $table->string('kodebooking');
            $table->string('counter');
            $table->string('norm');
            $table->string('nama');
            $table->string('tgl_lahir');
            $table->string('gender');

            $table->text('situation')->nullable();
            $table->text('background')->nullable();
            $table->text('assessment')->nullable();
            $table->text('recomendation')->nullable();
            $table->text('tulis')->nullable();
            $table->text('baca')->nullable();
            $table->text('konfirmasi')->nullable();

            $table->dateTime('waktu_sbar')->nullable();
            $table->string('pengirim')->nullable();
            $table->string('no_pengirim')->nullable();
            $table->string('user_pengirim')->nullable();
            $table->dateTime('waktu_tbak')->nullable();
            $table->string('penerima')->nullable();
            $table->string('no_penerima')->nullable();
            $table->string('user_penerima')->nullable();

            $table->string('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sbar_tbaks');
    }
};
