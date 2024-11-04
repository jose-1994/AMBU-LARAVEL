<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class JardineriaController extends Controller
{
    public function obtenerIncidenciasJardineriaConRelaciones()
    {
        $incidencias = DB::table('incidencia_jardineria')
            ->join('municipios', 'incidencia_jardineria.id_municipio', '=', 'municipios.id')
            ->join('parques', 'incidencia_jardineria.id_parque', '=', 'parques.id')
            ->join('users', 'incidencia_jardineria.id_user', '=', 'users.id')
            ->select(
                'incidencia_jardineria.*', 
                'municipios.NombreMunicipio', 
                'parques.NombreParque', 
                'users.name'
            )
            ->get();
    
        return response()->json(['incidencias' => $incidencias]);
    }

    public function obtenerIncidenciaJardineriaPorId($id)
    {
        DB::enableQueryLog();
        Log::info("ID recibido: " . $id);
    
        $incidencia = DB::table('incidencia_jardineria')
            ->leftJoin('municipios', 'incidencia_jardineria.id_municipio', '=', 'municipios.id')
            ->leftJoin('parques', 'incidencia_jardineria.id_parque', '=', 'parques.id')
            ->leftJoin('users', 'incidencia_jardineria.id_user', '=', 'users.id')
            ->select(
                'incidencia_jardineria.*', 
                'municipios.NombreMunicipio', 
                'parques.NombreParque', 
                'users.name as NombreUsuario', 
                'users.email as EmailUsuario',
                'users.Apellidos as ApellidosUsuario',
                'users.NumeroEmpleado'
            )
            ->where('incidencia_jardineria.id', $id)
            ->first();
    
        Log::info(DB::getQueryLog());
    
        if ($incidencia) {
            return response()->json($incidencia);
        } else {
            return response()->json(['error' => 'Incidencia no encontrada'], 404);
        }
    }
}
