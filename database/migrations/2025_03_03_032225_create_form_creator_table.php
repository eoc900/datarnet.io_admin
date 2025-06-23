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
        Schema::create('form_creator', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("titulo",64);
            $table->string("hidden_identifier",64)->nullable(); //sin espacios
            $table->string('permiso_requerido')->nullable(); // clave del permiso Spatie
            $table->string("descripcion");
            $table->string("action",64);
            $table->string("nombre_documento",64);
            $table->foreignUuid("creadoPor");
            $table->boolean("es_publico")->default(0);
            $table->string("ruta_banner")->nullable();
            $table->boolean("activo");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_creator');
    }
};
