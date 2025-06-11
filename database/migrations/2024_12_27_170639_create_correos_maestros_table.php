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
        Schema::create('correos_maestros', function (Blueprint $table) {
            $table->id();
            $table->string("correo");
            $table->foreignId("id_maestro");
            $table->foreignId("id_tipo_correo");
            $table->foreignUuid("creadoPor");
            $table->boolean("activo");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('correos_maestros');
    }
};
