<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Maestro;
use App\Models\Tareas;
use App\Models\Tipos_Documentos;

class HTMLTablesController extends Controller
{
    // This class is meant for retrieving ajax requests
    public function tableMaestro(Request $request){

        $search = "";
        if($request->search){
            $search = $request->search;
        }
         if($request->page){
            $page = $request->page;
        }

        $maestro = Maestro::tableMaestro($search);
        $count = $maestro->count();
        $maestro = $maestro->paginate(5);
        $maestro->appends(["page"=>$page,"search"=>$search]);
        $maestro->withPath('/tests/maestro_dynamic_table');

        return view('general.tables.simple_table',[
            "title"=>"Testing",
            "hasDynamicTable"=>true,
            "rowCheckbox"=>true,
            "idKeyName"=>"id",
            "keys"=>array("id","nombre","apellido_paterno","apellido_materno"),
            "columns"=>array("ID","Nombre","Apellido Paterno","Apellido Materno"),
            "rowActions"=>array("edit","show","destroy"),
            "data" => $maestro,
            "routeDestroy" => 'maestros.destroy',
            "routeEdit" => 'maestros.edit',
            "routeShow" => 'maestros.show',
            "routeIndex" => 'maestros.index',
            "searchFor"=>$search,
            "count"=>$count
        ]);

    }

    // This class is meant for retrieving ajax requests
    public function tableTitulos(Request $request){

        $search = "";
        if($request->search){
            $search = $request->search;
        }
         if($request->page){
            $page = $request->page;
        }

        $maestro = Maestro::tableTitulosDeMaestro($search);
        $count = $maestro->count();
        $maestro = $maestro->paginate(5);
        $maestro->appends(["page"=>$page,"search"=>$search]);
        $maestro->withPath('/tests/titulos_maestros');

        return view('general.tables.simple_table',[
            "hasDynamicTable"=>true,
            "rowCheckbox"=>true,
            "idKeyName"=>"id_titulo",
            "keys"=>array('id_titulo',"maestro",'grado_academico','nombre_titulo','nombre_universidad'),
            "columns"=>array("ID","Maestro","Grado","Titulo","Universidad"),
            "rowActions"=>array("edit","show","destroy"),
            "data" => $maestro,
            "routeDestroy" => 'titulos_academicos.destroy',
            "routeEdit" => 'titulos_academicos.edit',
            "routeShow" => 'titulos_academicos.show',
            "routeIndex" => 'titulos_academicos.index',
            "searchFor"=>$search,
            "count"=>$count
        ]);

    }

      // This class is meant for retrieving ajax requests
    public function tableTiposDocumentos(Request $request){

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
        $maestro->withPath('/tipos_documentos');

        return view('general.tables.simple_table',[
            "hasDynamicTable"=>true,
            "rowCheckbox"=>true,
            "idKeyName"=>"id",
            "keys"=>array('id',"nombre",'descripcion','formato','ruta_almacenamiento'),
            "columns"=>array("ID","Nombre","Descripción","Formato","Ruta"),
            "rowActions"=>array("edit","show","destroy"),
            "data" => $maestro,
            "routeDestroy" => 'tipos_documentos.destroy',
            "routeEdit" => 'tipos_documentos.edit',
            "routeShow" => 'tipos_documentos.show',
            "routeIndex" => 'tipos_documentos.index',
            "searchFor"=>$searchFor,
            "count"=>$count
        ]);

    }


        public function tableTareas(Request $request){

        $searchFor = "";
        $filter = "";
        $page = 1;
        if($request->search != "" && isset($request->search)){
            $searchFor = $request->search;
        }
        if($request->page != "" && isset($request->page)){
            $page = $request->page;
        }

        $datos = Tareas::busquedaPorResponsable($searchFor);
        //Filtros
        if($request->filter != "" && isset($request->filter)){
            $filter = $request->filter;
            if($filter=="nombre responsable"){
                 $datos = Tareas::busquedaPorResponsable($searchFor);
            }
            if($filter=="estado"){
                 $datos = Tareas::busquedaPorEstado($searchFor);
            }
            if($filter=="titulo"){
                 $datos = Tareas::busquedaPorTitulo($searchFor);
            }
        }
        
       

       
        $count = $datos->count();
        $datos = $datos->paginate(10);
        $datos->appends(["page"=>$page,"search"=>$searchFor,"filter"=>$filter]);
        $datos->withPath('/tareas');

        return view('general.tables.simple_table',[
            "rowCheckbox"=>true,
            "idKeyName"=>"id",
            "keys"=>array('id',"titulo",'name',"responsable","estado"),
            "columns"=>array("#Ref","Titulo","Creada Por","Asignada","Estado"),
            "indicadores"=>true,
            "botones"=>array('Pendiente'=>'btn-outline-danger',
                                'En Progreso'=>'btn-outline-primary',
                                'Completada'=>'btn-outline-success',
                                'Aprobada'=>'btn-outline-info',
                                'Reformular'=>'btn-outline-warning'),
            "rowActions"=>array("show","edit","destroy"),
            "data" => $datos,
            "routeDestroy" => 'tareas.destroy',
            "routeCreate" => 'tareas.create',
            "routeEdit" => 'tareas.edit',
            "routeShow" => 'tareas.show',
            "routeIndex" => 'tareas.index',
            "ajaxRenderRoute" => '/html/tabletareas',
            "reRenderSection" => ".dynamic_table",
            "searchFor"=>$searchFor,
            "count" => $count,
            "filtros_busqueda"=>["Nombre responsable","Titulo","Estado"],
            "txtBtnCrear"=>"Agregar una tarea"
        ]);

    }
}
