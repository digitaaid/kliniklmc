<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResepKemoterapi extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function resepdetail()
    {
        return $this->hasMany(ResepObatDetail::class, 'koderesep', 'kode');
    }
}
