<?php

namespace App\Http\Controllers;

use App\Models\Softphone;
use Illuminate\Http\Request;

class SoftphoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $softphones = Softphone::withCount('extensiones')->get();
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
            'usuario' => 'required|unique:softphones,usuario',
            'dispositivo' => 'required',
            'clave_softphone' => 'required',
        ]);

        Softphone::create($request->all());

        return redirect()->route('softphones.index')
            ->with('success', 'Softphone creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Softphone $softphone)
    {
        $softphone->load('extensiones');
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
            'usuario' => 'required|unique:softphones,usuario,' . $softphone->id_softphone . ',id_softphone',
            'dispositivo' => 'required',
            'clave_softphone' => 'required',
        ]);

        $softphone->update($request->all());

        return redirect()->route('softphones.index')
            ->with('success', 'Softphone actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Softphone $softphone)
    {
        // Verificar si el softphone tiene extensiones asociadas
        if ($softphone->extensiones->count() > 0) {
            return redirect()->route('softphones.index')
                ->with('error', 'No se puede eliminar el softphone porque tiene extensiones asociadas');
        }

        $softphone->delete();

        return redirect()->route('softphones.index')
            ->with('success', 'Softphone eliminado exitosamente');
    }
}