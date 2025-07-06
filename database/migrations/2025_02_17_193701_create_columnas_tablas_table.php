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
        Schema::create('columnas_tablas', function (Blueprint $table) {
            $table->id();
           // $table->string("id_columna",32);
            $table->string("nombre_columna",62);
            $table->foreignId("id_tabla");
            $table->string("tipo_dato",32);
            $table->unsignedTinyInteger("qty_caracteres")->nullable();
            $table->boolean("es_llave_primaria")->default(0);
            $table->boolean("es_foranea")->default(0);
            $table->string("on_table")->nullable();
            $table->string("on_column")->nullable();
            $table->boolean("nullable");
            $table->boolean("activo");
            $table->boolean('unica')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('columnas_tablas');
    }
};
