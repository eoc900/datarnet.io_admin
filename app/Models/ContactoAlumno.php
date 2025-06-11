<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes; 

class ContactoAlumno extends Model
{
    use HasFactory;
    protected $table = 'contactos_alumnos';
    protected $keyType = 'string';
    public $incrementing = false;

    // Definir los atributos asignables en masa
    protected $fillable = [
        'id',
        'id_alumno',
        'id_tipo_contacto',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'activo',
    ];

    // Relación con la tabla 'alumnos' (o como se llame la tabla que tiene a los alumnos)
    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'id_alumno');
    }

    // Relación con la tabla 'tipos_contactos' (o como se llame la tabla de tipos de contactos)
    public function tipoContacto()
    {
        return $this->belongsTo(TipoContacto::class, 'id_tipo_contacto');
    }
}
