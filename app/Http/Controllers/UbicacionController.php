<?php

namespace App\Http\Controllers;

use App\Models\Ubicacion;
use App\Models\Sede;
use App\Models\Bloque;
use Illuminate\Http\Request;

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

        Ubicacion::create($request->all());

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
}