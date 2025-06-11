<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Maestro;
use App\Models\TituloAcademMaestro;

class TestsController extends Controller
{

    public function viewDynamicTable(Request $request){
        $searchFor = "";
        $page = 1;
        if($request->search != "" && isset($request->search)){
            $searchFor = $request->search;
        }
        if($request->page != "" && isset($request->page)){
            $page = $request->page;
        }
        

        $maestro = Maestro::tableMaestro($searchFor);
        $count = $maestro->count();
        $maestro = $maestro->paginate(5);
        $maestro->appends(["page"=>$page,"search"=>$searchFor]);
        return view('tests.dynamic_tables',[
            "title"=>"Testing",
            "breadcrumb_title" => "Títulos académicos",
            "breadcrumb_second" => "Maestros",
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
            "ajaxRenderRoute" => '/html/tableMaestro',
            "reRenderSection" => ".dynamic_table",
            "searchFor"=>$searchFor,
            "count" => $count
            
        ]);

    }

     public function dynamicTableTitulos(Request $request){
        $searchFor = "";
        $page = 1;
        if($request->search != "" && isset($request->search)){
            $searchFor = $request->search;
        }
        if($request->page != "" && isset($request->page)){
            $page = $request->page;
        }
        

        $maestro = Maestro::tableTitulosDeMaestro($searchFor);
        $count = $maestro->count();
        $maestro = $maestro->paginate(5);
        $maestro->appends(["page"=>$page,"search"=>$searchFor]);
        return view('tests.dynamic_tables',[
            "title"=>"Titulos",
            "breadcrumb_title" => "Títulos académicos",
            "breadcrumb_second" => "Maestros",
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
            "ajaxRenderRoute" => '/html/tableTitulos',
            "reRenderSection" => ".dynamic_table",
            "searchFor"=>$searchFor,
            "count" => $count
            
        ]);

    }

        public function mailGun(){


        return view('tests.send_post',[
            "title"=>"Testing",
            "breadcrumb_title" => "Títulos académicos",
            "breadcrumb_second" => "Maestros",
            "hasDynamicTable"=>true,
            "count"=>0,
            "searchFor"=>"",
            "data"=>array(),
            "rowCheckbox"=>true]);
        }
    }

