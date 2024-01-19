<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function pic()
    {
        return $this->hasOne(User::class,  'id', 'user');
    }
    public function reseps()
    {
        return $this->hasMany(ResepObatDetail::class, 'obat_id', 'id');
    }
    public function stoks()
    {
        return $this->hasMany(StokObat::class, 'obat_id', 'id');
    }
}
