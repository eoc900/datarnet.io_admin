<?php

namespace App\Http\Controllers;
use Spatie\Permission\Models\Role;
use App\Models\Tablas;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use DateTime;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule; // Add this import statement


class RolesController extends Controller
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
        $registros = DB::table('roles')
                    ->where(function ($query) use ($searchFor) {
                        $query->where('name', 'like', "%{$searchFor}%");
                    })
                    ->whereNotIn('name', ['administrador tecnológico', 'owner']);
                    $conf = [
                        "title"=>"Lista de Roles",
                        "titulo_breadcrumb" => "Roles",
                        "subtitulo_breadcrumb" => "Roles",
                        "go_back_link"=>"#",
                        "formulario"=>"roles", // se utiliza para el form tag
                        "tabla"=>"tabla.roles",
                        "view"=>"sistema_cobros.tablas.plantilla", //No cambia, se mantiene así
                        "urlRoute"=>"roles",
                        "confTabla"=>array(
                            "tituloTabla"=>"Mis Roles",
                            "placeholder"=>"Buscar roles",
                            "idSearch"=>"buscarInfoTabla",
                            "valueSearch"=>$searchFor,
                            "idBotonBuscar"=>"btnBuscarTabla",
                            "botonBuscar"=>"Buscar",
                            "filtrosBusqueda"=>array(["key"=>"nombre","option"=>"Por nombre"]),
                            "rowCheckbox"=>true,
                            "idKeyName"=>"id",
                            "keys"=>array('id',"name"),
                            "columns"=>array("#Ref","Role"),
                            "indicadores"=>false,
                            "botones"=>array('Pendiente'=>'btn-outline-danger',
                                                'En Progreso'=>'btn-outline-primary',
                                                'Completada'=>'btn-outline-success',
                                                'Aprobada'=>'btn-outline-info',
                                                'Reformular'=>'btn-outline-warning'),
                            "rowActions"=>array("show","edit","destroy"),
                            "data" => $registros->paginate(5)->appends(["page"=>$page,"search"=>$searchFor,"filter"=>$filter]),
                            "routeDestroy" => 'roles.destroy',
                            "routeCreate" => 'roles.create',
                            "routeEdit" => 'roles.edit',
                            "routeShow" => 'roles.show',
                            "routeIndex" => 'roles.index',
                            "ajaxRenderRoute" => '/html/tabletareas',
                            "reRenderSection" => ".dynamic_table",
                            "searchFor"=>$searchFor,
                            "count" => $registros->count(),
                            "txtBtnCrear"=>"Agregar una tarea"
                        )];
            return view('sistema_cobros.roles.index',$conf);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    return view('sistema_cobros.roles.create',[
        "title"=>"Generar rol",
        "titulo_breadcrumb" => "Agregar un rol",
        "subtitulo_breadcrumb" => "Roles",
        "go_back_link"=>"#",
        "titulo_formulario"=>"Agregar un nuevo rol",
        "routeStore"=>"roles.insert"
    ]);  
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'rol'=>'required|string|max:32'
        ]);
        $role = Role::create(['name' => $request->rol]);
        return back()->with("success","Rol creado existosamente.");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Encuentra el rol por su ID o falla si no existe
        $role = Role::findOrFail($id);
        // Obtén los permisos asociados al rol
        $permissions = $role->permissions;

        // Retorna una vista (puedes crear una vista llamada 'roles.show') y pasarle el rol y sus permisos
        return view('sistema_cobros.roles.show', [
            "title"=>$role->name,
            "breadcrumb_title" => "Calendario general",
            "breadcrumb_second" => "Calendario",
            "role"=>$role,
            "permissions"=>$permissions
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
          // Encuentra el permiso por ID
        $role = Role::findOrFail($id);
        // Traer todos los permisos disponibles
        $permisos = Permission::all();
        $rolPermisos = $role->permissions->pluck('id')->toArray();

        return view('sistema_cobros.roles.edit', [
                    "obj"=>$role,
                    "title"=>"Edición de rol",
                    "titulo_breadcrumb" => "Roles",
                    "subtitulo_breadcrumb" => "Edición de roles",
                    "go_back_link"=>"#",
                    "permisos"=>$permisos,
                    "rolPermisos"=>$rolPermisos]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $role = Role::findOrFail($id);
        $role->name = $request->input('name');
        $permisosSeleccionados = $request->input('permisos', []); // Obtiene los permisos seleccionados, o un array vacío si no hay

        // Obtén los nombres de permisos a partir de los IDs seleccionados
        $nombresPermisos = Permission::whereIn('id', $permisosSeleccionados)->pluck('name')->toArray();

        // Sincroniza los permisos del rol usando los nombres en lugar de IDs
        $role->syncPermissions($nombresPermisos);
        $role->save();

        return redirect()->route('roles.index')->with('success', 'El rol ha sido actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rol = Role::findOrFail($id); // Busca el rol por ID, o lanza un error si no existe
        $rol->delete(); // Elimina el rol

        return redirect()->back()->with('success', 'El rol ha sido eliminado correctamente.');
    }
}
