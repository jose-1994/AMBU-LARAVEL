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
        Schema::create('incidencia_limpieza_parques', function (Blueprint $table) {
            $table->bigIncrements('id'); // ID principal
            $table->integer('folio')->unique();
            $table->unsignedBigInteger('id_municipio'); // Clave foránea para el municipio
            $table->unsignedBigInteger('id_parque'); // Clave foránea para el parque
            $table->unsignedBigInteger('id_user'); // Clave foránea para el usuario que crea la incidencia
            $table->text('tipo'); // Tipo de solicitud (limpieza de andadores, perimetral, etc.)
            $table->text('descripcion'); // Descripción de la incidencia
            $table->json('imagenes')->nullable(); // Guardar varias imágenes en formato JSON
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
        Schema::dropIfExists('incidencia_limpieza_del_parques');
    }
};
