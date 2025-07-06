<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarpetaUsuario extends Model
{
    use HasFactory;
    protected $table = "carpetas_usuarios";
    protected $fillable = [
        "nombre_ruta",
        "propietario",
        "visible",
        "activo",
        "creadoPor"
    ];
}
