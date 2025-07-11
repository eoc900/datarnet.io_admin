<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    protected $table = "archivos";
    protected $fillable = [
        "id",
        "nombre_archivo",
        "tamano",
        "formato",
        "carpeta",
        "creadoPor",
    ];
}
