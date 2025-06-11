<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormCreator extends Model
{
    protected $table = "form_creator";
    protected $fillable = [
        "id",
        "titulo",
        "hidden_identifier",
        "descripcion",
        "action",
        "nombre_documento",
        "creadoPor",
        "activo",
        "es_publico"
    ];
}
