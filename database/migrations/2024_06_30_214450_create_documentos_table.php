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
    
        Schema::create('tiposDocumentos', function (Blueprint $table) {
            $table->id();
            $table->string("nombre");
            $table->string("descripcion");
            $table->string("nombre_icono")->nullable();
            $table->string("ruta_almacenamiento");
            $table->string("creado_por");
            $table->string("actualizado_por");
            $table->timestamps();
        });
        
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            $table->string("nombre");
            $table->string("descripcion")->nullable;
            $table->enum("estado",["Revisión pendiente","Revisión","Aprobado","Rechazado"]);
            $table->foreignId("id_tipo_documento")->references("id")->on("tiposDocumentos");
            $table->string("formato");
            $table->string("peso");
            $table->string("subido_por");
            $table->string("actualizado_por");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos');
        Schema::dropIfExists('tiposDocumentos');
       
    }
};
