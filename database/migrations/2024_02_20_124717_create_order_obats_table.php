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
        Schema::create('order_obats', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->datetime('waktu');
            $table->string('nama');
            $table->string('nik')->nullable();
            $table->string('nomorkartu')->nullable();
            $table->string('pic');
            $table->string('user');
            $table->string('status')->default(1);
            $table->text('resep_obat')->nullable();
            $table->text('catatan_resep')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_obats');
    }
};
