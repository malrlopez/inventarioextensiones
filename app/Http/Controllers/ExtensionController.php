<?php

namespace App\Http\Controllers;

use App\Models\Extension;
use App\Models\Empleado;
use App\Models\Softphone;
use App\Models\Ubicacion;
use App\Models\Historial;
use App\Exports\ExtensionesExport;
use App\Traits\Exportable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ExtensionController extends Controller
{
    use Exportable;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $extensiones = Extension::with(['empleado.cargo', 'ubicacion.sede', 'softphone'])->get();
        return view('extensiones.index', compact('extensiones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $empleados = Empleado::all();
        $softphones = Softphone::all();
        $ubicaciones = Ubicacion::all();
        return view('extensiones.create', compact('empleados', 'softphones', 'ubicaciones'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'numero_extension' => 'required|unique:extensiones,numero_extension',
            'tecnologia' => 'required',
            'puerto' => 'required',
            'cor' => 'required',
            'id_empleado' => 'required|exists:empleados,id_empleado',
            'id_softphone' => 'required|exists:softphones,id_softphone',
            'id_ubicacion' => 'required|exists:ubicaciones,id_ubicacion',
        ]);

        $extension = Extension::create($request->all());

        // Registrar en historial
        $this->registrarHistorial($extension, 'crear', 'Se creó la extensión ' . $extension->numero_extension);

        return redirect()->route('extensiones.index')
            ->with('success', 'Extensión creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Extension $extension)
    {
        return view('extensiones.show', compact('extension'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Extension $extension)
    {
        $empleados = Empleado::all();
        $softphones = Softphone::all();
        $ubicaciones = Ubicacion::all();
        return view('extensiones.edit', compact('extension', 'empleados', 'softphones', 'ubicaciones'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Extension $extension)
    {
        $request->validate([
            'numero_extension' => 'required|unique:extensiones,numero_extension,' . $extension->id_extension . ',id_extension',
            'tecnologia' => 'required',
            'puerto' => 'required',
            'cor' => 'required',
            'id_empleado' => 'required|exists:empleados,id_empleado',
            'id_softphone' => 'required|exists:softphones,id_softphone',
            'id_ubicacion' => 'required|exists:ubicaciones,id_ubicacion',
        ]);

        // Guardar datos antiguos para el historial
        $cambios = $this->obtenerCambios($extension, $request->all());

        // Actualizar la extensión
        $extension->update($request->all());

        // Registrar en historial si hubo cambios
        if (!empty($cambios)) {
            $this->registrarHistorial($extension, 'actualizar', 'Cambios: ' . $cambios);
        }

        return redirect()->route('extensiones.index')
            ->with('success', 'Extensión actualizada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Extension $extension)
    {
        // Registrar en historial antes de eliminar
        $this->registrarHistorial($extension, 'eliminar', 'Se eliminó la extensión ' . $extension->numero_extension);

        $extension->delete();

        return redirect()->route('extensiones.index')
            ->with('success', 'Extensión eliminada exitosamente');
    }

    /**
     * Registra un cambio en el historial
     */
    private function registrarHistorial(Extension $extension, $accion, $detalles)
    {
        Historial::create([
            'usuario_id' => Auth::id(), // ID del usuario autenticado
            'tabla' => 'extensiones',
            'accion' => $accion,
            'registro_id' => $extension->id_extension,
            'detalles' => $detalles,
        ]);
    }

    /**
     * Obtiene los cambios realizados en formato legible
     */
    private function obtenerCambios(Extension $extension, array $nuevosDatos)
    {
        $cambios = [];

        // Comparar campos relevantes
        if ($extension->numero_extension != $nuevosDatos['numero_extension']) {
            $cambios[] = "Número: {$extension->numero_extension} → {$nuevosDatos['numero_extension']}";
        }

        if ($extension->tecnologia != $nuevosDatos['tecnologia']) {
            $cambios[] = "Tecnología: {$extension->tecnologia} → {$nuevosDatos['tecnologia']}";
        }

        if ($extension->puerto != $nuevosDatos['puerto']) {
            $cambios[] = "Puerto: {$extension->puerto} → {$nuevosDatos['puerto']}";
        }

        if ($extension->cor != $nuevosDatos['cor']) {
            $cambios[] = "COR: {$extension->cor} → {$nuevosDatos['cor']}";
        }

        if ($extension->id_empleado != $nuevosDatos['id_empleado']) {
            $empleadoAntiguo = Empleado::find($extension->id_empleado);
            $empleadoNuevo = Empleado::find($nuevosDatos['id_empleado']);
            $nombreAntiguo = $empleadoAntiguo ? $empleadoAntiguo->nombre : 'Ninguno';
            $nombreNuevo = $empleadoNuevo ? $empleadoNuevo->nombre : 'Ninguno';
            $cambios[] = "Empleado: {$nombreAntiguo} → {$nombreNuevo}";
        }

        return implode(', ', $cambios);
    }

    public function export(Request $request)
    {
        $extensiones = Extension::with(['empleado.cargo', 'ubicacion.sede', 'softphone'])->get();

        switch ($request->format) {
            case 'excel':
                return Excel::download(new ExtensionesExport($extensiones), 'extensiones_' . now()->format('Y-m-d') . '.xlsx');

            case 'csv':
                return Excel::download(new ExtensionesExport($extensiones), 'extensiones_' . now()->format('Y-m-d') . '.csv', \Maatwebsite\Excel\Excel::CSV);

            case 'pdf':
                // Preparar los datos para la vista PDF
                $headings = [
                    'Número',
                    'Empleado',
                    'Cargo',
                    'Sede',
                    'Ubicación',
                    'Softphone',
                    'Estado',
                    'Última Actualización'
                ];

                $rows = $extensiones->map(function ($extension) {
                    return [
                        $extension->numero_extension,
                        $extension->empleado ? $extension->empleado->nombre_completo : 'N/A',
                        $extension->empleado ? $extension->empleado->cargo->nombre : 'N/A',
                        $extension->ubicacion ? $extension->ubicacion->sede->nombre : 'N/A',
                        $extension->ubicacion ? $extension->ubicacion->nombre : 'N/A',
                        $extension->softphone ? $extension->softphone->nombre : 'N/A',
                        $extension->estado,
                        $extension->updated_at ? $extension->updated_at->format('d/m/Y H:i') : 'N/A'
                    ];
                });

                $pdf = PDF::loadView('exports.pdf', [
                    'headings' => $headings,
                    'rows' => $rows
                ]);
                return $pdf->download('extensiones_' . now()->format('Y-m-d') . '.pdf');

            default:
                return back()->with('error', 'Formato de exportación no válido');
        }
    }
}
