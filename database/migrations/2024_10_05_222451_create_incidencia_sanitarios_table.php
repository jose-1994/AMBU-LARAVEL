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
        Schema::create('incidencia_sanitarios', function (Blueprint $table) {
            $table->id();
            $table->integer('folio')->unique();
            $table->unsignedBigInteger('id_municipio'); // Clave foránea para municipios
            $table->unsignedBigInteger('id_parque'); // Clave foránea para parques
            $table->unsignedBigInteger('id_user'); // Clave foránea para usuarios
            $table->json('imagenes')->nullable(); // Almacenar múltiples imágenes en formato JSON
            $table->string('estado', 20)->default('en proceso'); // Estado de la incidencia
            $table->string('actividad', 255); // Tipo de tarea o actividad a realizar
            $table->text('descripcion'); // Descripción de la incidencia
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
        Schema::dropIfExists('incidencia_sanitarios');
    }
};
