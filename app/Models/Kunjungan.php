<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function pasien()
    {
        return $this->hasOne(Pasien::class,  'norm', 'norm');
    }
    public function asesmenperawat()
    {
        return $this->hasOne(AsesmenPerawat::class);
    }
    public function asesmendokter()
    {
        return $this->hasOne(AsesmenDokter::class);
    }
    public function layanans()
    {
        return $this->hasMany(Layanan::class);
    }
    public function jaminans()
    {
        return $this->belongsTo(Jaminan::class, 'jaminan', 'kode');
    }
    public function permintaan_lab()
    {
        return $this->hasOne(PermintaanLab::class);
    }
    public function antrian()
    {
        return $this->belongsTo(Antrian::class,  'kode', 'kodebooking');
    }
    public function dokters()
    {
        return $this->hasOne(Dokter::class, 'kodedokter', 'dokter');
    }
    public function units()
    {
        return $this->hasOne(Unit::class,  'kode', 'unit');
    }
    public function resepobat()
    {
        return $this->hasOne(ResepObat::class);
    }
    // public function resepdetail()
    // {
    //     return $this->hasMany(ResepObatDetail::class, 'id', 'antrian_id');
    // }
    public function files()
    {
        return $this->hasMany(FileUploadPasien::class);
    }
    public function pic()
    {
        return $this->hasOne(User::class, 'id', 'user1');
    }
    public function sbar()
    {
        return $this->hasOne(SbarTbak::class);
    }
}
