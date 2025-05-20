<?php

namespace App\Http\Controllers;

use App\Models\Rack;
use App\Models\Ubicacion;
use Illuminate\Http\Request;
use App\Exports\RacksExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class RackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $racks = Rack::with('ubicacion')->get();
        return view('racks.index', compact('racks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ubicaciones = Ubicacion::all();
        return view('racks.create', compact('ubicaciones'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'marca' => 'required',
            'referencia' => 'required',
            'id_ubicacion' => 'required|exists:ubicaciones,id_ubicacion',
        ]);

        Rack::create($request->all());

        return redirect()->route('racks.index')
            ->with('success', 'Rack creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Rack $rack)
    {
        $rack->load(['ubicacion', 'switches']);
        return view('racks.show', compact('rack'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rack $rack)
    {
        $ubicaciones = Ubicacion::all();
        return view('racks.edit', compact('rack', 'ubicaciones'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rack $rack)
    {
        $request->validate([
            'marca' => 'required',
            'referencia' => 'required',
            'id_ubicacion' => 'required|exists:ubicaciones,id_ubicacion',
        ]);

        $rack->update($request->all());

        return redirect()->route('racks.index')
            ->with('success', 'Rack actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rack $rack)
    {
        // Verificar si el rack tiene switches asociados
        if ($rack->switches->count() > 0) {
            return redirect()->route('racks.index')
                ->with('error', 'No se puede eliminar el rack porque tiene switches asociados');
        }

        $rack->delete();

        return redirect()->route('racks.index')
            ->with('success', 'Rack eliminado exitosamente');
    }

    public function export(Request $request)
    {
        $racks = Rack::with(['ubicacion.sede'])->get();

        switch ($request->format) {
            case 'excel':
                return Excel::download(new RacksExport($racks), 'racks_' . now()->format('Y-m-d') . '.xlsx');

            case 'csv':
                return Excel::download(new RacksExport($racks), 'racks_' . now()->format('Y-m-d') . '.csv', \Maatwebsite\Excel\Excel::CSV);

            case 'pdf':
                $headings = [
                    'Nombre',
                    'Ubicación',
                    'Sede',
                    'Descripción',
                    'Estado',
                    'Última Actualización'
                ];

                $rows = $racks->map(function ($rack) {
                    return [
                        $rack->nombre,
                        $rack->ubicacion ? $rack->ubicacion->oficina : 'N/A',
                        $rack->ubicacion && $rack->ubicacion->sede ? $rack->ubicacion->sede->nombre_sede : 'N/A',
                        $rack->descripcion ?? 'N/A',
                        $rack->estado,
                        $rack->updated_at ? $rack->updated_at->format('d/m/Y H:i') : 'N/A'
                    ];
                });

                $pdf = PDF::loadView('exports.pdf', [
                    'headings' => $headings,
                    'rows' => $rows
                ]);
                return $pdf->download('racks_' . now()->format('Y-m-d') . '.pdf');

            default:
                return back()->with('error', 'Formato de exportación no válido');
        }
    }
}
