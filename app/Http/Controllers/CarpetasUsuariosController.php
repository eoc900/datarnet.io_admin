<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CarpetasUsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function verContenido($id_directorio = null, $ruta = null){

        if($id_directorio!=null){
            $id_carpeta = $id_directorio;
            $directorio = DB::table('directorios_root')
            ->select('directorios_root.propietario','directorios_root.nombre_directorio','directorios_root.activo',DB::raw('CONCAT(users.name," ",users.lastname) as usuario'))
            ->join("users","directorios_root.propietario","=","users.id")
            ->first();

         $fullPath = $directorio->nombre_directorio;
        if($ruta){
            $fullPath = $ruta;
        }
       
        $subdirectories = Storage::directories($fullPath);
        $files = Storage::files($fullPath);

        return view('sistema_cobros.carpetas_usuarios.ver_contenido',[
            "title"=>"Ver contenido",
            "id_directorio"=>$id_directorio,
            "subdirectorios"=>$subdirectories,
            "files"=>$files,
            "ruta"=>$ruta
        ]);
        }
    
       
        
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
