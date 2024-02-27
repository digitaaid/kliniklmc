<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsesmenPerawat extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function antrian()
    {
        return $this->belongsTo(Antrian::class);
    }
    public function kunjungan()
    {
        return $this->belongsTo(Antrian::class);
    }
    public function pic1()
    {
        return $this->hasOne(User::class,  'id', 'user');
    }
}
