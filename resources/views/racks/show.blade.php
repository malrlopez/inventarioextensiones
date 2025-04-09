@extends('layouts.app')

@section('title', 'Detalle de Rack - Sistema de Inventario')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Detalle del Rack: {{ $rack->marca }} {{ $rack->referencia }}</h1>
        <div>
            <a href="{{ route('racks.edit', $rack->id_rack) }}" class="btn btn-warning">
                <i class="fas fa-edit me-1"></i> Editar
            </a>
            <a href="{{ route('racks.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Volver
            </a>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Información del Rack</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 30%">ID:</th>
                            <td>{{ $rack->id_rack }}</td>
                        </tr>
                        <tr>
                            <th>Marca:</th>
                            <td>{{ $rack->marca }}</td>
                        </tr>
                        <tr>
                            <th>Referencia:</th>
                            <td>{{ $rack->referencia }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">Ubicación</h5>
                </div>
                <div class="card-body">
                    @if($rack->ubicacion)
                        <table class="table table-bordered">
                            <tr>
                                <th>Sede:</th>
                                <td>{{ $rack->ubicacion->sede->nombre_sede ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Bloque:</th>
                                <td>{{ $rack->ubicacion->bloque->nombre_bloque ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Oficina:</th>
                                <td>{{ $rack->ubicacion->oficina ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Cuarto Técnico:</th>
                                <td>{{ $rack->ubicacion->cuarto_tecnico ?? 'N/A' }}</td>
                            </tr>
                        </table>
                        
                        <a href="{{ route('ubicaciones.show', $rack->ubicacion->id_ubicacion) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-eye me-1"></i> Ver Detalles de la Ubicación
                        </a>
                    @else
                        <p class="text-center">No hay ubicación asignada a este rack</p>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Switches Asociados</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Marca</th>
                                    <th>Referencia</th>
                                    <th>Puerto Asignado</th>
                                    <th>Total Puertos</th>
                                    <th>Puertos Disponibles</th>
                                    <th>VLAN</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rack->switches as $switch)
                                <tr>
                                    <td>{{ $switch->id_switch }}</td>
                                    <td>{{ $switch->marca }}</td>
                                    <td>{{ $switch->referencia }}</td>
                                    <td>{{ $switch->puerto_switche_asignado }}</td>
                                    <td>{{ $switch->total_puertos }}</td>
                                    <td>{{ $switch->puertos_disponibles }}</td>
                                    <td>{{ $switch->vlan }}</td>
                                    <td>
                                        <a href="{{ route('switches.show', $switch->id_switch) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">No hay switches asociados a este rack</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <a href="{{ route('switches.create') }}" class="btn btn-sm btn-success mt-2">
                        <i class="fas fa-plus me-1"></i> Agregar Switch
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-3">
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
            <i class="fas fa-trash me-1"></i> Eliminar Rack
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
                    ¿Está seguro de que desea eliminar el rack <strong>{{ $rack->marca }} {{ $rack->referencia }}</strong>?
                    <br>Esta acción no se puede deshacer.
                    @if($rack->switches->count() > 0)
                    <div class="alert alert-warning mt-2">
                        <i class="fas fa-exclamation-triangle me-1"></i> Este rack tiene {{ $rack->switches->count() }} switches asociados. La eliminación podría fallar.
                    </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form action="{{ route('racks.destroy', $rack->id_rack) }}" method="POST" style="display:inline;">
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