<?php

namespace App\Http\Controllers;

use App\Models\PromocionAplicada;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PromocionesAplicadasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Obtener todas las promociones aplicadas
        $promocionesAplicadas = PromocionAplicada::all();
        return response()->json($promocionesAplicadas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Mostrar un formulario para crear una nueva promoción aplicada
        return view('promociones_aplicadas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validar los datos
        $validated = $request->validate([
            'id_promocion' => 'required|uuid|exists:promociones,uuid',
            'id_cuenta' => 'required|uuid|exists:cuentas,uuid',
            'activo' => 'required|boolean',
        ]);

        // Crear la nueva promoción aplicada
        $promocionAplicada = PromocionAplicada::create([
            'uuid' => Str::uuid(),
            'id_promocion' => $validated['id_promocion'],
            'id_cuenta' => $validated['id_cuenta'],
            'activo' => $validated['activo'],
            'aplicado_por' => Auth::user()->id,
        ]);

        return back()->with('success','La promoción fue aplicada a la cuenta exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PromocionAplicada  $promocionAplicada
     * @return \Illuminate\Http\Response
     */
    public function show(PromocionAplicada $promocionAplicada)
    {
        // Mostrar una promoción aplicada específica
        return response()->json($promocionAplicada);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PromocionAplicada  $promocionAplicada
     * @return \Illuminate\Http\Response
     */
    public function edit(PromocionAplicada $promocionAplicada)
    {
        // Mostrar un formulario para editar la promoción aplicada
        return view('promociones_aplicadas.edit', compact('promocionAplicada'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PromocionAplicada  $promocionAplicada
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PromocionAplicada $promocionAplicada)
    {
        // Validar los datos
        $validated = $request->validate([
            'id_promocion' => 'uuid|exists:promociones,uuid',
            'id_cuenta' => 'uuid|exists:cuentas,uuid',
            'activo' => 'boolean',
            'aplicado_por' => 'uuid|exists:users,uuid',
        ]);

        // Actualizar la promoción aplicada
        $promocionAplicada->update($validated);

        return response()->json($promocionAplicada);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PromocionAplicada  $promocionAplicada
     * @return \Illuminate\Http\Response
     */
    public function destroy(PromocionAplicada $promocionAplicada)
    {
        // Eliminar la promoción aplicada
        $promocionAplicada->delete();

        return response()->json(['message' => 'Promoción aplicada eliminada con éxito']);
    }
}
