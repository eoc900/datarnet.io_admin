<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TipoCorreoContactoAlumno;
use Illuminate\Support\Facades\Validator;

class TiposCorreosContactosAlumnosController extends Controller
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
        $registros = DB::table('tipos_correos_contactos_alumnos')
        ->where("tipo_correo","like","%{$searchFor}%");
        $tipos_correos = [
            "title"=>"Tipos de correo de contactos",
            "titulo_breadcrumb" => "Tipos de correo de contactos",
            "subtitulo_breadcrumb" => "Tipos de correo de contactos",
            "go_back_link"=>"#",
            // "formulario"=>"escuelas", // se utiliza para el form tag
            "view"=>"sistema_cobros.tablas.plantilla", //No cambia, se mantiene así
            "urlRoute"=>"tipos_correos_contactos",
            "confTabla"=>array(
                "tituloTabla"=>"Tipos de correo de contactos",
                "placeholder"=>"Buscar tipos de correos de contactos",
                "idSearch"=>"buscarInfoTabla",
                "valueSearch"=>$searchFor,
                "idBotonBuscar"=>"btnBuscarTabla",
                "botonBuscar"=>"Buscar",
                "filtrosBusqueda"=>array(["key"=>"nombre","option"=>"Tipo correo"]),
                "rowCheckbox"=>true,
                "idKeyName"=>"id",
                "keys"=>array("id",'tipo_correo'),
                "columns"=>array("#","Tipo/Categoría"),
                "indicadores"=>true,
                "botones"=>array('0'=>'btn-outline-danger',
                                    '1'=>'btn-outline-success'),
                "rowActions"=>array("show","edit","destroy"),
                "data" => $registros->paginate(5)->appends(["page"=>$page,"search"=>$searchFor,"filter"=>$filter]),
                "routeDestroy" => 'tipos_correos_contactos.destroy',
                "routeCreate" => ['formulario','alta_escuelas'],
                "routeEdit" => 'tipos_correos_contactos.edit', // referente a un método ListadoFormularios
                "routeShow" => 'tipos_correos_contactos.show',
                "routeIndex" => 'tipos_correos_contactos.index',
                "searchFor"=>$searchFor,
                "count" => $registros->count(),
                "txtBtnCrear"=>"Tipo de correos de contactos"
            )
            

        ];
        return view('sistema_cobros.tipos_correos_contactos.index', $tipos_correos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sistema_cobros.tipos_correos_contactos.create',[
            "title"=>"Alta de tipos de correos de contactos",
            "titulo_breadcrumb" => "Tipos de correo de contactos"]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
        'tipo_correo' => 'required|string|max:32',
        'activo' => 'required|boolean',
        ]);
        try {
        // Crear el nuevo registro en la base de datos
        $tipoCorreo = new TipoCorreoContactoAlumno();
        $tipoCorreo->tipo_correo = $validatedData['tipo_correo'];
        $tipoCorreo->activo = $validatedData['activo'];
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
        $tipo= TipoCorreoContactoAlumno::find($id);
        return view('sistema_cobros.tipos_correos_contactos.edit', [
            "title"=>"Tipos de contactos",
            "titulo_breadcrumb" => "Tipos de Contactos",
            "tipo_correo"=>$tipo]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'tipo_correo' => 'required|string|max:32',
            'activo' => 'required|boolean',
        ]);

        // Comprobar si la validación falla
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Buscar el tipo de contacto por ID
        $tipoContacto = TipoCorreoContactoAlumno::find($id);

        // Comprobar si el registro existe
        if (!$tipoContacto) {
            return response()->json(['error' => 'Tipo de contacto no encontrado'], 404);
        }

        // Actualizar los campos del registro
        $tipoContacto->update([
            'tipo_correo' => $request->input('tipo_correo'),
            'activo' => $request->input('activo')
        ]);

        return back()->with('success','Se ha editado con este registro éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $record = TipoCorreoContactoAlumno::find($id);
        if($record){
            $record->delete();
            return back()->with('success', 'Tipo de correo de alumno eliminado con éxito.');
        }
        return back()->with('error', 'Hubo un error al tratar de borrar registro');
    }
}
