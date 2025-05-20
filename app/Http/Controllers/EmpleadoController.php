<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Cargo;
use App\Models\Sede;
use App\Exports\EmpleadosExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

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

    public function export(Request $request)
    {
        $empleados = Empleado::with(['cargo'])->get();

        switch ($request->format) {
            case 'excel':
                return Excel::download(new EmpleadosExport($empleados), 'empleados_' . now()->format('Y-m-d') . '.xlsx');

            case 'csv':
                return Excel::download(new EmpleadosExport($empleados), 'empleados_' . now()->format('Y-m-d') . '.csv', \Maatwebsite\Excel\Excel::CSV);

            case 'pdf':
                $headings = [
                    'Nombre',
                    'Apellido',
                    'Cargo',
                    'Email',
                    'Teléfono',
                    'Estado',
                    'Última Actualización'
                ];

                $rows = $empleados->map(function ($empleado) {
                    return [
                        $empleado->nombre,
                        $empleado->apellido,
                        $empleado->cargo ? $empleado->cargo->nombre : 'N/A',
                        $empleado->email ?? 'N/A',
                        $empleado->telefono ?? 'N/A',
                        $empleado->estado,
                        $empleado->updated_at ? $empleado->updated_at->format('d/m/Y H:i') : 'N/A'
                    ];
                });

                $pdf = PDF::loadView('exports.pdf', [
                    'headings' => $headings,
                    'rows' => $rows
                ]);
                return $pdf->download('empleados_' . now()->format('Y-m-d') . '.pdf');

            default:
                return back()->with('error', 'Formato de exportación no válido');
        }
    }

    /**
     * Buscar empleado por número de documento
     */
    public function buscarPorDocumento(Request $request)
    {
        $documento = $request->input('documento');
        
        if (!$documento) {
            return response()->json([
                'success' => false,
                'message' => 'Debe proporcionar un número de documento'
            ]);
        }
        
        $empleado = Empleado::where('numero_cedula', $documento)->first();
        
        if ($empleado) {
            return response()->json([
                'success' => true,
                'empleado' => $empleado
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró ningún empleado con ese número de documento'
            ]);
        }
    }
}
