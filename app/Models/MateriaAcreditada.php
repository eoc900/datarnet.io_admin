<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MateriaAcreditada extends Model
{
    use HasFactory;
    protected $table = 'materias_acreditadas';
    public $incrementing = false;
    protected $keyType = 'string';

    public $tipo_acreditacion = array(['id'=>'revalidación','option'=>'revalidada'],['id'=>'cursada','option'=>'cursada']);

    protected $fillable = [
        'id',
        'id_materia',
        'id_alumno',
        'calificacion',
        'createdBy'
    ];
}
