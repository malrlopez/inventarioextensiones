@extends('layouts.app')

@section('title', $titulo ?? 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="border-bottom pb-2">Dashboard</h1>
        </div>
    </div>

    <!-- Enlace directo al registro de usuarios (solo para administradores) -->
    @if(auth()->user()->role === 'admin')
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-info">
                <h4><i class="fas fa-user-plus me-2"></i> Registro de Usuarios</h4>
                <p>Usa el siguiente enlace para registrar nuevos usuarios en el sistema:</p>
                <a href="{{ route('register') }}" class="btn btn-primary">Registrar Nuevo Usuario</a>
            </div>
        </div>
    </div>
    @endif

    <!-- Tarjetas de información básica (para todos los usuarios) -->
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <h5 class="card-title">Total Sistema de Telefonía</h5>
                    <p class="card-text display-4">{{ $totalExtensiones }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <h5 class="card-title">Empleados con Teléfono</h5>
                    <p class="card-text display-4">{{ $empleadosConExtensiones }}/{{ $totalEmpleados }}</p>
                </div>
            </div>
        </div>

        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'user')
        <div class="col-md-4">
            <div class="card bg-info text-white mb-4">
                <div class="card-body">
                    <h5 class="card-title">Número de Sedes</h5>
                    <p class="card-text display-4">{{ $sedes->count() }}</p>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Información adicional para administradores -->
    @if(auth()->user()->role === 'admin')
    <div class="row mt-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Estadísticas Avanzadas</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h5 class="card-title">% Uso de Extensiones</h5>
                                    <div class="display-4 text-primary">{{ $stats['porcentajeUso'] }}%</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Bloques Registrados</h5>
                                    <div class="display-4 text-success">{{ $bloques->count() }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Cambios Recientes (7 días)</h5>
                                    <div class="display-4 text-info">{{ $stats['cambiosRecientes'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Distribución de Extensiones por Sede</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($stats['extensionesPorSede'] as $sede => $cantidad)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $sede }}
                            <span class="badge rounded-pill" style="background-color: #ffc107;">{{ $cantidad }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Sedes y Ubicaciones</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($sedes as $sede)
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <strong><i class="fas fa-city me-2"></i> {{ $sede->nombre_sede }}</strong>
                                <div>
                                    <span class="badge rounded-pill me-1" style="background-color: #ffc107;" title="Ubicaciones">
                                        <i class="fas fa-map-marker-alt"></i> {{ $sede->ubicaciones_count }}
                                    </span>
                                    <span class="badge rounded-pill me-1" style="background-color: #ffc107;" title="Bloques">
                                        <i class="fas fa-building"></i> {{ $sede->bloques_count }}
                                    </span>
                                    <span class="badge rounded-pill" style="background-color: #ffc107;" title="Empleados">
                                        <i class="fas fa-users"></i> {{ $sede->empleados_count }}
                                    </span>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Sección para mostrar el historial de cambios recientes (admin y usuarios) -->
    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'user')
    <div class="mt-5">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">
                    @if(auth()->user()->role === 'admin')
                        Últimos Cambios Globales
                    @else
                        Mis Últimos Cambios
                    @endif
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Extensión</th>
                                <th>Descripción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ultimosCambios as $cambio)
                                <tr>
                                    <td>{{ $cambio->fecha_cambio ?? $cambio->created_at }}</td>
                                    <td>{{ $cambio->extension ? $cambio->extension->numero_extension : 'N/A' }}</td>
                                    <td>{{ $cambio->detalles }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No hay cambios registrados</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Enlaces rápidos (para todos) -->
    <div class="mt-4">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Enlaces Rápidos</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('extensiones.index') }}" class="btn btn-primary btn-lg d-block">
                            <i class="fas fa-phone me-2"></i> Extensiones
                        </a>
                    </div>

                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'user')
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('empleados.index') }}" class="btn btn-success btn-lg d-block">
                            <i class="fas fa-users me-2"></i> Empleados
                        </a>
                    </div>

                    <div class="col-md-3 mb-3">
                        <a href="{{ route('sedes.index') }}" class="btn btn-info btn-lg d-block">
                            <i class="fas fa-building me-2"></i> Sedes
                        </a>
                    </div>
                    @endif

                    @if(auth()->user()->role === 'admin')
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('historial.index') }}" class="btn btn-warning btn-lg d-block">
                            <i class="fas fa-history me-2"></i> Historial
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
