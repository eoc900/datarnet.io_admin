<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\DashboardsGraphs;

class DashboardsController extends Controller
{
    
    public function index(){
        return view("general.pre_made.pages.guest_dashboard",[
            "title"=>"Administrar | Maestros"

        ]);
    }

    public function create(){
        return view("sistema_cobros.dashboard.create",["title"=>"Crear un dashboard"]);
    }

    public function store(){

    }
    public function edit(){
        
    }
    public function update(){
        
    }
    public function destroy(){
        
    }
}
