<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DireccionContactoAlumno extends Model
{
    use HasFactory;

    protected $table = 'direcciones_contactos_alumnos';

    // Definir los atributos asignables en masa
    protected $fillable = [
        'id_contacto',
        'calle',
        'num_exterior',
        'num_interior',
        'colonia',
        'codigo_postal',
        'activo',
        'confirmado',
        'ciudad',
        'estado'
    ];

    // Relación con el modelo ContactoAlumno
    public function contacto()
    {
        return $this->belongsTo(ContactoAlumno::class, 'id_contacto');
    }
}
