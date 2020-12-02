<?php
namespace App\Repositories;
use App\Models\Cours;
use App\Models\Prof;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as InterventionImage;

class CoursRepository
{
    public function store($request)
    {
        // Save image
        $path = $request->image->store('cours/images', 'public');
        $image = InterventionImage::make(public_path('storage/' . $path))->resize(200, 250);
        $image->save();
        // Save in base
        $cours = new Cours;
        $prof = Prof::find($request->user_id);
        $cours->description = $request->description;
        $cours->matiere_id = $request->matiere_id;
        $cours->lien = $request->lien;
        $cours->name = $path;
        $prof->cours()->save($cours);
    }
    public function getAllImages()
    {
        return $this->paginateAndRate(Cours::latestWithUser());
    }

    public function scopeLatestWithUser($query)
    {
        $user = auth()->user();
        if($user) {
            return $query->with ('user')->latest ();
        }
        return $query->with ('user')->latest ();
    }
    public function getImagesForCategory($slug)
    {

        $query = Cours::latestWithUser ()->whereHas ('matiere', function ($query) use ($slug) {
            $query->whereSlug ($slug);
        });
        return $this->paginateAndRate ($query);
    }

    public function getImagesForUser($id)
    {
        $query = Cours::latestWithUser ()->whereHas ('user', function ($query) use ($id) {
            $query->whereId ($id);
        });
        return $this->paginateAndRate ($query);
    }

    public function getImagesForAlbum($slug)
    {
        $query = Cours::latestWithUser ()->whereHas ('profs', function ($query) use ($slug) {
            $query->whereSlug ($slug);
        });
        return $this->paginateAndRate ($query);
    }

    public function isNotInAlbum($cours, $prof)
    {
        return $cours->profs()->where('profs.id', $prof->id)->doesntExist();
    }


    public function rateCour($user, $cour, $value)
    {
        $rate = $cour->users()->where('users.id', $user->id)->pluck('rating')->first();
        if($rate) {
            if($rate !== $value) {
                $cour->users ()->updateExistingPivot ($user->id, ['rating' => $value]);
            }
        } else {
            $cour->users ()->attach ($user->id, ['rating' => $value]);
        }
        return $rate;
    }
    public function isOwner($user, $cour)
    {
        return $cour->user()->where('users.id', $user->id)->exists();
    }

    public function paginateAndRate($query)
    {
        $cours = $query->paginate (config ('app.pagination'));
        return $this->setRating ($cours);
    }
    public function setRating($cours)
    {
        $cours->transform(function($cour) {
            $this->setCourRate($cour);
            return $cour;
        });
        return $cours;
    }
    public function setCourRate($cour)
    {
        $number = $cour->users->count();
        $cour->rate = $number ? $cour->users->pluck ('pivot.rating')->sum () / $number : 0;
    }


}
