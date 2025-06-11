<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Cobro;
use App\Models\Alumno;
use App\Models\Escuela;
use App\Models\CategoriaCobro;
use App\Models\SistemaAcademico;
use App\Models\CostoConceptoCobro;
use App\Models\Promocion;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class ListadoFormularios extends Model
{
    use HasFactory;


    static public function lista($request){
        $nameFormulario = $request->nombre;
        $idAlumno = ($request->alumno)?$request->alumno:"";
        switch($nameFormulario){
                case "alta_escuelas":
                    $escuelas = [
                        "title"=>"Alta de Escuelas",
                        "titulo_breadcrumb" => "Escuelas",
                        "subtitulo_breadcrumb" => "Alta de escuelas",
                        "go_back_link"=>"#",
                        "formulario"=>"escuelas", // se utiliza para el form tag
                        "titulo_formulario"=>"Crear un nuevo registro de escuela",
                        "view"=>"sistema_cobros.formularios.escuelas",
                        "accion"=>"alta",
                        "routeStore"=>"insert.escuela"
                    ];
                    return $escuelas;
                break;
                case "alta_sistemas_academicos":
                    $escuelas = DB::table('escuelas')->select("id","codigo_escuela","activo")->get();
                    $nivelesDropdown = SistemaAcademico::mostrarDropdownNiveles(); 
                    $sistemas = [
                        "title"=>"Alta de Sistemas",
                        "titulo_breadcrumb" => "Sistemas Académicos",
                        "subtitulo_breadcrumb" => "Alta de Sistemas Académicos",
                        "go_back_link"=>"#",
                        "formulario"=>"sistemas_academicos", // se utiliza para el form tag
                        "titulo_formulario"=>"Crear un nuevo registro de Sistemas Académicos",
                        "view"=>"sistema_cobros.formularios.sistemas_academicos",
                        "accion"=>"alta",
                        "routeStore"=>"insert.sistema_academico",
                        "escuelas"=>$escuelas,
                        "nivelesDropdown"=>$nivelesDropdown

                    ];
                    return $sistemas;
                break;
                case "alta_alumnos":
                   $sistemas = DB::table('sistemas_academicos')->select("id","codigo_sistema","activo")->get();
         
                    $sistemas = [
                        "title"=>"Alta de Alumnos",
                        "titulo_breadcrumb" => "Alumnos",
                        "subtitulo_breadcrumb" => "Alta de Alumnos",
                        "go_back_link"=>"#",
                        "formulario"=>"alumnos", // se utiliza para el form tag
                        "titulo_formulario"=>"Crear un nuevo registro de Alumnos",
                        "view"=>"sistema_cobros.formularios.alumnos",
                        "accion"=>"alta",
                        "routeStore"=>"insert.alumno",
                        "sistemas_academicos"=>$sistemas

                    ];
                    return $sistemas;
                break;
                case "alta_conceptos_cobros":
                   $escuelas = DB::table('escuelas')->select("id","codigo_escuela","activo")->where('activo','=',1)->get();
                   $categorias = DB::table('categoria_cobros')->where('activo','=',1)->get();
         
                    $sistemas = [
                        "title"=>"Alta de Concepto",
                        "titulo_breadcrumb" => "Concepto de Cobro",
                        "subtitulo_breadcrumb" => "Alta de Concepto de Cobro",
                        "go_back_link"=>"#",
                        "formulario"=>"conceptos_cobros", // se utiliza para el form tag
                        "titulo_formulario"=>"Crear un nuevo registro de concepto de cobro.",
                        "view"=>"sistema_cobros.formularios.conceptos_cobros",
                        "accion"=>"alta",
                        "routeStore"=>"insert.conceptos_cobros",
                        "escuelas"=>$escuelas,
                        "categorias"=>$categorias
                    ];
                    return $sistemas;
                break;
                case "alta_costos_conceptos":
                   $sistemas = DB::table('conceptos_cobros')->select("id","codigo_concepto","activo")->get();
                    $sistemas = [
                        "title"=>"Alta de Costo",
                        "titulo_breadcrumb" => "Costo por concepto",
                        "subtitulo_breadcrumb" => "Alta Costo por Concepto",
                        "go_back_link"=>"#",
                        "formulario"=>"costo_concepto", // se utiliza para el form tag
                        "titulo_formulario"=>"Crear un nuevo registro de costo de concepto",
                        "view"=>"sistema_cobros.formularios.costos_conceptos",
                        "accion"=>"alta",
                        "routeStore"=>"insert.costos_conceptos",
                        "sistemas_academicos"=>$sistemas,
                        "select2" => '/select2/conceptos',
                        "idSelect2"=>'conceptos'
                    ];
                    return $sistemas;
                break;
                case "alta_cuentas":
                  
                    $cuentas = [
                        "title"=>"Alta de cuentas",
                        "titulo_breadcrumb" => "Cuentas",
                        "subtitulo_breadcrumb" => "Crear cuenta de alumno",
                        "go_back_link"=>"#",
                        "formulario"=>"cuentas", // se utiliza para el form tag
                        "titulo_formulario"=>"Crear un nuevo registro de cuenta",
                        "view"=>"sistema_cobros.formularios.cuentas",
                        "accion"=>"alta",
                        "routeStore"=>"insert.cuentas",
                        "select2" => '/select2/alumnos',
                        "idSelect2"=>'alumnos'
                    ];
                    return $cuentas;
                break;
                case "enlace_cuenta_alumno":
                  $info = Alumno::informacionBasica($idAlumno);
                    $cuentas = [
                        "title"=>"Enlazar cuenta",
                        "titulo_breadcrumb" => "Cuenta de alumno",
                        "subtitulo_breadcrumb" => "Enlazar cuenta hacia alumno",
                        "go_back_link"=>"#",
                        "formulario"=>"cuentas", // se utiliza para el form tag
                        "titulo_formulario"=>"",
                        "view"=>"sistema_cobros.formularios.enlace_cuenta_alumno",
                        "accion"=>"alta",
                        "routeStore"=>"insert.cuentas",
                        "alumno"=>$info
                        
                    ];
                    return $cuentas;
                break;
                case "alta_roles":
                    $cuentas = [
                        "title"=>"Generar rol",
                        "titulo_breadcrumb" => "Agregar un rol",
                        "subtitulo_breadcrumb" => "Roles",
                        "go_back_link"=>"#",
                        "formulario"=>"roles", // se utiliza para el form tag
                        "titulo_formulario"=>"Agregar un nuevo rol",
                        "view"=>"sistema_cobros.formularios.roles",
                        "accion"=>"alta",
                        "routeStore"=>"insert.roles",
                        
                    ];
                    return $cuentas;
                break;
                case "alta_permisos":
                    $cuentas = [
                        "title"=>"Generar permiso",
                        "titulo_breadcrumb" => "Agregar un permiso",
                        "subtitulo_breadcrumb" => "Permisos",
                        "go_back_link"=>"#",
                        "formulario"=>"permisos", // se utiliza para el form tag
                        "titulo_formulario"=>"Agregar un nuevo permiso",
                        "view"=>"sistema_cobros.formularios.permisos",
                        "accion"=>"alta",
                        "routeStore"=>"insert.permisos",
                        
                    ];
                    return $cuentas;
                break;
                case "alta_rol_permisos":
                    $roles = Role::all();
                    $permissions = Permission::all();
                    $info = [
                        "title"=>"Añadir permisos al rol",
                        "titulo_breadcrumb" => "Agregar permisos",
                        "subtitulo_breadcrumb" => "Permisos del rol",
                        "go_back_link"=>"#",
                        "formulario"=>"rol_permisos", // se utiliza para el form tag
                        "titulo_formulario"=>"Agregar permisos",
                        "view"=>"sistema_cobros.formularios.rol_permisos",
                        "accion"=>"alta",
                        "routeStore"=>"insert.rol_permisos",
                        "roles"=>$roles,
                        "permissions"=>$permissions
                    ];
                    return $info;
                break;
                case "alta_usuarios":
                    $roles = Role::all();
                    $info = [
                        "title"=>"Añadir usuario",
                        "titulo_breadcrumb" => "Agregar usuario",
                        "subtitulo_breadcrumb" => "Usuarios",
                        "go_back_link"=>"#",
                        "formulario"=>"usuarios", // se utiliza para el form tag
                        "titulo_formulario"=>"Agregar usuario",
                        "view"=>"sistema_cobros.formularios.usuarios",
                        "accion"=>"alta",
                        "routeStore"=>"usuarios.store",
                        "roles"=>$roles,
                    ];
                    return $info;
                break;
                case "alta_categoria_cobros":
                    $cuentas = [
                        "title"=>"Crear categoría",
                        "titulo_breadcrumb" => "Agregar una categoría",
                        "subtitulo_breadcrumb" => "Permisos",
                        "go_back_link"=>"#",
                        "formulario"=>"categoria_cobros", // se utiliza para el form tag
                        "titulo_formulario"=>"Agregar una nueva categoría",
                        "view"=>"sistema_cobros.formularios.categoria_cobros",
                        "accion"=>"alta",
                        "routeStore"=>"insert.categoria_cobros",
                        
                    ];
                    return $cuentas;
                break;

                
                default:
                    return array(
                        "title"=>"No encontrado",
                        "breadcrumb_title" => "Recurso no encontrado",
                        "breadcrumb_second" => "Error 404",
                        "formulario"=>"");

        }
        

       

    }

    static public function listaEdicion($request){
          $nameFormulario = $request->nombre;
              switch($nameFormulario){
                case "escuelas":
                    $escuela = Escuela::findOrFail($request->id);
                    $escuelas = [
                        "title"=>"Edición de Escuela",
                        "titulo_breadcrumb" => "Escuela",
                        "subtitulo_breadcrumb" => "Edición de escuelas",
                        "go_back_link"=>"#",
                        "formulario"=>"escuelas", // se utiliza para el form tag
                        "titulo_formulario"=>"Editar escuela",
                        "view"=>"sistema_cobros.formularios.escuelas",
                        "accion"=>"edicion",
                        "routeUpdate"=>"escuelas.update",
                        "escuela"=>$escuela
                    ];
                    return $escuelas;
                break;
                case "sistema_academico":
                    $sistema = SistemaAcademico::findOrFail($request->id);
                    $lista = Escuela::all();
                    $nivelesDropdown = SistemaAcademico::mostrarDropdownNiveles(); 
                    $escuelas = [
                        "title"=>"Edición de Sistema académico",
                        "titulo_breadcrumb" => "Sistema Académico",
                        "subtitulo_breadcrumb" => "Edición de sistema académico.",
                        "go_back_link"=>"#",
                        "formulario"=>"escuelas", // se utiliza para el form tag
                        "titulo_formulario"=>"Editar Sistema Académico",
                        "view"=>"sistema_cobros.formularios.sistemas_academicos",
                        "accion"=>"edicion",
                        "routeUpdate"=>"sistema_academico.update",
                        "sistema"=>$sistema,
                        "escuelas"=>$lista,
                        "nivelesDropdown"=>$nivelesDropdown
                    ];
                    return $escuelas;
                break;
                case "concepto_cobro":
                    $concepto = ConceptoCobro::findOrFail($request->id);
                    $escuelas = DB::table('escuelas')->select("id","codigo_escuela","activo")->where('activo','=',1)->get();
                    $categorias = DB::table('categoria_cobros')->where('activo','=',1)->get();
                    $conceptos = [
                        "title"=>"Edición de Concepto Cobro",
                        "titulo_breadcrumb" => "Conceptos de Cobro",
                        "subtitulo_breadcrumb" => "Edición de concepto de cobro",
                        "go_back_link"=>"#",
                        "formulario"=>"conceptos_cobros", // se utiliza para el form tag
                        "titulo_formulario"=>"Editar Concepto de Cobro",
                        "view"=>"sistema_cobros.formularios.conceptos_cobros",
                        "accion"=>"edicion",
                        "routeUpdate"=>"concepto_cobro.update",
                        "concepto"=>$concepto,
                        "escuelas"=>$escuelas,
                        "categorias"=>$categorias
                    ];
                    return $conceptos;
                break;
                case "alumnos":
                $alumno = Alumno::findOrFail($request->id);
                $sistemas = SistemaAcademico::all();
                $conceptos = [
                    "title"=>"Edición de Alumno",
                    "titulo_breadcrumb" => "Alumnos",
                    "subtitulo_breadcrumb" => "Edición de alumno",
                    "go_back_link"=>"#",
                    "formulario"=>"alumnos", // se utiliza para el form tag
                    "titulo_formulario"=>"Editar información del alumno",
                    "view"=>"sistema_cobros.formularios.alumnos",
                    "accion"=>"edicion",
                    "routeUpdate"=>"alumnos.update",
                    "alumno"=>$alumno,
                    "sistemas"=>$sistemas

                ];
                return $conceptos;
                break;
                case "costos":
                $costo = CostoConceptoCobro::select('costo_concepto_cobros.id','costo_concepto_cobros.costo',
                'costo_concepto_cobros.activo','conceptos_cobros.nombre','conceptos_cobros.codigo_concepto',
                'costo_concepto_cobros.periodo')
                ->join('conceptos_cobros','costo_concepto_cobros.id_concepto','=','conceptos_cobros.id')
                ->where('costo_concepto_cobros.id','=',$request->id)
                ->firstOrFail();
                $conceptos = [
                    "title"=>"Edición de Costo",
                    "titulo_breadcrumb" => "Costos",
                    "subtitulo_breadcrumb" => "Edición de costos",
                    "go_back_link"=>"#",
                    "formulario"=>"costo_concepto", // se utiliza para el form tag
                    "titulo_formulario"=>"Editar información del costo de concepto",
                    "view"=>"sistema_cobros.formularios.costos_conceptos",
                    "accion"=>"edicion",
                    "routeUpdate"=>"costo_concepto.update",
                    "costo"=>$costo,
                    "select2" => '/select2/costos_conceptos',
                    "idSelect2"=>'conceptos'

                ];
                return $conceptos; 
                break;
                case "categoria_cobros":
                $categoria = CategoriaCobro::findOrFail($request->id);
                $conceptos = [
                    "title"=>"Edición de categoría",
                    "titulo_breadcrumb" => "Categorías",
                    "subtitulo_breadcrumb" => "Edición de categoría",
                    "go_back_link"=>"#",
                    "formulario"=>"categoria_cobros", // se utiliza para el form tag
                    "titulo_formulario"=>"Editar información del alumno",
                    "view"=>"sistema_cobros.formularios.categoria_cobros",
                    "accion"=>"edicion",
                    "routeUpdate"=>"categoria_cobros.update",
                    "categoria"=>$categoria,
                ];
                return $conceptos;
                break;
                case "promociones":
                $promocion = Promocion::findOrFail($request->id);
                $conceptos = [
                    "title"=>"Edición de promoción",
                    "titulo_breadcrumb" => "Promociones",
                    "subtitulo_breadcrumb" => "Edición de promoción",
                    "go_back_link"=>"#",
                    "formulario"=>"promociones", // se utiliza para el form tag
                    "titulo_formulario"=>"Editar información de la promoción.",
                    "view"=>"sistema_cobros.formularios.promociones",
                    "accion"=>"edicion",
                    "routeUpdate"=>"promociones.update",
                    "promocion"=>$promocion,
                ];
                return $conceptos;
                break;
                default:
                return array(
                    "title"=>"No encontrado",
                    "breadcrumb_title" => "Recurso no encontrado",
                    "breadcrumb_second" => "Error 404",
                    "formulario"=>"");
                }
    }

}
