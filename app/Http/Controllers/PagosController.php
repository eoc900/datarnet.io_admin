<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pago;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PagosController extends Controller
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
        $pago = new Pago();
        return view('sistema_cobros.pagos.create',[
                        "title"=>"Registrar un pago",
                        "titulo_breadcrumb" => "Pagos",
                        "subtitulo_breadcrumb" => "Crear un nuevo pago",
                        "go_back_link"=>"#",
                        "titulo_formulario"=>"Crear un nuevo pago",
                        "routeStore"=>"pagos_realizados.store",
                        "select2" => '/select2/alumnos',
                        "idSelect2"=>'alumnos',
                        "opciones"=> $pago->dropdown
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $pago= new Pago([
            'id' => (string) Str::uuid(), // Generar un UUID
            'id_cuenta'=>$request->cuenta,
            'id_estudiante'=>$request->id_alumno,
            'tipo_pago' => $request->tipo_pago,
            'createdBy' => Auth::user()->id,
            'monto' => $request->monto
        ]);
        // Guardar la instancia en la base de datos
        $pago->save();
        return back()->with('success','Se registró el pago exitosamente por un monto de $'.number_format($request->monto,2));
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
}
