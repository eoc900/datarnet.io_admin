<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CostoConceptoCobro extends Model
{
    use HasFactory;
    protected $table = 'costo_concepto_cobros';
    public $incrementing = false;
    protected $keyType = 'string';
    

     protected $fillable = [
        'id',
        'id_concepto',
        'periodo',
        'costo',
        'creado_por',
        'activo'
    ];

    static public function costos_por_concepto($concepto=""){
        $resultados = DB::table('conceptos_cobros')->select('conceptos_cobros.codigo_concepto','conceptos_cobros.nombre','costo_concepto_cobros.costo','costo_concepto_cobros.periodo')
                    ->join('costo_concepto_cobros','conceptos_cobros.id','=','costo_concepto_cobros.id_concepto')
                    ->where('conceptos_cobros.nombre','like',"%{$concepto}%")
                    ->orWhere('conceptos_cobros.codigo_concepto','like',"%{$concepto}%")
                    ->orWhere('costo_concepto_cobros.periodo','like',"%{$concepto}%")
                    ->get();
            
        if($resultados->count()>0){
            return $resultados;
        }       
        return false;
    }
}
