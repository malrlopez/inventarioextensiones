<?php

namespace App\Http\Controllers;

use App\Models\Extension;
use App\Models\Empleado;
use App\Models\Sede;
use App\Models\Bloque;
use App\Models\Historial; // Corregido: App con A mayúscula y falta punto y coma

class DashboardController extends Controller
{
    // En app/Http/Controllers/DashboardController.php
    public function index()
    {
        // Variables para el dashboard
        $totalExtensiones = Extension::count(); // Simplificado usando los imports
        $empleadosConExtensiones = Empleado::has('extensiones')->count();
        $totalEmpleados = Empleado::count();
        $sedes = Sede::withCount('ubicaciones')->get();
        $ultimosCambios = Historial::with('extension')->orderBy('fecha_cambio', 'desc')->take(5)->get();
       
        // Intenta con una vista simple primero
        return response()->view('simple', [
            'titulo' => 'Dashboard - Inventario de Extensiones',
            'totalExtensiones' => $totalExtensiones,
            'empleadosConExtensiones' => $empleadosConExtensiones,
            'totalEmpleados' => $totalEmpleados,
            'sedes' => $sedes,
            'ultimosCambios' => $ultimosCambios
        ]);
    }
}