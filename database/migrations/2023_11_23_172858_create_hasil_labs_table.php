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
        Schema::create('hasil_labs', function (Blueprint $table) {
            $table->id();
            $table->string('kodepermintaan')->index();
            $table->string('permintaanlab_id')->index();
            $table->string('parameter_id')->index();
            $table->string('hasil')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_labs');
    }
};
