<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConceptoCobro;
use App\Models\ListadoFormularios;
use App\Models\Code;
use App\Helpers\Mensajes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConceptosCobrosController extends Controller
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
          // view:
        $concepto = ConceptoCobro::select("conceptos_cobros.codigo_concepto","conceptos_cobros.nombre as concepto",DB::raw("CONCAT(escuelas.codigo_escuela, '-', conceptos_cobros.codigo_concepto) AS identificador"))
        ->leftJoin('escuelas','conceptos_cobros.id_escuela',"=","escuelas.id")
        ->firstOrFail();
        $costos_asociados = DB::table('costo_concepto_cobros')
        ->select("costo_concepto_cobros.periodo","conceptos_cobros.codigo_concepto","conceptos_cobros.nombre as concepto",
        "costo_concepto_cobros.costo", DB::raw("CONCAT(escuelas.codigo_escuela, '-', conceptos_cobros.codigo_concepto) AS identificador"))
        ->leftJoin('conceptos_cobros','costo_concepto_cobros.id_concepto','=','conceptos_cobros.id')
        ->leftJoin('escuelas','conceptos_cobros.id_escuela',"=","escuelas.id")
        ->where('conceptos_cobros.id','=',$id)
        ->get();
        

        return view('administrador.conceptos_cobros.dashboard',[
            'title'=>"Conceptos",
            'subtitulo_breadcrumb'=>"",
            'titulo_breadcrumb'=>"",
            "datos"=>[
            "concepto"=>$concepto,
            "costos_asociados"=>$costos_asociados,
            "conteo_costos"=>$costos_asociados->count()
        ]]);
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
        $mensajes = new Mensajes(); // registro de respuestas add(["mensaje"=>"Almacenamiento de acta de nacimiento exitosa","respuesta"=>true])
        $concepto = ConceptoCobro::findOrFail($id);     
        $concepto->update([
                'id_escuela'=>$request->id_escuela,
                'codigo_concepto'=>$request->codigo_concepto,
                'nombre' => $request->nombre,
                'activo' => $request->activo,
                'sistema_academico'=>$request->sistema_academico,
                'id_categoria'=>$request->categoria_cobro
        ]);
       $mensajes->add(array("response"=>true,"message"=>"Se editó el concepto exitosamente"));
       return back()->with('mensajes',$mensajes->log);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $record = ConceptoCobro::find($id);
        if($record){
            $record->delete();
            return back()->with('success', 'Concepto de cobro eliminado con éxito.');
        }
        return back()->with('error', 'Hubo un error al tratar de borrar registro');
    }
}
