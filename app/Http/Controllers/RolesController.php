<?php

namespace App\Http\Controllers;
use Spatie\Permission\Models\Role;
use App\Models\Tablas;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
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
        // Encuentra el rol por su ID o falla si no existe
        $role = Role::findOrFail($id);
        // Obtén los permisos asociados al rol
        $permissions = $role->permissions;

        // Retorna una vista (puedes crear una vista llamada 'roles.show') y pasarle el rol y sus permisos
        return view('sistema_cobros.pages.roles.show', [
            "title"=>"Calendario tareas",
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

        return redirect()->route('tabla','roles')->with('success', 'El rol ha sido actualizado correctamente.');
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
