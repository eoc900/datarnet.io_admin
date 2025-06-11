<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Maestro;
use App\Models\ConceptoCobro;
use App\Models\CostoConceptoCobro;
use Illuminate\Support\Facades\DB;
use App\Services\DatabaseService;


class Select2Controller extends Controller
{
    public function maestro(Request $request){
        $search = $request->input("search");
        return Maestro::buscarPorNombre($search);
    }

    public function conceptos_cobros(Request $request){
        $search = $request->input("search");
        return ConceptoCobro::select("conceptos_cobros.id as id_concepto","conceptos_cobros.codigo_concepto",
        "conceptos_cobros.nombre as nombre_concepto","escuelas.codigo_escuela",DB::raw("COALESCE(costo_concepto_cobros.costo, 'Sin asignar') as costo"),
        DB::raw("COALESCE(costo_concepto_cobros.periodo, 'Sin referencia') as periodo"))
                ->join('escuelas', 'conceptos_cobros.id_escuela', '=', 'escuelas.id')
                ->leftJoin('costo_concepto_cobros','conceptos_cobros.id','=','costo_concepto_cobros.id_concepto')
                ->where("conceptos_cobros.codigo_concepto","like","%{$search}%")
                ->orWhere("conceptos_cobros.nombre","like","%{$search}%")
                ->orWhere("escuelas.codigo_escuela","like","%{$search}%")
                ->get();
    }

    public function alumnos_con_sistema(Request $request){
            $search = $request->input("search");
            $alumnos = DB::table('alumnos')
                   ->select("alumnos.id as id_alumno","sistemas_academicos.codigo_sistema",
                   DB::raw('CONCAT(alumnos.nombre," ",alumnos.apellido_paterno," ",alumnos.apellido_materno) as alumno'),
                   "alumnos.activo","sistemas_academicos.nombre")
                   ->join('sistemas_academicos','alumnos.id_sistema_academico',"=",'sistemas_academicos.id')
                   ->where(DB::raw("CONCAT(alumnos.nombre, ' ',alumnos.apellido_paterno, ' ',alumnos.apellido_materno)"),"like","%{$search}%")
                   ->get();
            return $alumnos;
    }

    public function costos_conceptos(Request $request){
        $search = $request->input("search");
        return DB::table('costo_concepto_cobros')->select('costo_concepto_cobros.id','costo_concepto_cobros.periodo','costo_concepto_cobros.costo',
        'conceptos_cobros.codigo_concepto',"escuelas.codigo_escuela")
        ->join('conceptos_cobros','costo_concepto_cobros.id_concepto','=','conceptos_cobros.id')
        ->join('escuelas', 'conceptos_cobros.id_escuela', '=', 'escuelas.id')
        ->where("conceptos_cobros.codigo_concepto","like","%{$search}%")
        ->orWhere("conceptos_cobros.nombre","like","%{$search}%")
        ->orWhere("escuelas.nombre","like","%{$search}%")
        ->orWhere("escuelas.codigo_escuela","like","%{$search}%")
        ->get();
    }

    public function cuentas_alumno(Request $request){
        $search = $request->input("search");
        return DB::table('alumnos')->select("alumnos.id as id_alumno",
                   DB::raw('CONCAT(alumnos.nombre," ",alumnos.apellido_paterno," ",alumnos.apellido_materno) as alumno'),
                   'cuentas.cuatrimestre','cuentas.id','cuentas.activa')
                   ->join('cuentas','alumnos.id','=','cuentas.id_alumno')
                   ->where(DB::raw("CONCAT(alumnos.nombre, ' ',alumnos.apellido_paterno, ' ',alumnos.apellido_materno)"),"like","%{$search}%")
                   ->get();
    }

    public function usuariosYRoles(Request $request){
        $search = $request->input("search");
        return DB::table('users')->select('users.id',
                    DB::raw('CONCAT(users.name," ",users.lastname) as usuario'), 'roles.name as role','roles.id as roleID')
                ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                ->join('roles','model_has_roles.role_id','=','roles.id')
                ->where(DB::raw('CONCAT(users.name," ",users.lastname)'),'like',"%{$search}%")
                ->orWhere('roles.name','like',"%{$search}%")
                ->get();
    }

    public function usuarios(Request $request){
        $search = $request->input("search");
        return DB::table('users')->select('users.id','users.estado',
                    DB::raw('CONCAT(users.name," ",users.lastname) as usuario'))
                    ->where(DB::raw('CONCAT(users.name," ",users.lastname)'),'like',"%{$search}%")
                    ->get();
    }

    public function maestros(Request $request){
        $search = $request->input("search");
        return DB::table('maestros')->select('maestros.id','maestros.activo',
                    DB::raw('CONCAT(maestros.nombre," ",maestros.apellido_paterno," ",maestros.apellido_materno) as maestro'))
                    ->where(DB::raw('CONCAT(maestros.nombre," ",maestros.apellido_paterno," ",maestros.apellido_materno)'),'like',"%{$search}%")
                    ->get();
    }

    public function sistemas(Request $request){
        $search = $request->input("search");
        return DB::table('sistemas_academicos')->select('sistemas_academicos.id',
        'sistemas_academicos.activo','sistemas_academicos.nombre','sistemas_academicos.codigo_sistema')
        ->where('sistemas_academicos.nombre','like',"%{$search}%")
        ->where('sistemas_academicos.codigo_sistema','like',"%{$search}%")
        ->get();
    }

    public function dropdownDescuentos(Request $request){
        $searchBy = $request->search;
        $response = DB::table('descuentos')
        ->where('nombre','like',"%{$searchBy}%")
        ->orWhere('descripcion','like',"%{$searchBy}%")
        ->get();
        return $response;
    }

    public function formularios(Request $request){
        $searchBy = $request->search;
        $response = DB::table('form_creator')
        ->where('titulo','like',"%{$searchBy}%")
        ->orWhere('nombre_documento','like',"%{$searchBy}%")
        ->orWhere('id','like',"%{$searchBy}%")
        ->get();
        return $response;
    }

    public function queries(Request $request){
        $searchBy = $request->search;
        $response = DB::table('sql_creator')
        ->where('nombre','like',"%{$searchBy}%")
        ->orWhere('descripcion','like',"%{$searchBy}%")
        ->get();
        return $response;
    }
    public function tablasModulos(Request $request){
        return DatabaseService::obtenerTablasParaSelect2($request->search);        
    }
}
