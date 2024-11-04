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
        Schema::create('incidencia_concesionarios', function (Blueprint $table) {
            $table->id(); // ID único de la incidencia
            $table->string('folio')->unique(); // Folio único para cada incidencia
            $table->unsignedBigInteger('id_municipio'); // Clave foránea para la tabla municipios
            $table->unsignedBigInteger('id_parque'); // Clave foránea para la tabla parques
            $table->unsignedBigInteger('id_user'); // Clave foránea para el usuario que reporta la incidencia
            $table->string('nombre_comerciante', 255); // Nombre del comerciante
            $table->string('actividad_comercial', 255); // Actividad comercial realizada
            $table->boolean('cuenta_con_permiso'); // Indica si cuenta con permiso (true: sí, false: no)
            $table->boolean('cumple_limpieza'); // Indica si cumple con la limpieza general (true: sí, false: no)
            $table->boolean('mercancia_permitida'); // Indica si la mercancía es permitida (true: sí, false: no)
            $table->string('ubicacion', 255); // Ubicación del comerciante
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
        Schema::dropIfExists('incidencia_concesionarios');
    }
};
