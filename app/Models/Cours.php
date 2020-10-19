<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{

    public function matiere(){
        return $this->belongsTo(Matiere::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function scopeLatestWithUser($query){
        return $query->with ('user')->latest();
    }
}
