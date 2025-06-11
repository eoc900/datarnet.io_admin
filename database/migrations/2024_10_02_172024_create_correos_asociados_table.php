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
        Schema::create('correos_asociados', function (Blueprint $table) {
            $table->uuid('id');
            $table->foreignUuid('id_alumno');
            $table->string('correo');
            $table->foreignId('tipo_correo');
            $table->foreignUuid('createdBy');
            $table->boolean('activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('correos_asociados');
    }
};
