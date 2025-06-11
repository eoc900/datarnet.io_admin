<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\DirectorioRoot;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class CargasArchivosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function cargarDocumentos(){
        // 1. obtener el id de usuario
        $id_usuario = Auth::user()->id;

        // 2. checar si este usuario cuenta con una carpeta raíz
        $dRoot = DirectorioRoot::where('propietario', $id_usuario)->first();

        // 3. 
        
       



        return view('sistema_cobros.carga_archivos.cargar_archivo',[
            "title"=>"Prueba de carga",
            "datos_carpeta"=>$dRoot]);

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
        
        // Validar la entrada del formulario
        // $request->validate([
        //     'ruta' => 'required|string|max:255', // Validar que la ruta sea un string válido
        //     'archivo' => 'required|array',       // Validar que haya archivos en el array
        //     'archivo.*' => 'file|max:20480',    // Validar cada archivo (máx. 20MB por archivo)
        // ]);

        // // Obtener la ruta del input
        // $ruta = $request->input('ruta');

        // // Inicializar un array para registrar archivos subidos
        // $archivosSubidos = [];

        // // Procesar cada archivo subido
        // foreach ($request->file('archivo') as $archivo) {
        //     // Generar un nombre único para el archivo
        //     $nombreArchivo = $archivo->getClientOriginalName();
            
        //     // // Subir el archivo a la carpeta en `storage/app`
        //     // $rutaArchivo = $archivo->storeAs($ruta, $nombreArchivo);

        //     // // Agregar la ruta al array de archivos subidos
        //     // $archivosSubidos[] = $rutaArchivo;
        // }

        // Retornar una respuesta con los archivos subidos
        return back()->with("success","hola");
    }

    public function cargar(Request $request){

        Log::info("Se recibió la petición exitosamente: valor de variable ".$request->ruta);

  // Validar la entrada del formulario
        $request->validate([
            'ruta' => 'required|string|max:255', // Validar que la ruta sea un string válido
            'archivo' => 'required|array',       // Validar que haya archivos en el array
            'archivo.*' => 'file|max:20480',    // Validar cada archivo (máx. 20MB por archivo)
        ]);

        // Obtener la ruta del input
        $ruta = $request->input('ruta');

        // Inicializar un array para registrar archivos subidos
        $archivosSubidos = [];

        // Procesar cada archivo subido
        foreach ($request->file('archivo') as $archivo) {
            // Generar un nombre único para el archivo
            $nombreArchivo = $archivo->getClientOriginalName();
            
            // // Subir el archivo a la carpeta en `storage/app`
            $rutaArchivo = $archivo->storeAs($ruta, $nombreArchivo);

            // // Agregar la ruta al array de archivos subidos
            // $archivosSubidos[] = $rutaArchivo;
        }
        return back()->with("success",$request->ruta);
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
