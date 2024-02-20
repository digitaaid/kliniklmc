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
        Schema::create('order_obat_details', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->string('kodeorder');
            $table->string('obat_id');
            $table->string('nama');
            $table->integer('jumlah');
            $table->string('interval')->nullable();
            $table->string('waktu')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_obat_details');
    }
};
