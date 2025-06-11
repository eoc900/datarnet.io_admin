<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('titulos_generados', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("id_alumno");
            $table->date("fecha_expedicion");
            $table->boolean("estado");
            $table->foreignUuid("emitidoPor");
            $table->foreignUuid("aprobadoPor")->nullable();
            $table->integer("num_lote")->nullable();
            $table->integer("id_institucion");
            $table->integer("cve_carrera");
            $table->date("fecha_inicio")->nullable();
            $table->date("fecha_terminacion");
            $table->integer("modalidad_titulacion");
            $table->date("fecha_examen_profesional")->nullable();
            $table->date("fecha_exencion_examen")->nullable();
            $table->boolean("cumplio_servicio_social");
            $table->integer("id_entidad_expedicion");
            $table->integer("id_servicio_social");
            $table->integer("id_autorizacion");
            $table->string("nombre_institucion_antecedente");
            $table->integer("tipo_estudio_antecedente");
            $table->integer("id_entidad_estudios_antecedentes");
            $table->date("fecha_inicio_antecedente");
            $table->date("fecha_terminacion_antecedente");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('titulos_generados');
    }
};
