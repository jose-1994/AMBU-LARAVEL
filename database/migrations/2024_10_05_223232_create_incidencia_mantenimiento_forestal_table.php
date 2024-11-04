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
        Schema::create('incidencia_mantenimiento_forestal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_parque'); // Clave foránea para la tabla parques
            $table->unsignedBigInteger('id_municipio'); // Clave foránea para la tabla municipios
            $table->unsignedBigInteger('id_user'); // Clave foránea para la tabla users (nombre del usuario)
            $table->string('folio')->unique(); // Folio único para cada incidencia
            $table->string('tipo', 255); // Tipo de trabajo forestal
            $table->text('descripcion'); // Descripción del reporte
            $table->json('imagenes')->nullable(); // Guardar varias imágenes en formato JSON
            $table->string('estado', 20)->default('en proceso'); // Estado del reporte
            $table->timestamps();

            // Definir las claves foráneas
            $table->foreign('id_parque')->references('id')->on('parques');
            $table->foreign('id_municipio')->references('id')->on('municipios');
            $table->foreign('id_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidencia_mantenimiento_forestals');
    }
};
