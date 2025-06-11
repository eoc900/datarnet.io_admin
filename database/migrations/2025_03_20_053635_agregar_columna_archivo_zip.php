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
        Schema::table('titulos_generados', function (Blueprint $table) {
            $table->string('archivo_zip')->nullable()->after('num_lote'); //archivo_zip 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('titulos_generados', function (Blueprint $table) {
            $table->dropColumn('archivo_zip');
        });
    }
};
