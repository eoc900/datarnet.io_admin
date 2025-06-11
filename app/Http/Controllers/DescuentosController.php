<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Descuento;
use App\Models\DescuentosAplicado;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DescuentosController extends Controller
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
        return view('sistema_cobros.descuentos.create',[
                        "title"=>"Registrar un cargo.",
                        "titulo_breadcrumb" => "Cargos",
                        "subtitulo_breadcrumb" => "Crear un nuevo cargo",
                        "go_back_link"=>"#"]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre'=>'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'tasa' => 'required|numeric|max:1',
            'monto' => 'required|numeric',
            'activo' => 'required|boolean'
        ]);


         $descuento = new Descuento([
            'id' => (string) Str::uuid(), // Generar un UUID
            'nombre'=>$request->nombre,
            'descripcion'=>$request->descripcion,
            'tasa'=>$request->tasa,
            'monto' => $request->monto,
            'activo' => $request->activo,
            'createdBy' => Auth::user()->id,
        ]);
        // Guardar la instancia en la base de datos
        $descuento->save();
        return back()->with('success','Se registró el descuento de manera exitosa');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function aplicarDescuentoVista(){
        return view('sistema_cobros.descuentos.aplicar_descuento',[
                        "title"=>"Registrar un cargo.",
                        "titulo_breadcrumb" => "Cargos",
                        "subtitulo_breadcrumb" => "Crear un nuevo cargo",
                        "go_back_link"=>"#"]);
    }

    public function storeAplicarDescuento(Request $request){
       $validatedData = $request->validate([
            'descuento'=>'required|string|max:36',
            'tipo_descuento' => 'required|string|max:32',
            'pagos' => 'required|array', // Asegura que 'items' es un array
            'pagos.*' => 'string|exists:desglose_cuentas,id'
        ]);

    foreach ($validatedData['pagos'] as $item) {
         $descuento = new DescuentosAplicado([
            'id' => (string) Str::uuid(), // Generar un UUID
            'id_p_pendiente'=>$item,
            'id_descuento'=>$request->descuento,
            'tipo_descuento'=>$request->tipo_descuento,
            'createdBy' => Auth::user()->id,
        ]);
        $descuento->save();
    }
        // Guardar la instancia en la base de datos
        
        return back()->with('success','Se registró el descuento de manera exitosa');
    }
}
