@extends('layouts.app')

@section('title', 'Extensiones - Sistema de Inventario')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Extensiones</h1>
        <a href="{{ route('extensiones.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Nueva Extensión
        </a>
    </div>
    
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Número</th>
                            <th>Tecnología</th>
                            <th>Empleado</th>
                            <th>Ubicación</th>
                            <th>Softphone</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($extensiones as $extension)
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
                                @if($extension->softphone)
                                    {{ $extension->softphone->usuario }} ({{ $extension->softphone->dispositivo }})
                                @else
                                    <span class="text-muted">No asignado</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('extensiones.show', $extension->id_extension) }}" class="btn btn-sm btn-info" title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('extensiones.edit', $extension->id_extension) }}" class="btn btn-sm btn-warning" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $extension->id_extension }}" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                
                                <!-- Modal de confirmación de eliminación -->
                                <div class="modal fade" id="deleteModal{{ $extension->id_extension }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                ¿Está seguro de que desea eliminar la extensión <strong>{{ $extension->numero_extension }}</strong>?
                                                <br>Esta acción no se puede deshacer.
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <form action="{{ route('extensiones.destroy', $extension->id_extension) }}" method="POST" style="display:inline;">
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
                            <td colspan="6" class="text-center">No hay extensiones registradas</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection