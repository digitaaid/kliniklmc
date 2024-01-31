<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResepObat extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function resepdetail()
    {
        return $this->hasMany(ResepObatDetail::class, 'koderesep', 'kode');
    }
    public function antrian()
    {
        return $this->hasOne(Antrian::class, 'id', 'antrian_id');
    }
}
