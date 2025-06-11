<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Cobro;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cobros', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('id_costo_concepto');
            $table->foreignUuid('id_cuenta');
            $table->integer('grado')->nullable();
            $table->integer('periodo');
            $table->enum('estado',Cobro::mostrarEstados());
            $table->foreignUuid("creado_por");
            $table->foreignUuid("modificado_por")->nullable();
            $table->timestamp('pagado')->nullable();
            $table->datetime('fecha_inicio');
            $table->datetime('fecha_fin');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cobros');
    }
};
