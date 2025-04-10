<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Cargo;
use App\Models\Sede;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empleados = Empleado::with(['cargo', 'sede'])->get();
        return view('empleados.index', compact('empleados'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cargos = Cargo::all();
        $sedes = Sede::all();
        return view('empleados.create', compact('cargos', 'sedes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required|email|unique:empleados,email',
            'codigo_marcacion' => 'required|unique:empleados,codigo_marcacion',
            'estado' => 'required|in:Activo,Inactivo',
            'numero_cedula' => 'required|unique:empleados,numero_cedula',
            'id_cargo' => 'required|exists:cargos,id_cargo',
            'id_sede' => 'required|exists:sedes,id_sede',
        ]);

        Empleado::create($request->all());

        return redirect()->route('empleados.index')
            ->with('success', 'Empleado creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Empleado $empleado)
    {
        return view('empleados.show', compact('empleado'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Empleado $empleado)
    {
        $cargos = Cargo::all();
        $sedes = Sede::all();
        return view('empleados.edit', compact('empleado', 'cargos', 'sedes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Empleado $empleado)
    {
        $request->validate([
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required|email|unique:empleados,email,' . $empleado->id_empleado . ',id_empleado',
            'codigo_marcacion' => 'required|unique:empleados,codigo_marcacion,' . $empleado->id_empleado . ',id_empleado',
            'estado' => 'required|in:Activo,Inactivo',
            'numero_cedula' => 'required|unique:empleados,numero_cedula,' . $empleado->id_empleado . ',id_empleado',
            'id_cargo' => 'required|exists:cargos,id_cargo',
            'id_sede' => 'required|exists:sedes,id_sede',
        ]);

        $empleado->update($request->all());

        return redirect()->route('empleados.index')
            ->with('success', 'Empleado actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Empleado $empleado)
    {
        // Verificar si el empleado tiene extensiones asignadas
        if ($empleado->extensiones->count() > 0) {
            return redirect()->route('empleados.index')
                ->with('error', 'No se puede eliminar el empleado porque tiene extensiones asignadas');
        }

        $empleado->delete();

        return redirect()->route('empleados.index')
            ->with('success', 'Empleado eliminado exitosamente');
    }
}