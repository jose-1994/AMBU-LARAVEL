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
        Schema::create('incidencia_jardineria', function (Blueprint $table) {
            $table->id(); // ID único de la incidencia
            $table->string('folio')->unique(); // Folio único para cada incidencia
            $table->unsignedBigInteger('id_municipio'); // Clave foránea para la tabla municipios
            $table->unsignedBigInteger('id_parque'); // Clave foránea para la tabla parques
            $table->unsignedBigInteger('id_user'); // Clave foránea para el usuario que reporta la incidencia
            $table->string('folio')->unique(); // Folio único para la incidencia
            $table->string('tipo_solicitud', 255); // Tipo de solicitud (varchar 255)
            $table->text('descripcion_reporte'); // Descripción del reporte
            $table->json('imagenes')->nullable(); // Almacenar imágenes en formato JSON (opcional)
            $table->string('estado', 20)->default('en proceso'); // Estado del reporte
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
        Schema::dropIfExists('incidencia_jardineria');
    }
};
