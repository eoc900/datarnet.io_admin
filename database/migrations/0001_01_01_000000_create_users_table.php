<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

     /* 
      'name',
        'lastname',
        'avatar',
        'telephone',
        'email',
        'codigo_maestro', // Para ser registrado como primer usuario "el creador del sistema"
        'password',
        'codigo_primer_usuario', // asignado automaticamente por el sistema cuando admin crea un usuario
        'creado_por', 
        'ultimo_inicio',
        'fecha_activacion',
        'fecha_ultima_invite',
        'codigo_reset', 
        'envio_fecha_reset_codigo',
        'codigo_verificacion',
        'fecha_envio_verificacion',
        'avatar'
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->string("telephone")->unique()->nullable();
            $table->enum('estado',["Activo","Inactivo","Bloqueado"])->default('Inactivo');
            $table->foreignUuid("creado_por")->nullable()->constrained()->references("id")->on("users");
            $table->foreignUuid("actualizado_por")->nullable()->constrained()->references("id")->on("users");
            $table->timestamp('ultimo_inicio')->nullable();         
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignUuid('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
