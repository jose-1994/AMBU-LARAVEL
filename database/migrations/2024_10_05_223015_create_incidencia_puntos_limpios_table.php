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
        Schema::create('incidencia_puntos_limpios', function (Blueprint $table) {
            $table->id();
            $table->string('folio')->unique(); // Folio único
            $table->unsignedBigInteger('id_municipio'); // Clave foránea para el municipio
            $table->unsignedBigInteger('id_parque'); // Clave foránea para el parque
            $table->unsignedBigInteger('id_user'); // Clave foránea para el usuario
            $table->string('tipo_servicio', 255); // Tipo de servicio (e.g. recolección de metales, cartón, etc.)
            $table->string('tipo_vidrio')->nullable(); // Tipo de vidrio (verde, oscuro, transparente), nullable ya que es opcional
            $table->json('imagenes')->nullable(); // Almacenar múltiples imágenes en formato JSON
            $table->string('estado', 20)->default('en proceso'); // Estado de la incidencia
            $table->datetime('hora_fecha'); // Fecha y hora del incidente
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
        Schema::dropIfExists('incidencia_puntos_limpios');
    }
};
