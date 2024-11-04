<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;

class SanitariasController extends Controller
{
    public function obtenerIncidenciasSanitariasConRelaciones()
{
    $incidencias = DB::table('incidencia_sanitarios')
        ->join('municipios', 'incidencia_sanitarios.id_municipio', '=', 'municipios.id')
        ->join('parques', 'incidencia_sanitarios.id_parque', '=', 'parques.id')
        ->join('users', 'incidencia_sanitarios.id_user', '=', 'users.id')
        ->select(
            'incidencia_sanitarios.*', 
            'municipios.NombreMunicipio', 
            'parques.NombreParque', 
            'users.name'
        )
        ->get();

    $nombrePersonalizado = 'incidencias';  // Puedes cambiar este nombre si lo prefieres
    $response = [
        $nombrePersonalizado => $incidencias
    ];

    return response()->json($response);
}

public function obtenerIncidenciaSanitariaPorId($id)
{
    // Habilitar el log de consultas
    DB::enableQueryLog();

    // Verificar si el $id es el correcto
    Log::info("ID recibido: " . $id);

    // Realizar la consulta
    $incidencia = DB::table('incidencia_sanitarios')
        ->leftJoin('municipios', 'incidencia_sanitarios.id_municipio', '=', 'municipios.id')
        ->leftJoin('parques', 'incidencia_sanitarios.id_parque', '=', 'parques.id')
        ->leftJoin('users', 'incidencia_sanitarios.id_user', '=', 'users.id')
        ->leftJoin('areas', 'users.idArea', '=', 'areas.id')
        ->leftJoin('perfiles', 'users.idPerfil', '=', 'perfiles.id')
        ->select(
            'incidencia_sanitarios.*', 
            'municipios.NombreMunicipio', 
            'parques.NombreParque', 
            'users.name as NombreUsuario',  
            'users.email as EmailUsuario',
            'users.Apellidos as ApellidosUsuario',
            'users.NumeroEmpleado',  
            'areas.NombreArea',  
            'perfiles.NombrePerfil'  
        )
        ->where('incidencia_sanitarios.id', $id)
        ->first();

    // Mostrar la consulta generada en el log
    Log::info(DB::getQueryLog());

    // Verificar si se encontró la incidencia
    if ($incidencia) {
        return response()->json($incidencia);  // Devolver la incidencia encontrada como JSON
    } else {
        return response()->json(['error' => 'Incidencia no encontrada'], 404);  // Error si no se encuentra la incidencia
    }
}



}