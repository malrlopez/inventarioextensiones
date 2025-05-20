@extends('layouts.app')

@section('title', 'Switches - Sistema de Inventario')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Listado de Switches</h1>
        <div class="d-flex gap-2">
            @if(Auth::user()->role !== 'viewer')
            <a href="{{ route('switches.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Nuevo Switch
            </a>
            @endif
        </div>
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
                                    <form action="{{ route('switches.destroy', $switch->id_switch) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Está seguro de que desea eliminar el switch {{ $switch->marca }} {{ $switch->referencia }}? Esta acción no se puede deshacer.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
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
