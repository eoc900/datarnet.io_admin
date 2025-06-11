<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Models\Cuenta;
use App\Helpers\Email;
use Carbon\Carbon;

class PdfController extends Controller
{
    public function downloadInfo(){
        $pdf = Pdf::loadView('pdfs.test', ["titulo"=>"Blog Centro de Estudios",
            "descripcion"=>"Contenido especializado para estudiantes",
            "blog"=>true]);
        return $pdf->download('archivo.pdf');
    }
    public function verPDF(){
        Carbon::setLocale('es'); // Configura el idioma a español
        return view('pdfs.test');
    }

    public function vistaGenerarCuenta(Request $request){

        return view('pdfs.generar_cuenta',["info"=>"",
                        "title"=>"Registrar un cargo.",
                        "titulo_breadcrumb" => "Cargos",
                        "subtitulo_breadcrumb" => "Crear un nuevo cargo",
                        "go_back_link"=>"#"]);
    }

    public function downloadCuenta(Request $request){
         Carbon::setLocale('es'); // Configura el idioma a español
        
        // if(isset($request->cuenta) && $request->cuenta!=""){
        // $infoCuenta = DB::table('cuentas')
        // ->select('cuentas.dist_pagos_cuatri as qty_pagos',
        // 'cuentas.cuatrimestre','cuentas.fecha_inicio',
        // 'cuentas.vencimiento','alumnos.nombre as nombre_alumno', 'alumnos.apellido_paterno','alumnos.apellido_materno',
        // 'alumnos.matricula',
        // 'sistemas_academicos.codigo_sistema','sistemas_academicos.nombre as sistema','escuelas.codigo_postal','escuelas.imagen_logo',
        // 'escuelas.nombre as escuela','escuelas.calle','escuelas.colonia','escuelas.num_exterior','escuelas.ciudad','escuelas.estado')
        // ->join('alumnos','cuentas.id_alumno','=','alumnos.id')
        // ->join('sistemas_academicos','alumnos.id_sistema_academico','=','sistemas_academicos.id')
        // ->join('escuelas','sistemas_academicos.id_escuela','=','escuelas.id')
        // ->where('cuentas.id','=',$request->cuenta)
        // ->get();
        // }
        $cuenta = new Cuenta();
        $resultados = $cuenta->datosParaGenerarDocumento($request->cuenta);
        $pdf = Pdf::loadView('pdfs.plantilla_cuenta', $resultados);
        //$pdf = Pdf::loadView('pdfs.prueba_contenido', ["resultados"=>$resultados,"id_cuenta"=>$request->cuenta]);
        return $pdf->download('archivo.pdf');
    }

    public function enviarCuentaCorreo(Request $request){
        Carbon::setLocale('es'); // Configura el idioma a español
        $cuenta = new Cuenta();
        $resultados = $cuenta->datosParaGenerarDocumento($request->cuenta);
        $pdf = Pdf::loadView('pdfs.plantilla_cuenta', $resultados)->output();
        //$pdf = Pdf::loadView('pdfs.prueba_contenido', ["resultados"=>$resultados,"id_cuenta"=>$request->cuenta]);
        $html = "<p>Gracias por estudiar con nosotros</p>";
        $correo = new Email();
        $enviar = $correo->enviarDocumentoPdf("Haz recibido tu cuenta",$html,"Hola usuario","eoc900@gmail.com","Eugenio",$pdf);
        if($enviar){
            return back()->with("success","Se envío el correo exitosamente");
        }
    }

}
