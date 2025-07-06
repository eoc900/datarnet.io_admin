<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColumnaTabla extends Model
{
    use HasFactory;
    protected $table = "columnas_tablas";
    protected $fillable = [
        //"id_columna",
        "nombre_columna",
        "id_tabla",
        "tipo_dato",
        "activo",
        "qty_caracteres",
        "es_llave_primaria",
        "nullable",
        "es_foranea",
        "on_table",
        "on_column",
        "unica"
    ];
}
