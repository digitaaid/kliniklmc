<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function jadwals()
    {
        return $this->hasMany(JadwalDokter::class,  'kodepoli', 'kode');
    }
}
