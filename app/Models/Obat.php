<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $appends = ['real_stok'];
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
    public function getRealStokAttribute()
    {
        $obat_keluar = 0;
        $obat_masuk = 0;
        if ($this->reseps) {
            $obat_keluar = $this->reseps->sum('jumlah');
        }
        if ($this->stoks) {
            $obat_masuk = $this->stoks->sum('jumlah');
        }
        $realstok = $obat_masuk - $obat_keluar;
        return $realstok; //or however you want to manipulate it
    }
}
