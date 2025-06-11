<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TelefonoContactoAlumno extends Model
{
    use HasFactory;

    protected $table = 'telefonos_contactos_alumnos';

    // Definir los atributos asignables en masa
    protected $fillable = [
        'id_contacto',
        'telefono',
        'activo',
    ];

    // Relación con el modelo ContactoAlumno
    public function contacto()
    {
        return $this->belongsTo(ContactoAlumno::class, 'id_contacto');
    }
}
