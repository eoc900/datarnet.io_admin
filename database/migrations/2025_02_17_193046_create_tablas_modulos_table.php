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
        Schema::create('tablas_modulos', function (Blueprint $table) {
            $table->id();
            $table->string("nombre_tabla");
            $table->integer("qty_columnas")->nullable();
            $table->foreignUuid("creadoPor");
            $table->boolean("activo");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tablas_modulos');
    }
};
