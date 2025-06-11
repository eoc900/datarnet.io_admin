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
        Schema::create('telefonos_maestros', function (Blueprint $table) {
            $table->id();
            $table->string("telefono",15);
            $table->foreignId("id_maestro");
            $table->boolean("activo");
            $table->foreignUuid("creadoPor");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telefonos_maestros');
    }
};
