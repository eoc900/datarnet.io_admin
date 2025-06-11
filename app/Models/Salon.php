<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salon extends Model
{
    use HasFactory;
    protected $table = "salones";
    protected $fillable = [
        "nombre",
        "id_escuela",
        "capacidad",
        "activo",
        "creadoPor"
    ];
}
