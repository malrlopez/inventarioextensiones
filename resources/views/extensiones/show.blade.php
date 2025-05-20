@extends('layouts.app')

@section('title', 'Detalle de Extensión - Sistema de Inventario')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Detalle de la Extensión: {{ $extension->numero_extension }}</h1>
        <div>
            <a href="{{ route('extensiones.edit', ['extensione' => $extension]) }}" class="btn btn-warning">
                <i class="fas fa-edit me-1"></i> Editar
            </a>
            <a href="{{ route('extensiones.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Volver
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Información de la Extensión</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 30%">ID:</th>
                            <td>{{ $extension->id_extension }}</td>
                        </tr>
                        <tr>
                            <th>Número:</th>
                            <td>{{ $extension->numero_extension }}</td>
                        </tr>
                        <tr>
                            <th>Tecnología:</th>
                            <td>{{ $extension->tecnologia }}</td>
                        </tr>
                        <tr>
                            <th>Puerto:</th>
                            <td>{{ $extension->puerto }}</td>
                        </tr>
                        <tr>
                            <th>COR:</th>
                            <td>{{ $extension->cor }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Historial de Cambios</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Descripción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($extension->historialCambios as $cambio)
                                <tr>
                                    <td>{{ date('d/m/Y H:i', strtotime($cambio->fecha_cambio)) }}</td>
                                    <td>{{ $cambio->descripcion_cambio }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" class="text-center">No hay cambios registrados</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Empleado Asignado</h5>
                </div>
                <div class="card-body">
                    @if($extension->empleado)
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-light rounded-circle p-3 me-3">
                                <i class="fas fa-user fa-2x text-primary"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">{{ $extension->empleado->nombre }} {{ $extension->empleado->apellido }}</h5>
                                <p class="mb-0">{{ $extension->empleado->cargo->nombre_cargo ?? 'Sin cargo' }}</p>
                                <p class="mb-0"><i class="fas fa-envelope me-1"></i> {{ $extension->empleado->email }}</p>
                                <p class="mb-0"><i class="fas fa-id-card me-1"></i> {{ $extension->empleado->numero_cedula }}</p>
                            </div>
                        </div>

                        <a href="{{ route('empleados.show', $extension->empleado->id_empleado) }}" class="btn btn-info text-white">
                            <i class="fas fa-eye me-1"></i> Ver Detalles del Empleado
                        </a>
                    @else
                        <p class="text-center">No hay empleado asignado a esta extensión</p>
                    @endif
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">Ubicación</h5>
                </div>
                <div class="card-body">
                    @if($extension->ubicacion)
                        <table class="table table-bordered">
                            <tr>
                                <th>Sede:</th>
                                <td>{{ $extension->ubicacion->sede->nombre_sede ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Bloque:</th>
                                <td>{{ $extension->ubicacion->bloque->nombre_bloque ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Oficina:</th>
                                <td>{{ $extension->ubicacion->oficina ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Planta Telefónica:</th>
                                <td>{{ $extension->ubicacion->planta_telefonica ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Cuarto Técnico:</th>
                                <td>{{ $extension->ubicacion->cuarto_tecnico ?? 'N/A' }}</td>
                            </tr>
                        </table>

                        <a href="{{ route('ubicaciones.show', $extension->ubicacion->id_ubicacion) }}" class="btn btn-info text-white">
                            <i class="fas fa-eye me-1"></i> Ver Detalles de la Ubicación
                        </a>
                    @else
                        <p class="text-center">No hay ubicación asignada a esta extensión</p>
                    @endif
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Softphone</h5>
                </div>
                <div class="card-body">
                    @if($extension->softphone)
                        <table class="table table-bordered">
                            <tr>
                                <th>Usuario:</th>
                                <td>{{ $extension->softphone->usuario }}</td>
                            </tr>
                            <tr>
                                <th>Dispositivo:</th>
                                <td>{{ $extension->softphone->dispositivo }}</td>
                            </tr>
                        </table>

                        <a href="{{ route('softphones.show', $extension->softphone->id_softphone) }}" class="btn btn-info text-white">
                            <i class="fas fa-eye me-1"></i> Ver Detalles del Softphone
                        </a>
                    @else
                        <p class="text-center">No hay softphone asignado a esta extensión</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
            <i class="fas fa-trash me-1"></i> Eliminar Extensión
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
</div>
@endsection
