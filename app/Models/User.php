<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, MustVerifyEmail;
    protected $guarded = ['id'];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function verificator()
    {
        return $this->hasOne(User::class, 'id', 'user_verify');
    }
    public function adminlte_image()
    {
        if ($this->avatar) {
            return $this->avatar;
        } else {
            return asset('klinik/logokitasehat-lingkar.png');
        }
    }
    public function adminlte_profile_url()
    {
        return route('profile');
    }
}
