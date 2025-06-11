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
                case "escuelas":
                    $registros = DB::table('escuelas')->select("id","codigo_escuela","nombre","activo")
                    ->where("nombre","like","%{$searchFor}%");
                    $escuelas = [
                        "title"=>"Alta de Escuelas",
                        "titulo_breadcrumb" => "Escuelas",
                        "subtitulo_breadcrumb" => "Alta de escuelas",
                        "go_back_link"=>"#",
                        "formulario"=>"escuelas", // se utiliza para el form tag
                        "tabla"=>"tabla.escuelas",
                        "view"=>"sistema_cobros.tablas.plantilla", //No cambia, se mantiene así
                        "urlRoute"=>"tabla/escuelas",
                        "confTabla"=>array(
                            "tituloTabla"=>"Mis Escuelas",
                            "placeholder"=>"Buscar escuelas",
                            "idSearch"=>"buscarInfoTabla",
                            "valueSearch"=>$searchFor,
                            "idBotonBuscar"=>"btnBuscarTabla",
                            "botonBuscar"=>"Buscar",
                            "filtrosBusqueda"=>array(["key"=>"codigo_escuela","option"=>"Código Escuela"]),
                            "rowCheckbox"=>true,
                            "idKeyName"=>"id",
                            "keys"=>array("codigo_escuela",'nombre',"activo"),
                            "columns"=>array("Código Escuela","Nombre","Activa"),
                            "indicadores"=>true,
                            "botones"=>array('0'=>'btn-outline-danger',
                                                '1'=>'btn-outline-success'),
                            "rowActions"=>array("show","edit","destroy"),
                            "data" => $registros->paginate(5)->appends(["page"=>$page,"search"=>$searchFor,"filter"=>$filter]),
                            "routeDestroy" => 'escuelas.destroy',
                            "routeCreate" => ['formulario','alta_escuelas'],
                            "routeEdit" => 'editar',
                            "listaEdicion"=>'escuelas', // referente a un método ListadoFormularios
                            "routeShow" => 'escuelas.show',
                            "routeIndex" => 'tabla',
                            "ajaxRenderRoute" => '/html/tabletareas',
                            "reRenderSection" => ".dynamic_table",
                            "searchFor"=>$searchFor,
                            "count" => $registros->count(),
                            "txtBtnCrear"=>"Agregar una tarea"
                        )
                        

                    ];
                    return $escuelas;
                break;
                case "sistemas_academicos":
                    $registros = DB::table('sistemas_academicos')->select("id","codigo_sistema","nombre","activo")
                    ->where("nombre","like","%{$searchFor}%")
                    ->orWhere("codigo_sistema","like","%{$searchFor}%")
                    ->orWhere("activo","like","%{$searchFor}%");
                    $escuelas = [
                        "title"=>"Sistemas Académicos",
                        "titulo_breadcrumb" => "Sistemas Académicos",
                        "subtitulo_breadcrumb" => "Visualizar Sistemas Académicos",
                        "go_back_link"=>"#",
                        "formulario"=>"sistemas_academicos", // se utiliza para el form tag
                        "tabla"=>"tabla.sistemas_academicos",
                        "view"=>"sistema_cobros.tablas.plantilla", //No cambia, se mantiene así
                        "urlRoute"=>"tabla/sistemas_academicos",
                        "confTabla"=>array(
                            "tituloTabla"=>"Mis Sistemas Académicos",
                            "placeholder"=>"Buscar sistemas académicos",
                            "idSearch"=>"buscarInfoTabla",
                            "valueSearch"=>$searchFor,
                            "idBotonBuscar"=>"btnBuscarTabla",
                            "botonBuscar"=>"Buscar",
                            "filtrosBusqueda"=>array(["key"=>"codigo_sistema","option"=>"Código Sistema"]),
                            "rowCheckbox"=>true,
                            "idKeyName"=>"id",
                            "keys"=>array("codigo_sistema",'nombre',"activo"),
                            "columns"=>array("Código Sistema","Nombre","Activo"),
                            "indicadores"=>true,
                            "numerico"=>true,
                            "botones"=>array('0'=>'btn-outline-danger',
                                                '1'=>'btn-outline-success'),
                            "rowActions"=>array("show","edit","destroy"),
                            "data" => $registros->paginate(5)->appends(["page"=>$page,"search"=>$searchFor,"filter"=>$filter]),
                            "routeDestroy" => 'sistema_academico.destroy',
                            "routeCreate" => ['formulario','alta_sistemas_academicos'],
                            "routeEdit" => 'editar',
                            "listaEdicion"=>'sistema_academico', // referente a un método ListadoFormularios
                            "routeShow" => 'sistema_academico.show',
                            "routeIndex" => 'tabla',
                            "ajaxRenderRoute" => '/html/tabletareas',
                            "reRenderSection" => ".dynamic_table",
                            "searchFor"=>$searchFor,
                            "count" => $registros->count(),
                            "txtBtnCrear"=>"Agregar una tarea"
                        )
                        

                    ];
                    return $escuelas;
                break;
                case "conceptos_cobros":
                    $registros = DB::table('conceptos_cobros')->select("conceptos_cobros.id","conceptos_cobros.codigo_concepto","conceptos_cobros.nombre","conceptos_cobros.activo",
                    "escuelas.codigo_escuela","escuelas.nombre as escuela",DB::raw("CONCAT(escuelas.codigo_escuela,'-',conceptos_cobros.codigo_concepto) AS identificador"))
                    ->join("escuelas","conceptos_cobros.id_escuela","=","escuelas.id")
                    ->where("conceptos_cobros.nombre","like","%{$searchFor}%")
                    ->orWhere("escuelas.nombre","like","%{$searchFor}%")
                    ->orWhere("escuelas.codigo_escuela","like","%{$searchFor}%");
                    $escuelas = [
                        "title"=>"Conceptos Cobros",
                        "titulo_breadcrumb" => "Conceptos Cobros",
                        "subtitulo_breadcrumb" => "Visualizar Conceptos Cobros",
                        "go_back_link"=>"#",
                        "formulario"=>"conceptos_cobros", // se utiliza para el form tag
                        "tabla"=>"tabla.conceptos_cobros",
                        "view"=>"sistema_cobros.tablas.plantilla", //No cambia, se mantiene así
                        "urlRoute"=>"tabla/conceptos_cobros",
                        "confTabla"=>array(
                            "tituloTabla"=>"Mis Conceptos Cobros",
                            "placeholder"=>"Buscar conceptos de cobro",
                            "idSearch"=>"buscarInfoTabla",
                            "valueSearch"=>$searchFor,
                            "idBotonBuscar"=>"btnBuscarTabla",
                            "botonBuscar"=>"Buscar",
                            "filtrosBusqueda"=>array(["key"=>"codigo_concepto","option"=>"Código Concepto"]),
                            "rowCheckbox"=>true,
                            "idKeyName"=>"id",
                            "keys"=>array('identificador',"codigo_concepto",'nombre',"activo"),
                            "columns"=>array("#Ref","Código Concepto","Nombre","Estado"),
                            "indicadores"=>true,
                            "botones"=>array('0'=>'btn-outline-danger',
                                                '1'=>'btn-outline-success'),
                            "rowActions"=>array("show","edit","destroy"),
                            "data" => $registros->paginate(5)->appends(["page"=>$page,"search"=>$searchFor,"filter"=>$filter]),
                            "routeDestroy" => 'concepto_cobro.destroy',
                            "routeCreate" => ['formulario','alta_conceptos_cobros'],
                            "routeEdit" => 'editar',
                            "listaEdicion"=>'concepto_cobro', // referente a un método ListadoFormularios
                            "routeShow" => 'concepto_cobro.show',
                            "routeIndex" => 'tabla',
                            "ajaxRenderRoute" => '/html/tabletareas',
                            "reRenderSection" => ".dynamic_table",
                            "searchFor"=>$searchFor,
                            "count" => $registros->count(),
                            "txtBtnCrear"=>"Agregar una tarea"
                        )
                        

                    ];
                    return $escuelas;
                break;
                case "costos_conceptos":
                    $registros = DB::table('costo_concepto_cobros')
                    ->select("conceptos_cobros.codigo_concepto","costo_concepto_cobros.id","costo_concepto_cobros.id_concepto","costo_concepto_cobros.periodo","costo_concepto_cobros.costo","costo_concepto_cobros.activo")
                    ->join('conceptos_cobros','costo_concepto_cobros.id_concepto',"=",'conceptos_cobros.id')
                    ->where("conceptos_cobros.nombre","like","%{$searchFor}%");
                    $escuelas = [
                        "title"=>"Costo de Concepto",
                        "titulo_breadcrumb" => "Costo de Concepto",
                        "subtitulo_breadcrumb" => "Visualizar Costo de Concepto",
                        "go_back_link"=>"#",
                        "formulario"=>"costo_concepto", // se utiliza para el form tag
                        "tabla"=>"tabla.costos_conceptos",
                        "view"=>"sistema_cobros.tablas.plantilla", //No cambia, se mantiene así
                        "urlRoute"=>"tabla/costo_concepto",
                        "confTabla"=>array(
                            "tituloTabla"=>"Mis Costo de Concepto",
                            "placeholder"=>"Buscar costo de concepto",
                            "idSearch"=>"buscarInfoTabla",
                            "valueSearch"=>$searchFor,
                            "idBotonBuscar"=>"btnBuscarTabla",
                            "botonBuscar"=>"Buscar",
                            "filtrosBusqueda"=>array(["key"=>"id_costo_concepto","option"=>"Concepto"]),
                            "rowCheckbox"=>true,
                            "idKeyName"=>"id",
                            "keys"=>array("id","codigo_concepto","periodo","costo","activo"),
                            "columns"=>array("#Ref","Concepto","Periodo","Costo","Estado"),
                            "indicadores"=>false,
                            "botones"=>array('Pendiente'=>'btn-outline-danger',
                                                'En Progreso'=>'btn-outline-primary',
                                                'Completada'=>'btn-outline-success',
                                                'Aprobada'=>'btn-outline-info',
                                                'Reformular'=>'btn-outline-warning'),
                            "rowActions"=>array("show","edit","destroy"),
                            "data" => $registros->paginate(5)->appends(["page"=>$page,"search"=>$searchFor,"filter"=>$filter]),
                            "routeDestroy" => 'costo_concepto.destroy',
                            "routeCreate" => ['formulario','alta_costos_conceptos'],
                            "routeEdit" => 'editar',
                            "listaEdicion"=>'costos', // referente a un método ListadoFormularios
                            "routeShow" => 'costo_concepto.show',
                            "routeIndex" => 'tabla',
                            "reRenderSection" => ".dynamic_table",
                            "searchFor"=>$searchFor,

                        )
                        

                    ];
                    return $escuelas;
                break;
                case "alumnos":
                    $registros = DB::table('alumnos')
                    ->select("sistemas_academicos.codigo_sistema",DB::raw('CONCAT(alumnos.nombre," ",alumnos.apellido_paterno," ",alumnos.apellido_materno) as alumno'),
                    "alumnos.telefono","alumnos.id","alumnos.activo")
                    ->join('sistemas_academicos','alumnos.id_sistema_academico',"=",'sistemas_academicos.id')
                    ->where(DB::raw("CONCAT(alumnos.nombre, ' ',alumnos.apellido_paterno,' ',alumnos.apellido_materno)"), 'like', "%{$searchFor}%");
                    $escuelas = [
                        "title"=>"Alumnos",
                        "titulo_breadcrumb" => "Alumnos",
                        "subtitulo_breadcrumb" => "Visualizar Alumnos",
                        "go_back_link"=>"#",
                        "formulario"=>"alumnos", // se utiliza para el form tag
                        "tabla"=>"tabla.alumnos",
                        "view"=>"sistema_cobros.tablas.plantilla", //No cambia, se mantiene así
                        "urlRoute"=>"tabla/alumnos",
                        "confTabla"=>array(
                            "tituloTabla"=>"Mis Alumnos",
                            "placeholder"=>"Buscar alumno",
                            "idSearch"=>"buscarInfoTabla",
                            "valueSearch"=>$searchFor,
                            "idBotonBuscar"=>"btnBuscarTabla",
                            "botonBuscar"=>"Buscar",
                            "filtrosBusqueda"=>array(["key"=>"alumno","option"=>"Nombre completo"]),
                            "rowCheckbox"=>true,
                            "idKeyName"=>"id",
                            "keys"=>array("id","codigo_sistema","alumno","telefono","activo"),
                            "columns"=>array("#Ref","Código Sistema","Alumno","Teléfono","Estado"),
                            "indicadores"=>false,
                            "botones"=>array('Pendiente'=>'btn-outline-danger',
                                                'En Progreso'=>'btn-outline-primary',
                                                'Completada'=>'btn-outline-success',
                                                'Aprobada'=>'btn-outline-info',
                                                'Reformular'=>'btn-outline-warning'),
                            "rowActions"=>array("show","edit","destroy"),
                            "data" => $registros->paginate(10)->appends(["page"=>$page,"search"=>$searchFor,"filter"=>$filter]),
                            "routeDestroy" => 'alumnos.destroy',
                            "routeCreate" => ['formulario','alta_alumnos'],
                            "routeEdit" => 'editar',
                            "listaEdicion"=>'alumnos', // referente a un método ListadoFormularios
                            "routeShow" => 'alumnos.show',
                            "routeIndex" => 'tabla',
                            "ajaxRenderRoute" => '/html/tabletareas',
                            "reRenderSection" => ".dynamic_table",
                            "searchFor"=>$searchFor,
                            "count" => $registros->count(),
                            "txtBtnCrear"=>"Agregar una tarea"
                        )
                        

                    ];
                    return $escuelas;
                break;
                case "cuentas":
                    $registros = DB::table('cuentas')
                    ->select("cuentas.id","cuentas.cuatrimestre",DB::raw('CONCAT(alumnos.nombre," ",alumnos.apellido_paterno," ",alumnos.apellido_materno) as alumno'),
                    "cuentas.activa","sistemas_academicos.codigo_sistema")
                    ->join('alumnos','cuentas.id_alumno',"=",'alumnos.id')
                    ->join('sistemas_academicos','alumnos.id_sistema_academico',"=",'sistemas_academicos.id')
                    ->where(DB::raw("CONCAT(alumnos.nombre, ' ',alumnos.apellido_paterno, ' ',alumnos.apellido_materno)"), 'like', "%{$searchFor}%")
                    ->orWhere("cuentas.cuatrimestre","=",$searchFor);
                    $escuelas = [
                        "title"=>"Cuentas",
                        "titulo_breadcrumb" => "Cuentas",
                        "subtitulo_breadcrumb" => "Visualizar Cuentas",
                        "go_back_link"=>"#",
                        "formulario"=>"cuentas", // se utiliza para el form tag
                        "tabla"=>"tabla.cuentas",
                        "view"=>"sistema_cobros.tablas.plantilla", //No cambia, se mantiene así
                        "urlRoute"=>"tabla/cuentas",
                        "confTabla"=>array(
                            "tituloTabla"=>"Mis Cuentas",
                            "placeholder"=>"Buscar cuenta",
                            "idSearch"=>"buscarInfoTabla",
                            "valueSearch"=>$searchFor,
                            "idBotonBuscar"=>"btnBuscarTabla",
                            "botonBuscar"=>"Buscar",
                            "filtrosBusqueda"=>array(["key"=>"alumno","option"=>"Nombre completo"],["key"=>"period","option"=>"Periodo"]),
                            "rowCheckbox"=>true,
                            "idKeyName"=>"id",
                            "keys"=>array("id","cuatrimestre","alumno","codigo_sistema","activa"),
                            "columns"=>array("#Ref","Periodo","Alumno","Sistema Ac.","Estado"),
                            "indicadores"=>false,
                            "botones"=>array('Pendiente'=>'btn-outline-danger',
                                                'En Progreso'=>'btn-outline-primary',
                                                'Completada'=>'btn-outline-success',
                                                'Aprobada'=>'btn-outline-info',
                                                'Reformular'=>'btn-outline-warning'),
                            "rowActions"=>array("show","edit","destroy"),
                            "data" => $registros->paginate(10)->appends(["page"=>$page,"search"=>$searchFor,"filter"=>$filter]),
                            "routeDestroy" => 'cuentas.destroy',
                            "routeCreate" => ['formulario','alta_cuentas'],
                            "routeEdit" => 'editar',
                            "listaEdicion"=>'escuelas',
                            "routeShow" => 'cuentas.show',
                            "routeIndex" => 'tabla',
                            "searchFor"=>$searchFor,
                        )
                        

                    ];
                    return $escuelas;
                break;
                case "roles":
                $registros = DB::table('roles')
                    ->where("name","like","%{$searchFor}%");
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
                case "categoria_cobros":
                $registros = DB::table('categoria_cobros')
                    ->where("categoria","like","%{$searchFor}%")
                    ->orWhere("activo","like","%{$searchFor}%");
                    $conf = [
                        "title"=>"Lista de categorías",
                        "titulo_breadcrumb" => "Categorías",
                        "subtitulo_breadcrumb" => "Categorías",
                        "go_back_link"=>"#",
                        "formulario"=>"categoria_cobros", // se utiliza para el form tag
                        "tabla"=>"tabla.categoria_cobros",
                        "view"=>"sistema_cobros.tablas.plantilla", //No cambia, se mantiene así
                        "urlRoute"=>"tabla/categoria_cobros",
                        "confTabla"=>array(
                            "tituloTabla"=>"Mis categorías de cobros",
                            "placeholder"=>"Buscar roles",
                            "idSearch"=>"buscarInfoTabla",
                            "valueSearch"=>$searchFor,
                            "idBotonBuscar"=>"btnBuscarTabla",
                            "botonBuscar"=>"Buscar",
                            "filtrosBusqueda"=>array(["key"=>"categoria","option"=>"Por categoría"],["key"=>"activo","option"=>"Por estado"]),
                            "rowCheckbox"=>true,
                            "idKeyName"=>"id",
                            "keys"=>array('id',"categoria","activo"),
                            "columns"=>array("#Ref","Categoría","Estado"),
                            "indicadores"=>true,
                            "botones"=>array('0'=>'btn-outline-danger',
                                                '1'=>'btn-outline-success'),
                            "rowActions"=>array("show","edit","destroy"),
                            "data" => $registros->paginate(5)->appends(["page"=>$page,"search"=>$searchFor,"filter"=>$filter]),
                            "routeDestroy" => 'categoria_cobros.destroy',
                            "routeCreate" => ['formulario','alta_categoria_cobros'],
                            "routeEdit" => 'editar',
                            "listaEdicion"=>'categoria_cobros',
                            "routeShow" => 'categoria_cobros.show',
                            "routeIndex" => 'tabla',
                            "searchFor"=>$searchFor,
                            "count" => $registros->count(),
                            "txtBtnCrear"=>"Agregar una categoría"
                        )];
                return $conf;
                break;
                case "descuentos":
                $registros = DB::table('descuentos')
                    ->where("nombre","like","%{$searchFor}%")
                    ->orWhere("descripcion","like","%{$searchFor}%")
                    ->orWhere("tasa","like","%{$searchFor}%")
                    ->orWhere("monto","like","%{$searchFor}%");
                    $conf = [
                        "title"=>"Lista de descuentos",
                        "titulo_breadcrumb" => "Descuentos",
                        "subtitulo_breadcrumb" => "Descuentos",
                        "go_back_link"=>"#",
                        "formulario"=>"descuentos", // se utiliza para el form tag
                        "tabla"=>"tabla.descuentos",
                        "view"=>"sistema_cobros.tablas.plantilla", //No cambia, se mantiene así
                        "urlRoute"=>"tabla/descuentos",
                        "confTabla"=>array(
                            "tituloTabla"=>"Mis descuentos",
                            "placeholder"=>"Buscar descuentos",
                            "idSearch"=>"buscarInfoTabla",
                            "valueSearch"=>$searchFor,
                            "idBotonBuscar"=>"btnBuscarTabla",
                            "botonBuscar"=>"Buscar",
                            "filtrosBusqueda"=>array(["key"=>"nombre","option"=>"Nombre"],["key"=>"descripcion","option"=>"Descripcion"],["key"=>"tasa","option"=>"Tasa"],["key"=>"monto","option"=>"Monto"]),
                            "rowCheckbox"=>true,
                            "idKeyName"=>"id",
                            "keys"=>array("nombre","tasa","monto","activo"),
                            "columns"=>array("Nombre","Tasa","Monto","Activo"),
                            "indicadores"=>true,
                            "botones"=>array('0'=>'btn-outline-danger',
                                                '1'=>'btn-outline-success'),
                            "rowActions"=>array("show","edit","destroy"),
                            "data" => $registros->paginate(5)->appends(["page"=>$page,"search"=>$searchFor,"filter"=>$filter]),
                            "routeDestroy" => 'descuentos.destroy',
                            "routeCreate" => 'descuentos.create',
                            "routeEdit" => 'descuentos.edit',
                            "listaEdicion"=>'descuentos',
                            "routeShow" => 'descuentos.show',
                            "routeIndex" => 'tabla',
                            "searchFor"=>$searchFor,
                            "count" => $registros->count(),
                            "txtBtnCrear"=>"Agregar un descuento"
                        )];
                return $conf;
                break;
                case "pagos_pendientes":
                $registros = DB::table('desglose_cuentas')
                ->select(
                    'desglose_cuentas.id as id',
                    'desglose_cuentas.num_cargo',
                    'desglose_cuentas.monto',
                    'cuentas.id as cuenta',
                    DB::raw("CONCAT(alumnos.nombre, ' ',alumnos.apellido_paterno, ' ',alumnos.apellido_materno) as alumno"),
                    'cuentas.cuatrimestre'
                )
                ->join('cuentas', 'desglose_cuentas.id_cuenta', '=', 'cuentas.id')
                ->join('alumnos', 'cuentas.id_alumno', '=', 'alumnos.id')
                ->where(function($query) use ($searchFor) {
                    $query->where(DB::raw("CONCAT(alumnos.nombre, ' ',alumnos.apellido_paterno, ' ',alumnos.apellido_materno)"), 'like', "%{$searchFor}%")
                        ->orWhere('cuentas.cuatrimestre', 'like', "%{$searchFor}%")
                        ->orWhere('cuentas.id', 'like', "%{$searchFor}%");
                });
                    $conf = [
                        "title"=>"Lista de pagos pendientes",
                        "titulo_breadcrumb" => "Pagos pendientes",
                        "subtitulo_breadcrumb" => "Pagos pendientes",
                        "go_back_link"=>"#",
                        "formulario"=>"pagos_pendientes", // se utiliza para el form tag
                        "tabla"=>"tabla.pagos_pendientes",
                        "view"=>"sistema_cobros.tablas.plantilla", //No cambia, se mantiene así
                        "urlRoute"=>"tabla/pagos_pendientes",
                        "confTabla"=>array(
                            "tituloTabla"=>"Mis pagos pendientes",
                            "placeholder"=>"Buscar pagos pendientes",
                            "idSearch"=>"buscarInfoTabla",
                            "valueSearch"=>$searchFor,
                            "idBotonBuscar"=>"btnBuscarTabla",
                            "botonBuscar"=>"Buscar",
                            "filtrosBusqueda"=>array(["key"=>"nombre","option"=>"Nombre del alumno"],["key"=>"id","option"=>"Identificador de cuenta"],["key"=>"cuatri","option"=>"Cuatrimestre"]),
                            "rowCheckbox"=>true,
                            "idKeyName"=>"id",
                            "keys"=>array("num_cargo","alumno","monto","cuatrimestre"),
                            "columns"=>array("Num Cargo","Alumno","Monto","Cuatrimestre"),
                            "indicadores"=>false,
                            "botones"=>array('0'=>'btn-outline-danger',
                                                '1'=>'btn-outline-success'),
                            "rowActions"=>array("show","edit","destroy"),
                            "data" => $registros->paginate(5)->appends(["page"=>$page,"search"=>$searchFor,"filter"=>$filter]),
                            "routeDestroy" => 'pagos_pendientes.destroy',
                            "routeCreate" => 'pagos_pendientes.create',
                            "routeEdit" => 'pagos_pendientes.edit',
                            "listaEdicion"=>'pagos_pendientes',
                            "routeShow" => 'pagos_pendientes.show',
                            "routeIndex" => 'tabla',
                            "searchFor"=>$searchFor,
                            "count" => $registros->count(),
                            "txtBtnCrear"=>"Agregar un descuento"
                        )];
                return $conf;
                break;
                case "pagos_realizados":
                $registros = DB::table('pagos_realizados')
                    ->select('pagos_realizados.id as id','pagos_realizados.monto',
                            'pagos_realizados.tipo_pago','cuentas.cuatrimestre',
                            'pagos_realizados.created_at as fecha',
                            'cuentas.id as cuenta',
                            DB::raw("CONCAT(alumnos.nombre, ' ',alumnos.apellido_paterno, ' ',alumnos.apellido_materno) as alumno"))
                    ->join('cuentas', 'pagos_realizados.id_cuenta', '=', 'cuentas.id')
                    ->join('alumnos', 'pagos_realizados.id_estudiante', '=', 'alumnos.id')
                    ->where(function($query) use ($searchFor) {
                    $query->where(DB::raw("CONCAT(alumnos.nombre, ' ',alumnos.apellido_paterno, ' ',alumnos.apellido_materno)"), 'like', "%{$searchFor}%")
                    ->orWhere("pagos_realizados.tipo_pago","like","%{$searchFor}%")
                    ->orWhere("cuentas.id","like","%{$searchFor}%");
                    });
                    
                    $conf = [
                        "title"=>"Lista de pagos realizados",
                        "titulo_breadcrumb" => "Pagos realizados",
                        "subtitulo_breadcrumb" => "Pagos realizados",
                        "go_back_link"=>"#",
                        "formulario"=>"pagos_realizados", // se utiliza para el form tag
                        "tabla"=>"tabla.pagos_realizados",
                        "view"=>"sistema_cobros.tablas.plantilla", //No cambia, se mantiene así
                        "urlRoute"=>"tabla/pagos_realizados",
                        "confTabla"=>array(
                            "tituloTabla"=>"Mis pagos realizados",
                            "placeholder"=>"Buscar pagos realizados",
                            "idSearch"=>"buscarInfoTabla",
                            "valueSearch"=>$searchFor,
                            "idBotonBuscar"=>"btnBuscarTabla",
                            "botonBuscar"=>"Buscar",
                            "filtrosBusqueda"=>array(["key"=>"id_cuenta","option"=>"Identificador de cuenta"],["key"=>"alumno","option"=>"alumno"],["key"=>"cuatri","option"=>"Cuatrimestre"]),
                            "rowCheckbox"=>true,
                            "idKeyName"=>"id",
                            "keys"=>array("alumno","monto","cuatrimestre","fecha"),
                            "columns"=>array("Alumno","Monto","Periodo","Fecha realizado"),
                            "indicadores"=>true,
                            "botones"=>array('0'=>'btn-outline-danger',
                                                '1'=>'btn-outline-success'),
                            "rowActions"=>array("show","edit","destroy"),
                            "data" => $registros->paginate(5)->appends(["page"=>$page,"search"=>$searchFor,"filter"=>$filter]),
                            "routeDestroy" => 'pagos_realizados.destroy',
                            "routeCreate" => 'pagos_realizados.create',
                            "routeEdit" => 'pagos_realizados.edit',
                            "listaEdicion"=>'pagos_realizados',
                            "routeShow" => 'pagos_realizados.show',
                            "routeIndex" => 'tabla',
                            "searchFor"=>$searchFor,
                            "count" => $registros->count(),
                            "txtBtnCrear"=>"Agregar un descuento"
                        )];
                return $conf;
                break;
                case "promociones":
                $registros = DB::table('promociones')
                    ->where("nombre","like","%{$searchFor}%")
                    ->orWhere("breve_descripcion","like","%{$searchFor}%")
                    ->orWhere("tipo","like","%{$searchFor}%")
                    ->orWhere("banner_1200x700","like","%{$searchFor}%")
                    ->orWhere("banner_300x250","like","%{$searchFor}%");

                    $conf = [
                        "title"=>"Lista de promociones",
                        "titulo_breadcrumb" => "Promociones",
                        "subtitulo_breadcrumb" => "Promociones",
                        "go_back_link"=>"#",
                        "formulario"=>"promociones", // se utiliza para el form tag
                        "tabla"=>"tabla.promociones",
                        "view"=>"sistema_cobros.tablas.plantilla", //No cambia, se mantiene así
                        "urlRoute"=>"tabla/promociones",
                        "confTabla"=>array(
                            "tituloTabla"=>"Mis promociones",
                            "placeholder"=>"Buscar promociones",
                            "idSearch"=>"buscarInfoTabla",
                            "valueSearch"=>$searchFor,
                            "idBotonBuscar"=>"btnBuscarTabla",
                            "botonBuscar"=>"Buscar",
                            "filtrosBusqueda"=>array(["key"=>"nombre","option"=>"Nombre"],["key"=>"descripcion","option"=>"Descripcion"],["key"=>"tipo","option"=>"Tipo"],["key"=>"imagen_1200","option"=>"Nombre de imagen o banner"]),
                            "rowCheckbox"=>true,
                            "idKeyName"=>"id",
                            "keys"=>array("nombre","createdBy","inicia_en","caducidad",'activo'),
                            "columns"=>array("Nombre","Creado Por","Inicia","Caduca","activo"),
                            "indicadores"=>true,
                            "botones"=>array('0'=>'btn-outline-danger',
                                                '1'=>'btn-outline-success'),
                            "rowActions"=>array("show","edit","destroy"),
                            "data" => $registros->paginate(5)->appends(["page"=>$page,"search"=>$searchFor,"filter"=>$filter]),
                            "routeDestroy" => 'promociones.destroy',
                            "routeCreate" => 'promociones.create',
                            "routeEdit" => 'editar',
                            "listaEdicion"=>'promociones',
                            "routeShow" => 'promociones.show',
                            "routeIndex" => 'tabla',
                            "searchFor"=>$searchFor,
                            "count" => $registros->count(),
                            "txtBtnCrear"=>"Agregar un descuento"
                        )];
                return $conf;
                break;





                default:

                // Valores default
        }
     }
}
