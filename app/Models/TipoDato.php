<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDato extends Model
{
    use HasFactory;
    protected $table = "tipos_datos";
    protected $fillable = [
        "tipo_dato"

    ];
}
