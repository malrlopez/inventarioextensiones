@extends('layouts.app')

@section('title', 'Cargos - Sistema de Inventario')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Listado de Cargos</h1>
        <div class="d-flex gap-2">
            @if(Auth::user()->role !== 'viewer')
            <a href="{{ route('cargos.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Nuevo Cargo
            </a>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre del Cargo</th>
                            <th>Empleados Asignados</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cargos as $cargo)
                        <tr>
                            <td>{{ $cargo->id_cargo }}</td>
                            <td>{{ $cargo->nombre_cargo }}</td>
                            <td>{{ $cargo->empleados->count() }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('cargos.show', $cargo->id_cargo) }}" class="btn btn-sm btn-info" title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('cargos.edit', $cargo->id_cargo) }}" class="btn btn-sm btn-warning" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('cargos.destroy', $cargo->id_cargo) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Está seguro de que desea eliminar el cargo {{ $cargo->nombre_cargo }}? Esta acción no se puede deshacer.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">No hay cargos registrados</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
