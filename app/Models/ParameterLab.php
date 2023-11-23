<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParameterLab extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function pemeriksaans()
    {
        return $this->belongsToMany(PemeriksaanLab::class, 'parameter_pemeriksaan_lab', 'parameter_id', 'pemeriksaan_id');
    }
}
