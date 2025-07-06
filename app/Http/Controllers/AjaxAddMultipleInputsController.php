<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Inscripcion;
use App\Models\Alumno;

class AjaxAddMultipleInputsController extends Controller
{
    public function validate(Request $request){
        //Esta función debe retornar un html de tipo alerta si no se encuentra el grupo de inputs deseado
       
        if($request->inputs!=="" && isset($request->inputs)){
            switch ($request->inputs) {
                case 'correos_alumno':
                    $tipos_correos = DB::table('tipos_correos_alumnos')->get();
                    return view('sistema_cobros.htmlForAjaxResponse.inputCorreo',["tipos_correos"=>$tipos_correos]);
                    return "hola";
                    break;
                case 'correos_maestros':
                    $tipos_correos = DB::table('tipos_correos_maestros')->get();
                    return view('sistema_cobros.htmlForAjaxResponse.inputCorreoMaestro',["tipos_correos"=>$tipos_correos]);
                    return "hola";
                    break;
                case 'correos_contactos_alumnos':
                    $tipos_correos = DB::table('tipos_correos_contactos_alumnos')->get();
                    return view('sistema_cobros.htmlForAjaxResponse.inputCorreoContacto',["tipos_correos"=>$tipos_correos]);
                    break;
                case 'telefono':
                    return view('sistema_cobros.htmlForAjaxResponse.inputTelefono');
                    break;
                case 'direccion':
                    return view('sistema_cobros.htmlForAjaxResponse.inputsDireccion');
                    break;
                case 'inscripciones':
                    $inscripcion = new Inscripcion();
                    return view('sistema_cobros.htmlForAjaxResponse.inscripciones',["tipos_inscripcion"=>$inscripcion->tipos_inscripcion]);
                    break;
                case 'materias_sistema':
                    if(isset($request->id_sistema)){
                        $materias = DB::table("materias")
                        ->select("materias.id","materias.materia","materias.cuatrimestre","materias.creditos")
                        ->join("sistemas_academicos","materias.id_sistema","=","sistemas_academicos.id")
                        ->where("materias.id_sistema","=",$request->id_sistema)
                        ->get();
                        return view('sistema_cobros.htmlForAjaxResponse.materias_sistema',["materias"=>$materias]);
                    }

                    return '<div class="alert alert-danger">No detectamos el identificador de sistema.</div>';
                    break;
                case 'tabla_inscripciones':
                    $inscripciones = false;
                    $alumno = false;
                    if(isset($request->alumno)){
                        $inscripciones = DB::table('inscripciones')
                        ->select('inscripciones.id','inscripciones.periodo','inscripciones.inscrito_por','inscripciones.tipo_inscripcion',
                            DB::raw('COUNT(carga_materias.id) as materias_inscritas'))
                        ->leftJoin('carga_materias', 'inscripciones.id', '=', 'carga_materias.id_inscripcion')
                        ->leftJoin('materias','carga_materias.id_materia','=','materias.id')
                        ->where('inscripciones.id_alumno','=',$request->alumno)
                        ->groupBy('inscripciones.id','inscripciones.periodo')
                        ->get();
                        $alumno = Alumno::informacionBasica($request->alumno);

                        $materias = DB::table("materias")
                                    ->select("materias.id","materias.materia","materias.cuatrimestre","materias.creditos")
                                    ->join("sistemas_academicos","materias.id_sistema","=","sistemas_academicos.id")
                                    ->where("materias.id_sistema","=",$alumno->id_sistema_academico)
                                    ->get();
                    }

                    return view('sistema_cobros.htmlForAjaxResponse.tablaInscripciones',["materias"=>$materias,"inscripciones"=>$inscripciones,"alumno"=>$alumno]);
                    break;
                default:
                    return '<div class="alert alert-danger">Lo sentimos, la petición solicitada no se puede realizar...</div>';
                    break;
            }
        }

        return '<div class="alert alert-danger">Lo sentimos, la petición solicitada no se puede realizar...</div>';
    }

    public function test(Request $request){
       return view('snippets.plantillas.sections.agregar_multiples_inputs',["title"=>"Prueba"]);
    }

    
}
