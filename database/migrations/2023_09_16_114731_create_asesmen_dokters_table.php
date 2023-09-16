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
        Schema::create('asesmen_dokters', function (Blueprint $table) {
            $table->id();
            $table->text('riwayat_pengobatan')->nullable();
            $table->text('rencana_perawatan')->nullable();
            $table->text('instruksi_medis')->nullable();
            $table->string('diagnosa1')->nullable();
            $table->string('diagnosa2')->nullable();
            $table->text('terapi')->nullable();
            $table->text('obat')->nullable();
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
        Schema::dropIfExists('asesmen_dokters');
    }
};
