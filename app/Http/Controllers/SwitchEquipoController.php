<?php

namespace App\Http\Controllers;

use App\Models\SwitchEquipo;
use App\Models\Rack;
use App\Exports\SwitchesExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class SwitchEquipoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $switches = SwitchEquipo::with('rack')->get();
        return view('switches.index', compact('switches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $racks = Rack::all();
        return view('switches.create', compact('racks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'puerto_switche_asignado' => 'required',
            'total_puertos' => 'required|integer|min:1',
            'puertos_disponibles' => 'required|integer|min:0|lte:total_puertos',
            'vlan' => 'required',
            'marca' => 'required',
            'referencia' => 'required',
            'id_rack' => 'required|exists:racks,id_rack',
        ]);

        SwitchEquipo::create($request->all());

        return redirect()->route('switches.index')
            ->with('success', 'Switch creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $switchEquipo = SwitchEquipo::findOrFail($id);
        return view('switches.show', compact('switchEquipo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $switchEquipo = SwitchEquipo::findOrFail($id);
        $racks = Rack::all();
        return view('switches.edit', compact('switchEquipo', 'racks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'puerto_switche_asignado' => 'required',
            'total_puertos' => 'required|integer|min:1',
            'puertos_disponibles' => 'required|integer|min:0|lte:total_puertos',
            'vlan' => 'required',
            'marca' => 'required',
            'referencia' => 'required',
            'id_rack' => 'required|exists:racks,id_rack',
        ]);

        $switchEquipo = SwitchEquipo::findOrFail($id);
        $switchEquipo->update($request->all());

        return redirect()->route('switches.index')
            ->with('success', 'Switch actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $switchEquipo = SwitchEquipo::findOrFail($id);
        $switchEquipo->delete();

        return redirect()->route('switches.index')
            ->with('success', 'Switch eliminado exitosamente');
    }

    public function export(Request $request)
    {
        $switches = SwitchEquipo::all();

        switch ($request->format) {
            case 'excel':
                return Excel::download(new SwitchesExport($switches), 'switches_' . now()->format('Y-m-d') . '.xlsx');

            case 'csv':
                return Excel::download(new SwitchesExport($switches), 'switches_' . now()->format('Y-m-d') . '.csv', \Maatwebsite\Excel\Excel::CSV);

            case 'pdf':
                $headings = [
                    'Nombre',
                    'Marca',
                    'Modelo',
                    'Número de Serie',
                    'Puertos',
                    'IP',
                    'Estado',
                    'Última Actualización'
                ];

                $rows = $switches->map(function ($switch) {
                    return [
                        $switch->nombre,
                        $switch->marca ?? 'N/A',
                        $switch->modelo ?? 'N/A',
                        $switch->numero_serie ?? 'N/A',
                        $switch->puertos ?? 'N/A',
                        $switch->ip ?? 'N/A',
                        $switch->estado,
                        $switch->updated_at ? $switch->updated_at->format('d/m/Y H:i') : 'N/A'
                    ];
                });

                $pdf = PDF::loadView('exports.pdf', [
                    'headings' => $headings,
                    'rows' => $rows
                ]);
                return $pdf->download('switches_' . now()->format('Y-m-d') . '.pdf');

            default:
                return back()->with('error', 'Formato de exportación no válido');
        }
    }
}
