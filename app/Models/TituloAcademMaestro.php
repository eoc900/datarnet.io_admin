<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TituloAcademMaestro extends Model
{
    use HasFactory;
      protected $fillable = [
        'id_maestro',
        'grado_academico',
        'nombre_titulo',
        'nombre_universidad',
        'pais',
        'calificacion',
        'inicio',
        'conclusion',
    ];

    protected $casts = [
        'inicio' => 'date',
        'conclusion'=>'date'
    ];

   
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    
}
