<?php

namespace App\Http\Controllers;

use App\Models\Extension;
use App\Models\Empleado;
use App\Models\Softphone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        try {
            $query = $request->input('query');
            Log::info('Búsqueda iniciada con query: ' . $query);

            if (strlen($query) < 2) {
                return response()->json([]);
            }

            $results = [];

            // Búsqueda segura usando parámetros vinculados
            $searchTerm = '%' . $query . '%';

            // Buscar extensiones
            try {
                $extensiones = Extension::where(function($q) use ($searchTerm) {
                    $q->where(DB::raw('CAST(numero_extension AS CHAR)'), 'LIKE', $searchTerm)
                      ->orWhere('tecnologia', 'LIKE', $searchTerm);
                })->take(5)->get();

                foreach ($extensiones as $extension) {
                    $results[] = [
                        'id' => $extension->id_extension,
                        'text' => "Extensión: {$extension->numero_extension}",
                        'type' => 'extension',
                        'url' => route('extensiones.show', $extension->id_extension)
                    ];
                }
            } catch (\Exception $e) {
                Log::error('Error en búsqueda de extensiones: ' . $e->getMessage());
            }

            // Buscar empleados
            try {
                $empleados = Empleado::where(function($q) use ($searchTerm) {
                    $q->where('nombre', 'LIKE', $searchTerm)
                      ->orWhere('apellido', 'LIKE', $searchTerm)
                      ->orWhere('cedula', 'LIKE', $searchTerm);
                })->take(5)->get();

                foreach ($empleados as $empleado) {
                    $results[] = [
                        'id' => $empleado->id_empleado,
                        'text' => "Empleado: {$empleado->nombre} {$empleado->apellido}",
                        'type' => 'empleado',
                        'url' => route('empleados.show', $empleado->id_empleado)
                    ];
                }
            } catch (\Exception $e) {
                Log::error('Error en búsqueda de empleados: ' . $e->getMessage());
            }

            // Buscar softphones
            try {
                $softphones = Softphone::where(function($q) use ($searchTerm) {
                    $q->where('usuario', 'LIKE', $searchTerm)
                      ->orWhere('dispositivo', 'LIKE', $searchTerm);
                })->take(5)->get();

                foreach ($softphones as $softphone) {
                    $results[] = [
                        'id' => $softphone->id_softphone,
                        'text' => "Softphone: {$softphone->usuario}",
                        'type' => 'softphone',
                        'url' => route('softphones.show', $softphone->id_softphone)
                    ];
                }
            } catch (\Exception $e) {
                Log::error('Error en búsqueda de softphones: ' . $e->getMessage());
            }

            Log::info('Resultados encontrados: ' . count($results));
            return response()->json($results);

        } catch (\Exception $e) {
            Log::error('Error general en la búsqueda: ' . $e->getMessage());
            return response()->json(['error' => 'Error al realizar la búsqueda'], 500);
        }
    }
}
