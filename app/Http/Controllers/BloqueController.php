<?php

namespace App\Http\Controllers;

use App\Models\Bloque;
use App\Models\Sede;
use Illuminate\Http\Request;

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
            'nombre_bloque' => 'required',
            'id_sede' => 'required|exists:sedes,id_sede',
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
            'nombre_bloque' => 'required',
            'id_sede' => 'required|exists:sedes,id_sede',
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
        $bloque->delete();

        return redirect()->route('bloques.index')
            ->with('success', 'Bloque eliminado exitosamente');
    }
}