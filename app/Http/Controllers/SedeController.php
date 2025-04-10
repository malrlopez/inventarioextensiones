<?php

namespace App\Http\Controllers;

use App\Models\Sede;
use Illuminate\Http\Request;

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
        $request->validate([
            'nombre_sede' => 'required|unique:sedes,nombre_sede',
            'direccion' => 'required',
        ]);

        Sede::create($request->all());

        return redirect()->route('sedes.index')
            ->with('success', 'Sede creada exitosamente');
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
        $request->validate([
            'nombre_sede' => 'required|unique:sedes,nombre_sede,' . $sede->id_sede . ',id_sede',
            'direccion' => 'required',
        ]);

        $sede->update($request->all());

        return redirect()->route('sedes.index')
            ->with('success', 'Sede actualizada exitosamente');
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
}