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
        Schema::create('descuentos', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('nombre');
            $table->string('descripcion');
            $table->decimal('tasa',3,2);
            $table->decimal('monto',6,2);
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
        Schema::dropIfExists('descuentos');
    }
};
