<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TelefonoAlumno extends Model
{
    use HasFactory;

    // Definir el nombre de la tabla, si es diferente al plural automático
    protected $table = 'telefonos_alumnos';

    // Definir los atributos asignables en masa
    protected $fillable = [
        'id_contacto',
        'telefono',
        'activo',
    ];

    // Relación con el modelo ContactoAlumno (ajusta si usas otro nombre de modelo)
    public function contacto()
    {
        return $this->belongsTo(ContactoAlumno::class, 'id_contacto');
    }

    // Definir los tipos de los campos
    protected $casts = [
        'activo' => 'boolean',
    ];
}
