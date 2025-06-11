<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirectorioRoot extends Model
{
    use HasFactory;
    protected $table = "directorios_root";
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        "id",
        "nombre_directorio",
        "propietario",
        "creadoPor",
        "activo"
    ];
}
