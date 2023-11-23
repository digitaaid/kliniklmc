<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilLab extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $casts = [
        'parameter_id' => 'json',
        'hasil' => 'json',
        'keterangan' => 'json',
    ];
}
