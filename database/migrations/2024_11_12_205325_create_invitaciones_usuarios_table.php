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
        Schema::create('invitaciones_usuarios', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('createdBy');
            $table->string('correo',32);
            $table->uuid('codigo');
            $table->boolean('activo');
            $table->boolean('abierto');
            $table->string('roles',64);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitaciones_usuarios');
    }
};
