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
        Schema::create('recorridos_parques', function (Blueprint $table) {
            $table->unsignedBigInteger('idParque');    // Clave foránea para la tabla parques
            $table->unsignedBigInteger('idMunicipio'); // Clave foránea para la tabla municipios
            $table->integer('numero_punto');           //para almacenar el número de punto
            $table->string('Nombre');
            $table->timestamps();
            // Definir las claves foráneas
            $table->foreign('idParque')->references('id')->on('parques')->onDelete('cascade');
            $table->foreign('idMunicipio')->references('id')->on('municipios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('puntos_recorridos');
    }
};
