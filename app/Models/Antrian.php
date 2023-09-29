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
        return $this->belongsTo(Kunjungan::class);
    }
    public function asesmenperawat()
    {
        return $this->hasOne(AsesmenPerawat::class);
    }
    public function asesmendokter()
    {
        return $this->hasOne(AsesmenDokter::class);
    }
    public function resepobat()
    {
        return $this->hasOne(ResepObat::class);
    }
    public function fileuploads()
    {
        return $this->hasMany(FileUploadPasien::class);
    }
}
