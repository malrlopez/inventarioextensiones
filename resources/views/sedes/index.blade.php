@extends('layouts.app')

@section('title', 'Sedes - Sistema de Inventario')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Listado de Sedes</h1>
        <div class="d-flex gap-2">
            <form action="{{ route('reportes.generar') }}" method="POST" class="me-2">
                @csrf
                <input type="hidden" name="tipo" value="por_sede">
                <input type="hidden" name="formato" value="html">
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-chart-bar me-1"></i> Generar Reporte
                </button>
            </form>
            @if(Auth::user()->role !== 'viewer')
            <a href="{{ route('sedes.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Nueva Sede
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
                            <th>Nombre</th>
                            <th>Dirección</th>
                            <th>Bloques</th>
                            <th>Ubicaciones</th>
                            <th>Empleados</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sedes as $sede)
                        <tr>
                            <td>{{ $sede->id_sede }}</td>
                            <td>{{ $sede->nombre_sede }}</td>
                            <td>{{ $sede->direccion }}</td>
                            <td>{{ $sede->bloques_count ?? $sede->bloques->count() }}</td>
                            <td>{{ $sede->ubicaciones_count ?? $sede->ubicaciones->count() }}</td>
                            <td>{{ $sede->empleados_count ?? $sede->empleados->count() }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('sedes.show', $sede->id_sede) }}" class="btn btn-sm btn-info" title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('sedes.edit', $sede->id_sede) }}" class="btn btn-sm btn-warning" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('sedes.destroy', $sede->id_sede) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Está seguro de que desea eliminar la sede {{ $sede->nombre_sede }}? Esta acción no se puede deshacer.')">
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
                            <td colspan="7" class="text-center">No hay sedes registradas</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
