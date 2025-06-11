<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DesgloseCuenta;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CargosController extends Controller
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
          return view('sistema_cobros.pages.cargos.create',[
                        "title"=>"Registrar un cargo.",
                        "titulo_breadcrumb" => "Cargos",
                        "subtitulo_breadcrumb" => "Crear un nuevo cargo",
                        "go_back_link"=>"#",
                        "titulo_formulario"=>"Crear un nuevo cargo",
                        "routeStore"=>"pagos_pendientes.store",
                        "select2" => '/select2/alumnos',
                        "idSelect2"=>'alumno'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $num_cargo = $ultimoCargo = DB::table('desglose_cuentas') // Reemplaza con el nombre de tu tabla
        ->where('id_cuenta', $request->cuenta)
        ->max('num_cargo');

        $nuevoCargo = is_null($num_cargo) ? 1 : $num_cargo + 1;
        
        $cargo = new DesgloseCuenta([
            'id' => (string) Str::uuid(), // Generar un UUID
            'num_cargo'=>$nuevoCargo,
            'id_cuenta'=>$request->cuenta,
            'id_monto'=>$request->id_costo,
            'monto' => $request->monto,
            'diferido' => 0,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_finaliza' => $request->fecha_fin,
            'createdBy' => Auth::user()->id,
        ]);
        // Guardar la instancia en la base de datos
        $cargo->save();
        return back()->with('success','Se registró el cargo exitosamente por un monto de $'.number_format($request->monto,2));
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
