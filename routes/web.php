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
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ReporteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aquí es donde puedes registrar las rutas web para tu aplicación.
|
*/

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Rutas de registro (temporalmente accesibles para todos los usuarios autenticados)
Route::middleware(['auth'])->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Ruta raíz - redirecciona al dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Rutas protegidas que requieren autenticación
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rutas para los reportes (accesibles para todos los usuarios autenticados)
    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
    Route::match(['get', 'post'], '/reportes/generar', [ReporteController::class, 'generar'])->name('reportes.generar');

    // Ruta para el buscador (debe ir antes de las rutas de recursos)
    Route::get('/search', [SearchController::class, 'search'])->name('search');

    // Rutas para los recursos (CRUD)
    Route::resource('bloques', BloqueController::class);
    Route::resource('cargos', CargoController::class);
    Route::resource('empleados', EmpleadoController::class);
    Route::get('/empleados/buscar/documento', [EmpleadoController::class, 'buscarPorDocumento'])->name('empleados.buscar');
    Route::resource('extensiones', ExtensionController::class);
    Route::resource('historial', HistorialController::class)->only(['index', 'show']);
    Route::resource('racks', RackController::class);
    Route::resource('sedes', SedeController::class);
    Route::resource('softphones', SoftphoneController::class);
    Route::resource('ubicaciones', UbicacionController::class);

    // Rutas para SwitchEquipo con nombre más amigable "switches"
    Route::resource('switches', SwitchEquipoController::class, ['parameters' => ['switches' => 'switchEquipo']]);
});

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
