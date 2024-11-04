<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registro_incidencias;
use App\Models\Incidencia_mantenimiento_infraestructura;
use App\Models\Incidencia_fauna;
use App\Models\Incidencia_seguridad;
use App\Models\Incidencia_mantenimiento_forestal;
use App\Models\Incidencia_sanitarios;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Registro;


class IncidenciasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * ------------------------------------------------------------------------------------------------------------------------------------
     */

     public function mostrar()
    {
        $mostrar=Incidencia_mantenimiento_infraestructura::all();

        $nombrePersonalizado = 'incidencias';  // Puedes cambiar este nombre según tus preferencias
        $response = [
            $nombrePersonalizado => $mostrar
        ];
        return response()->json($response);
    }
    public function mostrar_fauna()
    {
        $mostrar=Incidencia_fauna::all();

        $nombrePersonalizado = 'incidencias';  // Puedes cambiar este nombre según tus preferencias
        $response = [
            $nombrePersonalizado => $mostrar
        ];
        return response()->json($response);
    }

/**
     * ------------------------------------------------------------------------------------------------------------------------------------
     */
    public function mostrar_forestal()
    {
        $mostrar=Incidencia_mantenimiento_forestal::all();

        $nombrePersonalizado = 'incidencias';  // Puedes cambiar este nombre según tus preferencias
        $response = [
            $nombrePersonalizado => $mostrar
        ];
        return response()->json($response);
    }

    /**
     * ------------------------------------------------------------------------------------------------------------------------------------
     */

    public function movil()
    {
        $mostrar=Incidencia_mantenimiento_infraestructura::all();

        $nombrePersonalizado = 'incidencias';  // Puedes cambiar este nombre según tus preferencias
        $response = [
            $nombrePersonalizado => $mostrar
        ];
        return response()->json($response);
    }

    /**
     * ------------------------------------------------------------------------------------------------------------------------------------
     */


    public function movilid(string $id)
    {
        $registro=Incidencia_mantenimiento_infraestructura::where('id', '=', $id)->get();
        
        
        return response()->json($registro);
    }

    /**
     * ------------------------------------------------------------------------------------------------------------------------------------
     */


    public function guardar(Request $request)
    {
       // \Log::info('Contenido del cuerpo de la solicitud:', [$request->getContent()]);
    
        // Extraer el contenido del cuerpo de la solicitud
        $cuerpo = $request->getContent();
    
        // Intentar corregir la codificación UTF-8 si es necesario
        if (!mb_check_encoding($cuerpo, 'UTF-8')) {
            $cuerpo = utf8_encode($cuerpo);
        }
    
        // Decodificar el JSON
        $datos = json_decode($cuerpo, true);
    
        if (json_last_error() !== JSON_ERROR_NONE) {
            \Log::error('Error al decodificar JSON:', ['error' => json_last_error_msg()]);
            return response()->json(['message' => 'Formato de JSON inválido'], 400);
        }
    
       // \Log::info('Datos decodificados:', $datos);
    
        // Validar los datos decodificados
        $camposRequeridos = ['Parque', 'Municipio', 'Nombre', 'Tipo', 'Tipo_incidencia', 'Descripcion'];
        foreach ($camposRequeridos as $campo) {
            if (!isset($datos[$campo])) {
                return response()->json(['message' => 'Faltan datos requeridos'], 400);
            }
        }
    
        $guardar = new Incidencia_mantenimiento_infraestructura();
    
        // Manejar la imagen base64
        if (isset($datos['Imagen'])) {
            $base64Image = $datos['Imagen'];
            $image = base64_decode($base64Image);
    
            if ($image === false) {
                return response()->json(['message' => 'Imagen base64 inválida'], 400);
            }
    
            // Crear un nombre único para la imagen
            $imgnombre = time() . '.png';
    
            // Ruta donde se guardará la imagen
            $url = 'imagenes/';
            $path = public_path($url . $imgnombre);
    
            // Guardar la imagen decodificada en el servidor
            file_put_contents($path, $image);
    
            // Asignar la ruta de la imagen al modelo
            $guardar->Imagen = $url . $imgnombre;
        }
    
        $guardar->Parque = $datos['Parque'];
        $guardar->Municipio = $datos['Municipio'];
        $guardar->Nombre = $datos['Nombre'];
        $guardar->Tipo = $datos['Tipo'];
        $guardar->Tipo_incidencia = $datos['Tipo_incidencia'];
        $guardar->Descripcion = $datos['Descripcion'];
        $guardar->Estado = "Activo";
        $guardar->save();
    
        return response()->json(['message' => 'Guardado exitoso'], 200);
    }
    

    
    /**
     * ------------------------------------------------------------------------------------------------------------------------------------
     */


     public function fauna(Request $request)
     {
         \Log::info('Contenido del cuerpo de la solicitud:', [$request->getContent()]);
     
         // Extraer el contenido del cuerpo de la solicitud
         $cuerpo = $request->getContent();
     
         // Intentar corregir la codificación UTF-8 si es necesario
         if (!mb_check_encoding($cuerpo, 'UTF-8')) {
             $cuerpo = utf8_encode($cuerpo);
         }
     
         // Decodificar el JSON
         $datos = json_decode($cuerpo, true);
     
         if (json_last_error() !== JSON_ERROR_NONE) {
             \Log::error('Error al decodificar JSON:', ['error' => json_last_error_msg()]);
             return response()->json(['message' => 'Formato de JSON inválido'], 400);
         }
     
         \Log::info('Datos decodificados:', $datos);
     
         // Validar los datos decodificados
         $camposRequeridos = ['Parque', 'Municipio', 'Ubicacion','Agente', 'Tipo', 'Especie','Condicion','Tamano', 'Descripcion','Riesgo'];
         foreach ($camposRequeridos as $campo) {
             if (!isset($datos[$campo])) {
                 return response()->json(['message' => 'Faltan datos requeridos'], 400);
             }
         }
     
         $guardar = new Incidencia_fauna();
     
         // Manejar la imagen base64
         if (isset($datos['Imagen'])) {
             $base64Image = $datos['Imagen'];
             $image = base64_decode($base64Image);
     
             if ($image === false) {
                 return response()->json(['message' => 'Imagen base64 inválida'], 400);
             }
     
             // Crear un nombre único para la imagen
             $imgnombre = time() . '.png';
     
             // Ruta donde se guardará la imagen
             $url = 'imagenes/';
             $path = public_path($url . $imgnombre);
     
             // Guardar la imagen decodificada en el servidor
             file_put_contents($path, $image);
     
             // Asignar la ruta de la imagen al modelo
             $guardar->Imagen = $url . $imgnombre;
         }
     
         $guardar->Parque = $datos['Parque'];
         $guardar->Municipio = $datos['Municipio'];
         $guardar->Ubicacion = $datos['Ubicacion'];
         $guardar->Agente = $datos['Agente'];
         $guardar->Tipo = $datos['Tipo'];
         $guardar->Especie = $datos['Especie'];
         $guardar->Condicion = $datos['Condicion'];
         $guardar->Tamano = $datos['Tamano'];
         $guardar->Descripcion = $datos['Descripcion'];
         $guardar->Riesgo = $datos['Riesgo'];
         $guardar->Estado = "Activo";
         $guardar->save();
     
         return response()->json(['message' => 'Guardado exitoso'], 200);
     }
     
 
     
     /**
      * ------------------------------------------------------------------------------------------------------------------------------------
      */

      public function seguridad(Request $request)
     {
        // \Log::info('Contenido del cuerpo de la solicitud:', [$request->getContent()]);
     
         // Extraer el contenido del cuerpo de la solicitud
         $cuerpo = $request->getContent();
     
         // Intentar corregir la codificación UTF-8 si es necesario
         if (!mb_check_encoding($cuerpo, 'UTF-8')) {
             $cuerpo = utf8_encode($cuerpo);
         }
     
         // Decodificar el JSON
         $datos = json_decode($cuerpo, true);
     
         if (json_last_error() !== JSON_ERROR_NONE) {
             \Log::error('Error al decodificar JSON:', ['error' => json_last_error_msg()]);
             return response()->json(['message' => 'Formato de JSON inválido'], 400);
         }
     
        // \Log::info('Datos decodificados:', $datos);
     
         // Validar los datos decodificados
         $camposRequeridos = ['Parque', 'Municipio', 'Nombre','Observaciones', 'Media', 'Tipo', 'Actividad','Arma','Transporte', 'Hora','Llamada','Numero'];
         foreach ($camposRequeridos as $campo) {
             if (!isset($datos[$campo])) {
                 return response()->json(['message' => 'Faltan datos requeridos'], 400);
             }
         }
     
         $guardar = new Incidencia_seguridad();
     
         // Manejar la imagen base64
         if (isset($datos['Imagen'])) {
             $base64Image = $datos['Imagen'];
             $image = base64_decode($base64Image);
     
             if ($image === false) {
                 return response()->json(['message' => 'Imagen base64 inválida'], 400);
             }
     
             // Crear un nombre único para la imagen
             $imgnombre = time() . '.png';
     
             // Ruta donde se guardará la imagen
             $url = 'imagenes/';
             $path = public_path($url . $imgnombre);
     
             // Guardar la imagen decodificada en el servidor
             file_put_contents($path, $image);
     
             // Asignar la ruta de la imagen al modelo
             $guardar->Imagen = $url . $imgnombre;
         }
     
         $guardar->Parque = $datos['Parque'];
         $guardar->Municipio = $datos['Municipio'];
         $guardar->Nombre = $datos['Nombre'];
         $guardar->Observaciones = $datos['Observaciones'];
         $guardar->Media = $datos['Media'];
         $guardar->Tipo = $datos['Tipo'];
         $guardar->Actividad = $datos['Actividad'];
         $guardar->Arma = $datos['Arma'];
         $guardar->Transporte = $datos['Transporte'];
         $guardar->Hora = $datos['Hora'];
         $guardar->Llamada = $datos['Llamada'];
         $guardar->Numero = $datos['Numero'];
         $guardar->Estado = "Activo";
         $guardar->save();
     
         return response()->json(['message' => 'Guardado exitoso'], 200);
     }
     
 
     
     /**
      * ------------------------------------------------------------------------------------------------------------------------------------
      */


      public function forestal(Request $request)
      {
         // \Log::info('Contenido del cuerpo de la solicitud:', [$request->getContent()]);
      
          // Extraer el contenido del cuerpo de la solicitud
          $cuerpo = $request->getContent();
      
          // Intentar corregir la codificación UTF-8 si es necesario
          if (!mb_check_encoding($cuerpo, 'UTF-8')) {
              $cuerpo = utf8_encode($cuerpo);
          }
      
          // Decodificar el JSON
          $datos = json_decode($cuerpo, true);
      
          if (json_last_error() !== JSON_ERROR_NONE) {
              \Log::error('Error al decodificar JSON:', ['error' => json_last_error_msg()]);
              return response()->json(['message' => 'Formato de JSON inválido'], 400);
          }
      
         // \Log::info('Datos decodificados:', $datos);
      
          // Validar los datos decodificados
          $camposRequeridos = ['Parque', 'Municipio', 'Nombre','Folio', 'Tipo', 'Descripcion'];
          foreach ($camposRequeridos as $campo) {
              if (!isset($datos[$campo])) {
                  return response()->json(['message' => 'Faltan datos requeridos'], 400);
              }
          }
      
          $guardar = new Incidencia_mantenimiento_forestal();
      
          // Manejar la imagen base64
          if (isset($datos['Imagen'])) {
              $base64Image = $datos['Imagen'];
              $image = base64_decode($base64Image);
      
              if ($image === false) {
                  return response()->json(['message' => 'Imagen base64 inválida'], 400);
              }
      
              // Crear un nombre único para la imagen
              $imgnombre = time() . '.png';
      
              // Ruta donde se guardará la imagen
              $url = 'imagenes/';
              $path = public_path($url . $imgnombre);
      
              // Guardar la imagen decodificada en el servidor
              file_put_contents($path, $image);
      
              // Asignar la ruta de la imagen al modelo
              $guardar->Imagen = $url . $imgnombre;
          }
      
          $guardar->Parque = $datos['Parque'];
          $guardar->Municipio = $datos['Municipio'];
          $guardar->Nombre = $datos['Nombre'];
          $guardar->Folio = $datos['Folio'];
          $guardar->Tipo = $datos['Tipo'];
          $guardar->Descripcion = $datos['Descripcion'];
          $guardar->Estado = "Activo";
          $guardar->save();
      
          return response()->json(['message' => 'Guardado exitoso'], 200);
      }
      
  
      
      /**
       * ------------------------------------------------------------------------------------------------------------------------------------
       */


       public function sanitarios(Request $request)
       {
          // \Log::info('Contenido del cuerpo de la solicitud:', [$request->getContent()]);
       
           // Extraer el contenido del cuerpo de la solicitud
           $cuerpo = $request->getContent();
       
           // Intentar corregir la codificación UTF-8 si es necesario
           if (!mb_check_encoding($cuerpo, 'UTF-8')) {
               $cuerpo = utf8_encode($cuerpo);
           }
       
           // Decodificar el JSON
           $datos = json_decode($cuerpo, true);
       
           if (json_last_error() !== JSON_ERROR_NONE) {
               \Log::error('Error al decodificar JSON:', ['error' => json_last_error_msg()]);
               return response()->json(['message' => 'Formato de JSON inválido'], 400);
           }
       
          // \Log::info('Datos decodificados:', $datos);
       
           // Validar los datos decodificados
           $camposRequeridos = ['Parque', 'Nombre','Solicitud', 'Descripcion'];
           foreach ($camposRequeridos as $campo) {
               if (!isset($datos[$campo])) {
                   return response()->json(['message' => 'Faltan datos requeridos'], 400);
               }
           }
       
           $guardar = new Incidencia_sanitarios();
       
           // Manejar la imagen base64
           if (isset($datos['Imagen'])) {
               $base64Image = $datos['Imagen'];
               $image = base64_decode($base64Image);
       
               if ($image === false) {
                   return response()->json(['message' => 'Imagen base64 inválida'], 400);
               }
       
               // Crear un nombre único para la imagen
               $imgnombre = time() . '.png';
       
               // Ruta donde se guardará la imagen
               $url = 'imagenes/';
               $path = public_path($url . $imgnombre);
       
               // Guardar la imagen decodificada en el servidor
               file_put_contents($path, $image);
       
               // Asignar la ruta de la imagen al modelo
               $guardar->Imagen = $url . $imgnombre;
           }
       
           $guardar->Parque = $datos['Parque'];
           $guardar->Nombre = $datos['Nombre'];
           $guardar->Solicitud = $datos['Solicitud'];
           $guardar->Descripcion = $datos['Descripcion'];
           $guardar->Estado = "Activo";
           $guardar->save();
       
           return response()->json(['message' => 'Guardado exitoso'], 200);
       }
       
   
       
       /**
        * ------------------------------------------------------------------------------------------------------------------------------------
        */

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
