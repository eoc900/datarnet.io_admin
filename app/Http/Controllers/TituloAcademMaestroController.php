<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTituloAcademMaestroRequest;
use App\Http\Requests\UpdateTituloAcademMaestroRequest;
use App\Models\TituloAcademMaestro;

class TituloAcademMaestroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = TituloAcademMaestro::paginate(5);
        $total = TituloAcademMaestro::count();
        return view("administrador.maestros.pages.titulos_academicos.index",[
            "title"=>"Títulos | Maestros",
            "data"=>$data,
            "total"=>$total
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
          return view("administrador.maestros.pages.titulos_academicos.create",[
            "title"=>"Agregar | Maestro",
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTituloAcademMaestroRequest $request)
    {
        TituloAcademMaestro::create($request->all());
        return back()->with('success', 'Grado académico agregado.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $maestro = TituloAcademMaestro::where('id', '=', $id)->firstOrFail(); 
        return view('administrador.maestros.pages.titulos_academicos.show',[
            "title"=>"Maestro | ".$maestro->nombre." ".$maestro->apellido_paterno,
            "maestro"=>$maestro
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TituloAcademMaestro $tituloAcademMaestro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTituloAcademMaestroRequest $request, TituloAcademMaestro $tituloAcademMaestro)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TituloAcademMaestro $tituloAcademMaestro)
    {
        //
    }
}
