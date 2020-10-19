<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Events\NameSaving;

class Matiere extends Model
{

    protected $fillable = [
        'name', 'slug',
    ];

    public function cours()
    {
        return $this->hasMany(Cours::class);
    }

    protected $dispatchesEvents = [
        'saving' => NameSaving::class,
    ];
}
