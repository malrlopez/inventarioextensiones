@extends('layouts.app')

@section('title', 'Ubicaciones - Sistema de Inventario')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Ubicaciones</h1>
        <a href="{{ route('ubicaciones.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Nueva Ubicación
        </a>
    </div>
    
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Sede</th>
                            <th>Bloque</th>
                            <th>Oficina</th>
                            <th>Planta Telefónica</th>
                            <th>Cuarto Técnico</th>
                            <th>Extensiones</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ubicaciones as $ubicacion)
                        <tr>
                            <td>{{ $ubicacion->id_ubicacion }}</td>
                            <td>{{ $ubicacion->sede->nombre_sede ?? 'N/A' }}</td>
                            <td>{{ $ubicacion->bloque->nombre_bloque ?? 'N/A' }}</td>
                            <td>{{ $ubicacion->oficina }}</td>
                            <td>{{ $ubicacion->planta_telefonica }}</td>
                            <td>{{ $ubicacion->cuarto_tecnico }}</td>
                            <td>{{ $ubicacion->extensiones->count() }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('ubicaciones.show', $ubicacion->id_ubicacion) }}" class="btn btn-sm btn-info" title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('ubicaciones.edit', $ubicacion->id_ubicacion) }}" class="btn btn-sm btn-warning" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $ubicacion->id_ubicacion }}" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                
                                <!-- Modal de confirmación de eliminación -->
                                <div class="modal fade" id="deleteModal{{ $ubicacion->id_ubicacion }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                ¿Está seguro de que desea eliminar la ubicación en <strong>{{ $ubicacion->sede->nombre_sede ?? 'N/A' }} - {{ $ubicacion->oficina }}</strong>?
                                                <br>Esta acción no se puede deshacer.
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
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">No hay ubicaciones registradas</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection