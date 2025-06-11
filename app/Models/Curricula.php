<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Materia;

class Curricula extends Model
{
    use HasFactory;
    protected $table = "curriculas";
    protected $fillable = [
        "id_materia",
        "id_sistema",
        "creadoPor",
        "activo"
    ];
    public function materia()
    {
        return $this->belongsTo(Materia::class, 'id_materia', 'id');
    }
}
