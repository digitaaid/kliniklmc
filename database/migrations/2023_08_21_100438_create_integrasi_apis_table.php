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
        Schema::create('integrasi_apis', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->index();
            $table->string('user_id')->nullable();
            $table->string('base_url')->nullable();
            $table->string('auth_url')->nullable();
            $table->string('user_key')->nullable();
            $table->string('secret_key')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('integrasi_apis');
    }
};
