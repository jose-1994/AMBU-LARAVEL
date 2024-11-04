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
        Schema::create('incidencia_seguridad', function (Blueprint $table) {
            $table->id();
            $table->string('folio')->unique(); // Cambié a string por si folio tiene caracteres especiales
            $table->unsignedBigInteger('id_municipio'); // Clave foránea
            $table->unsignedBigInteger('id_parque'); // Clave foránea
            $table->unsignedBigInteger('id_user'); // Clave foránea
            $table->json('imagenes')->nullable(); // Almacenar múltiples imágenes en formato JSON
            $table->string('estado', 20)->default('en proceso'); // Estado de la incidencia
            $table->text('observaciones'); // Texto extenso para observaciones
            
            // Definir las claves foráneas
            $table->foreign('id_municipio')->references('id')->on('municipios');
            $table->foreign('id_parque')->references('id')->on('parques');
            $table->foreign('id_user')->references('id')->on('users');
            $table->timestamps();

            // Otros campos descriptivos
            $table->string('media_afiliacion', 255); // Descripción de la persona
            $table->string('tipo_servicio', 100); // Tipo de servicio
            $table->string('actividad_persona', 100); // Actividad realizada
            $table->string('tipo_arma', 100); // Tipo de arma, si aplica
            $table->string('medio_transporte', 100); // Medio de transporte
            $table->datetime('hora_incidente'); // Fecha y hora del incidente
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidencia_seguridads');
    }
};
