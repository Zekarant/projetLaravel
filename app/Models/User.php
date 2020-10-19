<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'settings'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function cours()
    {
        return $this->hasMany (Cours::class);
    }

    public function getAdminAttribute()
    {
        return $this->role === 'admin';
    }
}
