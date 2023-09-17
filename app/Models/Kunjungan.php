<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function asesmenperawat()
    {
        return $this->hasOne(AsesmenPerawat::class);
    }
}
