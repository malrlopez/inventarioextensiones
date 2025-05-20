<?php

namespace App\Http\Controllers;

use App\Models\Softphone;
use App\Exports\SoftphonesExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class SoftphoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $softphones = Softphone::all();
        return view('softphones.index', compact('softphones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('softphones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'usuario' => 'required',
            'dispositivo' => 'required',
            'clave_softphone' => 'required'
        ]);

        try {
            Softphone::create($request->all());
            return redirect()->route('softphones.index')
                ->with('success', 'Softphone creado exitosamente');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error al crear el softphone: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Softphone $softphone)
    {
        return view('softphones.show', compact('softphone'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Softphone $softphone)
    {
        return view('softphones.edit', compact('softphone'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Softphone $softphone)
    {
        $request->validate([
            'usuario' => 'required',
            'dispositivo' => 'required',
            'clave_softphone' => 'required'
        ]);

        try {
            $softphone->update($request->all());
            return redirect()->route('softphones.index')
                ->with('success', 'Softphone actualizado exitosamente');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error al actualizar el softphone: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Softphone $softphone)
    {
        try {
            $softphone->delete();
            return redirect()->route('softphones.index')
                ->with('success', 'Softphone eliminado exitosamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el softphone: ' . $e->getMessage());
        }
    }

    public function export(Request $request)
    {
        $softphones = Softphone::all();

        switch ($request->format) {
            case 'excel':
                return Excel::download(new SoftphonesExport($softphones), 'softphones_' . now()->format('Y-m-d') . '.xlsx');

            case 'csv':
                return Excel::download(new SoftphonesExport($softphones), 'softphones_' . now()->format('Y-m-d') . '.csv', \Maatwebsite\Excel\Excel::CSV);

            case 'pdf':
                $headings = [
                    'Usuario',
                    'Dispositivo',
                    'Versión',
                    'Estado',
                    'Última Actualización'
                ];

                $rows = $softphones->map(function ($softphone) {
                    return [
                        $softphone->usuario,
                        $softphone->dispositivo,
                        $softphone->version ?? 'N/A',
                        $softphone->estado,
                        $softphone->updated_at ? $softphone->updated_at->format('d/m/Y H:i') : 'N/A'
                    ];
                });

                $pdf = PDF::loadView('exports.pdf', [
                    'headings' => $headings,
                    'rows' => $rows
                ]);
                return $pdf->download('softphones_' . now()->format('Y-m-d') . '.pdf');

            default:
                return back()->with('error', 'Formato de exportación no válido');
        }
    }
}
