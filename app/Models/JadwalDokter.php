<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalDokter extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function antrians()
    {
        return $this->hasMany(Antrian::class, 'id', 'jadwal_id');
    }
}
