<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParameterLab extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $casts = [
        'pemeriksaan' => 'array',
    ];
    public function pemeriksaans()
    {
        return $this->hasMany(ParameterLab::class, 'pemeriksaan', 'code');
    }
}
