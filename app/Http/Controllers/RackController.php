<?php

namespace App\Http\Controllers;

use App\Models\Rack;
use App\Models\Ubicacion;
use Illuminate\Http\Request;

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
}