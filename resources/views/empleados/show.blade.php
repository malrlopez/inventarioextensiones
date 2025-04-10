@extends('layouts.app')

@section('title', 'Detalle de Empleado - Sistema de Inventario')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Detalle del Empleado: {{ $empleado->nombre }} {{ $empleado->apellido }}</h1>
        <div>
            <a href="{{ route('empleados.edit', $empleado->id_empleado) }}" class="btn btn-warning">
                <i class="fas fa-edit me-1"></i> Editar
            </a>
            <a href="{{ route('empleados.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Volver
            </a>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Información Personal</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 30%">ID:</th>
                            <td>{{ $empleado->id_empleado }}</td>
                        </tr>
                        <tr>
                            <th>Nombre Completo:</th>
                            <td>{{ $empleado->nombre }} {{ $empleado->apellido }}</td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>{{ $empleado->email }}</td>
                        </tr>
                        <tr>
                            <th>Número de Cédula:</th>
                            <td>{{ $empleado->numero_cedula }}</td>
                        </tr>
                        <tr>
                            <th>Código de Marcación:</th>
                            <td>{{ $empleado->codigo_marcacion }}</td>
                        </tr>
                        <tr>
                            <th>Estado:</th>
                            <td>
                                <span class="badge {{ $empleado->estado == 'Activo' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $empleado->estado }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Cargo:</th>
                            <td>{{ $empleado->cargo->nombre_cargo ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Sede:</th>
                            <td>{{ $empleado->sede->nombre_sede ?? 'N/A' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Extensiones Asignadas</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Número</th>
                                    <th>Tecnología</th>
                                    <th>Ubicación</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($empleado->extensiones as $extension)
                                <tr>
                                    <td>{{ $extension->numero_extension }}</td>
                                    <td>{{ $extension->tecnologia }}</td>
                                    <td>
                                        @if($extension->ubicacion)
                                            {{ $extension->ubicacion->oficina ?? 'N/A' }} 
                                            ({{ $extension->ubicacion->sede->nombre_sede ?? 'N/A' }})
                                        @else
                                            <span class="text-muted">No asignada</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('extensiones.show', $extension->id_extension) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">No hay extensiones asignadas a este empleado</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-3">
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
            <i class="fas fa-trash me-1"></i> Eliminar Empleado
        </button>
    </div>
    
    <!-- Modal de confirmación de eliminación -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Está seguro de que desea eliminar al empleado <strong>{{ $empleado->nombre }} {{ $empleado->apellido }}</strong>?
                    <br>Esta acción no se puede deshacer.
                    @if($empleado->extensiones->count() > 0)
                    <div class="alert alert-warning mt-2">
                        <i class="fas fa-exclamation-triangle me-1"></i> Este empleado tiene {{ $empleado->extensiones->count() }} extensiones asignadas. La eliminación podría fallar.
                    </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form action="{{ route('empleados.destroy', $empleado->id_empleado) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
