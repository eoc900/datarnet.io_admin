<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class XmlZip extends Model
{
    protected $table = "xml_zips";
    protected $fillable = [
        "nombre",
        "error_retornado",
        "lote",
        "creadoPor"
    ];
}
