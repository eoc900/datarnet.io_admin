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
        Schema::create('conceptos_cobros', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('id_categoria');
            $table->foreignUuid('sistema_academico')->nullable();
            $table->foreignUuid('id_escuela');
            $table->string('codigo_concepto');
            $table->string('nombre');
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
        Schema::dropIfExists('conceptos_cobros');
    }
};
