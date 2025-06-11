<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\SistemaAcademico;

class CurriculasController extends Controller
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
    public function asociarMaterias(string $sistema="")
    {
 
        $materias_asociadas = [];
        if($sistema!=""){
                $materias_asociadas = SistemaAcademico::where("id", $sistema)
                ->first()
                ?->capacidadMaterias()->pluck('id_materia')->toArray() ?? ""; 
                $sistema = SistemaAcademico::where("id", $sistema)->first();
               
        }

        $materias_preparatoria = DB::table("materias")
        ->select("materias.id","materias.clave","materias.materia","materias.creditos","materias.cuatrimestre")
        ->get();

        return view("sistema_cobros.sistemas_academicos.definir_materias",
        ["title"=>"Lista materias",
        "sistema"=>$sistema,
        "materias_asociadas"=>$materias_asociadas,
        "materias_preparatoria"=>$materias_preparatoria]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "id_sistema"=>"uuid|required|exists:sistemas_academicos,id",
            'materia' => 'required|array',
            'materia.*' => 'required|string|max:36|exists:materias,id',
        ]);
        
        $materiasNuevas = $request->input('materia', []);
        // Obtener las materias actuales del maestro
        $materiasActuales = DB::table('curriculas')
            ->where('id_sistema', $request->id_sistema)
            ->pluck('id_materia')
            ->toArray();
        
         // Determinar materias a insertar
        $materiasAInsertar = array_diff($materiasNuevas, $materiasActuales);

        // Determinar materias a eliminar
        $materiasAEliminar = array_diff($materiasActuales, $materiasNuevas);

         // Insertar las materias faltantes
        foreach ($materiasAInsertar as $materia) {
            DB::table('curriculas')->insert([
                'id_sistema' => $request->id_sistema,
                'id_materia' => $materia,
                'activo'=>1,
                'creadoPor'=> Auth::user()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }


        // Eliminar las materias sobrantes
        if (!empty($materiasAEliminar)) {
            DB::table('curriculas')
                ->where('id_sistema', $request->id_sistema)
                ->whereIn('id_materia', $materiasAEliminar)
                ->delete();
        }

         

        return back()->with("Success","Se actualizaron las materias");
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
