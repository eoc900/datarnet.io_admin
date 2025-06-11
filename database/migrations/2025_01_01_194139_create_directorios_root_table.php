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
        Schema::create('directorios_root', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nombre_directorio',40);
            $table->foreignUuid('propietario');
            $table->boolean('activo');
            $table->foreignUuid('creadoPor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('directorios_root');
    }
};
