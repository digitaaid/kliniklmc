<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function pasien()
    {
        return $this->hasOne(Pasien::class,  'norm', 'norm');
    }
    public function jadwals()
    {
        return $this->belongsTo(JadwalDokter::class, 'id', 'jadwal_id');
    }
    public function suratkontrols()
    {
        return $this->hasMany(SuratKontrol::class, 'kodebooking', 'kodebooking');
    }
    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class, 'kodebooking', 'kode');
    }
    public function asesmenperawat()
    {
        return $this->hasOne(AsesmenPerawat::class);
    }
    public function sbar()
    {
        return $this->hasOne(SbarTbak::class);
    }
    public function asesmendokter()
    {
        return $this->hasOne(AsesmenDokter::class);
    }
    public function permintaan_lab()
    {
        return $this->hasOne(PermintaanLab::class);
    }
    public function resepobat()
    {
        return $this->hasOne(ResepObat::class);
    }
    public function layanans()
    {
        return $this->hasMany(Layanan::class);
    }
    public function fileuploads()
    {
        return $this->hasMany(FileUploadPasien::class);
    }
    public function unit()
    {
        return $this->hasOne(Unit::class, 'kode', 'kodepoli');
    }
    public function pic1()
    {
        return $this->hasOne(User::class,  'id', 'user1');
    }
    public function pic2()
    {
        return $this->hasOne(User::class,  'id', 'user2');
    }
    public function pic3()
    {
        return $this->hasOne(User::class,  'id', 'user3');
    }
    public function pic4()
    {
        return $this->hasOne(User::class,  'id', 'user4');
    }
}
