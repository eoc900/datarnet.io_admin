<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\TituloAcademMaestro;
use App\Models\CapacidadMateriasMaestro;

class Maestro extends Model
{
    use HasFactory;
    protected $table = "maestros";
    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'avatar',
        'activo',
        'creadoPor',
        'matricula',
        'id_escuela'
    ];

   
    protected $hidden = [
        'created_at',
        'updated_at',
    ];


    public function capacidadMaterias()
    {
        return $this->hasMany(CapacidadMateriasMaestro::class, 'id_maestro');
    }

    static public function buscarPorNombre($search){
        
        $names = explode(' ', $search);
         // Ensure there are exactly three parts (first name, middle name, last name)
        if(count($names) === 3) {
            $firstName = $names[0];
            $middleName = $names[1];
            $lastName = $names[2];
            return Maestro::select("id","nombre","apellido_paterno","apellido_materno")
            ->where(DB::raw("CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno)"), 'like', "%{$firstName} {$middleName} {$lastName}%")
            ->get();
        } elseif (count($names) === 2) {
            // Handle cases where only two names are provided
            $firstName = $names[0];
            $lastName = $names[1];

            return Maestro::select("id","nombre","apellido_paterno","apellido_materno")
            ->where(DB::raw("CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno)"), 'like', "%{$firstName} {$lastName}%")
            ->get();
        } else {
            // Handle cases where only one name is provided
            return Maestro::select("id","nombre","apellido_paterno","apellido_materno")
            ->where(DB::raw("CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno)"), 'like', "%{$search}%")
            ->get();
        }
    }

    static public function tableMaestro($search){
        $names = explode(' ', $search);
         // Ensure there are exactly three parts (first name, middle name, last name)
        if(count($names) === 3) {
            $firstName = $names[0];
            $middleName = $names[1];
            $lastName = $names[2];
            return Maestro::select("id","nombre","apellido_paterno","apellido_materno")
            ->where(DB::raw("CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno)"), 'like', "%{$firstName} {$middleName} {$lastName}%");
            
        } elseif (count($names) === 2) {
            // Handle cases where only two names are provided
            $firstName = $names[0];
            $lastName = $names[1];

            return Maestro::select("id","nombre","apellido_paterno","apellido_materno")
            ->where(DB::raw("CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno)"), 'like', "%{$firstName} {$lastName}%");
            
        } else {
            // Handle cases where only one name is provided
            return Maestro::select("id","nombre","apellido_paterno","apellido_materno")
            ->where(DB::raw("CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno)"), 'like', "%{$search}%");
        }

    }

    static public function tableTitulosDeMaestro($search){
        $names = explode(' ', $search);

        $results = DB::table('titulo_academ_maestros')
        ->join('maestros', 'maestros.id', '=', 'titulo_academ_maestros.id_maestro')
        ->select('titulo_academ_maestros.id_titulo',
        DB::raw('CONCAT(maestros.nombre," ",maestros.apellido_paterno," ",maestros.apellido_materno) as maestro'),'titulo_academ_maestros.grado_academico','titulo_academ_maestros.nombre_titulo','titulo_academ_maestros.nombre_universidad')
        ->where(DB::raw("CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno)"), 'like', "%{$search}%");

        return $results;

    }
}
