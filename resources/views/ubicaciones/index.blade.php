@extends('layouts.app')

@section('title', 'Ubicaciones - Sistema de Inventario')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Listado de Ubicaciones</h1>
                <div class="d-flex gap-2">
                    <x-export-buttons tipo="ubicaciones" />
                    @if(Auth::user()->role !== 'viewer')
                    <a href="{{ route('ubicaciones.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i> Nueva Ubicación
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
                                            <form action="{{ route('ubicaciones.destroy', $ubicacion->id_ubicacion) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Está seguro de que desea eliminar la ubicación en {{ $ubicacion->sede->nombre_sede ?? 'N/A' }} - {{ $ubicacion->oficina }}? Esta acción no se puede deshacer.')">
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
                                    <td colspan="8" class="text-center">No hay ubicaciones registradas</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
