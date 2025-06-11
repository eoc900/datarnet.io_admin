<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\SistemaAcademico;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('escuelas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('imagen_logo');
            $table->string('codigo_escuela',32)->unique();
            $table->string('nombre',64);
            $table->string('calle');
            $table->string('colonia');
            $table->string('codigo_postal',9);
            $table->string('num_exterior',5);
            $table->string('ciudad',32);
            $table->string('estado',32);
            $table->foreignUuid('creada_por');
            $table->boolean('activo');
            $table->timestamps();
        });

        Schema::create('sistemas_academicos',function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->foreignUuid('id_escuela');
            $table->string('modalidad'); //escolarizado y semi-escolarizado
            $table->string('codigo_sistema')->unique();
            $table->enum('nivel_academico',SistemaAcademico::mostrarNiveles());
            $table->string('nombre');
            $table->foreignUuid('creada_por');
            $table->boolean('activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('escuelas');
        Schema::dropIfExists('sistemas_academicos');
    }
};
