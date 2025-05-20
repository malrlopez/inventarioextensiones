@extends('layouts.app')

@section('title', 'Detalle de Sede - Sistema de Inventario')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Detalle de la Sede: {{ $sede->nombre_sede }}</h1>
        <div>
            <a href="{{ route('sedes.edit', $sede->id_sede) }}" class="btn btn-warning">
                <i class="fas fa-edit me-1"></i> Editar
            </a>
            <a href="{{ route('sedes.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Volver
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Información de la Sede</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 30%">ID:</th>
                            <td>{{ $sede->id_sede }}</td>
                        </tr>
                        <tr>
                            <th>Nombre:</th>
                            <td>{{ $sede->nombre_sede }}</td>
                        </tr>
                        <tr>
                            <th>Dirección:</th>
                            <td>{{ $sede->direccion }}</td>
                        </tr>
                        <tr>
                            <th>Bloques:</th>
                            <td>{{ $sede->bloques->count() }}</td>
                        </tr>
                        <tr>
                            <th>Ubicaciones:</th>
                            <td>{{ $sede->ubicaciones->count() }}</td>
                        </tr>
                        <tr>
                            <th>Empleados:</th>
                            <td>{{ $sede->empleados->count() }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="bloques-tab" data-bs-toggle="tab" data-bs-target="#bloques" type="button" role="tab" aria-controls="bloques" aria-selected="true">Bloques</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="ubicaciones-tab" data-bs-toggle="tab" data-bs-target="#ubicaciones" type="button" role="tab" aria-controls="ubicaciones" aria-selected="false">Ubicaciones</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="empleados-tab" data-bs-toggle="tab" data-bs-target="#empleados" type="button" role="tab" aria-controls="empleados" aria-selected="false">Empleados</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="bloques" role="tabpanel" aria-labelledby="bloques-tab">
                    <div class="card border-top-0 rounded-top-0">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre del Bloque</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($sede->bloques as $bloque)
                                        <tr>
                                            <td>{{ $bloque->id_bloque }}</td>
                                            <td>{{ $bloque->nombre_bloque }}</td>
                                            <td>
                                                <a href="{{ route('bloques.show', $bloque->id_bloque) }}" class="btn btn-sm btn-info text-white">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3" class="text-center">No hay bloques registrados para esta sede</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <a href="{{ route('bloques.create') }}" class="btn btn-sm btn-success mt-2">
                                <i class="fas fa-plus me-1"></i> Agregar Bloque
                            </a>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="ubicaciones" role="tabpanel" aria-labelledby="ubicaciones-tab">
                    <div class="card border-top-0 rounded-top-0">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Bloque</th>
                                            <th>Oficina</th>
                                            <th>Planta Tel.</th>
                                            <th>Cuarto Téc.</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($sede->ubicaciones as $ubicacion)
                                        <tr>
                                            <td>{{ $ubicacion->id_ubicacion }}</td>
                                            <td>{{ $ubicacion->bloque->nombre_bloque ?? 'N/A' }}</td>
                                            <td>{{ $ubicacion->oficina }}</td>
                                            <td>{{ $ubicacion->planta_telefonica }}</td>
                                            <td>{{ $ubicacion->cuarto_tecnico }}</td>
                                            <td>
                                                <a href="{{ route('ubicaciones.show', $ubicacion->id_ubicacion) }}" class="btn btn-sm btn-info text-white">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No hay ubicaciones registradas para esta sede</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <a href="{{ route('ubicaciones.create') }}" class="btn btn-sm btn-success mt-2">
                                <i class="fas fa-plus me-1"></i> Agregar Ubicación
                            </a>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="empleados" role="tabpanel" aria-labelledby="empleados-tab">
                    <div class="card border-top-0 rounded-top-0">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Apellido</th>
                                            <th>Cargo</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($sede->empleados as $empleado)
                                        <tr>
                                            <td>{{ $empleado->id_empleado }}</td>
                                            <td>{{ $empleado->nombre }}</td>
                                            <td>{{ $empleado->apellido }}</td>
                                            <td>{{ $empleado->cargo->nombre_cargo ?? 'N/A' }}</td>
                                            <td>
                                                <span class="badge {{ $empleado->estado == 'Activo' ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $empleado->estado }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('empleados.show', $empleado->id_empleado) }}" class="btn btn-sm btn-info text-white">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No hay empleados registrados para esta sede</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <a href="{{ route('empleados.create') }}" class="btn btn-sm btn-success mt-2">
                                <i class="fas fa-plus me-1"></i> Agregar Empleado
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
            <i class="fas fa-trash me-1"></i> Eliminar Sede
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
                    ¿Está seguro de que desea eliminar la sede <strong>{{ $sede->nombre_sede }}</strong>?
                    <br>Esta acción no se puede deshacer.
                    @if($sede->bloques->count() > 0 || $sede->ubicaciones->count() > 0 || $sede->empleados->count() > 0)
                    <div class="alert alert-warning mt-2">
                        <i class="fas fa-exclamation-triangle me-1"></i> Esta sede tiene elementos asociados (bloques, ubicaciones y/o empleados). La eliminación podría fallar.
                    </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form action="{{ route('sedes.destroy', $sede->id_sede) }}" method="POST" style="display:inline;">
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
