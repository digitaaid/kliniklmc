<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemeriksaanLab extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function parameters()
    {
        return $this->belongsToMany(ParameterLab::class, 'parameter_pemeriksaan_lab',  'pemeriksaan_id', 'parameter_id',);
    }
}
