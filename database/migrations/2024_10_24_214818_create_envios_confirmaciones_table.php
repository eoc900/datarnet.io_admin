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
        Schema::create('envios_confirmaciones', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('id_alumno');
            $table->boolean('entregado');
            $table->boolean('confirmado');
            $table->boolean('verificado_presencial');
            $table->uuid('codigo_36');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('envios_confirmaciones');
    }
};
