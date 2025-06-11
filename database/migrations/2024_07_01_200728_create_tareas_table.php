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
        Schema::create('tareas', function (Blueprint $table) {
            $table->id();
            $table->string("referencia");
            $table->string("titulo");
            $table->string("descripcion");
            $table->foreignUuid("creada_por")->references("id")->on("users");
            $table->foreignUuid("actualizada_por")->references("id")->on("users");
            $table->enum('estado', ["Pendiente","En Progreso","Completada","Aprobada","Reformular"]);
            $table->datetime("fecha_inicio");
            $table->datetime("terminar_en");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tareas');
    }
};
