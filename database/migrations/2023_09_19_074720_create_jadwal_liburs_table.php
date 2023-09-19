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
        Schema::create('jadwal_liburs', function (Blueprint $table) {
            $table->id();
            $table->string('kodepoli');
            $table->string('namapoli');
            $table->string('kodedokter');
            $table->string('namadokter');
            $table->date('tanggalawal');
            $table->date('tanggalakhir');
            $table->text('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_liburs');
    }
};
