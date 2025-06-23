<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class PermisosController extends Controller
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
        $registros = DB::table('permissions')
                    ->where("name","like","%{$searchFor}%");
                    $conf = [
                        "title"=>"Lista de permisos",
                        "titulo_breadcrumb" => "Permisos",
                        "subtitulo_breadcrumb" => "Permisos",
                        "go_back_link"=>"#",
                        "formulario"=>"permisos", // se utiliza para el form tag
                        "tabla"=>"tabla.permisos",
                        "view"=>"sistema_cobros.tablas.plantilla", //No cambia, se mantiene así
                        "urlRoute"=>"permisos",
                        "confTabla"=>array(
                            "tituloTabla"=>"Mis permisos",
                            "placeholder"=>"Buscar permisos",
                            "idSearch"=>"buscarInfoTabla",
                            "valueSearch"=>$searchFor,
                            "idBotonBuscar"=>"btnBuscarTabla",
                            "botonBuscar"=>"Buscar",
                            "filtrosBusqueda"=>array(["key"=>"nombre","option"=>"Por nombre"]),
                            "rowCheckbox"=>true,
                            "idKeyName"=>"id",
                            "keys"=>array('id',"name"),
                            "columns"=>array("#Ref","Permiso"),
                            "indicadores"=>false,
                            "botones"=>array('Pendiente'=>'btn-outline-danger',
                                                'En Progreso'=>'btn-outline-primary',
                                                'Completada'=>'btn-outline-success',
                                                'Aprobada'=>'btn-outline-info',
                                                'Reformular'=>'btn-outline-warning'),
                            "rowActions"=>array("show","edit","destroy"),
                            "data" => $registros->paginate(10)->appends(["page"=>$page,"search"=>$searchFor,"filter"=>$filter]),
                            "routeDestroy" => 'permisos.destroy',
                            "routeCreate" => 'permisos.create',
                            "routeEdit" => 'permisos.edit',
                            "routeShow" => 'permisos.show',
                            "routeIndex" => 'permisos.index',
                            "ajaxRenderRoute" => '/html/tabletareas',
                            "reRenderSection" => ".dynamic_table",
                            "searchFor"=>$searchFor,
                            "count" => $registros->count(),
                            "txtBtnCrear"=>"Agregar un permiso"
                        )];
             return view('sistema_cobros.permisos.index',$conf);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sistema_cobros.permisos.create', [
                        "title"=>"Generar permiso",
                        "titulo_breadcrumb" => "Agregar un permiso",
                        "subtitulo_breadcrumb" => "Permisos",
                        "go_back_link"=>"#",
                        "formulario"=>"permisos", // se utiliza para el form tag
                        "titulo_formulario"=>"Agregar un nuevo permiso",
                        "view"=>"sistema_cobros.formularios.permisos",
                        "accion"=>"alta",
                        "routeStore"=>"insert.permisos",
                        
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'permiso'=>'required|string|max:42'
        ]);
        $permission = Permission::create(['name' => $request->permiso]);
        if($permission){
            return back()->with("success","El permiso fue guardado existosamente.");
        }
        return back()->with("error","El permiso fue no fue guardado.");
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $permiso = Permission::findOrFail($id);
        // Obtener los usuarios que tienen dicho permiso
        $users = User::permission($permiso->name)->get();

        return view('sistema_cobros.permisos.show',
                    [
                    "permiso"=>$permiso,
                    "users"=>$users,
                    "title"=>"Ver usuario permiso",
                    "titulo_breadcrumb" => "Permiso",
                    "subtitulo_breadcrumb" => "Usuario con permiso de: ".$permiso->name,
                    "go_back_link"=>"#"]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Encuentra el permiso por ID
        $permiso = Permission::findOrFail($id);
        return view('sistema_cobros.pages.permisos.edit', [
                    "obj"=>$permiso,
                    "title"=>"Edición de categoría",
                    "titulo_breadcrumb" => "Categorías",
                    "subtitulo_breadcrumb" => "Edición de categoría",
                    "go_back_link"=>"#"]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validar los datos
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Encontrar el permiso y actualizarlo
        $permiso = Permission::findOrFail($id);
        $permiso->update($validatedData);

        // Redirigir con un mensaje de éxito
        return redirect()->route('tabla','permisos')->with('success', 'Permiso actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $record = Permission::find($id);
        if($record){
            $record->delete();
            return back()->with('success', 'El permiso fue eliminado de la base de datos.');
        }
        return back()->with('error', 'Hubo un error al tratar de borrar registro');
    }
}
