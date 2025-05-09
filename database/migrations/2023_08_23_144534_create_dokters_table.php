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
        Schema::create('dokters', function (Blueprint $table) {
            $table->id();
            $table->string('namadokter');
            $table->string('kodedokter')->unique();
            $table->string('kodejkn')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('gender')->default("L");
            $table->string('sip')->nullable();
            $table->string('image')->nullable();
            $table->boolean('status')->default(1);
            $table->string('user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokters');
    }
};
