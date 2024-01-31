<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokObat extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function obat()
    {
        return $this->hasOne(Obat::class, 'id', 'obat_id');
    }
}
