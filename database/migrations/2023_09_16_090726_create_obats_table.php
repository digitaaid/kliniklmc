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
        Schema::create('obats', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('bpom')->nullable();
            $table->string('barcode')->nullable();
            $table->string('stok_minimum')->nullable();
            $table->string('kemasan')->nullable();
            $table->integer('konversi_satuan')->default(1);
            $table->string('satuan')->nullable();
            $table->string('harga_beli')->default(0);
            $table->string('diskon_beli')->default(0);
            $table->string('harga_jual')->default(0);
            $table->string('jenisobat')->nullable();
            $table->string('tipeobat')->nullable();
            $table->string('distributor')->nullable();
            $table->string('merk')->nullable();
            $table->string('user')->default(1);
            $table->string('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obats');
    }
};
