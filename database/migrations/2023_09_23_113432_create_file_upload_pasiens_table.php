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
        Schema::create('file_upload_pasiens', function (Blueprint $table) {
            $table->id();
            $table->string('kodebooking')->nullable();
            $table->string('antrian_id')->nullable();
            $table->string('kodekunjungan')->nullable();
            $table->string('kunjungan_id')->nullable();
            $table->string('norm')->nullable();
            $table->string('namapasien')->nullable();
            $table->string('nama');
            $table->string('label')->nullable();
            $table->string('type');
            $table->string('fileurl');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_upload_pasiens');
    }
};
