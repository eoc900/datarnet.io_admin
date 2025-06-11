<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TituloGenerado extends Model
{
    
    protected $table = "titulos_generados";
    protected $keyType = 'string'; // Indica que la clave primaria es una cadena (UUID)
    public $incrementing = false; 
    protected $fillable = [
        "id",
        "id_alumno",
        "fecha_expedicion",
        "estado",
        "emitidoPor",
        "aprobadoPor",
        "num_lote",
        "archivo_zip",
        "id_institucion",
        "cve_carrera",
        "fecha_inicio",
        "fecha_terminacion",
        "modalidad_titulacion",
        "fecha_examen_profesional",
        "fecha_exencion_examen",
        "cumplio_servicio_social",
        "id_entidad_expedicion",
        "id_servicio_social",
        "id_autorizacion",
        "nombre_institucion_antecedente",
        "tipo_estudio_antecedente",
        "id_entidad_estudios_antecedentes",
        "fecha_inicio_antecedente",
        "fecha_terminacion_antecedente"
    ];
}
