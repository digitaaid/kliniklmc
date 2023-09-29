<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function kunjungans()
    {
        return $this->hasMany(Kunjungan::class, 'norm', 'norm6digit');
    }
    public function fileuploads()
    {
        return $this->hasMany(FileUploadPasien::class,  'norm6digit', 'norm');
    }
}
