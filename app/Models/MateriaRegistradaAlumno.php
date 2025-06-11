<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MateriaRegistradaAlumno extends Model
{
    use HasFactory;
    protected $table = "materias_registradas_alumnos";
    protected $fillable =[
        "id_materia",
        "id_alumno",
        "creadoPor",
        "cuatrimestre"
    ];
}
