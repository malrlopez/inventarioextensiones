<?php

namespace App\Http\Controllers;

use App\Models\Sede;
use App\Exports\SedesExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class SedeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sedes = Sede::withCount(['bloques', 'empleados', 'ubicaciones'])->get();
        return view('sedes.index', compact('sedes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sedes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = $this->validateWithCustomMessages($request->all(), Sede::$rules);

        if ($validation !== true) {
            return $validation;
        }

        try {
            Sede::create($request->all());
            return redirect()->route('sedes.index')
                ->with('success', 'Sede creada exitosamente.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error al crear la sede: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Sede $sede)
    {
        $sede->load(['bloques', 'ubicaciones', 'empleados']);
        return view('sedes.show', compact('sede'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sede $sede)
    {
        return view('sedes.edit', compact('sede'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sede $sede)
    {
        $rules = Sede::$rules;
        // Modificar las reglas unique para excluir el registro actual
        $rules['nombre_sede'] = 'required|unique:sedes,nombre_sede,' . $sede->id_sede . ',id_sede';

        $validation = $this->validateWithCustomMessages($request->all(), $rules);

        if ($validation !== true) {
            return $validation;
        }

        try {
            $sede->update($request->all());
            return redirect()->route('sedes.index')
                ->with('success', 'Sede actualizada exitosamente.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error al actualizar la sede: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sede $sede)
    {
        // Verificar si la sede tiene bloques, empleados o ubicaciones asociadas
        if ($sede->bloques->count() > 0 || $sede->empleados->count() > 0 || $sede->ubicaciones->count() > 0) {
            return redirect()->route('sedes.index')
                ->with('error', 'No se puede eliminar la sede porque tiene bloques, empleados o ubicaciones asociadas');
        }

        $sede->delete();

        return redirect()->route('sedes.index')
            ->with('success', 'Sede eliminada exitosamente');
    }

    public function export(Request $request)
    {
        $sedes = Sede::all();

        switch ($request->format) {
            case 'excel':
                return Excel::download(new SedesExport($sedes), 'sedes_' . now()->format('Y-m-d') . '.xlsx');

            case 'csv':
                return Excel::download(new SedesExport($sedes), 'sedes_' . now()->format('Y-m-d') . '.csv', \Maatwebsite\Excel\Excel::CSV);

            case 'pdf':
                $headings = [
                    'Nombre',
                    'Ciudad',
                    'Dirección',
                    'Teléfono',
                    'Estado',
                    'Última Actualización'
                ];

                $rows = $sedes->map(function ($sede) {
                    return [
                        $sede->nombre_sede,
                        $sede->ciudad ?? 'N/A',
                        $sede->direccion ?? 'N/A',
                        $sede->telefono ?? 'N/A',
                        $sede->estado,
                        $sede->updated_at ? $sede->updated_at->format('d/m/Y H:i') : 'N/A'
                    ];
                });

                $pdf = PDF::loadView('exports.pdf', [
                    'headings' => $headings,
                    'rows' => $rows
                ]);
                return $pdf->download('sedes_' . now()->format('Y-m-d') . '.pdf');

            default:
                return back()->with('error', 'Formato de exportación no válido');
        }
    }
}
