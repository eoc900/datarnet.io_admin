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
        Schema::create('direcciones_alumnos', function (Blueprint $table) {
            $table->id('id');
            $table->foreignUuid('id_alumno');
            $table->string('calle',32);
            $table->string('num_exterior',7);
            $table->string('num_interior',7)->nullable();
            $table->string('colonia',32);
            $table->string('codigo_postal',7);
            $table->string('ciudad',32);
            $table->string('estado',24);
            $table->boolean('activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('direcciones_alumnos');
    }
};
