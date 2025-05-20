<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Exports\CargosExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class CargoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cargos = Cargo::all();
        return view('cargos.index', compact('cargos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cargos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_cargo' => 'required|unique:cargos,nombre_cargo',
        ]);

        Cargo::create($request->all());

        return redirect()->route('cargos.index')
            ->with('success', 'Cargo creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cargo $cargo)
    {
        return view('cargos.show', compact('cargo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cargo $cargo)
    {
        return view('cargos.edit', compact('cargo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cargo $cargo)
    {
        $request->validate([
            'nombre_cargo' => 'required|unique:cargos,nombre_cargo,' . $cargo->id_cargo . ',id_cargo',
        ]);

        $cargo->update($request->all());

        return redirect()->route('cargos.index')
            ->with('success', 'Cargo actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cargo $cargo)
    {
        // Verificar si el cargo tiene empleados asociados
        if ($cargo->empleados->count() > 0) {
            return redirect()->route('cargos.index')
                ->with('error', 'No se puede eliminar el cargo porque tiene empleados asociados');
        }

        $cargo->delete();

        return redirect()->route('cargos.index')
            ->with('success', 'Cargo eliminado exitosamente');
    }

    public function export(Request $request)
    {
        $cargos = Cargo::all();

        switch ($request->format) {
            case 'excel':
                return Excel::download(new CargosExport($cargos), 'cargos_' . now()->format('Y-m-d') . '.xlsx');

            case 'csv':
                return Excel::download(new CargosExport($cargos), 'cargos_' . now()->format('Y-m-d') . '.csv', \Maatwebsite\Excel\Excel::CSV);

            case 'pdf':
                $headings = [
                    'Nombre',
                    'Descripción',
                    'Departamento',
                    'Estado',
                    'Última Actualización'
                ];

                $rows = $cargos->map(function ($cargo) {
                    return [
                        $cargo->nombre_cargo,
                        $cargo->descripcion ?? 'N/A',
                        $cargo->departamento ?? 'N/A',
                        $cargo->estado,
                        $cargo->updated_at ? $cargo->updated_at->format('d/m/Y H:i') : 'N/A'
                    ];
                });

                $pdf = PDF::loadView('exports.pdf', [
                    'headings' => $headings,
                    'rows' => $rows
                ]);
                return $pdf->download('cargos_' . now()->format('Y-m-d') . '.pdf');

            default:
                return back()->with('error', 'Formato de exportación no válido');
        }
    }
}
