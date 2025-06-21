<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Tablas extends Model
{
    use HasFactory;
     static public function lista($tabla, $searchFor="", $filter="",$page=1){
     
        switch($tabla){            
                case "roles":
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
                        "urlRoute"=>"tabla/roles",
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
                            "routeCreate" => ['formulario','alta_roles'],
                            "routeEdit" => 'roles.edit',
                            "routeShow" => 'roles.show',
                            "routeIndex" => 'tabla',
                            "ajaxRenderRoute" => '/html/tabletareas',
                            "reRenderSection" => ".dynamic_table",
                            "searchFor"=>$searchFor,
                            "count" => $registros->count(),
                            "txtBtnCrear"=>"Agregar una tarea"
                        )];
                return $conf;
                break;
                case "permisos":
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
                        "urlRoute"=>"tabla/permisos",
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
                            "routeCreate" => ['formulario','alta_permisos'],
                            "routeEdit" => 'permisos.edit',
                            "routeShow" => 'permisos.show',
                            "routeIndex" => 'tabla',
                            "ajaxRenderRoute" => '/html/tabletareas',
                            "reRenderSection" => ".dynamic_table",
                            "searchFor"=>$searchFor,
                            "count" => $registros->count(),
                            "txtBtnCrear"=>"Agregar un permiso"
                        )];
                return $conf;
                break;
                case "usuarios":
                $registros = DB::table('users')
                    ->where(DB::raw("CONCAT(users.name, ' ',users.lastname)"),"like","%{$searchFor}%")
                    ->orWhere('users.email','like',"%{$searchFor}%")
                    ->orWhere('users.telephone','like',"%{$searchFor}%")
                    ->orWhere('users.estado','like',"%{$searchFor}%");
   
                    $conf = [
                        "title"=>"Lista de usuario",
                        "titulo_breadcrumb" => "Usuarios",
                        "subtitulo_breadcrumb" => "Usuarios",
                        "go_back_link"=>"#",
                        "formulario"=>"usuarios", // se utiliza para el form tag
                        "tabla"=>"tabla.usuarios",
                        "view"=>"sistema_cobros.tablas.plantilla", //No cambia, se mantiene así
                        "urlRoute"=>"tabla/usuarios",
                        "confTabla"=>array(
                            "tituloTabla"=>"Mis usuarios",
                            "placeholder"=>"Buscar usuarios",
                            "idSearch"=>"buscarInfoTabla",
                            "valueSearch"=>$searchFor,
                            "idBotonBuscar"=>"btnBuscarTabla",
                            "botonBuscar"=>"Buscar",
                            "filtrosBusqueda"=>array(["key"=>"nombre","option"=>"Por nombre completo"],
                            ["key"=>"correo","option"=>"Por correo electrónico"],["key"=>"telefono","option"=>"Telefono"],
                            ["key"=>"estado","option"=>"Estado"]),
                            "rowCheckbox"=>true,
                            "idKeyName"=>"id",
                            "keys"=>array("id","name","lastname","email","telephone","estado"),
                            "columns"=>array("#Ref","Nombre","Apellidos","Email","Teléfono","Estado"),
                            "indicadores"=>true,
                            "botones"=>array('Inactivo'=>'btn-outline-danger',
                                                'Activo'=>'btn-outline-primary',
                                                'Bloqueado'=>'btn-outline-warning'),
                            "rowActions"=>array("show","edit","destroy"),
                            "data" => $registros->paginate(5)->appends(["page"=>$page,"search"=>$searchFor,"filter"=>$filter]),
                            "routeDestroy" => 'users.destroy',
                            "routeCreate" => ['formulario','alta_usuarios'],
                            "routeEdit" => 'users.edit',
                            "routeShow" => 'users.show',
                            "routeIndex" => 'tabla',
                            "ajaxRenderRoute" => '/html/tabletareas',
                            "reRenderSection" => ".dynamic_table",
                            "searchFor"=>$searchFor,
                            "count" => $registros->count(),
                            "txtBtnCrear"=>"Agregar un usuario"
                        )];
                return $conf;
                break;
                default:
                // Valores default
        }
     }
}
