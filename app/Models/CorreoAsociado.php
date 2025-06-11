<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorreoAsociado extends Model
{
    use HasFactory;
    protected $table = 'correos_asociados';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id',
        'id_alumno',
        'correo',
        'tipo_correo',
        'createdBy',
        'activo'
    ];
}
