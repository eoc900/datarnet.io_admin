<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoContacto extends Model
{
    use HasFactory;

    protected $table = 'tipos_contactos';

    // Definir los atributos asignables en masa
    protected $fillable = [
        'tipo_contacto',
        'activo',
    ];

    // Relación con la tabla 'contactos_alumnos'
    public function contactosAlumnos()
    {
        return $this->hasMany(ContactoAlumno::class, 'id_tipo_contacto');
    }
}
