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
        Schema::create('resep_obat_details', function (Blueprint $table) {
            $table->id();
            $table->string('koderesep');
            $table->string('idresep');
            $table->string('nama');
            $table->integer('jumlah');
            $table->string('sediaan');
            $table->string('metode_pemberian');
            $table->string('dosis');
            $table->string('satuan');
            $table->string('interval');
            $table->string('aturan_tambahan')->nullable();
            $table->text('catatan')->nullable();
            $table->string('dokter');
            $table->string('petugas');
            $table->string('nohp')->nullable();
            $table->datetime('waktu');
            $table->string('status')->default(0);
            $table->string('pengkajian');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resep_obat_details');
    }
};
