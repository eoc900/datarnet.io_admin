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
        Schema::create('costo_concepto_cobros', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('id_concepto');
            $table->integer('periodo');
            $table->float('costo');
            $table->foreignUuid('creado_por');
            $table->boolean('activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('costo_concepto_cobros');
    }
};
