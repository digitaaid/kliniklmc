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
        Schema::create('tindakan_pasiens', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('petugas');
            $table->text('alat_medis')->nullable();
            $table->text('bmhp')->nullable();
            $table->datetime('waktu_awal')->nullable();
            $table->datetime('waktu_selesai')->nullable();
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
        Schema::dropIfExists('tindakan_pasiens');
    }
};
