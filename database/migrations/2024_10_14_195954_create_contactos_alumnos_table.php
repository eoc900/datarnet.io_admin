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
        Schema::create('contactos_alumnos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('id_alumno');
            $table->foreignUuid('id_tipo_contacto');
            $table->string('nombre');
            $table->string('apellido_paterno');
            $table->string('apellido_materno');
            $table->boolean('activo');
            $table->timestamps();
        });

        Schema::create('tipos_contactos', function (Blueprint $table) {
            $table->id('id');
            $table->string('tipo_contacto');
            $table->boolean('activo');
            $table->timestamps();
        });

        Schema::create('telefonos_contactos_alumnos', function (Blueprint $table) {
            $table->id('id');
            $table->foreignUuid('id_contacto');
            $table->string('telefono',15);
            $table->boolean('activo');
            $table->timestamps();
        });
        Schema::create('correos_contactos_alumnos', function (Blueprint $table) {
            $table->id('id');
            $table->foreignUuid('id_contacto');
            $table->foreignUuid('id_tipo_correo');
            $table->string('correo',32);
            $table->string('pin_acceso',6);
            $table->boolean('activo');
            $table->boolean('confirmado'); // Aquí se le envía un código de verificación al correo
            $table->timestamps();
        });
        Schema::create('tipos_correos_contactos_alumnos', function (Blueprint $table) {
            $table->id('id');
            $table->string('tipo_correo',32);
            $table->boolean('activo');
            $table->timestamps();
        });
        Schema::create('direcciones_contactos_alumnos', function (Blueprint $table) {
            $table->id('id');
            $table->foreignUuid('id_contacto');
            $table->string('calle',32);
            $table->string('num_exterior',7);
            $table->string('num_interior',7)->nullable();
            $table->string('colonia',32);
            $table->string('codigo_postal',7);
            $table->boolean('activo');
            $table->string('ciudad',32);
            $table->string('estado',24);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contactos_alumnos');
        Schema::dropIfExists('tipos_contactos');
        Schema::dropIfExists('telefonos_contactos_alumnos');
        Schema::dropIfExists('correos_contactos_alumnos');
        Schema::dropIfExists('tipos_correos_contactos_alumnos');
        Schema::dropIfExists('direcciones_contactos_alumnos');
    }
};
