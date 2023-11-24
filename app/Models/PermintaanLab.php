<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermintaanLab extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // protected $casts = ['permintaan_lab' => 'json'];

    public function pasien()
    {
        return $this->hasOne(Pasien::class,  'norm', 'norm');
    }
    public function hasillab()
    {
        return $this->hasOne(HasilLab::class, 'permintaanlab_id', 'id');
    }
}
