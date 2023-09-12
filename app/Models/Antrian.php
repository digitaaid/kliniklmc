<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function jadwals()
    {
        return $this->belongsTo(JadwalDokter::class, 'id', 'jadwal_id');
    }
    public function suratkontrol()
    {
        return $this->belongsTo(SuratKontrol::class, 'kodebooking', 'kodebooking');
    }


}
