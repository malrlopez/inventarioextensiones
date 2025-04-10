<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BloqueController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\ExtensionController;
use App\Http\Controllers\RackController;
use App\Http\Controllers\SedeController;
use App\Http\Controllers\SoftphoneController;
use App\Http\Controllers\SwitchEquipoController;
use App\Http\Controllers\UbicacionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\HistorialController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aquí es donde puedes registrar las rutas web para tu aplicación.
|
*/

// Ruta raíz - redirecciona al dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Rutas para los recursos (CRUD)
Route::resource('bloques', BloqueController::class);
Route::resource('cargos', CargoController::class);
Route::resource('empleados', EmpleadoController::class);
Route::resource('extensiones', ExtensionController::class);
Route::resource('historial', HistorialController::class);
Route::resource('racks', RackController::class);
Route::resource('sedes', SedeController::class);
Route::resource('softphones', SoftphoneController::class);
Route::resource('switches-equipos', SwitchEquipoController::class);
Route::resource('ubicaciones', UbicacionController::class);
Route::get('/switches', [SwitchEquipoController::class, 'index'])->name('switches.index');
Route::get('/switches/create', [SwitchEquipoController::class, 'create'])->name('switches.create');
Route::post('/switches', [SwitchEquipoController::class, 'store'])->name('switches.store');
Route::get('/switches/{switchEquipo}', [SwitchEquipoController::class, 'show'])->name('switches.show');
Route::get('/switches/{switchEquipo}/edit', [SwitchEquipoController::class, 'edit'])->name('switches.edit');
Route::put('/switches/{switchEquipo}', [SwitchEquipoController::class, 'update'])->name('switches.update');
Route::delete('/switches/{switchEquipo}', [SwitchEquipoController::class, 'destroy'])->name('switches.destroy');
Route::resource('historial', HistorialController::class);
//Route::redirect('historial-cambios', 'historial', 301);
//Route::redirect('historial-cambios/{any}', 'historial/{any}', 301)->where('any', '.*');

// Ruta para probar la conexión a la base de datos
Route::get('/test-db-connection', [TestController::class, 'testDbConnection'])->name('test.db-connection');

// Ruta temporal para verificar la configuración de la BD
Route::get('/env-test', function () {
    dd([
        'DB_CONNECTION' => env('DB_CONNECTION'),
        'DB_HOST' => env('DB_HOST'),
        'DB_PORT' => env('DB_PORT'),
        'DB_DATABASE' => env('DB_DATABASE'),
        'DB_USERNAME' => env('DB_USERNAME'),
        'DB_PASSWORD' => env('DB_PASSWORD') ? 'Contraseña configurada' : 'Sin contraseña'
    ]);
});