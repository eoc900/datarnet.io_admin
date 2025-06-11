<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Tareas extends Model
{
   
     use HasFactory;
     public $estados = ["Pendiente","En Progreso","Completada","Aprobada","Reformular"];
     protected $fillable = [
        'titulo',
        'descripcion',
        'creada_por',
        'actualizada_por',
        'fecha_inicio',
        'fecha_entrega',
        'estado'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_entrega' => 'date',
    ];

   
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    static public function buscarPorMes($mes){
        return Tareas::select("*")
        ->whereYear('fecha_inicio', Carbon::now()->year)
        ->whereMonth('fecha_inicio', Carbon::now()->month)
        ->get();
    }

    static public function listarTareas($search=""){

        $results = DB::table('tareas')
        ->leftJoin('users as u','tareas.creada_por','=','u.id')
        ->leftJoin('tareas_asignadas', 'tareas.referencia', '=', 'tareas_asignadas.ref')
        ->leftJoin('users as u1','tareas_asignadas.id_usuario','=','u1.id')
        ->select('tareas.id as id',"tareas.titulo","tareas.titulo","u.name","u1.name as responsable","tareas.estado")
        ->orderByRaw('fecha_inicio ASC');

        return $results;
    }

    static public function busquedaPorResponsable($search=""){
         $results = DB::table('tareas')
        ->leftJoin('users as u','tareas.creada_por','=','u.id')
        ->leftJoin('tareas_asignadas', 'tareas.referencia', '=', 'tareas_asignadas.ref')
        ->leftJoin('users as u1','tareas_asignadas.id_usuario','=','u1.id')
        ->select('tareas.id as id',"tareas.titulo","tareas.titulo","u.name","u1.name as responsable","tareas.estado")
        ->where("u1.name","like","%{$search}%")
        ->orderByRaw('fecha_inicio ASC');
        return $results;
    }

    static public function busquedaPorEstado($search=""){
         $results = DB::table('tareas')
        ->leftJoin('users as u','tareas.creada_por','=','u.id')
        ->leftJoin('tareas_asignadas', 'tareas.referencia', '=', 'tareas_asignadas.ref')
        ->leftJoin('users as u1','tareas_asignadas.id_usuario','=','u1.id')
        ->select('tareas.id as id',"tareas.titulo","tareas.titulo","u.name","u1.name as responsable","tareas.estado")
        ->where("tareas.estado","like","%{$search}%")
        ->orderByRaw('fecha_inicio ASC');
        return $results;
    }

    static public function busquedaPorTitulo($search=""){
         $results = DB::table('tareas')
        ->leftJoin('users as u','tareas.creada_por','=','u.id')
        ->leftJoin('tareas_asignadas', 'tareas.referencia', '=', 'tareas_asignadas.ref')
        ->leftJoin('users as u1','tareas_asignadas.id_usuario','=','u1.id')
        ->select('tareas.id as id',"tareas.titulo","tareas.titulo","u.name","u1.name as responsable","tareas.estado")
        ->where("tareas.titulo","like","%{$search}%")
        ->orderByRaw('fecha_inicio ASC');
        return $results;
    }
}
