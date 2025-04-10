<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use Illuminate\Http\Request;

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
}