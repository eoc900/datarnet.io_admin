<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;
    public $estados = ["Revisión pendiente","Revisión","Aprobado","Rechazado"];

    protected $fillable = [
        'nombre',
        'descripcion',
        'estado',
        'id_tipo_documento',
        'formato',
        'peso',
        'subido_por',
        'actualizado_por'
    ];   
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
