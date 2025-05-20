@extends('layouts.app')

@section('title', 'Extensiones')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Listado de Extensiones</h1>
                <div class="d-flex gap-2">
                    <x-export-buttons tipo="extensiones" />
                    @if(Auth::user()->role !== 'viewer')
                    <a href="{{ route('extensiones.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i> Nueva Extensión
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
                                            <form action="{{ route('extensiones.destroy', $extension->id_extension) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Está seguro de que desea eliminar la extensión {{ $extension->numero_extension }}? Esta acción no se puede deshacer.')">
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
                                    <td colspan="6" class="text-center">No hay extensiones registradas</td>
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
