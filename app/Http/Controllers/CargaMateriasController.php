<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Alumno;
use App\Models\CargaMateria;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CargaMateriasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         if(Auth::user()->can('Ver materias cargadas')){
        $searchFor = "";
        $filter = "";
        $page = 1;
        if($request->search != "" && isset($request->search)){
            $searchFor = $request->search;
        }
        if($request->filter != "" && isset($request->filter)){
            $filter = $request->filter;
        }
        if($request->page != "" && isset($request->page)){
            $page = $request->page;
        }
              // Query principal
        $registros = DB::table('carga_materias')
            ->join('materias', 'carga_materias.id_materia', '=', 'materias.id')
            ->join('inscripciones', 'carga_materias.id_inscripcion', '=', 'inscripciones.id')
            ->join('alumnos', 'inscripciones.id_alumno', '=', 'alumnos.id')
            ->join('sistemas_academicos', 'alumnos.id_sistema_academico', '=', 'sistemas_academicos.id')
            ->select(
                'carga_materias.id',
                'materias.materia AS nombre_materia',
                'inscripciones.periodo',
                DB::raw("CONCAT(alumnos.nombre, ' ', alumnos.apellido_paterno, ' ', alumnos.apellido_materno) AS nombre_alumno"),
                'alumnos.matricula',
                'sistemas_academicos.nombre AS nombre_sistema',
                'sistemas_academicos.codigo_sistema'
            )
            ->where(function ($query) use ($searchFor) {
                // Agregamos filtros con `LIKE`
                $query->where('materias.materia', 'LIKE', "%{$searchFor}%")
                      ->orWhere('inscripciones.periodo', 'LIKE', "%{$searchFor}%")
                      ->orWhere(DB::raw("CONCAT(alumnos.nombre, ' ', alumnos.apellido_paterno, ' ', alumnos.apellido_materno)"), 'LIKE', "%{$searchFor}%")
                      ->orWhere('alumnos.matricula', 'LIKE', "%{$searchFor}%")
                      ->orWhere('sistemas_academicos.nombre', 'LIKE', "%{$searchFor}%");
            })->orderBy('inscripciones.periodo', 'desc')
            ->orderBy(DB::raw("CONCAT(alumnos.nombre, ' ', alumnos.apellido_paterno, ' ', alumnos.apellido_materno)"), 'asc');
        
        $tipos_contactos = [
            "title"=>"Materias Cargadas",
            "titulo_breadcrumb" => "Materias",
            "subtitulo_breadcrumb" => "Materias Cargadas",
            "go_back_link"=>"#",
            // "formulario"=>"escuelas", // se utiliza para el form tag
            "view"=>"sistema_cobros.tablas.plantilla", //No cambia, se mantiene así
            "urlRoute"=>"carga_materias",
            "confTabla"=>array(
                "tituloTabla"=>"Materias Cargadas",
                "placeholder"=>"Buscar materias cargadas",
                "idSearch"=>"buscarInfoTabla",
                "valueSearch"=>$searchFor,
                "idBotonBuscar"=>"btnBuscarTabla",
                "botonBuscar"=>"Buscar",
                "filtrosBusqueda"=>array(["key"=>"nombre_materia","option"=>"Nombre de la materia"],
                ["key"=>"periodo","option"=>"Periodo"],
                ["key"=>"nombre_alumno","option"=>"Nombre del Alumno"],
                ["key"=>"matricula","option"=>"matricula"],
                ["key"=>"sistema_academico","option"=>"Sistema Académico"]),
                "rowCheckbox"=>true,
                "idKeyName"=>"id",
                "keys"=>array('nombre_materia','periodo','nombre_alumno','matricula','nombre_sistema'),
                "columns"=>array('Materia','Periodo',"Alumno","Matrícula","Sistema Ac."),
                "indicadores"=>false,
                "botones"=>array('0'=>'btn-outline-danger',
                                    '1'=>'btn-outline-success'),
                "rowActions"=>array("show","edit","destroy"),
                "data" => $registros->paginate(25)->appends(["page"=>$page,"search"=>$searchFor,"filter"=>$filter]),
                "routeDestroy" => 'carga_materias.destroy',
                "routeCreate" => ['carga_materias','create'],
                "routeEdit" => 'carga_materias.edit', // referente a un método ListadoFormularios
                "routeShow" => 'carga_materias.show',
                "routeIndex" => 'carga_materias.index',
                "searchFor"=>$searchFor,
                "count" => $registros->count(),
                "txtBtnCrear"=>"Inscripciones"
            )];

            return view('sistema_cobros.carga_materias.index', $tipos_contactos);
        }
        return view('sistema_cobros.respuestas_peticiones.no_tienes_acceso', [
            "title"=>"Sin acceso",
            "titulo_breadcrumb" => "Lo sentimos"
        ]);
            
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $inscripciones = false;
        $alumno = false;
        $materias = false;
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

        return view('sistema_cobros.carga_materias.create',[
            "title"=>"Alta de tipos de correo",
            "titulo_breadcrumb" => "Tipos de Correo",
            "inscripciones"=>$inscripciones,
            "alumno"=>$alumno,
            "materias"=>$materias]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         // Validación de los datos
        $validatedData = $request->validate([
            'id_inscripcion' => 'required|exists:inscripciones,id', // Verifica que el id_inscripcion exista en la tabla inscripciones
            'materias' => 'required|array', // Asegura que materias sea un array
            'materias.*' => 'exists:materias,id', // Verifica que cada materia exista en la tabla materias
            'periodo'=>'string|max:6'
        ]);

        // Obtener el id_inscripcion
        $idInscripcion = $validatedData['id_inscripcion'];

          // Recorrer las materias y crear las instancias
        foreach ($validatedData['materias'] as $idMateria) {
            $cargaMateria = new CargaMateria();
            $cargaMateria->id= (string) Str::uuid(); // Generar un UUID
            $cargaMateria->id_inscripcion = $idInscripcion;
            $cargaMateria->id_materia = $idMateria;
            $cargaMateria->createdBy = Auth::user()->id; // Suponiendo que usas autenticación
            $cargaMateria->save();
        }

        return back()->with("success","Materia registrada al periodo ".$validatedData['periodo']);

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
