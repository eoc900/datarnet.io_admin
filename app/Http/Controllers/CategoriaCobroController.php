<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListadoFormularios;
use App\Models\Code;
use App\Models\CategoriaCobro;
use App\Helpers\Mensajes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoriaCobroController extends Controller
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
        $concepto = CategoriaCobro::findOrFail($id);     
        $concepto->update([
                'categoria'=>$request->categoria,
                'activo' => $request->activo
        ]);
       $mensajes->add(array("response"=>true,"message"=>"Se editó la categoría de cobro exitosamente"));
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
