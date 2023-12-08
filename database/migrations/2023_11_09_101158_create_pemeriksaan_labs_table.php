s<?php

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
            Schema::create('pemeriksaan_labs', function (Blueprint $table) {
                $table->id();
                $table->string('nama');
                $table->string('kode');
                $table->string('jenis')->nullable();
                $table->string('group')->nullable();
                $table->string('kelompok')->nullable();
                $table->string('tarif_id');
                $table->string('status')->default('1');
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('pemeriksaan_labs');
        }
    };
