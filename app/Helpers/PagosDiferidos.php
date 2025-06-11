<?php

namespace App\Helpers;
use Carbon\Carbon;

class PagosDiferidos{
    

static public function getCuatrimestreFechas(int $year, int $cuatrimestre, bool $completa = true)
{
        $fechaInicio = null;
        $fechaFin = null;

        switch ($cuatrimestre) {
            case 1:
                $fechaInicio = Carbon::create($year, 1, 1, 0, 0, 0);
                $fechaFin = Carbon::create($year, 4, 30, 23, 59, 59);
                break;
            case 2:
                $fechaInicio = Carbon::create($year, 5, 1, 0, 0, 0);
                $fechaFin = Carbon::create($year, 8, 31, 23, 59, 59);
                break;
            case 3:
                $fechaInicio = Carbon::create($year, 9, 1, 0, 0, 0);
                $fechaFin = Carbon::create($year, 12, 31, 23, 59, 59);
                break;
            default:
                throw new InvalidArgumentException('El cuatrimestre debe ser un valor entre 1 y 3.');
        }

    if($completa){
         return [
            'fecha_inicio' => date('Y-m-d H:i:s',$fechaInicio->timestamp),
            'fecha_fin' => date('Y-m-d H:i:s',$fechaFin->timestamp)
        ];
    }
    if(!$completa){
         return [
            'fecha_inicio' => date('Y-m-d',$fechaInicio->timestamp),
            'fecha_fin' => date('Y-m-d',$fechaFin->timestamp)
        ];
    }
   
}

static public function periodoActual(){
    $year = date('Y');
    $month = date('m');
    $cuatrimestre = 1;
    if(in_array($month,[1,2,3,4])){
        $cuatrimestre = 1;
    }
    if(in_array($month,[5,6,7,8])){
        $cuatrimestre = 2;
    }
    if(in_array($month,[9,10,11,12])){
        $cuatrimestre = 3;
    }
    return $year."".$cuatrimestre;
}

static public function cuatrimestreActual(){
    $month = date('m');
    $cuatrimestre = 1;
    if(in_array($month,[1,2,3,4])){
        $cuatrimestre = 1;
    }
    if(in_array($month,[5,6,7,8])){
        $cuatrimestre = 2;
    }
    if(in_array($month,[9,10,11,12])){
        $cuatrimestre = 3;
    }
    return $cuatrimestre;
}

}