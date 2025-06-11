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
        Schema::create('titulo_academ_maestros', function (Blueprint $table) {
            $table->id("id_titulo");
            $table->foreignId("id_maestro")->references("id")->on("maestros");
            $table->enum('grado_academico', ['bachillerato', 'licenciatura','ingenieria','maestría','doctorado','diplomado']);
            $table->string("nombre_titulo");
            $table->string("nombre_universidad");
            $table->float('calificacion', precision: 3);
            $table->string("pais");
            $table->date("inicio");
            $table->date("conclusion");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('titulo_academ_maestros');
    }
};
