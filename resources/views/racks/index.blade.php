@extends('layouts.app')

@section('title', 'Racks - Sistema de Inventario')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Listado de Racks</h1>
        <div class="d-flex gap-2">
            @if(Auth::user()->role !== 'viewer')
            <a href="{{ route('racks.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Nuevo Rack
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
                            <th>Ubicación</th>
                            <th>Switches</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($racks as $rack)
                        <tr>
                            <td>{{ $rack->id_rack }}</td>
                            <td>{{ $rack->marca }}</td>
                            <td>{{ $rack->referencia }}</td>
                            <td>
                                @if($rack->ubicacion)
                                    {{ $rack->ubicacion->oficina ?? 'N/A' }}
                                    ({{ optional($rack->ubicacion->sede)->nombre_sede ?? 'N/A' }})
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>{{ $rack->switches->count() }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('racks.show', $rack->id_rack) }}" class="btn btn-sm btn-info" title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('racks.edit', $rack->id_rack) }}" class="btn btn-sm btn-warning" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('racks.destroy', $rack->id_rack) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Está seguro de que desea eliminar el rack {{ $rack->marca }} {{ $rack->referencia }}? Esta acción no se puede deshacer.')">
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
                            <td colspan="6" class="text-center">No hay racks registrados</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
