<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cobro extends Model
{
    /*
        $table->uuid('id')->primary();
        $table->foreignUuid('id_costo_concepto');
        $table->foreignUuid('id_cuenta');
        $table->integer('grado')->nullable();
        $table->integer('periodo');
        $table->enum('estado',Cobro::mostrarEstados());
        $table->foreignUuid("creado_por");
        $table->foreignUuid("modificado_por");
        $table->timestamp('pagado')->nullable();
        $table->timestamps();
    */

    use HasFactory;
    protected $table = 'cobros';
    public $incrementing = false;
    protected $keyType = 'string';
    public static $estados = ['pendiente','pagado','congelado']; 
    public static $estadosDropdown = [["id"=>'pendiente',"option"=>"Pendiente"],
                                    ["id"=>'pagado',"option"=>"Pagado"],
                                    ["id"=>'congelado',"option"=>"Congelado"]
                                ]; 
    public static function mostrarEstados() {
        return self::$estados;
    }
    public static function mostrarEstadosDropdown() {
        return self::$estadosDropdown;
    }

    protected $fillable = [
        'id',
        'id_costo_concepto',
        'id_cuenta',
        'grado',
        'periodo',
        'estado',
        'creado_por',
        'modificado_por',
        'fecha_inicio',
        'fecha_fin'
    ];

    static public function cobrosRelacionadosCuenta($idCuenta=""){ 
        // ---->Nota: esto es para el html ajax, necesitaríamos aplicar el método get() si no es para eso dada nuestra configuración
        // en AjaxHtmlController;
       $results= DB::table('cobros')->select('conceptos_cobros.codigo_concepto','cobros.id','cobros.estado',
        'cobros.fecha_inicio','cobros.fecha_fin','costo_concepto_cobros.costo')
        ->join('costo_concepto_cobros','cobros.id_costo_concepto','=','costo_concepto_cobros.id')
        ->join('conceptos_cobros','costo_concepto_cobros.id_concepto','=','conceptos_cobros.id')
        ->where('cobros.id_cuenta','=',$idCuenta);
     
        return $results;
    }
   

}
