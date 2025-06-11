<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoCorreoContactoAlumno extends Model
{
    use HasFactory;

    protected $table = 'tipos_correos_contactos_alumnos';

    // Definir los atributos asignables en masa
    protected $fillable = [
        'tipo_correo',
        'activo',
    ];

    // Relación con el modelo CorreoContactoAlumno
    public function correosContactosAlumnos()
    {
        return $this->hasMany(CorreoContactoAlumno::class, 'id_tipo_correo');
    }
}
