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
        Schema::create('elementos_paginas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pagina_id')->constrained()->onDelete('cascade');
            $table->foreignId('catalogo_elemento_id')->constrained('catalogo_elementos')->onDelete('cascade');
            $table->json('parametros')->nullable(); // aquí vive la configuración específica de ese elemento
            $table->integer('orden')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('elementos_paginas');
    }
};
