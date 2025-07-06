<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LigaFormulario extends Model
{
    protected $table = 'ligas_formularios';
    protected $fillable = [
        'formulario_id',
        'slug',
        'fecha_apertura',
        'fecha_cierre',
        'activa',
        'max_respuestas',
        'requiere_token',
        'notas_admin',
        'redirect_url'
    ];
}
