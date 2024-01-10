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
        Schema::create('kunjungans', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique()->index();
            $table->integer('counter');
            $table->datetime('tgl_masuk');
            $table->datetime('tgl_pulang')->nullable();
            $table->string('jaminan');
            // identitas pasien
            $table->string('nomorkartu');
            $table->string('norm');
            $table->string('nama');
            $table->date('tgl_lahir');
            $table->string('gender');
            $table->string('kelas');
            $table->string('penjamin');

            $table->string('jeniskunjungan');
            $table->string('nomorreferensi')->nullable();
            $table->string('sep')->nullable();

            $table->string('unit');
            $table->string('dokter');

            $table->string('diagnosa_awal')->nullable();
            $table->string('diagnosa1')->nullable();
            $table->string('diagnosa2')->nullable();

            $table->string('cara_masuk');
            $table->string('alasan_pulang')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('catatan')->nullable();
            $table->string('status');
            $table->string('user1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kunjungans');
    }
};
