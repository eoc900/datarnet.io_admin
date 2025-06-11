<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListadoFormularios;
use App\Models\Code;
use App\Helpers\Mensajes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Escuela;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class EscuelasController extends Controller
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
        // view:
        $escuela = Escuela::findOrFail($id);
        $sistemasEnlazados = DB::table('escuelas')
        ->select('escuelas.codigo_escuela','escuelas.nombre as escuela','sistemas_academicos.nombre as sistema','sistemas_academicos.activo',
        'sistemas_academicos.codigo_sistema')
        ->leftJoin('sistemas_academicos','escuelas.id','=','sistemas_academicos.id_escuela')
        ->where('escuelas.id','=',$id)
        ->get();
        

        return view('administrador.escuelas.dashboard',[
            'title'=>"Alumno",
            'subtitulo_breadcrumb'=>"",
            'titulo_breadcrumb'=>"",
            "datos"=>[
            "escuela"=>$escuela,
            "sistemas"=>$sistemasEnlazados,
            "conteo_sistemas"=>$sistemasEnlazados->count()
        ]]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
        'nombre' => 'required|string|max:64',
        'codigo_escuela' => 'required|string|max:32', // Validar el código único, excluyendo la actual escuela
        'imagen_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Campo opcional para la imagen
        'calle' => 'required|string|max:255',
        'colonia' => 'required|string|max:255', // Campo requerido para la colonia
        'codigo_postal' => 'required|string|max:9', // Campo requerido para el código postal
        'num_exterior' => 'required|string|max:5', // Campo requerido para el número exterior
        'ciudad' => 'required|string|max:32', // Campo requerido para la ciudad
        'estado' => 'required|string|max:32', // Campo requerido para el estado
        'activo' => 'required|boolean' // Campo booleano requerido
        // Agrega las demás validaciones aquí según tu tabla
        ]);

        $mensajes = new Mensajes(); // registro de respuestas add(["mensaje"=>"Almacenamiento de acta de nacimiento exitosa","respuesta"=>true])
        $escuela = Escuela::findOrFail($id);

        if ($request->hasFile('imagen_logo')) {
            // Eliminar el logo anterior si existe
            if ($escuela->imagen_logo) {
                Storage::delete('public/logos/' . $escuela->imagen_logo);
            }

            // Subir la nueva imagen y guardarla
            $image = $request->file('imagen_logo');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $request->file('imagen_logo')->storeAs('logos/',$imageName, 'public');

            // Guardar el nombre de la nueva imagen en la base de datos
            $escuela->imagen_logo = $imageName;
        }

        $escuela->codigo_escuela = $request->input('codigo_escuela');
        $escuela->nombre = $request->input('nombre');
        $escuela->calle = $request->input('calle');
        $escuela->colonia = $request->input('colonia');
        $escuela->codigo_postal = $request->input('codigo_postal');
        $escuela->num_exterior = $request->input('num_exterior');
        $escuela->ciudad = $request->input('ciudad');
        $escuela->estado = $request->input('estado');
        $escuela->creada_por = Auth::user()->id;
        $escuela->activo = $request->input('activo');
        $escuela->save();
        $mensajes->add(array("response"=>true,"message"=>"Se editó la escuela exitosamentes"));

        return back()->with('mensajes',$mensajes->log);
            
        
      
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $record = Escuela::find($id);
        if($record){
            $record->delete();
            return back()->with('success', 'Escuela eliminada exitosamente');
        }
        return back()->with('error', 'Hubo un error al tratar de borrar registro');
    }
}
