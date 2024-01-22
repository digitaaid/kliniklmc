<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResepObatDetail extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function obat()
    {
        return $this->belongsTo(Obat::class, 'obat_id', 'id');
    }
    public function resepobat()
    {
        return $this->hasOne(ResepObat::class,  'id', 'resep_id');
    }
}
