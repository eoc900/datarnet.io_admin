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
        Schema::create('horarios_disponibilidad_maestros', function (Blueprint $table) {
            $table->id();
            $table->datetime("hora_inicio");
            $table->datetime("hora_finaliza");
            $table->foreignId("id_maestro");
            $table->foreignUuid("creado_por");
            $table->string("marcar_como")->default("Disponible");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios_disponibilidad_maestros');
    }
};
