<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Materia;
use App\Models\Curricula;

class MateriasRegistradasAlumnosController extends Controller
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
        //
    }

    public function definirRegistroMaterias(string $alumno = "")
    {


        $materias_asociadas = [];
        if($alumno!=""){
                $materias_asociadas = Alumno::where("id", $alumno)
                ->first()
                ?->materiasRegistradas()->pluck('id_materia')->toArray() ?? ""; 
                $alumno = DB::table("alumnos")
                ->select(DB::raw('CONCAT(alumnos.nombre," ",alumnos.apellido_paterno," ",alumnos.apellido_materno) as alumno'),
                'sistemas_academicos.nombre as sistema','sistemas_academicos.codigo_sistema','alumnos.id_sistema_academico as id_sistema')
                ->join('sistemas_academicos','alumnos.id_sistema_academico','=','sistemas_academicos.id')
                ->where("alumnos.id","=", $alumno)
                ->first();
               
        }

        if(!$alumno || $alumno==""){
            return view("sistema_cobros.materias_registradas.definir_materias",
            ["title"=>"Selección materias1 ",
            "alumno"=>$alumno]);
        }

      

        $materias_curricula = DB::table("curriculas")
        ->select("curriculas.id_materia","curriculas.id_sistema","sistemas_academicos.nombre as sistema",
        "materias.cuatrimestre","materias.materia","materias.clave","sistemas_academicos.codigo_sistema")
        ->join('sistemas_academicos','curriculas.id_sistema','=','sistemas_academicos.id')
        ->join('materias','curriculas.id_materia','=','materias.id')
        ->where("curriculas.id_sistema","=",$alumno->id_sistema)
        ->orderBy('materias.cuatrimestre', 'asc')
        ->orderBy('materias.clave', 'asc')
        ->get();

        return view("sistema_cobros.materias_registradas.definir_materias",
        ["title"=>"Lista materias",
        "alumno"=>$alumno,
        "materias_asociadas"=>$materias_asociadas,
        "materias_preparatoria"=>$materias_curricula]);
    }

    public function test(string $alumno = ""){
        return view('sistema_cobros.materias_registradas.create',["title"=>"Hola"]);
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
