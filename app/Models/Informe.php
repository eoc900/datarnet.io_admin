<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Informe extends Model
{
        protected $table = 'informes';
        protected $fillable = [
            "nombre",
            "descripcion",
            "identificador",
            "creado_por",
            "activo"
        ];
}
