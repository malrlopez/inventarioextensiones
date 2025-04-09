@extends('layouts.app')

@section('title', 'Detalle de Ubicación - Sistema de Inventario')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Detalle de la Ubicación</h1>
        <div>
            <a href="{{ route('ubicaciones.edit', $ubicacion->id_ubicacion) }}" class="btn btn-warning">
                <i class="fas fa-edit me-1"></i> Editar
            </a>
            <a href="{{ route('ubicaciones.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Volver
            </a>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Información de la Ubicación</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 30%">ID:</th>
                            <td>{{ $ubicacion->id_ubicacion }}</td>
                        </tr>
                        <tr>
                            <th>Sede:</th>
                            <td>{{ $ubicacion->sede->nombre_sede ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Bloque:</th>
                            <td>{{ $ubicacion->bloque->nombre_bloque ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Oficina:</th>
                            <td>{{ $ubicacion->oficina }}</td>
                        </tr>
                        <tr>
                            <th>Planta Telefónica:</th>
                            <td>{{ $ubicacion->planta_telefonica ?: 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Cuarto Técnico:</th>
                            <td>{{ $ubicacion->cuarto_tecnico ?: 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Rack:</th>
                            <td>{{ $ubicacion->rack ?: 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Patch Panel:</th>
                            <td>{{ $ubicacion->patch_panel ?: 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Faceplate:</th>
                            <td>{{ $ubicacion->faceplate ?: 'N/A' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Racks en esta Ubicación</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Marca</th>
                                    <th>Referencia</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ubicacion->racks as $rack)
                                <tr>
                                    <td>{{ $rack->id_rack }}</td>
                                    <td>{{ $rack->marca }}</td>
                                    <td>{{ $rack->referencia }}</td>
                                    <td>
                                        <a href="{{ route('racks.show', $rack->id_rack) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">No hay racks registrados en esta ubicación</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <a href="{{ route('racks.create') }}" class="btn btn-sm btn-success mt-2">
                        <i class="fas fa-plus me-1"></i> Agregar Rack
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Extensiones en esta Ubicación</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Número</th>
                                    <th>Tecnología</th>
                                    <th>Empleado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ubicacion->extensiones as $extension)
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
                                        <a href="{{ route('extensiones.show', $extension->id_extension) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">No hay extensiones asignadas a esta ubicación</td>
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
            
            <div class="card mt-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">Historial de Cambios en esta Ubicación</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Extensión</th>
                                    <th>Descripción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $historiales = [];
                                    foreach ($ubicacion->extensiones as $extension) {
                                        $historiales = array_merge($historiales, $extension->historialCambios->toArray());
                                    }
                                    // Ordenar por fecha, más reciente primero
                                    usort($historiales, function($a, $b) {
                                        return strtotime($b['fecha_cambio']) - strtotime($a['fecha_cambio']);
                                    });
                                    // Tomar solo los primeros 5
                                    $historiales = array_slice($historiales, 0, 5);
                                @endphp
                                
                                @forelse($historiales as $cambio)
                                <tr>
                                    <td>{{ date('d/m/Y H:i', strtotime($cambio['fecha_cambio'])) }}</td>
                                    <td>
                                        @foreach($ubicacion->extensiones as $extension)
                                            @if($extension->id_extension == $cambio['id_extension'])
                                                {{ $extension->numero_extension }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>{{ Str::limit($cambio['descripcion_cambio'], 50) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">No hay cambios registrados para esta ubicación</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <a href="{{ route('historial-cambios.create') }}" class="btn btn-sm btn-success mt-2">
                        <i class="fas fa-plus me-1"></i> Registrar Cambio
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-3">
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
            <i class="fas fa-trash me-1"></i> Eliminar Ubicación
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
                    ¿Está seguro de que desea eliminar esta ubicación en <strong>{{ $ubicacion->sede->nombre_sede ?? 'N/A' }} - {{ $ubicacion->oficina }}</strong>?
                    <br>Esta acción no se puede deshacer.
                    @if($ubicacion->extensiones->count() > 0 || $ubicacion->racks->count() > 0)
                    <div class="alert alert-warning mt-2">
                        <i class="fas fa-exclamation-triangle me-1"></i> Esta ubicación tiene extensiones o racks asociados. La eliminación podría fallar.
                    </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form action="{{ route('ubicaciones.destroy', $ubicacion->id_ubicacion) }}" method="POST" style="display:inline;">
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