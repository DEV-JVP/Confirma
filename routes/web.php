<?php
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\ComunidadController;
use Illuminate\Support\Facades\Route;

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

Route::resource('personas', PersonaController::class);

Route::resource('asistencias', AsistenciaController::class)->except(['show']);



// Rutas adicionales para funcionalidades específicas
Route::post('/asistencias/fecha', [AsistenciaController::class, 'storeFecha'])->name('asistencias.storeFecha');
Route::post('/asistencias/toggle', [AsistenciaController::class, 'toggle'])->name('asistencias.toggle');
Route::post('/asistencias/toggle-all', [AsistenciaController::class, 'toggleAll'])->name('asistencias.toggleAll');
Route::get('/asistencias-reporte', [AsistenciaController::class, 'reporte'])->name('asistencias.reporte');
Route::get('/asistencias-exportar', [AsistenciaController::class, 'exportar'])->name('asistencias.exportar');
Route::get('/asistencias/resumen', [AsistenciaController::class, 'resumen'])->name('asistencias.resumen');
Route::post('/asistencias/guardar', [AsistenciaController::class, 'guardar'])->name('asistencias.guardar');


Route::get('/comunidades', [ComunidadController::class, 'index'])->name('comunidades.index');
Route::post('/comunidades', [ComunidadController::class, 'store'])->name('comunidades.store');
Route::get('/comunidades/listado', [ComunidadController::class, 'listado'])->name('comunidades.listado');
Route::delete('/comunidades/{id}', [ComunidadController::class, 'destroy'])->name('comunidades.destroy');



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
