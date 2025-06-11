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
        Schema::create('alumnos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('matricula',10);
            $table->foreignUuid('id_sistema_academico');
            $table->string('nombre',32);
            $table->string('apellido_paterno',32);
            $table->string('apellido_materno',32);
            $table->foreignUuid('creado_por');
            $table->boolean('activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnos');
    }
};
