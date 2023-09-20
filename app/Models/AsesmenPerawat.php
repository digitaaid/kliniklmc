<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsesmenPerawat extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    /**
     * Get the user associated with the AsesmenPerawat
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function antrian()
    {
        return $this->belongsTo(Antrian::class);
    }
}
