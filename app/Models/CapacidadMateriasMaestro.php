<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CapacidadMateriasMaestro extends Model
{
    use HasFactory;
    protected $table = "capacidad_materias_maestros";
    protected $fillable = [
        "id_maestro",
        "id_materia",
        "activo",
        "creadoPor"
    ];
}
