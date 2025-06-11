<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvitacionUsuario extends Model
{
    use HasFactory;
    protected $table = 'invitaciones_usuarios';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'createdBy',
        'correo',
        'codigo',
        'activo',
        'abierto',
        'roles'
    ];
}
