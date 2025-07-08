<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuloUser extends Model
{
    use HasFactory;

    protected $table = 'modulo_users';
    protected $primaryKey = 'uuid_repetido';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['uuid_repetido', 'nombre_completo', 'correo', 'telefono'];
}
