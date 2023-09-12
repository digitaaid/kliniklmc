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
        Schema::create('antrians', function (Blueprint $table) {
            $table->id();
            $table->string('kodebooking')->unique();
            $table->string('jenispasien')->nullable();
            $table->string('nomorkartu')->nullable();
            $table->string('nik')->nullable();
            $table->string('nohp')->nullable();
            $table->string('kodepoli')->nullable();
            $table->string('namapoli')->nullable();
            $table->string('pasienbaru')->nullable();
            $table->string('norm')->nullable();
            $table->date('tanggalperiksa');
            $table->string('kodedokter')->nullable();
            $table->string('namadokter')->nullable();
            $table->string('jampraktek')->nullable();
            $table->string('jeniskunjungan')->nullable();
            $table->string('nomorreferensi')->nullable();
            $table->string('nomorantrean');
            $table->string('angkaantrean');
            $table->string('estimasidilayani')->nullable();
            $table->integer('sisakuotajkn')->nullable();
            $table->integer('kuotajkn')->nullable();
            $table->integer('sisakuotanonjkn')->nullable();
            $table->integer('kuotanonjkn')->nullable();
            $table->text('keterangan')->nullable();
            $table->text('jenisresep')->nullable();
            $table->text('catatan')->nullable();
            $table->string('nama')->nullable();
            $table->string('sep')->nullable();
            $table->string('nomorrujukan')->nullable();
            $table->string('nomorsuratkontrol')->nullable();
            $table->string('jadwal_id')->nullable();
            $table->string('method')->nullable();
            $table->integer('taskid')->default(0);
            $table->string('user1')->nullable();
            $table->string('user2')->nullable();
            $table->string('user3')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antrians');
    }
};
