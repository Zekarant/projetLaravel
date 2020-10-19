<?php

namespace App\Http\Controllers;

use App\Repositories\CoursRepository;

class HomeController extends Controller
{
    public function index(CoursRepository $repository)
    {
        $cours = $repository->getAllImages();
        return view('home', compact ('cours'));
    }
}
