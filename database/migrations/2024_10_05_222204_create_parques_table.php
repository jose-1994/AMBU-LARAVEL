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
        Schema::create('parques', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('idMunicipio'); 
            $table->string('NombreParque', 255);
            $table->string('colonia', 255);
            $table->string('codigo_postal', 20);
            $table->string('direccion', 255);

            // Definir la clave foránea 
            $table->foreign('idMunicipio')->references('id')->on('municipios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parques');
    }
};
