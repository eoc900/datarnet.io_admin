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
        Schema::create('pagina_parametros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pagina_id')->constrained()->onDelete('cascade');
            $table->string('nombre_parametro');
            $table->boolean('es_requerido')->default(true);
            $table->string('tipo')->nullable(); // string, int, fecha, etc. (por validación)
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagina_parametros');
    }
};
