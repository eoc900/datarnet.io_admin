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
        Schema::create('materias_acreditadas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('id_materia');
            $table->foreignUuid('id_alumno');
            $table->integer('calificacion');
            $table->foreignUuid('createdBy');
            $table->string('tipo_acreditacion',24);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materias_acreditadas');
    }
};
