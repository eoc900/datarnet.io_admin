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
        Schema::create('descuentos_aplicados', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('id_p_pendiente');
            $table->foreignUuid('id_descuento');
            $table->string('tipo_descuento',32);
            $table->foreignUuid('createdBy');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('descuentos_aplicados');
    }
};
