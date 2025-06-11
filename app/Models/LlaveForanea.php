<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LlaveForanea extends Model
{
    use HasFactory;
    protected $table = "llaves_foraneas";
    protected $fillable = [
        "llave_foranea",
        "llave_primaria"
    ];
}
