<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipos_Documentos extends Model
{
    use HasFactory;
    protected $table = 'tiposDocumentos';
      
    protected $fillable = [
        'nombre',
        'descripcion',
        'icono',
        'ruta_almacenamiento',
        'creado_por',
        'actualizado_por',
    ];   
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

}
