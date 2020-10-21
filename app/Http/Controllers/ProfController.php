<?php

namespace App\Http\Controllers;

use App\Models\Prof;
use App\Http\Requests\ProfRequest;
use App\Repositories\MatiereRepository;
use App\Repositories\ProfRepository;
use Illuminate\Http\Request;


class ProfController extends Controller
{

    protected $repository;
    public function __construct(ProfRepository $repository)
    {
        $this->repository = $repository;
        $this->middleware('ajax')->only('destroy');
    }
    public function store(ProfRequest $request, ProfRepository $repository)
    {
        $repository->store($request->all());
        return back()->with ('ok', __ ("Le prof a bien été enregistré"));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        return view ('profs.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('profs.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Prof $prof)
    {
        return view ('profs.edit', compact ('prof'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProfRequest $request, Prof $prof)
    {
        $this->authorize('manage', $prof);
        $prof->update ($request->all ());
        return redirect ()->route('prof.index')->with ('ok', __ ("Le nom du professeur a bien été modifié !"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prof $prof)
    {
        $this->authorize('manage', $prof);
        $prof->delete ();
        return response ()->json ();
    }
}
