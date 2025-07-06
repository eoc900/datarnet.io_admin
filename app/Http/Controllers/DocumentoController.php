<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocumentoRequest;
use App\Http\Requests\UpdateDocumentoRequest;
use App\Models\Documento;
use App\Models\Tipos_Documentos;
use Illuminate\Http\Request;

class DocumentoController extends Controller
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
        if($request->page != "" && isset($request->page)){
            $page = $request->page;
        }
        if($request->filter != "" && isset($request->filter)){
            $filter = $request->filter;
        }
        

        $maestro = Documento::where("nombre","like",'%' . $searchFor . '%');
        $count = $maestro->count();
        $maestro = $maestro->paginate(1);
        $maestro->appends(["page"=>$page,"search"=>$searchFor]);
        return view('administrador.documentos.index',[
            "title"=>"Documentos",
            "breadcrumb_title" => "Visualizar lista",
            "breadcrumb_second" => "Documentos",
            "hasDynamicTable"=>true,
            "rowCheckbox"=>true,
            "idKeyName"=>"id",
            "keys"=>array('id',"nombre",'descripcion','formato','subido_por'),
            "columns"=>array("ID","Nombre","Descripción","Formato","Cargado por"),
            "rowActions"=>array("show","edit","destroy"),
            "data" => $maestro,
            "routeDestroy" => 'documentos.destroy',
            "routeCreate" => 'documentos.create',
            "routeEdit" => 'documentos.edit',
            "routeShow" => 'documentos.show',
            "routeIndex" => 'documentos.index',
            "ajaxRenderRoute" => '/html/tableDocumentos',
            "reRenderSection" => ".dynamic_table",
            "searchFor"=>$searchFor,
            "count" => $count,
            "filtros_busqueda"=>["Por tipo","Formato"],
            "txtBtnCrear"=>"Cargar nuevo documento"
            
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tipos_documentos = Tipos_Documentos::select("id","nombre")->get();
        $documento = new Documento();
        $estados = $documento->estados;

         return view("administrador.documentos.create",[
            "title"=>"Agregar | Documento",
            "breadcrumb_title" => "Documentos",
            "breadcrumb_second" => "Documentos",
            "tipos_documentos" => $tipos_documentos,
            "estados"=> $estados
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDocumentoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Documento $documento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Documento $documento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDocumentoRequest $request, Documento $documento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Documento $documento)
    {
        //
    }
}
