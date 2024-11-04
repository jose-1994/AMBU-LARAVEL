<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('incidencia_mantenimiento_forestal', function (Blueprint $table) {
            $table->integer('folio')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incidencia_mantenimiento_forestal', function (Blueprint $table) {
            // Cambiar a su tipo de dato original si es necesario
            $table->string('folio')->change();
        });
    }
};
