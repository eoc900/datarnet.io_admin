<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCorreo extends Model
{
    use HasFactory;
    protected $table = 'tipos_correos_alumnos';
    protected $fillable = [
        'tipo_correo',
        'descripcion',
        'activo'
    ];
}
