@extends('layouts.app')

@section('title', 'Detalle de Cargo - Sistema de Inventario')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Detalle del Cargo: {{ $cargo->nombre_cargo }}</h1>
        <div>
            <a href="{{ route('cargos.edit', $cargo->id_cargo) }}" class="btn btn-warning">
                <i class="fas fa-edit me-1"></i> Editar
            </a>
            <a href="{{ route('cargos.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Volver
            </a>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Información del Cargo</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 30%">ID:</th>
                            <td>{{ $cargo->id_cargo }}</td>
                        </tr>
                        <tr>
                            <th>Nombre:</th>
                            <td>{{ $cargo->nombre_cargo }}</td>
                        </tr>
                        <tr>
                            <th>Empleados:</th>
                            <td>{{ $cargo->empleados->count() }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Empleados con este Cargo</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Email</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cargo->empleados as $empleado)
                                <tr>
                                    <td>{{ $empleado->id_empleado }}</td>
                                    <td>{{ $empleado->nombre }}</td>
                                    <td>{{ $empleado->apellido }}</td>
                                    <td>{{ $empleado->email }}</td>
                                    <td>
                                        <span class="badge {{ $empleado->estado == 'Activo' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $empleado->estado }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('empleados.show', $empleado->id_empleado) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No hay empleados asignados a este cargo</td>
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
            <i class="fas fa-trash me-1"></i> Eliminar Cargo
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
                    ¿Está seguro de que desea eliminar el cargo <strong>{{ $cargo->nombre_cargo }}</strong>?
                    <br>Esta acción no se puede deshacer.
                    @if($cargo->empleados->count() > 0)
                    <div class="alert alert-warning mt-2">
                        <i class="fas fa-exclamation-triangle me-1"></i> Este cargo tiene {{ $cargo->empleados->count() }} empleados asignados. La eliminación podría fallar.
                    </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form action="{{ route('cargos.destroy', $cargo->id_cargo) }}" method="POST" style="display:inline;">
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