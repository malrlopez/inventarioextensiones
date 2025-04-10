@extends('layouts.app')

@section('title', 'Detalle de Softphone - Sistema de Inventario')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Detalle del Softphone: {{ $softphone->usuario }}</h1>
        <div>
            <a href="{{ route('softphones.edit', $softphone->id_softphone) }}" class="btn btn-warning">
                <i class="fas fa-edit me-1"></i> Editar
            </a>
            <a href="{{ route('softphones.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Volver
            </a>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Información del Softphone</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 30%">ID:</th>
                            <td>{{ $softphone->id_softphone }}</td>
                        </tr>
                        <tr>
                            <th>Usuario:</th>
                            <td>{{ $softphone->usuario }}</td>
                        </tr>
                        <tr>
                            <th>Dispositivo:</th>
                            <td>{{ $softphone->dispositivo }}</td>
                        </tr>
                        <tr>
                            <th>Clave:</th>
                            <td>
                                <span class="text-muted">******</span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-md-7">
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
                                    <th>Empleado</th>
                                    <th>Ubicación</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($softphone->extensiones as $extension)
                                <tr>
                                    <td>{{ $extension->numero_extension }}</td>
                                    <td>{{ $extension->tecnologia }}</td>
                                    <td>
                                        @if($extension->empleado)
                                            {{ $extension->empleado->nombre }} {{ $extension->empleado->apellido }}
                                        @else
                                            <span class="text-muted">No asignado</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($extension->ubicacion)
                                            {{ $extension->ubicacion->oficina ?? 'N/A' }} 
                                            ({{ optional($extension->ubicacion->sede)->nombre_sede ?? 'N/A' }})
                                        @else
                                            <span class="text-muted">No asignado</span>
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
                                    <td colspan="5" class="text-center">No hay extensiones asignadas a este softphone</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <a href="{{ route('extensiones.create') }}" class="btn btn-sm btn-success mt-2">
                        <i class="fas fa-plus me-1"></i> Agregar Extensión
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-3">
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
            <i class="fas fa-trash me-1"></i> Eliminar Softphone
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
                    ¿Está seguro de que desea eliminar el softphone <strong>{{ $softphone->usuario }}</strong>?
                    <br>Esta acción no se puede deshacer.
                    @if($softphone->extensiones->count() > 0)
                    <div class="alert alert-warning mt-2">
                        <i class="fas fa-exclamation-triangle me-1"></i> Este softphone tiene {{ $softphone->extensiones->count() }} extensiones asignadas. La eliminación podría fallar.
                    </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form action="{{ route('softphones.destroy', $softphone->id_softphone) }}" method="POST" style="display:inline;">
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