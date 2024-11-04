<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class SeguridadController extends Controller
{
    public function obtenerIncidenciasSeguridadConRelaciones()
    {
        $incidencias = DB::table('incidencia_seguridads')
            ->join('municipios', 'incidencia_seguridads.id_municipio', '=', 'municipios.id')
            ->join('parques', 'incidencia_seguridads.id_parque', '=', 'parques.id')
            ->join('users', 'incidencia_seguridads.id_user', '=', 'users.id')
            ->select(
                'incidencia_seguridads.*', 
                'municipios.NombreMunicipio', 
                'parques.NombreParque', 
                'users.name'
            )
            ->get();
    
        return response()->json(['incidencias' => $incidencias]);
    }

    public function obtenerIncidenciaSeguridadPorId($id)
    {
        DB::enableQueryLog();
        Log::info("ID recibido: " . $id);
    
        $incidencia = DB::table('incidencia_seguridads')
            ->leftJoin('municipios', 'incidencia_seguridads.id_municipio', '=', 'municipios.id')
            ->leftJoin('parques', 'incidencia_seguridads.id_parque', '=', 'parques.id')
            ->leftJoin('users', 'incidencia_seguridads.id_user', '=', 'users.id')
            ->select(
                'incidencia_seguridads.*', 
                'municipios.NombreMunicipio', 
                'parques.NombreParque', 
                'users.name as NombreUsuario', 
                'users.email as EmailUsuario',
                'users.Apellidos as ApellidosUsuario',
                'users.NumeroEmpleado'
            )
            ->where('incidencia_seguridads.id', $id)
            ->first();
    
        Log::info(DB::getQueryLog());
    
        if ($incidencia) {
            return response()->json($incidencia);
        } else {
            return response()->json(['error' => 'Incidencia no encontrada'], 404);
        }
    }
}
