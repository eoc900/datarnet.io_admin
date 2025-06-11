<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TipoContacto;
use Illuminate\Support\Facades\Validator;

class TiposContactosController extends Controller
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
        $registros = DB::table('tipos_contactos')
        ->where("tipo_contacto","like","%{$searchFor}%");
        $tipos_contactos = [
            "title"=>"Tipos de contactos",
            "titulo_breadcrumb" => "Tipos de Contactos",
            "subtitulo_breadcrumb" => "Tipos de Conctactos de Alumnos",
            "go_back_link"=>"#",
            // "formulario"=>"escuelas", // se utiliza para el form tag
            "view"=>"sistema_cobros.tablas.plantilla", //No cambia, se mantiene así
            "urlRoute"=>"tipos_contactos",
            "confTabla"=>array(
                "tituloTabla"=>"Tipos de contactos de alumnos",
                "placeholder"=>"Buscar tipos de contactos",
                "idSearch"=>"buscarInfoTabla",
                "valueSearch"=>$searchFor,
                "idBotonBuscar"=>"btnBuscarTabla",
                "botonBuscar"=>"Buscar",
                "filtrosBusqueda"=>array(["key"=>"nombre","option"=>"Tipo contacto"]),
                "rowCheckbox"=>true,
                "idKeyName"=>"id",
                "keys"=>array("id",'tipo_contacto'),
                "columns"=>array("#","Tipo/Categoría"),
                "indicadores"=>true,
                "botones"=>array('0'=>'btn-outline-danger',
                                    '1'=>'btn-outline-success'),
                "rowActions"=>array("show","edit","destroy"),
                "data" => $registros->paginate(5)->appends(["page"=>$page,"search"=>$searchFor,"filter"=>$filter]),
                "routeDestroy" => 'tipos_contactos.destroy',
                "routeCreate" => ['tipos_contactos','create'],
                "routeEdit" => 'tipos_contactos.edit', // referente a un método ListadoFormularios
                "routeShow" => 'tipos_contactos.show',
                "routeIndex" => 'tipos_contactos.index',
                "searchFor"=>$searchFor,
                "count" => $registros->count(),
                "txtBtnCrear"=>"Tipo de correo"
            )
            

        ];
        return view('sistema_cobros.tipos_contactos.index', $tipos_contactos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sistema_cobros.tipos_contactos.create',[
            "title"=>"Alta de tipos de contactos",
            "titulo_breadcrumb" => "Tipos contactos"]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          // Validar los datos entrantes
        $validator = Validator::make($request->all(), [
            'tipo_contacto' => 'required|string|max:32',
            'activo' => 'required|boolean',
        ]);

        // Comprobar si la validación falla
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Crear el nuevo tipo de contacto
        $tipoContacto = TipoContacto::create([
            'tipo_contacto' => $request->input('tipo_contacto'),
            'activo' => $request->input('activo'),
        ]);

        // Retornar la respuesta en JSON con el nuevo registro
        return back()->with("success","Nuevo tipo de contacto creado exitosamente.");
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
        $contacto = TipoContacto::find($id);
        return view('sistema_cobros.tipos_contactos.edit', [
            "title"=>"Tipos de contactos",
            "titulo_breadcrumb" => "Tipos de Contactos",
            "tipo_contacto"=>$contacto]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $validator = Validator::make($request->all(), [
            'tipo_contacto' => 'required|string|max:32',
            'activo' => 'required|boolean',
        ]);

        // Comprobar si la validación falla
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Buscar el tipo de contacto por ID
        $tipoContacto = TipoContacto::find($id);

        // Comprobar si el registro existe
        if (!$tipoContacto) {
            return response()->json(['error' => 'Tipo de contacto no encontrado'], 404);
        }

        // Actualizar los campos del registro
        $tipoContacto->update([
            'tipo_contacto' => $request->input('tipo_contacto'),
            'activo' => $request->input('activo')
        ]);

        return back()->with('success','Se ha editado con este registro éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $record = TipoContacto::find($id);
        if($record){
            $record->delete();
            return back()->with('success', 'Tipo de contacto de alumno eliminado con éxito.');
        }
        return back()->with('error', 'Hubo un error al tratar de borrar registro');
    }
}
