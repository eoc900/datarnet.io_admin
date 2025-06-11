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
        Schema::create('tareas_asignadas', function (Blueprint $table) {
            $table->id();
            //$table->foreign("ref")->references("referencia")->on("tareas");
            $table->string('ref');
            //$table->foreignId("id_tarea")->references("id")->on("tareas");
            $table->foreignUuid("id_usuario")->references("id")->on("users");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tareas_asignadas');
    }
};
