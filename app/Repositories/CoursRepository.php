<?php
namespace App\Repositories;
use App\Models\Cours;
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
        $cours->description = $request->description;
        $cours->matiere_id = $request->matiere_id;
        $cours->name = $path;
        $request->user()->cours()->save($cours);
    }
    public function getAllImages()
    {
        return Cours::latestWithUser()->paginate(config('app.pagination'));
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
        return Cours::latestWithUser()->whereHas('matiere', function ($query) use ($slug) {
            $query->whereSlug($slug);
        })->paginate(config('app.pagination'));
    }

    public function getImagesForUser($id)
    {
        return Cours::latestWithUser()->whereHas('user', function ($query) use ($id) {
            $query->whereId ($id);
        })->paginate(config('app.pagination'));
    }

    public function getImagesForAlbum($slug)
    {
        return Cours::latestWithUser ()->whereHas ('profs', function ($query) use ($slug) {
            $query->whereSlug ($slug);
        })->paginate(config('app.pagination'));
    }

    public function isNotInAlbum($cours, $prof)
    {
        return $cours->profs()->where('profs.id', $prof->id)->doesntExist();
    }


}
