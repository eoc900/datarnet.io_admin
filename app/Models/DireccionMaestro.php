<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DireccionMaestro extends Model
{
    use HasFactory;
    protected $table = "direcciones_maestros";
    protected $fillable = [
        'id_maestro',
        'calle',
        'num_exterior',
        'num_interior',
        'colonia',
        'codigo_postal',
        'ciudad',
        'estado',
        'activo'
    ];
}
