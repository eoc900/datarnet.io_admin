<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TablaModulo extends Model
{
    use HasFactory;
    protected $table = "tablas_modulos";
    protected $fillable = [
        "nombre_tabla",
        "qty_columnas",
        "creadoPor",
        "activo"
    ];
    protected $hidden = ['created_at', 'updated_at'];
}
