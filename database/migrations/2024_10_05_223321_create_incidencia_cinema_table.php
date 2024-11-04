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
        Schema::create('incidencia_cinema', function (Blueprint $table) {
            $table->id();
            $table->string('folio')->unique(); // Folio único para cada incidencia
            $table->unsignedBigInteger('id_municipio'); // Clave foránea para el municipio
            $table->unsignedBigInteger('id_parque'); // Clave foránea para el parque
            $table->unsignedBigInteger('id_user'); // Clave foránea para el usuario
            $table->json('imagenes')->nullable(); // Almacenar múltiples imágenes en formato JSON
            $table->string('estado', 20)->default('en proceso'); // Estado de la incidencia
            $table->datetime('hora_fecha'); // Hora y fecha del reporte
            $table->string('pelicula', 255); // Nombre de la película
            $table->integer('duracion'); // Duración de la película en minutos
            $table->integer('aforo'); // Aforo máximo de personas
            $table->text('observaciones'); // Observaciones del reporte
            $table->timestamps();

            // Definir las claves foráneas
            $table->foreign('id_municipio')->references('id')->on('municipios');
            $table->foreign('id_parque')->references('id')->on('parques');
            $table->foreign('id_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidencia_cinema');
    }
};
