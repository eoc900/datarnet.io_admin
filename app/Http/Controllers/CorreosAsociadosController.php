<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CorrreoAsociado;

class CorreosAsociadosController extends Controller
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
       $correoAsociado = DB::table('correos_asociados')
        ->join('tipos_correos_alumnos', 'correos_asociados.tipo_correo', '=', 'tipos_correos_alumnos.id')
        ->where('correos_asociados.id_alumno', $id)
        ->where('tipos_correos_alumnos.tipo_correo', 'like', '%ccuenta%') // aquí 'correo_especifico' es el valor que buscas
        ->select('correos_asociados.*')
        ->first();

        // Verificamos si se encontró el correo asociado
        if ($correoAsociado) {
            // Realizamos la actualización usando el constructor de consultas
            DB::table('correos_asociados')
                ->where('id', $correoAsociado->id) // Usamos el id del correoAsociado encontrado
                ->update([
                    'correo' => $request->ccuenta,
                ]);
            return back()->with('success','Se actualizó el correo exitosamente verificar si alumno recibió correo de bienvenida.');

        } else {
            // Si no se encontró, puedes lanzar una excepción o manejar el error
            return back()->with("error",'Lo sentimos no pudimos ejecutar la consulta.');
        }

        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
