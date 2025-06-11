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
        Schema::create('promociones', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('nombre');
            $table->string('breve_descripcion');
            $table->string('tipo',32);
            $table->string('banner_1200x700')->nullable();
            $table->string('banner_300x250')->nullable();
            $table->decimal('tasa',3,2);
            $table->decimal('monto',6,2);
            $table->datetime('inicia_en');
            $table->datetime('caducidad');
            $table->boolean('activo');
            $table->foreignUuid('createdBy');
            $table->timestamps();
        });

        Schema::create('condiciones_promociones', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('id_promocion');
            $table->string('condicion');
            $table->integer('prioridad');
            $table->boolean('activo');
            $table->foreignUuid('createdBy');
            $table->timestamps();
        });
    }

    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promociones');
        Schema::dropIfExists('condiciones_promociones');
    }
};
