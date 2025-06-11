<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CorreoContactoAlumno extends Model
{
    use HasFactory;

    protected $table = 'correos_contactos_alumnos';

    // Definir los atributos asignables en masa
    protected $fillable = [
        'id_contacto',
        'id_tipo_correo',
        'correo',
        'pin_acceso',
        'activo',
        'confirmado',
    ];

    // Relación con el modelo ContactoAlumno
    public function contacto()
    {
        return $this->belongsTo(ContactoAlumno::class, 'id_contacto');
    }

    // Relación con el modelo TipoCorreo (asegúrate de tener este modelo)
    public function tipoCorreo()
    {
        return $this->belongsTo(TipoCorreo::class, 'id_tipo_correo');
    }
}
