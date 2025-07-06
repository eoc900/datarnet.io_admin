<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SQLCreator extends Model
{
    protected $table = "sql_creator";
    protected $fillable = [
        "nombre",
        "descripcion",
        "creadoPor",
        "activo"
    ];

}
