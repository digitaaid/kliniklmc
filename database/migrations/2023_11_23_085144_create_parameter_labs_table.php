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
        Schema::create('parameter_labs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('group')->nullable();
            $table->string('kelompok')->nullable();
            $table->text('pemeriksaan')->nullable();
            $table->string('nilai_rujukan')->nullable();
            $table->string('satuan')->nullable();
            $table->string('status')->default(1);
            $table->string('user')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parameter_labs');
    }
};
