<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnvioConfirmacion extends Model
{
    use HasFactory;
    protected $table = 'envios_confirmaciones';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id',
        'id_alumno',
        'entregado',
        'confirmado',
        'verificado_presencial',
        'codigo_36'
    ];
}
