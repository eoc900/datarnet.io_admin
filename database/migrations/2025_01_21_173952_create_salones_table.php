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
        Schema::create('salones', function (Blueprint $table) {
            $table->id();
            $table->string("nombre",32);
            $table->foreignUuid("id_escuela");
            $table->boolean("activo");
            $table->foreignUuid("creadoPor");
            $table->integer("capacidad");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salones');
    }
};
