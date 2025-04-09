@extends('layouts.app')

@section('title', 'Detalle de Historial - Sistema de Inventario')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Detalle del Historial #{{ $historial->id }}</h1>
        <div>
            <a href="{{ route('historial.edit', $historial->id) }}" class="btn btn-warning">
                <i class="fas fa-edit me-1"></i> Editar
            </a>
            <a href="{{ route('historial.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Volver
            </a>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">Información del Registro</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th style="width: 30%">ID:</th>
                    <td>{{ $historial->id }}</td>
                </tr>
                <tr>
                    <th>Usuario:</th>
                    <td>{{ $historial->usuario->name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Tabla afectada:</th>
                    <td>{{ $historial->tabla }}</td>
                </tr>
                <tr>
                    <th>Acción:</th>
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
                </tr>
                <tr>
                    <th>ID de Registro:</th>
                    <td>{{ $historial->registro_id }}</td>
                </tr>
                <tr>
                    <th>Fecha y Hora:</th>
                    <td>{{ $historial->created_at->format('d/m/Y H:i:s') }}</td>
                </tr>
            </table>
            
            @if($historial->detalles)
                <div class="mt-4">
                    <h5>Detalles del Registro:</h5>
                    <div class="card">
                        <div class="card-body bg-light">
                            <pre class="mb-0">{{ $historial->detalles }}</pre>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection