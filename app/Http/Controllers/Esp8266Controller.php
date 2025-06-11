<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Esp8266Controller extends Controller
{
    
    public function index()
    {
        //
    }

    public function prueba(Request $request)
    {
        // Verificar si el JSON tiene la clave "auth_code"
        $authCode = $request->input('auth_code');
        $validAuthCode = '4611150766'; // Reemplázalo con tu código real

        if ($authCode !== $validAuthCode) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        // Obtener datos del JSON
        $data = $request->all();

        // Procesar los datos (guárdalos en base de datos o haz lo que necesites)
        // Por ejemplo, guardar la temperatura y humedad de un sensor
        $temperatura = $data['temperatura'] ?? null;
        $humedad = $data['humedad'] ?? null;

        return response()->json([
            'message' => 'Datos recibidos correctamente',
            "maestros"=>[1=>"Miguel",2=>"Agustín",3=>"Benny"],
            'data' => compact('temperatura', 'humedad'),
        ], 200);
    }

    public function prueba2(Request $request)
    {
        $authCode = $request->query('auth_code');  // Alternativamente: $request->input('auth_code')
        $temperatura = $request->query('temperatura');
        $humedad = $request->query('humedad');

        // Opcional: validar los datos
        $request->validate([
            'auth_code' => 'required|string',
            'temperatura' => 'required|numeric',
            'humedad' => 'required|numeric'
        ]);

        // Responder con los datos recibidos
        return response()->json([
            'mensaje' => 'Datos recibidos correctamente',
            'auth_code' => $authCode,
            'temperatura' => $temperatura,
            'humedad' => $humedad
        ]);
    }


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
