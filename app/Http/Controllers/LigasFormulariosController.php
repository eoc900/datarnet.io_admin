<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LigaFormulario;
use App\Models\FormCreator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LigasFormulariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
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
        $registros = DB::table('ligas_formularios')
        ->select('ligas_formularios.id','ligas_formularios.slug',
        'ligas_formularios.fecha_apertura','ligas_formularios.fecha_cierre','ligas_formularios.activa',
        'form_creator.titulo')
        ->join('form_creator','ligas_formularios.formulario_id','=','form_creator.id')
        ->where('ligas_formularios.slug', 'like', "%{$searchFor}%")
        ->orWhere('form_creator.titulo', 'like', "%{$searchFor}%")
        ->orWhere('ligas_formularios.id', '=', $searchFor);
       
        
        $ligas = [
            "title"=>"Ligas para formulario",
            "titulo_breadcrumb" => "Ligas para formulario",
            "subtitulo_breadcrumb" => "Ligas para formulario",
            "go_back_link"=>"#",
            // "formulario"=>"escuelas", // se utiliza para el form tag
            "view"=>"sistema_cobros.tablas.plantilla", //No cambia, se mantiene así
            "urlRoute"=>"/ligas_formulario",
            "confTabla"=>array( // Variables de la vista
                "tituloTabla"=>"Ligas para formulario",
                "placeholder"=>"Buscar form_creator",
                "idSearch"=>"buscarInfoTabla",
                "valueSearch"=>$searchFor,
                "idBotonBuscar"=>"btnBuscarTabla",
                "botonBuscar"=>"Buscar",
                "filtrosBusqueda"=>array(["key"=>"slug","option"=>"Buscar slug"],["key"=>"formulario","option"=>"Título de formulario"]),
                "rowCheckbox"=>true,
                "idKeyName"=>"id",
                "keys"=>array('slug','titulo','fecha_apertura','fecha_cierre','activa'),
                "columns"=>array('Slug','Formulario','Apertura','Cierre',"Activa"),
                "indicadores"=>true,
                "botones"=>array('0'=>'btn-outline-danger',
                                    '1'=>'btn-outline-success'),
                "rowActions"=>array("show","edit","destroy"),
                "data" => $registros->paginate(10)->appends(["page"=>$page,"search"=>$searchFor,"filter"=>$filter]),
                "routeDestroy" => 'ligas_formulario.destroy',
                "routeCreate" => "ligas_formulario.create",
                "routeEdit" => 'ligas_formulario.edit', // referente a un método ListadoLigas para formulario
                "routeShow" => 'ligas_formulario.show',
                "routeIndex" => 'ligas_formulario.index',
                "searchFor"=>$searchFor,
                "count" => $registros->count(),
                "txtBtnCrear"=>"Ligas para formulario",
                "qr_code_url"=>'generar.qr'
            )];

            return view('sistema_cobros.form_creator_ligas.index',$ligas);
        }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("sistema_cobros.form_creator_ligas.create",[
            "title"=>"Crear un enlace"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "formulario_id"=>'required|exists:form_creator,id',
            "slug"=>'required|string|max:255',
            "fecha_apertura"=>'nullable|date',
            "fecha_cierre"=>'nullable|date',
            "activa"=>'nullable|boolean',
            "max_respuestas"=>'nullable|integer',
            "requiere_token"=>'nullable|integer',
            "notas_admin"=>'nullable|max:255',
            "redirect_url"=>'nullable|max:255'
        ]);
        
        $liga = new LigaFormulario([
            'formulario_id'=>$request->formulario_id,
            'slug'=>$request->slug,
            'fecha_apertura'=>$request->fecha_apertura??null,
            'fecha_cierre'=>$request->fecha_cierre??null,
            'activa'=>$request->activa??1,
            'max_respuestas'=>$request->max_respuestas??null,
            'requiere_token'=>$request->require_token??0,
            'notas_admin'=>$request->notas_admin??null,
            'redirect_url'=>$request->redirect_url??null
        ]);
        $liga->save();

        return back()->with("success","Se insertó la liga correctamente");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       $resultado = LigaFormulario::where("slug",$id)->first();
       if($resultado){
            $formulario = FormCreator::find($resultado->formulario_id);
            // Construimos la ruta del archivo
            $ruta = 'formularios/' . $formulario->nombre_documento;
            $contenido = Storage::get($ruta);

           
                $jsonDecoded = json_decode($contenido, true);
                $jsonDecoded["title"] = "Lectura formulario";
                $jsonDecoded["nombre_documento"] = $formulario->nombre_documento;

                if($jsonDecoded["publico"]){
                    return redirect('/formulario_publico/'.$id);
                }
                
                foreach($jsonDecoded["inputs"] as $index=>$input){
                    // Queries para dropdowns y select2
                    if($input["type"]=="dropdown"){
                        $resultados = DB::table($input["tabla"])->select($input["value"]." as value",$input["option"]." as option")->get();
                        $jsonDecoded["inputs"][$index]["resultados"] = $resultados;
                    }

                    // Queries para campos de checkbox
                    if($input["type"]=="checkbox" && $input["enlazado"]=="true"){
                        $valores = DB::table($input["tabla"])->pluck($input["valores_tabla"])->toArray();
                        $textos = DB::table($input["tabla"])->pluck($input["textos_tabla"])->toArray();
                        $jsonDecoded["inputs"][$index]["resultados_valores"] = $valores;
                        $jsonDecoded["inputs"][$index]["resultados_textos"] = $textos;
                    }
                }



                
        return view("sistema_cobros.form_creator_ligas.show",$jsonDecoded);
       }
    }

    public function formularioPublico(string $id){
        //dd($id);
            $resultado = LigaFormulario::where("slug",$id)->first();
            
            if($resultado){                
                $formulario = FormCreator::find($resultado->formulario_id);
                $nombre_documento = $formulario->nombre_documento;
                // Asegurar que termina en ".json"
                if (!Str::endsWith($nombre_documento, '.json')) {
                    $nombre_documento .= '.json';
                }
                $ruta = 'formularios/' . $nombre_documento;            
                $contenido = Storage::get($ruta);
                $jsonDecoded = json_decode($contenido, true);
                $jsonDecoded["title"] = "Lectura formulario";
                $jsonDecoded["nombre_documento"] = $formulario->nombre_documento;
                $jsonDecoded["liga"] = $resultado->id;
                $jsonDecoded['ruta_banner'] = $formulario->ruta_banner;

                if($formulario->es_publico || $jsonDecoded["publico"] ){
                    return view("sistema_cobros.form_creator_ligas.formulario_publico",$jsonDecoded);
                }
                     
                return redirect('/form_creator/'.$resultado->formulario_id);
            }
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
