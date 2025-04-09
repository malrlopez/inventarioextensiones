<?php

namespace App\Http\Controllers;

use App\Models\SwitchEquipo;
use App\Models\Rack;
use Illuminate\Http\Request;

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
}