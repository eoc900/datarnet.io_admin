<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    use HasFactory;
    protected $table = 'codes';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'codigo',
        'hidden_input',
        'correo_encripted'
    ];
}
