<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DescuentosAplicado extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_p_pendiente',
        'id_descuento',
        'tipo_descuento',
        'createdBy'
    ];

    public $tipos_descuentos = ['fijo','porcentaje'];
}
