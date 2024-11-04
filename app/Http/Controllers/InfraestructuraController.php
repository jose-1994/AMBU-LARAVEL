<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Incidencia_mantenimiento_infraestructura;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class InfraestructuraController extends Controller
{
    public function obtenerIncidenciasInfraestructuraConRelaciones()
    {
        $incidencias = DB::table('incidencia_mantenimiento_infraestructuras')
            ->join('municipios', 'incidencia_mantenimiento_infraestructuras.id_municipio', '=', 'municipios.id')
            ->join('parques', 'incidencia_mantenimiento_infraestructuras.id_parque', '=', 'parques.id')
            ->join('users', 'incidencia_mantenimiento_infraestructuras.id_user', '=', 'users.id')
            ->select(
                'incidencia_mantenimiento_infraestructuras.*',
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

    public function obtenerIncidenciaInfraestructuraPorId($id)
    {
        // Habilitar el log de consultas
        DB::enableQueryLog();

        // Verificar si el $id es el correcto
        Log::info("ID recibido: " . $id);

        // Realizar la consulta
        $incidencia = DB::table('incidencia_mantenimiento_infraestructuras')
            ->leftJoin('municipios', 'incidencia_mantenimiento_infraestructuras.id_municipio', '=', 'municipios.id')
            ->leftJoin('parques', 'incidencia_mantenimiento_infraestructuras.id_parque', '=', 'parques.id')
            ->leftJoin('users', 'incidencia_mantenimiento_infraestructuras.id_user', '=', 'users.id')
            ->leftJoin('areas', 'users.idArea', '=', 'areas.id')
            ->leftJoin('perfiles', 'users.idPerfil', '=', 'perfiles.id')
            ->select(
                'incidencia_mantenimiento_infraestructuras.*',
                'municipios.NombreMunicipio',
                'parques.NombreParque',
                'users.name as NombreUsuario',
                'users.email as EmailUsuario',
                'users.Apellidos as ApellidosUsuario',
                'users.NumeroEmpleado',
                'areas.NombreArea',
                'perfiles.NombrePerfil'
            )
            ->where('incidencia_mantenimiento_infraestructuras.id', $id)
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
    public function saveReportInfraestructura(Request $request)
    {
        // Validar los datos de entrada con mensajes personalizados, sin validar que las imágenes sean archivos
        $validated = $request->validate([
            'folio' => 'required|unique:incidencia_mantenimiento_infraestructuras',
            'actividad' => 'required|string|min:3',
            'id_parque' => 'required|integer|exists:parques,id',
            'id_user' => 'required|integer|exists:users,id',
            'estado' => 'required|string|in:Activo,Inactivo',
            'descripcion' => 'required|string|min:5',
            'id_municipio' => 'required|integer|exists:municipios,id',
            'imagenes.*' => 'nullable|string|starts_with:data:image/', // Validar que comience con data:image/
        ], [
            'folio.required' => 'El folio es obligatorio.',
            'folio.unique' => 'El folio ya ha sido registrado.',
            'id_municipio.required' => '',
            'id_municipio.exists' => 'El municipio seleccionado no es válido.',
            'id_parque.required' => 'Parque/Bosque es obligatorio.',
            'id_parque.exists' => 'El parque seleccionado no es válido.',
            'id_user.required' => 'El usuario es obligatorio.',
            'id_user.exists' => 'El usuario seleccionado no es válido.',
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado debe ser "Activo" o "Inactivo".',
            'actividad.required' => 'El tipo es obligatorio.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.min' => 'La descripción debe tener al menos 5 caracteres.',
        ]);

        // Guardar las imágenes base64
        $imagePaths = [];

        if ($request->has('imagenes')) {
            foreach ($request->imagenes as $imageBase64) {
                // Extraer el contenido base64 y decodificar
                $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageBase64));

                if ($image === false) {
                    return response()->json(['message' => 'Imagen base64 inválida'], 400);
                }

                // Generar un nombre único para la imagen
                $imageName = uniqid() . '.jpeg';

                // Guardar la imagen en el almacenamiento y obtener la URL pública
                $path = Storage::put("public/infraestructuraReport/{$validated['folio']}/{$imageName}", $image);

                if ($path) {
                    // Obtener la URL pública de la imagen
                    $url = Storage::url("public/infraestructuraReport/{$validated['folio']}/{$imageName}");
                    // Almacenar la URL de la imagen
                    $imagePaths[] = $url;
                } else {
                    return response()->json(['message' => 'Error al guardar la imagen'], 500);
                }
            }
        }

        // Crear una nueva incidencia en la base de datos
        $incidencia = new Incidencia_mantenimiento_infraestructura();
        $incidencia->folio = $validated['folio'];
        $incidencia->id_municipio = $validated['id_municipio'];
        $incidencia->id_parque = $validated['id_parque'];
        $incidencia->id_user = $validated['id_user'];
        $incidencia->estado = $validated['estado'];
        $incidencia->actividad = $validated['actividad'];
        $incidencia->descripcion = $validated['descripcion'];

        // Almacenar las URLs de las imágenes en formato JSON
        if (!empty($imagePaths)) {
            $incidencia->imagenes = json_encode($imagePaths);
        }

        // Guardar la incidencia
        if ($incidencia->save()) {
            return response()->json(['message' => 'Incidencia guardada correctamente', 'incidencia' => $incidencia], 201);
        } else {
            return response()->json(['message' => 'Error al guardar la incidencia'], 500);
        }
    }



    public function getLastFolio()
    {
        $lastFolio = DB::table('Incidencia_mantenimiento_infraestructuras')->max('folio');
        return response()->json([$lastFolio]);
    }
}