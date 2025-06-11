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
        Schema::create('capacidad_materias_maestros', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid("id_materia");
            $table->foreignId("id_maestro");
            $table->boolean("activo")->default(1);
            $table->foreignUuid("creadoPor");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('capacidad_materias_maestros');
    }
};
