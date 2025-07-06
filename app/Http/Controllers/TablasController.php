<?php

namespace App\Http\Controllers;

use App\Models\Tablas;
use Illuminate\Http\Request;

class TablasController extends Controller
{
    public function index(Request $request){
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
        return view('sistema_cobros.pages.tabla', Tablas::lista($request->nombre,$searchFor,$filter,$page));
    }

    public function busqueda(Request $request){
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
        return back()->with(Tablas::lista($request->nombre,$searchFor,$filter,$page));
    }
}
