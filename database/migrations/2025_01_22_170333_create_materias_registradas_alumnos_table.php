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
        Schema::create('materias_registradas_alumnos', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid("id_materia");
            $table->foreignUuid("id_alumno");
            $table->integer("cuatrimestre");
            $table->foreignUuid("creadoPor");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materias_registradas_alumnos');
    }
};
