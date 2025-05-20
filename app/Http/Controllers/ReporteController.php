<?php

namespace App\Http\Controllers;

use App\Models\Softphone;
use App\Models\Extension;
use App\Models\Dispositivo;
use App\Models\Sede;
use App\Models\Bloque;
use App\Models\Ubicacion;
use App\Models\Empleado;
use App\Models\SwitchEquipo;
use App\Models\Rack;
use App\Exports\SoftphonesExport;
use App\Exports\ExtensionesExport;
use App\Exports\DispositivosExport;
use App\Exports\ReporteConsolidadoExport;
use App\Exports\EmpleadosExport;
use App\Exports\UbicacionesExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReporteController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']); // Permitir a todos los usuarios autenticados
    }

    public function index()
    {
        // Obtener datos para los selectores
        $sedes = Sede::orderBy('nombre', 'asc')->pluck('nombre', 'id');
        $bloques = Bloque::orderBy('nombre', 'asc')->pluck('nombre', 'id');
        $ubicaciones = Ubicacion::orderBy('nombre', 'asc')->pluck('nombre', 'id');
        $empleados = Empleado::orderBy('nombre', 'asc')->pluck('nombre', 'id');

        return view('reportes.index', compact('sedes', 'bloques', 'ubicaciones', 'empleados'));
    }

    public function generar(Request $request)
    {
        try {
            // Validar los campos requeridos
            $validated = $request->validate([
                'tipo' => 'required|in:softphones,extensiones,dispositivos,consolidado,empleados,ubicaciones,por_sede,estadisticas',
                'formato' => 'required|in:excel,csv,html',
                'fecha_inicio' => 'nullable|date',
                'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
                'sede_id' => 'nullable|exists:sedes,id',
                'bloque_id' => 'nullable|exists:bloques,id',
                'ubicacion_id' => 'nullable|exists:ubicaciones,id',
                'empleado_id' => 'nullable|exists:empleados,id',
                'estado' => 'nullable|string',
            ], [
                'tipo.required' => 'El tipo de reporte es obligatorio.',
                'tipo.in' => 'El tipo de reporte seleccionado no es válido.',
                'formato.required' => 'El formato de exportación es obligatorio.',
                'formato.in' => 'El formato de exportación seleccionado no es válido.',
                'fecha_inicio.date' => 'La fecha de inicio debe ser una fecha válida.',
                'fecha_fin.date' => 'La fecha fin debe ser una fecha válida.',
                'fecha_fin.after_or_equal' => 'La fecha fin debe ser posterior o igual a la fecha de inicio.',
            ]);

            $tipo = $request->tipo;
            $formato = $request->formato;

            // Procesamiento de fechas
            if ($request->usar_periodo && $request->periodo) {
                list($fechaInicio, $fechaFin) = $this->obtenerRangoFechasPeriodo($request->periodo);
            } else {
                $fechaInicio = $request->fecha_inicio ? Carbon::parse($request->fecha_inicio)->startOfDay() : null;
                $fechaFin = $request->fecha_fin ? Carbon::parse($request->fecha_fin)->endOfDay() : null;
            }

            // Obtener los datos según el tipo de reporte aplicando los filtros
            $datos = $this->obtenerDatosFiltrados($tipo, $request, $fechaInicio, $fechaFin);

            if ($datos->isEmpty()) {
                return back()->with('warning', 'No se encontraron datos para generar el reporte con los filtros seleccionados.');
            }

            // Si es un reporte de estadísticas y el formato es HTML, mostrar la vista con gráficos
            if ($tipo === 'estadisticas' && $formato === 'html') {
                return $this->generarEstadisticas($datos, $request);
            }

            // Determinar los campos y encabezados para el reporte
            [$campos, $encabezados] = $this->determinarCampos($datos);

            // Guardar información sobre el reporte generado
            $this->guardarHistorialReporte($tipo, $formato, $request);

            // Generar el reporte según el formato seleccionado
            $filename = $this->obtenerTituloReporte($tipo) . '_' . date('Ymd_His');
            $titulo = $this->obtenerTituloReporte($tipo);

            if ($formato === 'excel') {
                return $this->generarExcel($datos, $tipo, $filename, $titulo, $campos, $encabezados);
            } elseif ($formato === 'csv') {
                return $this->generarCSV($datos, $tipo, $filename, $titulo, $campos, $encabezados);
            } else {
                return $this->generarHTML($datos, $tipo, $titulo, $request);
            }
        } catch (Exception $e) {
            Log::error('Error al generar reporte: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return back()->with('error', 'Ocurrió un error al generar el reporte: ' . $e->getMessage());
        }
    }

    private function obtenerRangoFechasPeriodo($periodo)
    {
        $ahora = Carbon::now();

        return match($periodo) {
            'hoy' => [Carbon::today(), Carbon::today()->endOfDay()],
            'ayer' => [Carbon::yesterday(), Carbon::yesterday()->endOfDay()],
            'semana_actual' => [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()],
            'semana_anterior' => [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()],
            'mes_actual' => [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()],
            'mes_anterior' => [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()],
            'año_actual' => [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()],
            default => [null, null]
        };
    }

    private function obtenerDatosFiltrados($tipo, $request, $fechaInicio, $fechaFin)
    {
        $query = $this->inicializarConsulta($tipo);

        // Aplicar filtros de fecha si existen
        if ($fechaInicio && $fechaFin) {
            $query->whereBetween('created_at', [$fechaInicio, $fechaFin]);
        }

        // Aplicar filtro de sede
        if ($request->sede_id) {
            $this->aplicarFiltroSede($query, $tipo, $request->sede_id);
        }

        // Aplicar filtro de bloque
        if ($request->bloque_id) {
            $this->aplicarFiltroBloque($query, $tipo, $request->bloque_id);
        }

        // Aplicar filtro de ubicación
        if ($request->ubicacion_id) {
            $this->aplicarFiltroUbicacion($query, $tipo, $request->ubicacion_id);
        }

        // Aplicar filtro de empleado
        if ($request->empleado_id) {
            $this->aplicarFiltroEmpleado($query, $tipo, $request->empleado_id);
        }

        // Aplicar filtro de estado
        if ($request->estado) {
            $query->where('estado', $request->estado);
        }

        // Aplicar filtros adicionales
        if ($request->filtros) {
            foreach ($request->filtros as $campo => $valor) {
                if ($valor) {
                    $query->where($campo, 'LIKE', "%{$valor}%");
                }
            }
        }

        return $query->get();
    }

    private function inicializarConsulta($tipo)
    {
        return match($tipo) {
            'softphones' => Softphone::with(['empleado.sede']),
            'extensiones' => Extension::with(['empleado.sede']),
            'dispositivos' => Dispositivo::with(['empleado.sede']),
            'empleados' => Empleado::with(['sede', 'cargo']),
            'ubicaciones' => Ubicacion::with(['sede', 'bloque']),
            'por_sede' => Sede::with(['ubicaciones', 'empleados']),
            'estadisticas' => Dispositivo::with(['empleado.sede']),
            'consolidado' => DB::table('softphones')
                ->join('empleados', 'softphones.empleado_id', '=', 'empleados.id')
                ->join('sedes', 'empleados.id_sede', '=', 'sedes.id_sede')
                ->select('sedes.nombre as sede', DB::raw('NULL as ubicacion'), 'empleados.nombre as empleado', 'softphones.numero as numero'),
            default => abort(404, 'Tipo de reporte no válido')
        };
    }

    private function aplicarFiltroSede($query, $tipo, $sedeId)
    {
        switch ($tipo) {
            case 'softphones':
            case 'extensiones':
            case 'dispositivos':
                $query->whereHas('empleado.sede', function($q) use ($sedeId) {
                    $q->where('id_sede', $sedeId);
                });
                break;
            case 'empleados':
                $query->whereHas('sede', function($q) use ($sedeId) {
                    $q->where('id_sede', $sedeId);
                });
                break;
            case 'ubicaciones':
                $query->where('sede_id', $sedeId);
                break;
            case 'por_sede':
                $query->where('id', $sedeId);
                break;
            case 'estadisticas':
                $query->whereHas('empleado.sede', function($q) use ($sedeId) {
                    $q->where('id_sede', $sedeId);
                });
                break;
            case 'consolidado':
                $query->where('sedes.id_sede', $sedeId);
                break;
        }
    }

    private function aplicarFiltroBloque($query, $tipo, $bloqueId)
    {
        switch ($tipo) {
            case 'softphones':
            case 'extensiones':
            case 'dispositivos':
                $query->whereHas('empleado.ubicacion', function($q) use ($bloqueId) {
                    $q->where('bloque_id', $bloqueId);
                });
                break;
            case 'empleados':
                $query->whereHas('ubicacion', function($q) use ($bloqueId) {
                    $q->where('bloque_id', $bloqueId);
                });
                break;
            case 'ubicaciones':
                $query->where('bloque_id', $bloqueId);
                break;
        }
    }

    private function aplicarFiltroUbicacion($query, $tipo, $ubicacionId)
    {
        switch ($tipo) {
            case 'softphones':
            case 'extensiones':
            case 'dispositivos':
                $query->whereHas('empleado', function($q) use ($ubicacionId) {
                    $q->where('ubicacion_id', $ubicacionId);
                });
                break;
            case 'empleados':
                $query->where('ubicacion_id', $ubicacionId);
                break;
        }
    }

    private function aplicarFiltroEmpleado($query, $tipo, $empleadoId)
    {
        switch ($tipo) {
            case 'softphones':
            case 'extensiones':
            case 'dispositivos':
                $query->where('empleado_id', $empleadoId);
                break;
        }
    }

    private function obtenerTituloReporte($tipo)
    {
        return match($tipo) {
            'softphones' => 'Reporte de Softphones',
            'extensiones' => 'Reporte de Extensiones',
            'dispositivos' => 'Reporte de Dispositivos',
            'empleados' => 'Reporte de Empleados',
            'ubicaciones' => 'Reporte de Ubicaciones',
            'por_sede' => 'Reporte por Sede',
            'estadisticas' => 'Estadísticas',
            'consolidado' => 'Reporte Consolidado',
            default => 'Reporte'
        };
    }

    private function guardarHistorialReporte($tipo, $formato, $request)
    {
        // Podría implementarse para mantener un registro de los reportes generados
        // Por ejemplo, guardar en una tabla 'reportes_historial' con los filtros aplicados
    }

    private function determinarCampos($datos)
    {
        $campos = [];
        $encabezados = [];

        if (count($datos) > 0) {
            // Si hay datos, extraer los campos basados en el primer registro
            $primerRegistro = $datos->first();

            if ($primerRegistro instanceof \Illuminate\Database\Eloquent\Model) {
                // Es un modelo de Eloquent
                $atributos = $primerRegistro->getAttributes();
                foreach ($atributos as $campo => $valor) {
                    if (!in_array($campo, ['id', 'created_at', 'updated_at', 'deleted_at'])) {
                        $campos[] = $campo;
                        $encabezados[] = str_replace('_', ' ', ucfirst($campo));
                    }
                }
            } else {
                // Es un objeto o array simple
                $campos = array_keys((array)$primerRegistro);
                $encabezados = array_map(function($campo) {
                    return str_replace('_', ' ', ucfirst($campo));
                }, $campos);
            }
        }

        return [$campos, $encabezados];
    }

    private function generarExcel($datos, $tipo, $filename, $titulo, $campos, $encabezados)
    {
        try {
            // Primero convertimos los datos a arrays para asegurar consistencia con la vista
            $datosArray = [];
            foreach ($datos as $item) {
                if ($item instanceof \Illuminate\Database\Eloquent\Model) {
                    $datosArray[] = $item->toArray();
                } else {
                    $datosArray[] = (array)$item;
                }
            }

            // Crear un nuevo objeto de colección con los datos convertidos
            $datosCollection = collect($datosArray);
            
            // Creamos una clase genérica para exportar exactamente lo que se ve en la vista
            $exportClass = new class($datosCollection, $titulo, $campos, $encabezados) implements \Maatwebsite\Excel\Concerns\WithMultipleSheets {
                protected $datos;
                protected $titulo;
                protected $campos;
                protected $encabezados;
                
                public function __construct($datos, $titulo, $campos, $encabezados)
                {
                    $this->datos = $datos;
                    $this->titulo = $titulo;
                    $this->campos = $campos;
                    $this->encabezados = $encabezados;
                }
                
                public function sheets(): array
                {
                    return [
                        new class($this->datos, $this->titulo, $this->campos, $this->encabezados) implements 
                            \Maatwebsite\Excel\Concerns\FromCollection,
                            \Maatwebsite\Excel\Concerns\WithTitle,
                            \Maatwebsite\Excel\Concerns\WithHeadings,
                            \Maatwebsite\Excel\Concerns\WithStyles,
                            \Maatwebsite\Excel\Concerns\ShouldAutoSize {
                                
                            protected $datos;
                            protected $titulo;
                            protected $campos;
                            protected $encabezados;
                            
                            public function __construct($datos, $titulo, $campos, $encabezados)
                            {
                                $this->datos = $datos;
                                $this->titulo = $titulo;
                                $this->campos = $campos;
                                $this->encabezados = $encabezados;
                            }
                            
                            public function collection()
                            {
                                // Mapear los datos para que solo incluyan los campos especificados en el orden correcto
                                return $this->datos->map(function ($fila) {
                                    $resultado = [];
                                    foreach ($this->campos as $campo) {
                                        $resultado[$campo] = $fila[$campo] ?? '-';
                                    }
                                    return $resultado;
                                });
                            }
                            
                            public function headings(): array
                            {
                                return $this->encabezados;
                            }
                            
                            public function title(): string
                            {
                                return $this->titulo;
                            }
                            
                            public function styles($sheet)
                            {
                                return [
                                    1 => ['font' => ['bold' => true]],
                                ];
                            }
                        }
                    ];
                }
            };

            return Excel::download($exportClass, $filename . '.xlsx');
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error al generar Excel: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            // Redirigir con mensaje de error
            return back()->with('error', 'Error al generar el reporte Excel: ' . $e->getMessage());
        }
    }

    private function generarCSV($datos, $tipo, $filename, $titulo, $campos, $encabezados)
    {
        try {
            // Primero convertimos los datos a arrays para asegurar consistencia con la vista
            $datosArray = [];
            foreach ($datos as $item) {
                if ($item instanceof \Illuminate\Database\Eloquent\Model) {
                    $datosArray[] = $item->toArray();
                } else {
                    $datosArray[] = (array)$item;
                }
            }

            // Crear un nuevo objeto de colección con los datos convertidos
            $datosCollection = collect($datosArray);
            
            // Creamos una clase genérica para exportar exactamente lo que se ve en la vista
            $exportClass = new class($datosCollection, $titulo, $campos, $encabezados) implements 
                \Maatwebsite\Excel\Concerns\FromCollection,
                \Maatwebsite\Excel\Concerns\WithHeadings {
                    
                protected $datos;
                protected $titulo;
                protected $campos;
                protected $encabezados;
                
                public function __construct($datos, $titulo, $campos, $encabezados)
                {
                    $this->datos = $datos;
                    $this->titulo = $titulo;
                    $this->campos = $campos;
                    $this->encabezados = $encabezados;
                }
                
                public function collection()
                {
                    // Mapear los datos para que solo incluyan los campos especificados en el orden correcto
                    return $this->datos->map(function ($fila) {
                        $resultado = [];
                        foreach ($this->campos as $campo) {
                            $resultado[$campo] = $fila[$campo] ?? '-';
                        }
                        return $resultado;
                    });
                }
                
                public function headings(): array
                {
                    return $this->encabezados;
                }
            };

            return Excel::download($exportClass, $filename . '.csv', \Maatwebsite\Excel\Excel::CSV);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error al generar CSV: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            // Redirigir con mensaje de error
            return back()->with('error', 'Error al generar el reporte CSV: ' . $e->getMessage());
        }
    }

    private function generarHTML($datos, $tipo, $titulo, $request)
    {
        // Preparar los filtros aplicados para mostrarlos en la vista
        $filtrosAplicados = [];

        if ($request->sede_id) {
            $sede = Sede::find($request->sede_id);
            $filtrosAplicados['sede'] = $sede ? $sede->nombre : 'Desconocido';
        }

        if ($request->bloque_id) {
            $bloque = Bloque::find($request->bloque_id);
            $filtrosAplicados['bloque'] = $bloque ? $bloque->nombre : 'Desconocido';
        }

        if ($request->ubicacion_id) {
            $ubicacion = Ubicacion::find($request->ubicacion_id);
            $filtrosAplicados['ubicacion'] = $ubicacion ? $ubicacion->nombre : 'Desconocido';
        }

        if ($request->empleado_id) {
            $empleado = Empleado::find($request->empleado_id);
            $filtrosAplicados['empleado'] = $empleado ? $empleado->nombre : 'Desconocido';
        }

        if ($request->estado) {
            $filtrosAplicados['estado'] = ucfirst($request->estado);
        }

        if ($request->has('fecha_inicio') && $request->has('fecha_fin')) {
            $fechaInicio = Carbon::parse($request->fecha_inicio)->format('d/m/Y');
            $fechaFin = Carbon::parse($request->fecha_fin)->format('d/m/Y');
            $filtrosAplicados['fecha'] = "$fechaInicio a $fechaFin";
        } elseif ($request->has('periodo')) {
            $filtrosAplicados['periodo'] = match($request->periodo) {
                'hoy' => 'Hoy',
                'ayer' => 'Ayer',
                'semana_actual' => 'Semana actual',
                'semana_anterior' => 'Semana anterior',
                'mes_actual' => 'Mes actual',
                'mes_anterior' => 'Mes anterior',
                'año_actual' => 'Año actual',
                default => $request->periodo
            };
        }

        // Filtros adicionales
        if ($request->filtros) {
            foreach ($request->filtros as $campo => $valor) {
                if ($valor) {
                    $filtrosAplicados[$campo] = $valor;
                }
            }
        }

        // Convertir modelos en arrays para la vista
        $datosArray = [];
        foreach ($datos as $item) {
            if ($item instanceof \Illuminate\Database\Eloquent\Model) {
                $datosArray[] = $item->toArray();
            } else {
                $datosArray[] = (array)$item;
            }
        }

        return view('exports.show', [
            'datos' => $datosArray,
            'titulo' => $titulo,
            'filtrosAplicados' => $filtrosAplicados,
            'campos' => $this->determinarCampos($datos)[0],
            'encabezados' => $this->determinarCampos($datos)[1],
            'totalItems' => count($datos),
            'fecha' => now()->format('d/m/Y H:i:s')
        ]);
    }

    private function generarEstadisticas($datos, $request)
    {
        // Preparar datos para gráficos
        $tipoGrafico = $request->tipo_grafico ?? 'barras';
        $agruparPor = $request->agrupar_por ?? 'sede';
        $metrica = $request->metrica ?? 'count';

        // Agrupar los datos según lo solicitado
        $datosAgrupados = $this->agruparDatosParaEstadisticas($datos, $agruparPor, $metrica);

        return view('reportes.estadisticas', [
            'datos' => $datos,
            'datosAgrupados' => $datosAgrupados,
            'tipoGrafico' => $tipoGrafico,
            'agruparPor' => $agruparPor,
            'metrica' => $metrica,
            'titulo' => 'Estadísticas',
            'filtros' => $request->all(),
            'fecha' => now()->format('d/m/Y H:i:s')
        ]);
    }

    private function agruparDatosParaEstadisticas($datos, $agruparPor, $metrica)
    {
        // Implementar la lógica de agrupación según los parámetros
        // Esto dependerá del tipo de datos y cómo quieras representarlos

        // Ejemplo simple para agrupar por sede y contar
        if ($agruparPor === 'sede') {
            return $datos->groupBy(function($item) {
                return $item->empleado->sede->nombre ?? 'Sin sede';
            })->map(function($grupo) {
                return $grupo->count();
            });
        }

        // Más implementaciones de agrupación...

        return collect(); // Devolver colección vacía si no hay implementación
    }
}
