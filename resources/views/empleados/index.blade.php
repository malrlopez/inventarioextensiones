@extends('layouts.app')

@section('title', 'Empleados - Sistema de Inventario')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Listado de Empleados</h1>
                <div class="d-flex gap-2">
                    <form action="{{ route('reportes.generar') }}" method="POST" class="me-2">
                        @csrf
                        <input type="hidden" name="tipo" value="empleados">
                        <input type="hidden" name="formato" value="html">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-chart-bar me-1"></i> Generar Reporte
                        </button>
                    </form>
                    @if(Auth::user()->role !== 'viewer')
                    <a href="{{ route('empleados.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i> Nuevo Empleado
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
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Email</th>
                                    <th>Cargo</th>
                                    <th>Sede</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($empleados as $empleado)
                                <tr>
                                    <td>{{ $empleado->id_empleado }}</td>
                                    <td>{{ $empleado->nombre }}</td>
                                    <td>{{ $empleado->apellido }}</td>
                                    <td>{{ $empleado->email }}</td>
                                    <td>{{ $empleado->cargo->nombre_cargo ?? 'N/A' }}</td>
                                    <td>{{ $empleado->sede->nombre_sede ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge {{ $empleado->estado == 'Activo' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $empleado->estado }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('empleados.show', $empleado->id_empleado) }}" class="btn btn-sm btn-info" title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('empleados.edit', $empleado->id_empleado) }}" class="btn btn-sm btn-warning" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('empleados.destroy', $empleado->id_empleado) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Está seguro de que desea eliminar al empleado {{ $empleado->nombre }} {{ $empleado->apellido }}? Esta acción no se puede deshacer.')">
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
                                    <td colspan="8" class="text-center">No hay empleados registrados</td>
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
