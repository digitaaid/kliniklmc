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
        Schema::create('parameter_pemeriksaan_lab', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pemeriksaan_id');
            $table->unsignedBigInteger('parameter_id');
            $table->timestamps();
            $table->foreign('pemeriksaan_id')->references('id')->on('pemeriksaan_labs')->onDelete('cascade');
            $table->foreign('parameter_id')->references('id')->on('parameter_labs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
