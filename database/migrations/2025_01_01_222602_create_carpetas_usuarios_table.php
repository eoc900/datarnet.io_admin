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
        Schema::create('carpetas_usuarios', function (Blueprint $table) {
            $table->id();
            $table->string("nombre_ruta");
            $table->foreignUuid("propietario");
            $table->boolean('visible');
            $table->boolean('activo');
            $table->foreignUuid("creadoPor");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carpetas_usuarios');
    }
};
