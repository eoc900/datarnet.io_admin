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
        Schema::create('cuentas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('id_alumno');
            $table->integer('dist_pagos_cuatri');
            $table->integer('cuatrimestre'); // 20241, 20242,
            $table->boolean('activa');
            $table->boolean('condonada')->default(false);
            $table->foreignUuid('creada_por');
            $table->foreignUuid('modificada_por')->nullable();
            $table->timestamp('vencimiento');
            $table->timestamp('fecha_inicio');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuentas');
    }
};
