@extends('layouts.app')

@section('title', 'Softphones - Sistema de Inventario')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Listado de Softphones</h1>
                <div class="d-flex gap-2">
                    <x-export-buttons tipo="softphones" />
                    @if(Auth::user()->role !== 'viewer')
                    <a href="{{ route('softphones.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i> Nuevo Softphone
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
                                    <th>Usuario</th>
                                    <th>Dispositivo</th>
                                    <th>Extensiones Asignadas</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($softphones as $softphone)
                                <tr>
                                    <td>{{ $softphone->id_softphone }}</td>
                                    <td>{{ $softphone->usuario }}</td>
                                    <td>{{ $softphone->dispositivo }}</td>
                                    <td>{{ $softphone->extensiones_count ?? $softphone->extensiones->count() }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('softphones.show', $softphone->id_softphone) }}" class="btn btn-sm btn-info" title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('softphones.edit', $softphone->id_softphone) }}" class="btn btn-sm btn-warning" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('softphones.destroy', $softphone->id_softphone) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Está seguro de que desea eliminar el softphone {{ $softphone->usuario }}? Esta acción no se puede deshacer.')">
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
                                    <td colspan="5" class="text-center">No hay softphones registrados</td>
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
