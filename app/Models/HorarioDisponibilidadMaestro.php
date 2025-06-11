<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorarioDisponibilidadMaestro extends Model
{
    use HasFactory;

    protected $table = "horarios_disponibilidad_maestros";
    public $marcar_como = ["Disponible","No disponible"];

    protected $fillable = [
        "hora_inicio",
        "hora_finaliza",
        "id_maestro",
        "creado_por",
        "marcar_como"
    ];
}
