<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Events\NameSaving;
class Prof extends Model
{
    protected $fillable = [
        'name', 'slug',
    ];
    protected $dispatchesEvents = [
        'saving' => NameSaving::class,
    ];

    public function cours()
    {
        return $this->hasMany(Cours::class);
    }
}
