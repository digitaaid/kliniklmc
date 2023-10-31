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
    public function layanan()
    {
        return $this->hasOne(Layanan::class);
    }
    public function jaminans()
    {
        return $this->belongsTo(Jaminan::class, 'jaminan', 'kode');
    }
    public function antrian()
    {
        return $this->belongsTo(Antrian::class,  'kode', 'kodebooking');
    }
    public function units()
    {
        return $this->hasOne(Unit::class,  'kode', 'unit');
    }
    public function resepobat()
    {
        return $this->hasOne(ResepObat::class);
    }
    public function files()
    {
        return $this->hasMany(FileUploadPasien::class);
    }
}
