<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\DashboardsGraphs;
use Illuminate\Support\Facades\Auth;

class DashboardsController extends Controller
{
    
    public function index(){
        $user = Auth::user()->name;
        return view("general.pre_made.pages.guest_dashboard",[
            "title"=>"Bienvenido ".$user

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
