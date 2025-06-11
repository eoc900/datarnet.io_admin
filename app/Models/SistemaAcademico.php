<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Curricula;

class SistemaAcademico extends Model
{
    use HasFactory;
    protected $table = 'sistemas_academicos';
    public $incrementing = false;
    protected $keyType = 'string';

    public static $niveles = ["Preparatoria","Licenciatura","Ingeniería","Maestría"];
    public static $nivelesDropdown = [["id"=>'Preparatoria',"option"=>"Preparatoria"],
                                    ["id"=>'Licenciatura',"option"=>"Licenciatura"],
                                    ["id"=>'Ingeniería',"option"=>"Ingeniería"],
                                    ["id"=>'Maestría',"option"=>"Maestría"]];
    public static $modalidades = [["id"=>'Escolarizado',"option"=>"Escolarizado"],
                                    ["id"=>'No-Escolarizado',"option"=>"No-Escolarizado"]
                                   ];

    protected $fillable = [
        'id',
        'id_escuela',
        'codigo_sistema',
        'modalidad',
        'nombre',
        'creada_por',
        'nivel_academico',
        'activo'
    ];

    public function capacidadMaterias()
    {
        return $this->hasMany(Curricula::class, 'id_sistema');
    }

    static public function mostrarNiveles(){
        return self::$niveles;
    }
    static public function mostrarDropdownNiveles(){
        return self::$nivelesDropdown;
    }
    static public function mostrarDropdownModalidades(){
        return self::$modalidades;
    }
}
