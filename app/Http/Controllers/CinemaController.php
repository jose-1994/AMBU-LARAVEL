<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class CinemaController extends Controller
{
    public function obtenerIncidenciasCinemaConRelaciones()
    {
        $incidencias = DB::table('incidencia_cinema')
            ->join('municipios', 'incidencia_cinema.id_municipio', '=', 'municipios.id')
            ->join('parques', 'incidencia_cinema.id_parque', '=', 'parques.id')
            ->join('users', 'incidencia_cinema.id_user', '=', 'users.id')
            ->select(
                'incidencia_cinema.*', 
                'municipios.NombreMunicipio', 
                'parques.NombreParque', 
                'users.name'
            )
            ->get();
    
        return response()->json(['incidencias' => $incidencias]);
    }

    public function obtenerIncidenciaCinemaPorId($id)
    {
        DB::enableQueryLog();
        Log::info("ID recibido: " . $id);
    
        $incidencia = DB::table('incidencia_cinema')
            ->leftJoin('municipios', 'incidencia_cinema.id_municipio', '=', 'municipios.id')
            ->leftJoin('parques', 'incidencia_cinema.id_parque', '=', 'parques.id')
            ->leftJoin('users', 'incidencia_cinema.id_user', '=', 'users.id')
            ->select(
                'incidencia_cinema.*', 
                'municipios.NombreMunicipio', 
                'parques.NombreParque', 
                'users.name as NombreUsuario', 
                'users.email as EmailUsuario',
                'users.Apellidos as ApellidosUsuario',
                'users.NumeroEmpleado'
            )
            ->where('incidencia_cinema.id', $id)
            ->first();
    
        Log::info(DB::getQueryLog());
    
        if ($incidencia) {
            return response()->json($incidencia);
        } else {
            return response()->json(['error' => 'Incidencia no encontrada'], 404);
        }
    }
}

