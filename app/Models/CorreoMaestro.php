<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorreoMaestro extends Model
{
    use HasFactory;
    protected $table = "correos_maestros";
    protected $fillable = [
        "id_maestro",
        'id_tipo_correo',
        "correo",
        "creadoPor",
        "activo"
    ];
}
