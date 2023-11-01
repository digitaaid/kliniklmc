<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function layanandetails()
    {
        return $this->hasMany(LayananDetail::class);
    }
    public function pic()
    {
        return $this->hasOne(User::class,  'id', 'user');
    }
}
