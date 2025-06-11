<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\EjemploCertificado;

class CertificadosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function ejemploCertificados(Request $request){
        
        $Ejemplo = new EjemploCertificado();
        $private_file=storage_path("app/private/llave.key.pem");      // Ruta al archivo key con contraseña
        $public_file=storage_path("app/private/certificado.key.pem");
        $cadena_original="||1.0|3|MUOC810214HCHRCR00|Director de Articulación de Procesos|SECRETARÍA DE EDUCACIÓN|Departamento de Control Escolar|23DPR0749T|005|23|SOSE810201HDFRND05|EDGAR|SORIANO|SANCHEZ|2|7.8|2017-01-01T12:05:00||";
        $passcode = env('CLAVE_CODE');
        $resultados = $Ejemplo->firmarCadena($cadena_original, $private_file, $public_file,$passcode);

        return view("sistema_cobros.certificados.ejemplo",["title"=>"Ejemplo certificado","resultado"=>$resultados]);

    }

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
