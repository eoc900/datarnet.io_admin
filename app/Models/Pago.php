<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;
    protected $table = 'pagos_realizados';
    public $incrementing = false;
    protected $keyType = 'string';

    public $tiposPagos = ["deposito_oxxo","deposito_banco"];
    public $dropdown = [["id"=>"deposito_oxxo","option"=>"Oxxo depósito"],["id"=>"deposito_banco","option"=>"Depósito banco"]];
    protected $fillable = [
        'id',
        'id_cuenta',
        'id_estudiante',
        'createdBy',
        'monto',
        'tipo_pago'
    ];
}
