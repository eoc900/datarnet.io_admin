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
        Schema::create('catalogo_elementos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // Ej: "Formulario dinámico"
            $table->string('tipo');   // Ej: "formulario", "banner", "tabla"
            $table->string('nombre_archivo'); // Ej: "formulario.blade.php"
            $table->json('configuracion_base')->nullable(); // atributos por default
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalogo_elementos');
    }
};
