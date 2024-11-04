<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Agregar los nuevos campos a la tabla principal users
            $table->unsignedBigInteger('idArea')->nullable(); // Relación con la tabla 'areas'
            $table->unsignedBigInteger('idPerfil')->nullable(); // Relación con la tabla 'perfil'
            $table->integer('NumeroEmpleado')->nullable();
            $table->string('Apellidos', 255)->nullable();
            
            // Agregar el campo 'estado' con valor predeterminado de 'activo'
            $table->string('estado', 20)->default('activo');
        
            // Definir las claves foráneas 
            $table->foreign('idArea')->references('id')->on('areas');
            $table->foreign('idPerfil')->references('id')->on('perfiles');
        });
        
        // Agregar el comentario usando SQL crudo
     DB::statement("ALTER TABLE `users` MODIFY `estado` VARCHAR(20) DEFAULT 'activo' COMMENT 'Estado de la solicitud cambia a inactivo, cuando el usuario ya no cuente con acceso por la institución';");
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Eliminar los campos agregados en caso de rollback
            $table->dropForeign(['idArea']);
            $table->dropForeign(['idPerfil']);
            $table->dropColumn(['idArea', 'idPerfil', 'NumeroEmpleado', 'Apellidos', 'estado']);
        });
    }
};
    