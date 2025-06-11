<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TareasAsignadas extends Model
{
    use HasFactory;
      protected $fillable = [
        'id_tarea',
        'id_usuario'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

}
