<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderObat extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function orderdetail()
    {
        return $this->hasMany(OrderObatDetail::class, 'order_id', 'id');
    }
}
