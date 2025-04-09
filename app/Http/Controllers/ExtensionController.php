<?php

namespace App\Http\Controllers;

use App\Models\Extension;
use App\Models\Empleado;
use App\Models\Softphone;
use App\Models\Ubicacion;
use Illuminate\Http\Request;

class ExtensionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $extensiones = Extension::with(['empleado', 'softphone', 'ubicacion'])->get();
        return view('extensiones.index', compact('extensiones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $empleados = Empleado::all();
        $softphones = Softphone::all();
        $ubicaciones = Ubicacion::all();
        return view('extensiones.create', compact('empleados', 'softphones', 'ubicaciones'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'numero_extension' => 'required|unique:extensiones,numero_extension',
            'tecnologia' => 'required',
            'puerto' => 'required',
            'cor' => 'required',
            'id_empleado' => 'required|exists:empleados,id_empleado',
            'id_softphone' => 'required|exists:softphones,id_softphone',
            'id_ubicacion' => 'required|exists:ubicaciones,id_ubicacion',
        ]);

        Extension::create($request->all());

        return redirect()->route('extensiones.index')
            ->with('success', 'Extensión creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Extension $extension)
    {
        return view('extensiones.show', compact('extension'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Extension $extension)
    {
        $empleados = Empleado::all();
        $softphones = Softphone::all();
        $ubicaciones = Ubicacion::all();
        return view('extensiones.edit', compact('extension', 'empleados', 'softphones', 'ubicaciones'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Extension $extension)
    {
        $request->validate([
            'numero_extension' => 'required|unique:extensiones,numero_extension,' . $extension->id_extension . ',id_extension',
            'tecnologia' => 'required',
            'puerto' => 'required',
            'cor' => 'required',
            'id_empleado' => 'required|exists:empleados,id_empleado',
            'id_softphone' => 'required|exists:softphones,id_softphone',
            'id_ubicacion' => 'required|exists:ubicaciones,id_ubicacion',
        ]);

        $extension->update($request->all());

        return redirect()->route('extensiones.index')
            ->with('success', 'Extensión actualizada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Extension $extension)
    {
        $extension->delete();

        return redirect()->route('extensiones.index')
            ->with('success', 'Extensión eliminada exitosamente');
    }
}