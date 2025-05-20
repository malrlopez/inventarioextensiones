<?php

namespace App\Http\Controllers;

use App\Models\Bloque;
use App\Models\Sede;
use App\Models\Ubicacion;
use App\Exports\BloquesExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class BloqueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bloques = Bloque::with('sede')->get();
        return view('bloques.index', compact('bloques'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sedes = Sede::all();
        return view('bloques.create', compact('sedes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_bloque' => [
                'required',
                Rule::unique('bloques')->where(function ($query) use ($request) {
                    return $query->where('id_sede', $request->id_sede);
                }),
            ],
            'id_sede' => 'required|exists:sedes,id_sede',
        ], [
            'nombre_bloque.required' => 'El nombre del bloque es obligatorio.',
            'nombre_bloque.unique' => 'Ya existe un bloque con este nombre en la sede seleccionada.',
            'id_sede.required' => 'Debe seleccionar una sede.',
            'id_sede.exists' => 'La sede seleccionada no existe.',
        ]);

        Bloque::create($request->all());

        return redirect()->route('bloques.index')
            ->with('success', 'Bloque creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Bloque $bloque)
    {
        return view('bloques.show', compact('bloque'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bloque $bloque)
    {
        $sedes = Sede::all();
        return view('bloques.edit', compact('bloque', 'sedes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bloque $bloque)
    {
        $request->validate([
            'nombre_bloque' => [
                'required',
                Rule::unique('bloques')->where(function ($query) use ($request) {
                    return $query->where('id_sede', $request->id_sede);
                })->ignore($bloque->id_bloque, 'id_bloque'),
            ],
            'id_sede' => 'required|exists:sedes,id_sede',
        ], [
            'nombre_bloque.required' => 'El nombre del bloque es obligatorio.',
            'nombre_bloque.unique' => 'Ya existe un bloque con este nombre en la sede seleccionada.',
            'id_sede.required' => 'Debe seleccionar una sede.',
            'id_sede.exists' => 'La sede seleccionada no existe.',
        ]);

        $bloque->update($request->all());

        return redirect()->route('bloques.index')
            ->with('success', 'Bloque actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bloque $bloque)
    {
        try {
            // Verificar si el bloque tiene ubicaciones asociadas
            $ubicacionesCount = Ubicacion::where('id_bloque', $bloque->id_bloque)->count();

            if ($ubicacionesCount > 0) {
                return redirect()->route('bloques.index')
                    ->with('error', 'No se puede eliminar el bloque porque tiene ' . $ubicacionesCount . ' ubicación(es) asociada(s). Por favor, elimine primero las ubicaciones.');
            }

            DB::beginTransaction();

            // Eliminar el bloque
            $bloque->delete();

            DB::commit();

            return redirect()->route('bloques.index')
                ->with('success', 'Bloque eliminado exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('bloques.index')
                ->with('error', 'Error al eliminar el bloque: ' . $e->getMessage());
        }
    }

    public function export(Request $request)
    {
        $bloques = Bloque::with(['sede'])->get();

        switch ($request->format) {
            case 'excel':
                return Excel::download(new BloquesExport($bloques), 'bloques_' . now()->format('Y-m-d') . '.xlsx');

            case 'csv':
                return Excel::download(new BloquesExport($bloques), 'bloques_' . now()->format('Y-m-d') . '.csv', \Maatwebsite\Excel\Excel::CSV);

            case 'pdf':
                $headings = [
                    'Nombre',
                    'Sede',
                    'Descripción',
                    'Estado',
                    'Última Actualización'
                ];

                $rows = $bloques->map(function ($bloque) {
                    return [
                        $bloque->nombre_bloque,
                        $bloque->sede ? $bloque->sede->nombre_sede : 'N/A',
                        $bloque->descripcion ?? 'N/A',
                        $bloque->estado,
                        $bloque->updated_at ? $bloque->updated_at->format('d/m/Y H:i') : 'N/A'
                    ];
                });

                $pdf = PDF::loadView('exports.pdf', [
                    'headings' => $headings,
                    'rows' => $rows
                ]);
                return $pdf->download('bloques_' . now()->format('Y-m-d') . '.pdf');

            default:
                return back()->with('error', 'Formato de exportación no válido');
        }
    }
}
