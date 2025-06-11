<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    use HasFactory;
    protected $table = 'inscripciones';
    protected $keyType = 'string';
    public $incrementing = false;

    public $tipos_inscripcion = array(["id"=>"Inscripción","option"=>"Inscripción"],["id"=>"re-inscripción","option"=>"Re-inscripción"]);
    public $modalidad = array(["id"=>"Escolarizado","option"=>"Escolarizado"],["id"=>"Semi-Escolarizado","option"=>"Semi-Escolarizado"]);

    protected $fillable = [
        'id',
        'id_alumno',
        'periodo',
        'tipo_inscripcion',
        'inscrito_por'
    ];

     // Relación con la tabla 'alumnos' (o como se llame la tabla que tiene a los alumnos)
    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'id_alumno');
    }

}
