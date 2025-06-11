<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LandingPageController extends Controller
{
    public function index(){
        return view('landing_page.index',[
            "titulo"=>"Centro de Estudios",
            "descripcion"=>"Bienvenido a centro de estudios, conoce todos nuestros planteles.",
            "randomString"=>Str::random(12)
        ]);
    }
}
