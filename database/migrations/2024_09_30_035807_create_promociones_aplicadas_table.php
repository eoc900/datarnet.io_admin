<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('promociones_aplicadas', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->foreignUuid('id_promocion');
            $table->foreignUuid('id_cuenta');
            $table->boolean('activo')->default(true);
            $table->foreignUuid('aplicado_por')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promociones_aplicadas');
    }
};
