<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CostoConceptoCobro;
use App\Helpers\Mensajes;

class CostoConceptoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $mensajes = new Mensajes(); // registro de respuestas add(["mensaje"=>"Almacenamiento de acta de nacimiento exitosa","respuesta"=>true])
        $costo = CostoConceptoCobro::findOrFail($id);
        $request->validate(['costo'=>'required|numeric']);
        $costo->update([
                'costo' => $request->costo,
                'activo' => $request->activo
        ]);
       $mensajes->add(array("response"=>true,"message"=>"Se editó el costo de concepto."));
       return back()->with('mensajes',$mensajes->log); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
