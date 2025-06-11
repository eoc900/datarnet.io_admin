<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargaMateria extends Model
{
    use HasFactory;
    protected $table = 'carga_materias';
    public $incrementing = false;
    protected $keyType = 'string';

    public static $cargaNormal = 6; // # materias 
    public static $maximoCarga = 8; // # materias 

    protected $fillable = [
        'id',
        'id_inscripcion',
        'id_materia',
        'createdBy'
    ];
}
