<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTipos_DocumentosRequest;
use App\Http\Requests\UpdateTipos_DocumentosRequest;
use App\Models\Tipos_Documentos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TiposDocumentosController extends Controller
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
        

        $maestro = Tipos_Documentos::where("nombre","like",'%' . $searchFor . '%');
        $count = $maestro->count();
        $maestro = $maestro->paginate(1);
        $maestro->appends(["page"=>$page,"search"=>$searchFor]);
        return view('administrador.tipos_documentos.index',[
            "title"=>"Documentos",
            "breadcrumb_title" => "Tipos Documentos",
            "breadcrumb_second" => "Documentos",
            "hasDynamicTable"=>true,
            "rowCheckbox"=>true,
            "idKeyName"=>"id",
            "keys"=>array('id',"nombre",'descripcion','formato','ruta_almacenamiento'),
            "columns"=>array("ID","Nombre","Descripción","Formato","Ruta"),
            "rowActions"=>array("edit","destroy"),
            "data" => $maestro,
            "routeDestroy" => 'tipos_documentos.destroy',
            "routeCreate" => 'tipos_documentos.create',
            "routeEdit" => 'tipos_documentos.edit',
            "routeShow" => 'tipos_documentos.show',
            "routeIndex" => 'tipos_documentos.index',
            "ajaxRenderRoute" => '/html/tableTiposDocumentos',
            "reRenderSection" => ".dynamic_table",
            "searchFor"=>$searchFor,
            "count" => $count,
            "filtros_busqueda"=>["Nombre","Formato"],
            "txtBtnCrear"=>"Crear tipo de documento"
            
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("administrador.tipos_documentos.create",[
            "title"=>"Agregar | Tipo Documento",
            "breadcrumb_title" => "Tipos Documentos",
            "breadcrumb_second" => "Documentos"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTipos_DocumentosRequest $request)
    {
        $tipoDocumento = new Tipos_Documentos();
        $tipoDocumento->nombre = $request->nombre;
        $tipoDocumento->descripcion = $request->descripcion;
        $tipoDocumento->ruta_almacenamiento = $request->ruta_almacenamiento;
        $tipoDocumento->creado_por = Auth::user()->name; // Asumiendo que tienes autenticación y quieres guardar el nombre del usuario
        $tipoDocumento->actualizado_por = Auth::user()->name; // Asumiendo que tienes autenticación y quieres guardar el nombre del usuario

        // Guardar el registro en la base de datos
        $tipoDocumento->save();
        return redirect()->route('tipos_documentos.index')->with('success', 'Tipo de documento creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tipos_Documentos $tipos_Documentos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $maestro = Tipos_Documentos::where('id', '=', $id)->firstOrFail(); 
        return view('administrador.tipos_documentos.edit',[
            "title"=>"Editar | Tipo Documento",
            "breadcrumb_title" => "Tipos Documentos",
            "breadcrumb_second" => "Documentos",
            "data"=>$maestro
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTipos_DocumentosRequest $request, $id)
    {
        $maestro = Tipos_Documentos::findOrFail($id);
        $maestro->update([
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
            'ruta_almacenamiento' => $request->input('ruta_almacenamiento'),
            'updated_at' => now(),
            'actualizado_por' => Auth::user()->name
            
        ]);
         return back()->with('success', 'Datos personales del maestro fueron actualizados.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
           $record = Tipos_Documentos::find($id);
        if($record){
            $record->delete();
            return back()->with('success', 'Registro de maestro eliminado exitosamente.');
        }
        return back()->with('error', 'Hubo un error al tratar de borrar registro');
    }
}
