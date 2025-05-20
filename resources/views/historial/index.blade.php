@extends('layouts.app')

@section('title', 'Historial - Sistema de Inventario')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Historial de Cambios</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Registro de Actividades</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Tabla</th>
                            <th>Acción</th>
                            <th>ID Registro</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($historiales as $historial)
                            <tr>
                                <td>{{ $historial->id }}</td>
                                <td>{{ $historial->usuario->name ?? 'N/A' }}</td>
                                <td>{{ $historial->tabla }}</td>
                                <td>
                                    @if($historial->accion == 'crear')
                                        <span class="badge bg-success">Creación</span>
                                    @elseif($historial->accion == 'actualizar')
                                        <span class="badge bg-warning">Actualización</span>
                                    @elseif($historial->accion == 'eliminar')
                                        <span class="badge bg-danger">Eliminación</span>
                                    @else
                                        <span class="badge bg-info">{{ $historial->accion }}</span>
                                    @endif
                                </td>
                                <td>{{ $historial->registro_id }}</td>
                                <td>{{ $historial->created_at->format('d/m/Y H:i:s') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('historial.show', $historial->id) }}" class="btn btn-sm btn-info" title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No hay registros de historial disponibles.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
