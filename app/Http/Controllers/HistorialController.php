<?php

namespace App\Http\Controllers;

use App\Models\Historial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistorialController extends Controller
{
    /**
     * Muestra un listado del historial.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Si es administrador, muestra todos los registros
        if (Auth::user()->role === 'admin') {
            $historiales = Historial::with('usuario')
                                   ->orderBy('created_at', 'desc')
                                   ->get();
        } else {
            // Si no es administrador, solo muestra sus propios registros
            $historiales = Historial::where('usuario_id', Auth::id())
                                   ->orderBy('created_at', 'desc')
                                   ->get();
        }
        
        return view('historial.index', compact('historiales'));
    }

    /**
     * Muestra el formulario para crear un nuevo registro.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('historial.create');
    }

    /**
     * Almacena un nuevo registro en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required',
            'tabla' => 'required',
            'accion' => 'required',
            'registro_id' => 'required',
            'detalles' => 'nullable',
        ]);

        Historial::create($request->all());

        return redirect()->route('historial.index')
            ->with('success', 'Registro de historial creado correctamente.');
    }

    /**
     * Muestra un registro específico.
     *
     * @param  \App\Models\Historial  $historial
     * @return \Illuminate\Http\Response
     */
    public function show(Historial $historial)
    {
        return view('historial.show', compact('historial'));
    }

    /**
     * Muestra el formulario para editar un registro existente.
     *
     * @param  \App\Models\Historial  $historial
     * @return \Illuminate\Http\Response
     */
    public function edit(Historial $historial)
    {
        return view('historial.edit', compact('historial'));
    }

    /**
     * Actualiza un registro existente en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Historial  $historial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Historial $historial)
    {
        $request->validate([
            'usuario_id' => 'required',
            'tabla' => 'required',
            'accion' => 'required',
            'registro_id' => 'required',
            'detalles' => 'nullable',
        ]);

        $historial->update($request->all());

        return redirect()->route('historial.index')
            ->with('success', 'Registro de historial actualizado correctamente.');
    }

    /**
     * Elimina un registro de la base de datos.
     *
     * @param  \App\Models\Historial  $historial
     * @return \Illuminate\Http\Response
     */
    public function destroy(Historial $historial)
    {
        $historial->delete();

        return redirect()->route('historial.index')
            ->with('success', 'Registro de historial eliminado correctamente.');
    }
}