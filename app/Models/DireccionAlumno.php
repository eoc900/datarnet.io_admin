<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DireccionAlumno extends Model
{
    use HasFactory;

    // Definir el nombre de la tabla, si es diferente al plural automático
    protected $table = 'direcciones_alumnos';

    // Definir los atributos asignables en masa
    protected $fillable = [
        'id_alumno',
        'calle',
        'num_exterior',
        'num_interior',
        'colonia',
        'codigo_postal',
        'ciudad',
        'estado',
        'activo',
    ];

    // Relación con el modelo Alumno (ajusta si usas otro nombre de modelo)
    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'id_alumno');
    }

    // Definir los tipos de los campos
    protected $casts = [
        'activo' => 'boolean',
    ];
}
