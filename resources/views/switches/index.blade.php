@extends('layouts.app')

@section('title', 'Switches - Sistema de Inventario')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Switches</h1>
        <a href="{{ route('switches.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Nuevo Switch
        </a>
    </div>
    
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Marca</th>
                            <th>Referencia</th>
                            <th>Puerto Asignado</th>
                            <th>Puertos (Total/Disponibles)</th>
                            <th>VLAN</th>
                            <th>Rack</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($switches as $switch)
                        <tr>
                            <td>{{ $switch->id_switch }}</td>
                            <td>{{ $switch->marca }}</td>
                            <td>{{ $switch->referencia }}</td>
                            <td>{{ $switch->puerto_switche_asignado }}</td>
                            <td>{{ $switch->total_puertos }} / {{ $switch->puertos_disponibles }}</td>
                            <td>{{ $switch->vlan }}</td>
                            <td>
                                @if($switch->rack)
                                    {{ $switch->rack->marca }} {{ $switch->rack->referencia }}
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('switches.show', $switch->id_switch) }}" class="btn btn-sm btn-info" title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('switches.edit', $switch->id_switch) }}" class="btn btn-sm btn-warning" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $switch->id_switch }}" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                
                                <!-- Modal de confirmación de eliminación -->
                                <div class="modal fade" id="deleteModal{{ $switch->id_switch }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                ¿Está seguro de que desea eliminar el switch <strong>{{ $switch->marca }} {{ $switch->referencia }}</strong>?
                                                <br>Esta acción no se puede deshacer.
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <form action="{{ route('switches.destroy', $switch->id_switch) }}" method="POST" style="display:inline;">
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
                            <td colspan="8" class="text-center">No hay switches registrados</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection