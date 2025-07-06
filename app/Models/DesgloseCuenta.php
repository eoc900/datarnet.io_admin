<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class DesgloseCuenta extends Model
{
    use HasFactory;
    protected $table = 'desglose_cuentas';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id',
        'id_cuenta',
        'num_cargo',
        'id_monto',
        'monto',
        'diferido',
        'fecha_inicio',
        'fecha_finaliza',
        'createdBy'
    ];


    // Para generar los cargos de colegiatura cuando se crea una cuenta.
    static function generarCargosColegiatura($idCuenta, $idMonto, $numCargos,$monto,$periodo, $createdBy) {
        // Definir el inicio del cuatrimestre basado en el periodo
        $año = substr($periodo, 0, 4);  // Los primeros 4 caracteres son el año
        $cuatrimestre = substr($periodo, 4, 1);  // El último carácter es el cuatrimestre

        switch ($cuatrimestre) {
            case '1': // Enero-Abril
                $fechaInicioPeriodo = Carbon::create($año, 1, 1); 
                break;
            case '2': // Mayo-Agosto
                $fechaInicioPeriodo = Carbon::create($año, 5, 1);
                break;
            case '3': // Septiembre-Diciembre
                $fechaInicioPeriodo = Carbon::create($año, 9, 1);
                break;
            default:
                throw new Exception("Periodo inválido");
        }

        $cargos = [];

        for ($i = 0; $i < $numCargos; $i++) {
            $fechaInicio = $fechaInicioPeriodo->copy()->addWeeks($i);
            $fechaFinaliza = $fechaInicio->copy()->addDays(6);  // Cada cargo dura 1 semana

            $cargos[] = [
                'id' => (string) Str::uuid(),
                'id_cuenta' => $idCuenta,
                'num_cargo' => $i + 1,
                'id_monto' => $idMonto,
                'monto' => $monto, // Asumido 0, ajusta según necesidad
                'diferido' => 1, // Asumido 0, ajusta según necesidad
                'fecha_inicio' => $fechaInicio->toDateString(),
                'fecha_finaliza' => $fechaFinaliza->toDateString(),
                'createdBy' => $createdBy,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insertar en la tabla desglose_cuenta
        DB::table('desglose_cuentas')->insert($cargos);

        return true;
    }
}
