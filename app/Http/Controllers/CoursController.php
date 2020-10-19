<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ {
    CoursRepository, MatiereRepository
};
use App\Models\ {
    User, Cours
};


class CoursController extends Controller
{

    protected $coursRepository;
    protected $matiereRepository;

    public function __construct(CoursRepository $coursRepository, MatiereRepository $matiereRepository)
    {
        $this->coursRepository = $coursRepository;
        $this->matiereRepository = $matiereRepository;
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

    public function update(Request $request, Cours $cours)
    {
        $this->authorize('manage', $cours);
        $cours->matiere_id = $request->matiere_id;
        $cours->save();
        return back()->with('updated', __('La matière a bien été changée !'));
    }

    public function destroy(Cours $cours)
    {
        $this->authorize('manage', $cours);
        $cours->delete();
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
}
