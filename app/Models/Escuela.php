<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Escuela extends Model
{
    use HasFactory;
    protected $table = 'escuelas';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'imagen_logo',
        'codigo_escuela',
        'nombre',
        'calle',
        'colonia',
        'codigo_postal',
        'num_exterior',
        'ciudad',
        'estado',
        'creada_por',
        'activo'
    ];
}
