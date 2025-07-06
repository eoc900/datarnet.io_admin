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
        Schema::create('ligas_formularios', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid("formulario_id");
            $table->string("slug")->unique(); //la ruta sin dominio ejemplo.com/formulario_abcd
            $table->date("fecha_apertura")->nullable();
            $table->date("fecha_cierre")->nullable();
            $table->boolean("activa")->default(1);
            $table->unsignedInteger('max_respuestas')->nullable(); // null = sin límite
            $table->boolean('requiere_token')->default(false);
            $table->text('notas_admin')->nullable();
            $table->string('redirect_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ligas_formularios');
    }
};
