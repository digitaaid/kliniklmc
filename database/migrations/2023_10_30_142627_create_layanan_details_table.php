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
        // Schema::create('layanan_details', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('layanan_id');
        //     $table->string('kodelayanan');
        //     $table->string('tarif_id');
        //     $table->string('nama');
        //     $table->double('harga');
        //     $table->integer('jumlah');
        //     $table->integer('diskon');
        //     $table->string('klasifikasi');
        //     $table->text('keterangan')->nullable();
        //     $table->dateTime('tgl_input');
        //     $table->string('user');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanan_details');
    }
};
