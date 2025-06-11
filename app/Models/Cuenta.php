<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Cuenta extends Model
{
    use HasFactory;
    protected $table = 'cuentas';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'id_alumno',
        'dist_pagos_cuatri',
        'cuatrimestre',
        'activa',
        'condonada',
        'creada_por',
        'modificada_por',
        'vencimiento',
        'fecha_inicio'
    ];

    static public function cuentasAlumno($idAlumno="", $periodo=""){
        $respuesta = DB::table('cuentas')->select('cuentas.id','cuentas.cuatrimestre','cuentas.dist_pagos_cuatri','cuentas.activa',
        'cuentas.vencimiento','cuentas.fecha_inicio',DB::raw('CONCAT(alumnos.nombre," ",alumnos.apellido_paterno," ",alumnos.apellido_materno) as alumno'))
        ->join('alumnos','cuentas.id_alumno','=','alumnos.id')
        ->where('alumnos.id','=',$idAlumno)
        ->where('cuentas.cuatrimestre','LIKE',"%{$periodo}%")
        ->get();
        if($respuesta->count()>0){
            return $respuesta;
        }
        return false;
    }

    public function datosParaGenerarDocumento($id_cuenta=""){
        Carbon::setLocale('es'); // Configura el idioma a español
        $datos = [];
        if(isset($id_cuenta) && $id_cuenta!=""){
       
            $infoCuenta = DB::table('cuentas')
            ->select('cuentas.dist_pagos_cuatri as qty_pagos',
            'cuentas.cuatrimestre','cuentas.fecha_inicio',
            'cuentas.vencimiento','alumnos.nombre as nombre_alumno', 'alumnos.apellido_paterno','alumnos.apellido_materno',
            'alumnos.matricula',
            'sistemas_academicos.codigo_sistema','sistemas_academicos.nombre as sistema','escuelas.codigo_postal','escuelas.imagen_logo',
            'escuelas.nombre as escuela','escuelas.calle','escuelas.colonia','escuelas.num_exterior','escuelas.ciudad','escuelas.estado')
            ->join('alumnos','cuentas.id_alumno','=','alumnos.id')
            ->join('sistemas_academicos','alumnos.id_sistema_academico','=','sistemas_academicos.id')
            ->join('escuelas','sistemas_academicos.id_escuela','=','escuelas.id')
            ->where('cuentas.id','=',$id_cuenta)
            ->get();

    
            $infoPagosPendientes = DB::table('desglose_cuentas')
            ->select(
            'desglose_cuentas.monto',
            'desglose_cuentas.num_cargo',
            'desglose_cuentas.fecha_inicio',
            'desglose_cuentas.fecha_finaliza',
            'costo_concepto_cobros.costo',
            'conceptos_cobros.codigo_concepto',
            DB::raw('IFNULL(descuentos.tasa, 0) as tasa_descuento'),
            DB::raw('IFNULL(descuentos.monto, 0) as monto_descuento'),
            DB::raw('IFNULL(descuentos_aplicados.tipo_descuento, 0) as tipo_descuento')
            )
            ->join('costo_concepto_cobros', 'desglose_cuentas.id_monto', '=', 'costo_concepto_cobros.id')
            ->join('conceptos_cobros', 'costo_concepto_cobros.id_concepto', '=', 'conceptos_cobros.id')
            ->leftJoin('descuentos_aplicados', 'desglose_cuentas.id', '=', 'descuentos_aplicados.id_p_pendiente')
            ->leftJoin('descuentos', 'descuentos_aplicados.id_descuento', '=', 'descuentos.id')
            ->where('desglose_cuentas.id_cuenta','=',$id_cuenta)
            ->get();


            $infoPagosConDescuento = DB::table('desglose_cuentas')
                ->select(
                    DB::raw('SUM(desglose_cuentas.monto) as total_pagos_pendientes'),
                    DB::raw('SUM(
                        CASE 
                            WHEN descuentos_aplicados.tipo_descuento = "fijo" THEN descuentos.tasa * desglose_cuentas.monto
                            WHEN descuentos_aplicados.tipo_descuento = "porcentaje" THEN descuentos.monto
                            ELSE 0
                        END
                    ) as total_descuentos')
                )
                ->join('costo_concepto_cobros', 'desglose_cuentas.id_monto', '=', 'costo_concepto_cobros.id')
                ->join('conceptos_cobros', 'costo_concepto_cobros.id_concepto', '=', 'conceptos_cobros.id')
                ->leftJoin('descuentos_aplicados', 'desglose_cuentas.id', '=', 'descuentos_aplicados.id_p_pendiente')
                ->leftJoin('descuentos', 'descuentos_aplicados.id_descuento', '=', 'descuentos.id')
                ->where('desglose_cuentas.id_cuenta', '=', $id_cuenta)
                ->first();

            $totalPagar = $infoPagosConDescuento->total_pagos_pendientes - $infoPagosConDescuento->total_descuentos;
            $infoPagosRealizados = DB::table('pagos_realizados')->where('pagos_realizados.id_cuenta','=',$id_cuenta)->get();
            $datos = ["info"=>
                                        ["cuenta"=>$infoCuenta,
                                        'totalPagar'=>$totalPagar,
                                        "pagos_pendientes"=>$infoPagosPendientes,
                                        "pagos_realizados"=>$infoPagosRealizados,
                                        "fecha_inicio"=>($infoCuenta->count()>0)?Carbon::parse($infoCuenta[0]->fecha_inicio)->isoFormat('D [de] MMMM'):'',
                                        "vencimiento"=>($infoCuenta->count()>0)?Carbon::parse($infoCuenta[0]->vencimiento)->isoFormat('D [de] MMMM'):'',
                                        "anio"=>($infoCuenta->count()>0)?Carbon::parse($infoCuenta[0]->vencimiento)->isoFormat('YYYY'):'']
            ];
            return $datos;
        }
    }

    
}
