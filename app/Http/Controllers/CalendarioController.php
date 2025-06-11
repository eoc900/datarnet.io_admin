<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tareas;
use Carbon\Carbon;

class CalendarioController extends Controller
{
    public function index(Request $request){
        $mes = Carbon::now()->format('m');
        if($request->mes){
            $mes = $request->mes;
        }
        
        $objeto = Tareas::buscarPorMes($mes);
        $count = $objeto->count();
        return view('administrador.calendario.index',[
            "title"=>"Calendario tareas",
            "breadcrumb_title" => "Calendario general",
            "breadcrumb_second" => "Calendario",
            "data" => $objeto,
            "routeDestroy" => 'tareas.destroy',
            "routeCreate" => 'tareas.create',
            "routeEdit" => 'tareas.edit',
            "routeShow" => 'tareas.show',
            "routeIndex" => 'tareas.index',
            "count" => $count,
            "txtBtnCrear"=>"Agregar nueva tarea"
        ]);
    }
}
