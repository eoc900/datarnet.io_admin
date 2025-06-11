<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\HorarioDisponibilidadMaestro;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Maestro;

class HorariosMaestrosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function buscarMaestro(){
        return view('sistema_cobros.horarios_maestros.buscar_maestro',["title"=>"Buscar horario de maestro"]);
    }


    public function disponibilidad(Request $request){
        // $validated = $request->validate([
        //         'maestro' => 'required|id|exists:maestros,id',
        // ]);

        $horarios = DB::table("horarios_disponibilidad_maestros")
        ->select("id","marcar_como","hora_inicio","hora_finaliza")
        ->where("id_maestro","=",$request->maestro)
        ->get();

        $maestro = Maestro::find($request->maestro);

        if($maestro){
            return view('sistema_cobros.horarios_maestros.asignar_disponibilidad',["title"=>"calendario","data"=>$horarios,"maestro"=>$request->maestro,"info"=>$maestro]);
        }
        return view('sistema_cobros.horarios_maestros.asignar_disponibilidad',["title"=>"No encontrado","data"=>$horarios,"maestro"=>$request->maestro,"info"=>$maestro]);
        
    }

    public function storeDisponibilidad(Request $request){
        $request->validate([
            'inicio' => 'required|date_format:Y-m-d\TH:i:s',
            'fin' => 'required|date_format:Y-m-d\TH:i:s',
            'maestro'=>'required|exists:maestros,id'
        ]);

        $f1 = str_replace("T"," ",$request->inicio);
        $f2 = str_replace("T"," ",$request->fin);
       
        $idMaestro = $request->maestro;
        $horaInicio = Carbon::createFromFormat('Y-m-d H:i:s', $f1, 'UTC')
        ->setTimezone('America/Mexico_City')
        ->format('Y-m-d H:i:s');
        $horaFinaliza = Carbon::createFromFormat('Y-m-d H:i:s', $f2, 'UTC')
        ->setTimezone('America/Mexico_City')
        ->format('Y-m-d H:i:s');
        // Paso 1: Verificar solapamientos
        $horariosSolapados = DB::table('horarios_disponibilidad_maestros')
        ->where('id_maestro', $idMaestro)
        ->where(function ($query) use ($horaInicio, $horaFinaliza) {
            $query->whereBetween('hora_inicio', [$horaInicio, $horaFinaliza])
                  ->orWhereBetween('hora_finaliza', [$horaInicio, $horaFinaliza])
                  ->orWhere(function ($query) use ($horaInicio, $horaFinaliza) {
                      $query->where('hora_inicio', '<', $horaInicio)
                            ->where('hora_finaliza', '>', $horaFinaliza);
                  });
        })
        ->get();

        // Paso 2: Eliminar horarios solapados (si existen)
        if ($horariosSolapados->isNotEmpty()) {
            DB::table('horarios_disponibilidad_maestros')
                ->where('id_maestro', $idMaestro)
                ->where(function ($query) use ($horaInicio, $horaFinaliza) {
                    $query->whereBetween('hora_inicio', [$horaInicio, $horaFinaliza])
                        ->orWhereBetween('hora_finaliza', [$horaInicio, $horaFinaliza])
                        ->orWhere(function ($query) use ($horaInicio, $horaFinaliza) {
                            $query->where('hora_inicio', '<', $horaInicio)
                                    ->where('hora_finaliza', '>', $horaFinaliza);
                        });
                })
                ->delete();
        }
        
        $modelo = new HorarioDisponibilidadMaestro();
        $modelo->hora_inicio = $horaInicio; // Carbon se encargará de formatear correctamente
        $modelo->hora_finaliza = $horaFinaliza; // Carbon se encargará de formatear correctamente
        $modelo->id_maestro = $request->maestro; // Carbon se encargará de formatear correctamente
        $modelo->marcar_como = "Disponible";
        $modelo->creado_por = (string) Str::uuid(); // Carbon se encargará de formatear correctamente
       
        $modelo->save();

        return response()->json([
            'inicio' => $request->inicio,
            'fin' => $request->fin,
            'respuesta'=>'<div class="alert alert-success">Horario de maestro elegido exitosamente</div>.'
        ]);
    }

    public function eliminarHoraDisponible(Request $request){
                $record = HorarioDisponibilidadMaestro::find($request->id_hora);
            if($record){
                $record->delete();
                 return response()->json([
                    'respuesta'=>'<div class="alert alert-success">Horario de maestro elegido exitosamente</div>.'
                ]);
            }
        return response()->json([
            'respuesta'=>'<div class="alert alert-success">Horario de maestro elegido exitosamente</div>.'
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
