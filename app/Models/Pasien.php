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
        return $this->hasMany(Kunjungan::class, 'norm', 'norm');
    }
    public function fileuploads()
    {
        return $this->hasMany(FileUploadPasien::class,  'norm', 'norm');
    }
    public function pic()
    {
        return $this->hasOne(User::class,  'id', 'user');
    }
    public function antrians()
    {
        return $this->hasMany(Kunjungan::class, 'norm', 'norm');
    }
}
