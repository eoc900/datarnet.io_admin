<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Email;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\DB;





class EmailController extends Controller
{
    public function testView(){
      
        
         return view('general.emails.test',[
            "title"=>"Email",
            "breadcrumb_title" => "Email",
            "breadcrumb_second" => "Prueba de correo"
        ]);
   
    }

     public function testSend(Request $request){
        
        if(Auth::user()->user_type=="Admin"){
            $email = new Email();
            $mensajeNoHtml = "Hola hay un nuevo registro";
            $mail = $email->sendEmail("Nuevo usuario registrado",'<h1>Un nuevo formulario</h1><p>Recibimos un nuevo registro</p>',$mensajeNoHtml,"eoc900@gmail.com","Eugenio Ortiz C.");
            $nombre = $request->nombre;
            $telefono = $request->telefono;
            $email = $request->email;
            $descripcion = $request->descripcion;
           
            if($mail){
                return back()->with('success', 'se envió un correo, verificar en tu bandeja de entrada.');  
            }
               
            return back()->with('error', 'Hubo un error, no se pudo enviar el correo');  

        }
    }

    public function bienvenida(Request $request){
        $alumno = DB::table('alumnos')
        ->select('correos_asociados.correo','alumnos.nombre','alumnos.apellido_paterno','sistemas_academicos.nombre as sistema')
        ->join('correos_asociados','alumnos.id','=','correos_asociados.id_alumno')
        ->join('sistemas_academicos','alumnos.id_sistema_academico','=','sistemas_academicos.id')
        ->where('alumnos.id','=',$request->alumno)
        ->first();
        if(Auth::user()->hasRole(["Admin","Developer"])){
        return 'Se detectó la petición para correo de bienvenida para '.$alumno->nombre.' con correo: '.$alumno->correo.' al sistema: '.$alumno->sistema;
        }
        return 'Lo sentimos no podemos ejecutar tu petición.';
    }

}
