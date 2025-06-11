<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promocion extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'promociones';

    protected $fillable = [
        'id',
        'nombre',
        'tipo',
        'breve_descripcion',
        'banner_1200x700',
        'banner_300x250',
        'inicia_en',
        'caducidad',
        'monto',
        'tasa',
        'activo',
        'createdBy'
    ];
}
