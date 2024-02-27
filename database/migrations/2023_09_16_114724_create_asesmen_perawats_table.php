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
        Schema::create('asesmen_perawats', function (Blueprint $table) {
            $table->id();
            $table->string('sumber_data')->nullable();
            $table->text('keluhan_utama')->nullable();
            $table->text('riwayat_penyakit')->nullable();
            $table->text('riwayat_penyakit_keluarga')->nullable();
            $table->text('riwayat_alergi')->nullable();
            $table->text('riwayat_pengobatan')->nullable();

            $table->string('skala_nyeri')->nullable();
            $table->string('keluhan_nyeri')->nullable();
            $table->string('resiko_jatuh')->nullable();
            $table->string('alat_bantu')->nullable();
            $table->string('alat_bantu_text')->nullable();
            $table->string('cacat_fisik')->nullable();
            $table->string('cacat_fisik_text')->nullable();

            $table->string('status_psikologi')->nullable();
            $table->string('tinggal_dengan')->nullable();
            $table->string('hubungan_keluarga')->nullable();
            $table->string('ekonomi')->nullable();
            $table->string('edukasi')->nullable();

            $table->string('pekerjaan')->nullable();
            $table->string('agama')->nullable();
            $table->string('pendidikan')->nullable();
            $table->string('status_nikah')->nullable();
            $table->string('bahasa')->nullable();

            $table->string('penurunan_berat_badan')->nullable();
            $table->string('asupan_berkurang')->nullable();
            $table->string('apakah_diagnosa_khusus')->nullable();

            $table->string('denyut_jantung')->nullable();
            $table->string('pernapasan')->nullable();
            $table->string('sistole')->nullable();
            $table->string('distole')->nullable();
            $table->string('suhu')->nullable();
            $table->string('berat_badan')->nullable();
            $table->string('tinggi_badan')->nullable();
            $table->string('bsa')->nullable();
            $table->string('tingkat_kesadaran')->nullable();
            $table->text('keadaan_tubuh')->nullable();

            $table->text('pemeriksaan_lab')->nullable();
            $table->text('pemeriksaan_rad')->nullable();
            $table->text('pemeriksaan_penunjang')->nullable();

            $table->text('diagnosa_keperawatan')->nullable();
            $table->text('rencana_keperawatan')->nullable();
            $table->text('tindakan_keperawatan')->nullable();
            $table->text('evaluasi_keperawatan')->nullable();

            $table->datetime('waktu');
            $table->string('kunjungan_id');
            $table->string('kodekunjungan');
            $table->string('antrian_id');
            $table->string('kodebooking');
            $table->string('counter');
            $table->string('norm');
            $table->string('nama');
            $table->string('tgl_lahir');
            $table->string('gender');

            $table->string('pic');
            $table->string('user');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asesmen_perawats');
    }
};
