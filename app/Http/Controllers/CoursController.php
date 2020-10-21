<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ {
    CoursRepository, MatiereRepository, ProfRepository
};
use App\Models\ {
    User, Cours
};


class CoursController extends Controller
{

    protected $coursRepository;
    protected $matiereRepository;

    public function __construct(CoursRepository $coursRepository, MatiereRepository $matiereRepository, ProfRepository $profRepository)
    {
        $this->coursRepository = $coursRepository;
        $this->matiereRepository = $matiereRepository;
        $this->profRepository = $profRepository;
    }
    public function create()
    {
        return view ('cours.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:6000',
            'matiere_id' => 'required|exists:matieres,id',
            'description' => 'nullable|string|max:255',
        ]);

        $this->coursRepository->store($request);

        return back()->with('ok', __ ("Le cours a bien été enregistré"));
    }


    public function user(User $user)
    {
        $cours = $this->coursRepository->getImagesForUser($user->id);
        return view('home', compact ('user', 'cours'));
    }

    public function update(Request $request, Cours $cour)
    {
        $this->authorize('manage', $cour);
        $cour->matiere_id = $request->matiere_id;
        $cour->save();
        return back()->with('updated', __('La matière a bien été changée !'));
    }

    public function destroy(Cours $cour)
    {
        $this->authorize('manage', $cour);
        $cour->delete();
        return back();
    }

    public function descriptionUpdate(Request $request, Cours $cours)
    {
        $this->authorize ('manage', $cours);
        $request->validate ([
            'description' => 'nullable|string|max:255'
        ]);
        $cours->description = $request->description;
        $cours->save();
        return $cours;
    }

    public function matiere($slug)
    {
        $matiere = $this->matiereRepository->getBySlug($slug);
        $cours = $this->coursRepository->getImagesForCategory($slug);
        return view ('home', compact ('matiere', 'cours'));
    }

    public function prof($slug)
    {
        $prof = $this->profRepository->getBySlug($slug);
        $cours = $this->coursRepository->getImagesForAlbum($slug);
        return view ('home', compact ('prof', 'cours'));
    }

    public function profs(Request $request,  Cours $cours)
    {
        $this->authorize ('manage', $cours);
        $profs = $this->profRepository->getAlbumsWithImages ($request->user ());
        return view ('cours.profs', compact('profs', 'cours'));
    }

    public function profsUpdate(Request $request, Cours $cours)
    {
        $this->authorize('manage', $cours);

        $cours->albums()->sync($request->profs);
        $path = pathinfo (parse_url(url()->previous())['path']);
        if($path['dirname'] === '/prof') {
            $prof = $this->profRepository->getBySlug($path['basename']);
            if($this->coursRepository->isNotInAlbum($cours, $prof)) {
                return response ()->json('reload');
            }
        }
        return response ()->json();
    }
}
