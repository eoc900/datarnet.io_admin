<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\MateriaRegistradaAlumno;

class Alumno extends Model
{
    use HasFactory;
    protected $table = 'alumnos';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'id_sistema_academico',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'creado_por',
        'activo',
        'matricula'
    ];

    static public function informacionBasica($idAlumno=""){
        $alumnos = DB::table('alumnos')
                   ->select("alumnos.id as id_alumno","sistemas_academicos.codigo_sistema","escuelas.codigo_escuela",
                   "alumnos.matricula","sistemas_academicos.id as id_sistema_academico",
                   DB::raw('CONCAT(alumnos.nombre," ",alumnos.apellido_paterno," ",alumnos.apellido_materno) as alumno'),
                   "alumnos.activo")
                   ->join('sistemas_academicos','alumnos.id_sistema_academico',"=",'sistemas_academicos.id')
                   ->join('escuelas','sistemas_academicos.id_escuela','=','escuelas.id')
                   ->where('alumnos.id','=',$idAlumno)
                   ->first();

        if($alumnos){
            return $alumnos;
        }
        return false;
    }

    public function materiasRegistradas()
    {
        return $this->hasMany(MateriaRegistradaAlumno::class, 'id_alumno');
    }
}
