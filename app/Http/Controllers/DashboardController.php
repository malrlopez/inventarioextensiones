<?php

namespace App\Http\Controllers;

use App\Models\Extension;
use App\Models\Empleado;
use App\Models\Sede;
use App\Models\Bloque;
use App\Models\Historial;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // En app/Http/Controllers/DashboardController.php
    public function index()
    {
        // Variables básicas para todos los usuarios
        $totalExtensiones = Extension::count();
        $empleadosConExtensiones = Empleado::has('extensiones')->count();
        $totalEmpleados = Empleado::count();

        // Datos para admin y usuario normal
        $sedes = collect();
        $ultimosCambios = collect();
        $bloques = collect();
        $stats = [];

        // Personalización según el rol del usuario
        if (Auth::user()->role === 'admin') {
            // Administradores ven toda la información
            $sedes = Sede::withCount(['ubicaciones', 'bloques', 'empleados'])->get();
            $ultimosCambios = Historial::with('extension')
                ->orderBy('fecha_cambio', 'desc')
                ->take(5)
                ->get();
            $bloques = Bloque::withCount('ubicaciones')->get();

            // Estadísticas adicionales para admins
            $stats = [
                'porcentajeUso' => $totalEmpleados > 0 ? round(($empleadosConExtensiones / $totalEmpleados) * 100) : 0,
                'extensionesPorSede' => $this->getExtensionesDistribucion(),
                'cambiosRecientes' => Historial::where('created_at', '>=', now()->subDays(7))->count()
            ];
        } elseif (Auth::user()->role === 'user') {
            // Usuarios regulares ven información parcial
            $sedes = Sede::withCount(['ubicaciones', 'bloques', 'empleados'])->get();
            $ultimosCambios = Historial::with('extension')
                ->where('usuario_id', Auth::id())
                ->orderBy('fecha_cambio', 'desc')
                ->take(5)
                ->get();
        } else {
            // Visualizadores solo ven lo básico, las variables ya están inicializadas
        }

        // Renderizar la vista dashboard
        return view('dashboard', [
            'titulo' => 'Dashboard',
            'totalExtensiones' => $totalExtensiones,
            'empleadosConExtensiones' => $empleadosConExtensiones,
            'totalEmpleados' => $totalEmpleados,
            'sedes' => $sedes,
            'ultimosCambios' => $ultimosCambios,
            'bloques' => $bloques,
            'stats' => $stats
        ]);
    }

    /**
     * Obtiene la distribución de extensiones por sede
     */
    private function getExtensionesDistribucion()
    {
        $distribucion = [];
        $sedes = Sede::all();

        foreach ($sedes as $sede) {
            $extensiones = Extension::whereHas('ubicacion.bloque', function ($query) use ($sede) {
                $query->where('id_sede', $sede->id_sede);
            })->count();

            $distribucion[$sede->nombre] = $extensiones;
        }

        return $distribucion;
    }
}
