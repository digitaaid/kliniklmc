<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileUploadPasien extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $appends = ['norm6digit'];
    public function getNorm6digitAttribute()
    {
        return substr($this->norm, -6);
    }
    public function pasien()
    {
        return $this->hasOne(Pasien::class,  'norm', 'norm6digit');
    }
}
