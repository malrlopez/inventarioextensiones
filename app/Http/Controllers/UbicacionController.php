<?php

namespace App\Http\Controllers;

use App\Models\Ubicacion;
use App\Models\Sede;
use App\Models\Bloque;
use App\Models\Extension;
use App\Exports\UbicacionesExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class UbicacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ubicaciones = Ubicacion::with(['sede', 'bloque'])->get();
        return view('ubicaciones.index', compact('ubicaciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sedes = Sede::all();
        $bloques = Bloque::all();
        return view('ubicaciones.create', compact('sedes', 'bloques'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'planta_telefonica' => 'nullable',
            'cuarto_tecnico' => 'nullable',
            'rack' => 'nullable',
            'patch_panel' => 'nullable',
            'faceplate' => 'nullable',
            'oficina' => 'required',
            'id_sede' => 'required|exists:sedes,id_sede',
            'id_bloque' => 'required|exists:bloques,id_bloque',
        ]);

        // Verificar si existen extensiones en ubicaciones con el mismo nombre de oficina
        $ubicacionesSimilares = Ubicacion::where('oficina', 'LIKE', '%' . $request->oficina . '%')->get();

        if ($ubicacionesSimilares->isNotEmpty()) {
            $extensionesExistentes = Extension::whereIn('id_ubicacion', $ubicacionesSimilares->pluck('id_ubicacion'))->get();

            if ($extensionesExistentes->isNotEmpty()) {
                $mensaje = 'Se encontraron extensiones en oficinas con nombre similar:<br>';
                foreach ($extensionesExistentes as $extension) {
                    $ubicacion = $extension->ubicacion;
                    $mensaje .= "- Extensión {$extension->numero_extension} en oficina \"{$ubicacion->oficina}\"<br>";
                    $mensaje .= "&nbsp;&nbsp;(Sede: {$ubicacion->sede->nombre_sede}, ";
                    $mensaje .= "Bloque: {$ubicacion->bloque->nombre})<br>";
                }

                return back()
                    ->withInput()
                    ->with('warning', $mensaje);
            }
        }

        // Si no hay extensiones existentes o el usuario decide continuar
        $ubicacion = Ubicacion::create($request->all());

        return redirect()->route('ubicaciones.index')
            ->with('success', 'Ubicación creada exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ubicacion $ubicacion)
    {
        $ubicacion->load(['sede', 'bloque', 'extensiones', 'racks']);
        return view('ubicaciones.show', compact('ubicacion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ubicacion $ubicacion)
    {
        $sedes = Sede::all();
        $bloques = Bloque::all();
        return view('ubicaciones.edit', compact('ubicacion', 'sedes', 'bloques'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ubicacion $ubicacion)
    {
        $request->validate([
            'planta_telefonica' => 'nullable',
            'cuarto_tecnico' => 'nullable',
            'rack' => 'nullable',
            'patch_panel' => 'nullable',
            'faceplate' => 'nullable',
            'oficina' => 'required',
            'id_sede' => 'required|exists:sedes,id_sede',
            'id_bloque' => 'required|exists:bloques,id_bloque',
        ]);

        $ubicacion->update($request->all());

        return redirect()->route('ubicaciones.index')
            ->with('success', 'Ubicación actualizada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ubicacion $ubicacion)
    {
        // Verificar si la ubicación tiene extensiones o racks asociados
        if ($ubicacion->extensiones->count() > 0 || $ubicacion->racks->count() > 0) {
            return redirect()->route('ubicaciones.index')
                ->with('error', 'No se puede eliminar la ubicación porque tiene extensiones o racks asociados');
        }

        $ubicacion->delete();

        return redirect()->route('ubicaciones.index')
            ->with('success', 'Ubicación eliminada exitosamente');
    }

    public function export(Request $request)
    {
        $ubicaciones = Ubicacion::with(['sede'])->get();

        switch ($request->format) {
            case 'excel':
                return Excel::download(new UbicacionesExport($ubicaciones), 'ubicaciones_' . now()->format('Y-m-d') . '.xlsx');

            case 'csv':
                return Excel::download(new UbicacionesExport($ubicaciones), 'ubicaciones_' . now()->format('Y-m-d') . '.csv', \Maatwebsite\Excel\Excel::CSV);

            case 'pdf':
                $headings = [
                    'Oficina',
                    'Sede',
                    'Piso',
                    'Descripción',
                    'Estado',
                    'Última Actualización'
                ];

                $rows = $ubicaciones->map(function ($ubicacion) {
                    return [
                        $ubicacion->oficina,
                        $ubicacion->sede ? $ubicacion->sede->nombre_sede : 'N/A',
                        $ubicacion->piso ?? 'N/A',
                        $ubicacion->descripcion ?? 'N/A',
                        $ubicacion->estado,
                        $ubicacion->updated_at ? $ubicacion->updated_at->format('d/m/Y H:i') : 'N/A'
                    ];
                });

                $pdf = PDF::loadView('exports.pdf', [
                    'headings' => $headings,
                    'rows' => $rows
                ]);
                return $pdf->download('ubicaciones_' . now()->format('Y-m-d') . '.pdf');

            default:
                return back()->with('error', 'Formato de exportación no válido');
        }
    }
}
