<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HuellaMaestro extends Model
{
    protected $table = "huellas_maestros";
    protected $fillable = [
        "id_maestro",
        "id_huella"
    ];
}
