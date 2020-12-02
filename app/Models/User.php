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

    protected $dates = [
        'created_at',
        'updated_at',
        'email_verified_at',
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

    public function getSettingsAttribute($value)
    {
        return json_decode ($value);
    }

    public function getPaginationAttribute()
    {
        return $this->settings->pagination;
    }
    public function profs()
    {
        return $this->hasMany (Prof::class);
    }

    public function coursRated()
    {
        return $this->belongsToMany (Cours::class);
    }

}
