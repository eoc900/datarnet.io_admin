<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\TipoCorreoMaestro;

class TiposCorreosMaestrosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchFor = "";
        $filter = "";
        $page = 1;
        if($request->search != "" && isset($request->search)){
            $searchFor = $request->search;
        }
        if($request->filter != "" && isset($request->filter)){
            $filter = $request->filter;
        }
        if($request->page != "" && isset($request->page)){
            $page = $request->page;
        }
        $registros = DB::table('tipos_correos_maestros')
        ->where("tipo_correo","like","%{$searchFor}%");
        $tipos_correos = [
            "title"=>"Alta de tipos de correo",
            "titulo_breadcrumb" => "Tipos de Correo",
            "subtitulo_breadcrumb" => "Alta de tipos de correo",
            "go_back_link"=>"#",
            // "formulario"=>"escuelas", // se utiliza para el form tag
            "view"=>"sistema_cobros.tablas.plantilla", //No cambia, se mantiene así
            "urlRoute"=>"tipos_correos",
            "confTabla"=>array(
                "tituloTabla"=>"Mis tipos de correo",
                "placeholder"=>"Buscar tipos de correos",
                "idSearch"=>"buscarInfoTabla",
                "valueSearch"=>$searchFor,
                "idBotonBuscar"=>"btnBuscarTabla",
                "botonBuscar"=>"Buscar",
                "filtrosBusqueda"=>array(["key"=>"nombre","option"=>"Tipo correo"],["key"=>"descripcion","option"=>"Descripción"]),
                "rowCheckbox"=>true,
                "idKeyName"=>"id",
                "keys"=>array("id",'tipo_correo'),
                "columns"=>array("#","Tipo/Categoría"),
                "indicadores"=>true,
                "botones"=>array('0'=>'btn-outline-danger',
                                    '1'=>'btn-outline-success'),
                "rowActions"=>array("show","edit","destroy"),
                "data" => $registros->paginate(5)->appends(["page"=>$page,"search"=>$searchFor,"filter"=>$filter]),
                "routeDestroy" => 'tipos_correos_maestros.destroy',
                "routeCreate" => 'tipos_correos_maestros.create',
                "routeEdit" => 'tipos_correos_maestros.edit', // referente a un método ListadoFormularios
                "routeShow" => 'tipos_correos_maestros.show',
                "routeIndex" => 'tipos_correos_maestros.index',
                "searchFor"=>$searchFor,
                "count" => $registros->count(),
                "txtBtnCrear"=>"Tipo de correo"
            )
            

        ];
        return view('sistema_cobros.tipos_correos_maestros.index', $tipos_correos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sistema_cobros.tipos_correos_maestros.create',[
            "title"=>"Alta de tipos de correos de contactos",
            "titulo_breadcrumb" => "Tipos de correo de contactos"]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
        'tipo_correo' => 'required|string|max:24',
        'descripcion' => 'nullable|string|max:255',
        'activo' => 'required|boolean',
        ]);
        try {
        // Crear el nuevo registro en la base de datos
        $tipoCorreo = new TipoCorreoMaestro();
        $tipoCorreo->tipo_correo = $validatedData['tipo_correo'];
        $tipoCorreo->descripcion = $validatedData['descripcion'];
        $tipoCorreo->activo = $validatedData['activo'];
        $tipoCorreo->creadoPor = Auth::user()->id;
        $tipoCorreo->save();

        // Respuesta exitosa
        return back()->with('success','Tipo de correo insertado con éxito.');

    } catch (\Exception $e) {
        // Manejo de errores
        return back()->with('error', 'Error al crear el tipo de correo: ' . $e->getMessage());
    }
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
         $obj = TipoCorreoMaestro::findOrFail($id);

         // Retornar la vista con el formulario de edición, pasando el registro encontrado
        return view('sistema_cobros.tipos_correos_maestros.edit', [
            "title"=>"Alta de tipos de correo",
            "titulo_breadcrumb" => "Tipos de Correo",
            "obj"=>$obj]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $alumno = TipoCorreoMaestro::findOrFail($id);
        $alumno->update([
        'tipo_correo'=>$request->tipo_correo,
        'descripcion' => $request->descripcion,
        'activo' => $request->activo
        ]);
        return back()->with('success','El tipo de correo fue modificado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $record = TipoCorreoMaestro::find($id);
        if($record){
            $record->delete();
            return back()->with('success', 'Tipo de correo eliminado con éxito.');
        }
        return back()->with('error', 'Hubo un error al tratar de borrar registro');
    }
}
