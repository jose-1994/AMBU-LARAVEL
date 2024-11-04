<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class PuntosLimpiosController extends Controller
{
    public function obtenerIncidenciasPuntosLimpiosConRelaciones()
    {
        $incidencias = DB::table('incidencia_puntos_limpios')
            ->join('municipios', 'incidencia_puntos_limpios.id_municipio', '=', 'municipios.id')
            ->join('parques', 'incidencia_puntos_limpios.id_parque', '=', 'parques.id')
            ->join('users', 'incidencia_puntos_limpios.id_user', '=', 'users.id')
            ->select(
                'incidencia_puntos_limpios.*', 
                'municipios.NombreMunicipio', 
                'parques.NombreParque', 
                'users.name'
            )
            ->get();
    
        return response()->json(['incidencias' => $incidencias]);
    }

    public function obtenerIncidenciaPuntosLimpiosPorId($id)
    {
        DB::enableQueryLog();
        Log::info("ID recibido: " . $id);
    
        $incidencia = DB::table('incidencia_puntos_limpios')
            ->leftJoin('municipios', 'incidencia_puntos_limpios.id_municipio', '=', 'municipios.id')
            ->leftJoin('parques', 'incidencia_puntos_limpios.id_parque', '=', 'parques.id')
            ->leftJoin('users', 'incidencia_puntos_limpios.id_user', '=', 'users.id')
            ->select(
                'incidencia_puntos_limpios.*', 
                'municipios.NombreMunicipio', 
                'parques.NombreParque', 
                'users.name as NombreUsuario', 
                'users.email as EmailUsuario',
                'users.Apellidos as ApellidosUsuario',
                'users.NumeroEmpleado'
            )
            ->where('incidencia_puntos_limpios.id', $id)
            ->first();
    
        Log::info(DB::getQueryLog());
    
        if ($incidencia) {
            return response()->json($incidencia);
        } else {
            return response()->json(['error' => 'Incidencia no encontrada'], 404);
        }
    }
}
