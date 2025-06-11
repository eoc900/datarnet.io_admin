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
        Schema::create('desglose_cuentas', function (Blueprint $table) {
            $table->uuid('id');
            $table->integer("num_cargo");
            $table->foreignUuid("id_monto");
            $table->foreignUuid("id_cuenta");
            $table->decimal("monto",8,2);
            $table->boolean("diferido"); // El motivo es que el costo se muestra mensual en el caso de la colegiatura y se puede dividir en varios pagos
            $table->datetime("fecha_inicio");
            $table->datetime("fecha_finaliza");
            $table->foreignUuid('createdBy');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('desglose_cuentas');
    }
};
