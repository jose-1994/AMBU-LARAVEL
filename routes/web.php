<?php

use App\Http\Controllers\LimpiezaParquesController;
use App\Http\Controllers\ParquesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IncidenciaFaunaController;
use App\Http\Controllers\SanitariasController;
use App\Http\Controllers\InfraestructuraController;
use App\Http\Controllers\ForestalController;
use App\Http\Controllers\FaunaController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return view('welcome');
});


Route::post('/guardar', [App\Http\Controllers\IncidenciasController::class, 'guardar'])->name('guardar');
Route::post('/fauna', [App\Http\Controllers\IncidenciasController::class, 'fauna'])->name('fauna');
Route::post('/seguridad', [App\Http\Controllers\IncidenciasController::class, 'seguridad'])->name('seguridad');
Route::post('/forestal', [App\Http\Controllers\IncidenciasController::class, 'forestal'])->name('forestal');
Route::post('/sanitarios', [App\Http\Controllers\IncidenciasController::class, 'sanitarios'])->name('sanitarios');


Route::get('/incidencias', 'App\Http\Controllers\IncidenciasController@mostrar');

//ruta para ver los datos de la tabla incidencia_faunas
Route::get('/obtenerIncidenciasFaunaConRelaciones', 'App\Http\Controllers\FaunaController@obtenerIncidenciasFaunaConRelaciones');
// Ruta para obtener una incidencia específica por ID
Route::get('obtenerIncidenciasFaunaConRelaciones/incidencias/{id}', [FaunaController::class, 'obtenerIncidenciaFaunaPorId']);

//ruta para ver los datos de la tabla incidencia_sanitarios
Route::get('/obtenerIncidenciasSanitariasConRelaciones', 'App\Http\Controllers\SanitariasController@obtenerIncidenciasSanitariasConRelaciones');
// Ruta para obtener una incidencia específica por ID
Route::get('/obtenerIncidenciaSanitariaPorId/{id}', 'App\Http\Controllers\SanitariasController@obtenerIncidenciaSanitariaPorId');

// Ruta para ver los datos de la tabla incidencia_mantenimiento_infraestructuras
Route::get('/obtenerIncidenciasInfraestructuraConRelaciones', 'App\Http\Controllers\InfraestructuraController@obtenerIncidenciasInfraestructuraConRelaciones');
// Ruta para obtener una incidencia específica por ID
Route::get('/obtenerIncidenciasInfraestructuraConRelaciones/incidencias/{id}', 'App\Http\Controllers\InfraestructuraController@obtenerIncidenciaInfraestructuraPorId');

// Ruta para ver los datos de la tabla incidencia_mantenimiento_forestals
Route::get('/obtenerIncidenciasForestalConRelaciones', 'App\Http\Controllers\ForestalController@obtenerMantenimientoForestal');
// Ruta para obtener una incidencia específica por ID
Route::get('/obtenerIncidenciasForestalConRelaciones/incidencias/{id}', 'App\Http\Controllers\ForestalController@obtenerMantenimientoForestalPorId');

// Ruta para ver los datos de la tabla incidencia_cinema
Route::get('/obtenerIncidenciasCinemaConRelaciones', 'App\Http\Controllers\CinemaController@obtenerIncidenciasCinemaConRelaciones');
// Ruta para obtener una incidencia específica por ID
Route::get('/obtenerIncidenciasCinemaConRelaciones/incidencias/{id}', 'App\Http\Controllers\CinemaController@obtenerIncidenciaCinemaPorId');

// Ruta para ver los datos de la tabla incidencia_concesionarios
Route::get('/obtenerIncidenciasConcesionariosConRelaciones', 'App\Http\Controllers\ConcesionariosController@obtenerIncidenciasConcesionariosConRelaciones');
// Ruta para obtener una incidencia específica por ID
Route::get('/obtenerIncidenciasConcesionariosConRelaciones/incidencias/{id}', 'App\Http\Controllers\ConcesionariosController@obtenerIncidenciaConcesionariosPorId');

// Ruta para ver los datos de la tabla incidencia_jardineria
Route::get('/obtenerIncidenciasJardineriaConRelaciones', 'App\Http\Controllers\JardineriaController@obtenerIncidenciasJardineriaConRelaciones');
// Ruta para obtener una incidencia específica por ID
Route::get('/obtenerIncidenciasJardineriaConRelaciones/incidencias/{id}', 'App\Http\Controllers\JardineriaController@obtenerIncidenciaJardineriaPorId');

// Ruta para ver los datos de la tabla incidencia_limpieza_parques
Route::get('/obtenerIncidenciasLimpiezaParquesConRelaciones', 'App\Http\Controllers\LimpiezaParquesController@obtenerIncidenciasLimpiezaParquesConRelaciones');
// Ruta para obtener una incidencia específica por ID
Route::get('/obtenerIncidenciasLimpiezaParquesConRelaciones/incidencias/{id}', 'App\Http\Controllers\LimpiezaParquesController@obtenerIncidenciaLimpiezaParquesPorId');

// Ruta para ver los datos de la tabla incidencia_puntos_limpios
Route::get('/obtenerIncidenciasPuntosLimpiosConRelaciones', 'App\Http\Controllers\PuntosLimpiosController@obtenerIncidenciasPuntosLimpiosConRelaciones');
// Ruta para obtener una incidencia específica por ID
Route::get('/obtenerIncidenciasPuntosLimpiosConRelaciones/incidencias/{id}', 'App\Http\Controllers\PuntosLimpiosController@obtenerIncidenciaPuntosLimpiosPorId');


// Ruta para ver los datos de la tabla incidencia_seguridad
Route::get('/obtenerIncidenciasSeguridadConRelaciones', 'App\Http\Controllers\SeguridadController@obtenerIncidenciasSeguridadConRelaciones');
// Ruta para obtener una incidencia específica por ID
Route::get('/obtenerIncidenciasSeguridadConRelaciones/incidencias/{id}', 'App\Http\Controllers\SeguridadController@obtenerIncidenciaSeguridadPorId');


Route::get('/mostrar_forestal', 'App\Http\Controllers\IncidenciasController@mostrar_forestal');
Route::get('/mostrar', 'App\Http\Controllers\IncidenciasController@movil');
Route::get('/mostrarid/{id}', 'App\Http\Controllers\IncidenciasController@movilid')->name('mostrarid');




//Extraer las Ubicaciones de parques y municipios
Route::get('/getParques', [ParquesController::class, 'getAllParques']);
Route::get('/getMunicipios', [ParquesController::class, 'getAllMunicipios']);

//Extraer ultimo Folio de las tablas para la incesrcion de nuevos
Route::get('/getFolioInfraestructura', [InfraestructuraController::class, 'getLastFolio']);

Route::get('/getLastFolioForestal', [ForestalController::class, 'getLastFolioForestal']);

Route::get('/getFolioLimpieza', [LimpiezaParquesController::class, 'getLastFolioLimpieza']);



//Rutas para Guardar Incidencias
Route::post('/saveInfraestructuraReport', [InfraestructuraController::class, 'saveReportInfraestructura']);

Route::post('/saveForestalReport', [ForestalController::class, 'saveForestalReport']);

Route::post('/saveLimpiezaReport', [LimpiezaParquesController::class, 'saveLimpiezaReport']);
