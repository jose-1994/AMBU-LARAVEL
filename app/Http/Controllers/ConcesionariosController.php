<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ConcesionariosController extends Controller
{
    public function obtenerIncidenciasConcesionariosConRelaciones()
    {
        $incidencias = DB::table('incidencia_concesionarios')
            ->join('municipios', 'incidencia_concesionarios.id_municipio', '=', 'municipios.id')
            ->join('parques', 'incidencia_concesionarios.id_parque', '=', 'parques.id')
            ->join('users', 'incidencia_concesionarios.id_user', '=', 'users.id')
            ->select(
                'incidencia_concesionarios.*', 
                'municipios.NombreMunicipio', 
                'parques.NombreParque', 
                'users.name'
            )
            ->get();
    
        return response()->json(['incidencias' => $incidencias]);
    }

    public function obtenerIncidenciaConcesionariosPorId($id)
    {
        DB::enableQueryLog();
        Log::info("ID recibido: " . $id);
    
        $incidencia = DB::table('incidencia_concesionarios')
            ->leftJoin('municipios', 'incidencia_concesionarios.id_municipio', '=', 'municipios.id')
            ->leftJoin('parques', 'incidencia_concesionarios.id_parque', '=', 'parques.id')
            ->leftJoin('users', 'incidencia_concesionarios.id_user', '=', 'users.id')
            ->select(
                'incidencia_concesionarios.*', 
                'municipios.NombreMunicipio', 
                'parques.NombreParque', 
                'users.name as NombreUsuario', 
                'users.email as EmailUsuario',
                'users.Apellidos as ApellidosUsuario',
                'users.NumeroEmpleado'
            )
            ->where('incidencia_concesionarios.id', $id)
            ->first();
    
        Log::info(DB::getQueryLog());
    
        if ($incidencia) {
            return response()->json($incidencia);
        } else {
            return response()->json(['error' => 'Incidencia no encontrada'], 404);
        }
    }
}
