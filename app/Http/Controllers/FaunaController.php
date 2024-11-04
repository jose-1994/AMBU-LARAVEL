<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class FaunaController extends Controller
{
    public function obtenerIncidenciasFaunaConRelaciones()
    {
        $incidencias = DB::table('incidencia_faunas')
            ->join('municipios', 'incidencia_faunas.id_municipio', '=', 'municipios.id')
            ->join('parques', 'incidencia_faunas.id_parque', '=', 'parques.id')
            ->join('users', 'incidencia_faunas.id_user', '=', 'users.id')
            ->select(
                'incidencia_faunas.*', 
                'municipios.NombreMunicipio', 
                'parques.NombreParque', 
                'users.name'
            )
            ->get();
    
        $nombrePersonalizado = 'incidencias';  // Puedes cambiar este nombre según tus preferencias
        $response = [
            $nombrePersonalizado => $incidencias
        ];
        
        return response()->json($response);
    }

    public function obtenerIncidenciaFaunaPorId($id)
    {
        // Habilitar el log de consultas
        DB::enableQueryLog();
    
        // Verificar si el $id es el correcto
        Log::info("ID recibido: " . $id);
    
        // Realizar la consulta
        $incidencia = DB::table('incidencia_faunas')
            ->leftJoin('municipios', 'incidencia_faunas.id_municipio', '=', 'municipios.id')
            ->leftJoin('parques', 'incidencia_faunas.id_parque', '=', 'parques.id')
            ->leftJoin('users', 'incidencia_faunas.id_user', '=', 'users.id')
            ->leftJoin('areas', 'users.idArea', '=', 'areas.id')
            ->leftJoin('perfiles', 'users.idPerfil', '=', 'perfiles.id')
            ->select(
                'incidencia_faunas.*', 
                'municipios.NombreMunicipio', 
                'parques.NombreParque', 
                'users.name as NombreUsuario',  // Evitar conflicto de nombres con incidencia_faunas
                'users.email as EmailUsuario',
                'users.Apellidos as ApellidosUsuario',
                'users.email as EmailUsuario',  // Selecciona solo las columnas necesarias
                'users.NumeroEmpleado',  
                'areas.NombreArea',  
                'perfiles.NombrePerfil'  
            )
            ->where('incidencia_faunas.id', $id)
            ->first();
    
        // Mostrar la consulta generada en el log
        Log::info(DB::getQueryLog());
    
        // Verificar si se encontró la incidencia
        if ($incidencia) {
            return response()->json($incidencia);  // Devolver la incidencia encontrada como JSON
        } else {
            return response()->json(['error' => 'Incidencia no encontrada '], 404);  // Error si no se encuentra la incidencia
        }
    }
    

    
}
