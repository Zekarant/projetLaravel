<?php
namespace App\Http\Controllers;
use App\Models\Cours;
use App\Repositories\CoursRepository;
use Illuminate\Http\Request;
class AdminController extends Controller
{
    protected $repository;
    public function __construct(CoursRepository $repository)
    {
        $this->repository = $repository;
    }
    public function orphans()
    {
        $orphans = $this->repository->getOrphans ();
        $orphans->count = count($orphans);
        return view ('maintenance.orphans', compact ('orphans'));
    }
}
