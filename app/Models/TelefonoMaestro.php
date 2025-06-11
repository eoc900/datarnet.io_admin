<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TelefonoMaestro extends Model
{
    use HasFactory;
    protected $table = "telefonos_maestros";
    protected $fillable = [
        "telefono",
        "creadoPor",
        "activo",
        "id_maestro"
    ];
}
