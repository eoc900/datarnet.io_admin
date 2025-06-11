<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConceptoCobro extends Model
{
    use HasFactory;
    protected $table = 'conceptos_cobros';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'id_escuela',
        'id_categoria',
        'sistema_academico',
        'codigo_concepto',
        'nombre',
        'creado_por',
        'activo'
    ];
}
