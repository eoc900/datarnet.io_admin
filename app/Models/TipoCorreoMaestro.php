<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCorreoMaestro extends Model
{
    use HasFactory;
    protected $table = 'tipos_correos_maestros';
    protected $fillable = [
        'tipo_correo',
        'descripcion',
        'creadoPor',
        'activo'
    ];
}
