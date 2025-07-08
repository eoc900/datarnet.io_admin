<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\TablaModulo;
use App\Models\ColumnaTabla;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('modulo_users', function (Blueprint $table) {
            $table->uuid('uuid_repetido')->primary();
            $table->string('nombre_completo');
            $table->string('correo')->unique();
            $table->string('telefono')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modulo_users');
    }
};
