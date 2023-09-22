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
            $table->string('resep_id');
            $table->string('koderesep');
            $table->string('nama');
            $table->integer('jumlah');
            $table->string('interval')->nullable();
            $table->string('waktu')->nullable();
            $table->text('keterangan');
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
