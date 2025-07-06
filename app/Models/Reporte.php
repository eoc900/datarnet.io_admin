<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    protected $table = "reportes";
    protected $fillable = [
        "nombre",
        "descripcion",
        "creadoPor",
        "activo"
    ];
}
