<?php

namespace App\Http\Controllers;
use App\Models\Incidencia_limpieza_del_parque;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Storage;

class LimpiezaParquesController extends Controller
{
    public function obtenerIncidenciasLimpiezaParquesConRelaciones()
    {
        $incidencias = DB::table('incidencia_limpieza_parques')
            ->join('municipios', 'incidencia_limpieza_parques.id_municipio', '=', 'municipios.id')
            ->join('parques', 'incidencia_limpieza_parques.id_parque', '=', 'parques.id')
            ->join('users', 'incidencia_limpieza_parques.id_user', '=', 'users.id')
            ->select(
                'incidencia_limpieza_parques.*',
                'municipios.NombreMunicipio',
                'parques.NombreParque',
                'users.name'
            )
            ->get();

        return response()->json(['incidencias' => $incidencias]);
    }

    public function obtenerIncidenciaLimpiezaParquesPorId($id)
    {
        DB::enableQueryLog();
        Log::info("ID recibido: " . $id);

        $incidencia = DB::table('incidencia_limpieza_parques')
            ->leftJoin('municipios', 'incidencia_limpieza_parques.id_municipio', '=', 'municipios.id')
            ->leftJoin('parques', 'incidencia_limpieza_parques.id_parque', '=', 'parques.id')
            ->leftJoin('users', 'incidencia_limpieza_parques.id_user', '=', 'users.id')
            ->select(
                'incidencia_limpieza_parques.*',
                'municipios.NombreMunicipio',
                'parques.NombreParque',
                'users.name as NombreUsuario',
                'users.email as EmailUsuario',
                'users.Apellidos as ApellidosUsuario',
                'users.NumeroEmpleado'
            )
            ->where('incidencia_limpieza_parques.id', $id)
            ->first();

        Log::info(DB::getQueryLog());

        if ($incidencia) {
            return response()->json($incidencia);
        } else {
            return response()->json(['error' => 'Incidencia no encontrada'], 404);
        }
    }

    public function getLastFolioLimpieza()
    {
        $lastFolio = DB::table('incidencia_limpieza_parques')->max('folio');
        return response()->json($lastFolio);
    }

    public function saveLimpiezaReport(Request $request)
    {

        //Validar los datos de entrada con mensajes personalizados, incluyendo tipo
        $validated = $request->validate([
            'folio' => 'required|unique:incidencia_limpieza_parques',
            'id_municipio' => 'required|integer|exists:municipios,id',
            'id_parque' => 'required|integer|exists:parques,id',
            'id_user' => 'required|integer|exists:users,id',
            'tipo' => 'required|string',
            'descripcion' => 'required|string|min:5',
            'imagenes.*' => 'nullable|string|starts_with:data:image/',
            'estado' => 'required|string|in:Activo,Inactivo',
        ], [
            'folio.required' => 'El folio es obligatorio.',
            'folio.unique' => 'El folio ya ha sido registrado.',
            'id_municipio.required' => '',
            'id_municipio.exists' => 'El municipio seleccionado no es válido.',
            'id_parque.required' => 'Parque/Bosque es obligatorio.',
            'id_parque.exists' => 'El parque seleccionado no es válido.',
            'id_user.required' => 'El usuario es obligatorio.',
            'id_user.exists' => 'El usuario seleccionado no es válido.',
            'tipo.required' => 'El tipo es obligatorio.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.min' => 'La descripción debe tener al menos 5 caracteres.',
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado debe ser "Activo" o "Inactivo".',
        ]);

        //Guardar las imagenes en base64
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
                $path = Storage::put("public/LimpiezaParque/{$validated['folio']}/{$imageName}", $image);

                if ($path) {
                    // Obtener la URL pública de la imagen
                    $url = Storage::url("public/LimpiezaParque/{$validated['folio']}/{$imageName}");
                    // Almacenar la URL de la imagen
                    $imagePaths[] = $url;
                } else {
                    return response()->json(['message' => 'Error al guardar la imagen'], 500);
                }
            }

            $incidencia = new Incidencia_limpieza_del_parque();
            $incidencia->folio = $validated['folio'];
            $incidencia->id_municipio = $validated['id_municipio'];
            $incidencia->id_parque = $validated['id_parque'];
            $incidencia->id_user = $validated['id_user'];
            $incidencia->tipo = $validated['tipo'];
            $incidencia->descripcion = $validated['descripcion'];
            $incidencia->estado = $validated['estado'];

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


    }
}
