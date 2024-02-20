<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderObatDetail extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function obat()
    {
        return $this->belongsTo(Obat::class, 'obat_id', 'id');
    }
    public function orderobat()
    {
        return $this->hasOne(OrderObat::class,  'id', 'order_id');
    }
}
