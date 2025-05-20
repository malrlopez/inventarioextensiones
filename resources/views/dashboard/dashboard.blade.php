@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Dashboard</h1>

    <div class="row">
        <!-- Tarjeta de Extensiones -->
        <div class="col-md-3 mb-4">
            <div class="card bg-warning text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase">Total de Extensiones</h6>
                            <h1 class="display-4">{{ $totalExtensiones }}</h1>
                        </div>
                        <i class="fas fa-phone fa-3x opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="{{ route('extensiones.index') }}" class="text-white text-decoration-none">Ver detalles</a>
                    <i class="fas fa-angle-right text-white"></i>
                </div>
            </div>
        </div>

        <!-- Tarjeta de Empleados -->
        <div class="col-md-3 mb-4">
            <div class="card bg-warning text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase">Empleados con Extensión</h6>
                            <h1 class="display-4">{{ $empleadosConExtensiones }}/{{ $totalEmpleados }}</h1>
                        </div>
                        <i class="fas fa-users fa-3x opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="{{ route('empleados.index') }}" class="text-white text-decoration-none">Ver detalles</a>
                    <i class="fas fa-angle-right text-white"></i>
                </div>
            </div>
        </div>

        <!-- Tarjeta de Sedes -->
        <div class="col-md-3 mb-4">
            <div class="card bg-warning text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase">Total de Sedes</h6>
                            <h1 class="display-4">{{ $sedes->count() }}</h1>
                        </div>
                        <i class="fas fa-building fa-3x opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="{{ route('sedes.index') }}" class="text-white text-decoration-none">Ver detalles</a>
                    <i class="fas fa-angle-right text-white"></i>
                </div>
            </div>
        </div>

        <!-- Tarjeta de Ubicaciones -->
        <div class="col-md-3 mb-4">
            <div class="card bg-warning text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase">Total de Ubicaciones</h6>
                            <h1 class="display-4">{{ $sedes->sum('ubicaciones_count') }}</h1>
                        </div>
                        <i class="fas fa-map-marker-alt fa-3x opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="{{ route('ubicaciones.index') }}" class="text-white text-decoration-none">Ver detalles</a>
                    <i class="fas fa-angle-right text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Accesos rápidos a reportes -->
        <div class="col-md-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Reportes Rápidos</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="{{ route('reportes.generar', ['tipo' => 'softphones', 'formato' => 'html']) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-headset text-warning me-2"></i>
                                <span>Reporte de Softphones</span>
                            </div>
                            <span class="badge bg-warning rounded-pill">{{ $softphones->count() }}</span>
                        </a>
                        <a href="{{ route('reportes.generar', ['tipo' => 'extensiones', 'formato' => 'html']) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-phone text-warning me-2"></i>
                                <span>Reporte de Extensiones</span>
                            </div>
                            <span class="badge bg-warning rounded-pill">{{ $extensiones->count() }}</span>
                        </a>
                        <a href="{{ route('reportes.generar', ['tipo' => 'empleados', 'formato' => 'html']) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-users text-warning me-2"></i>
                                <span>Reporte de Empleados</span>
                            </div>
                            <span class="badge bg-warning rounded-pill">{{ $totalEmpleados }}</span>
                        </a>
                        <a href="{{ route('reportes.generar', ['tipo' => 'dispositivos', 'formato' => 'html']) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-mobile-alt text-warning me-2"></i>
                                <span>Reporte de Dispositivos</span>
                            </div>
                            <span class="badge bg-warning rounded-pill">{{ $dispositivos->count() }}</span>
                        </a>
                        <a href="{{ route('reportes.generar', ['tipo' => 'estadisticas', 'formato' => 'html', 'tipo_grafico' => 'pie', 'agrupar_por' => 'sede']) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-chart-pie text-warning me-2"></i>
                                <span>Estadísticas por Sede</span>
                            </div>
                            <i class="fas fa-chart-pie text-warning"></i>
                        </a>
                    </div>
                </div>
                <div class="card-footer bg-white text-center">
                    <a href="{{ route('reportes.index') }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-cog me-1"></i> Personalizar Reportes
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Últimos Cambios -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Últimos Cambios Registrados</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="table-warning">
                                <tr>
                                    <th>Fecha</th>
                                    <th>Extensión</th>
                                    <th>Descripción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ultimosCambios as $cambio)
                                <tr class="table-warning">
                                    <td>{{ date('d/m/Y H:i', strtotime($cambio->fecha_cambio)) }}</td>
                                    <td>{{ $cambio->extension->numero_extension ?? 'N/A' }}</td>
                                    <td>{{ isset($cambio['descripcion_cambio']) ? Str::limit($cambio['descripcion_cambio'], 50) : 'Sin descripción' }}</td>
                                </tr>
                                @empty
                                <tr class="table-warning">
                                    <td colspan="3" class="text-center">No hay cambios registrados</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('historial-cambios.index') }}" class="btn btn-sm btn-primary">Ver historial completo</a>
                </div>
            </div>
        </div>

        <!-- Sedes y Ubicaciones -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Distribución por Sedes</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="table-warning">
                                <tr>
                                    <th>Sede</th>
                                    <th>Ubicaciones</th>
                                    <th>Dirección</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sedes as $sede)
                                <tr class="table-warning">
                                    <td>{{ $sede->nombre_sede }}</td>
                                    <td>{{ $sede->ubicaciones_count }}</td>
                                    <td>{{ $sede->direccion }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('sedes.index') }}" class="btn btn-sm btn-primary">Ver todas</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Enlace temporal a reportes para pruebas -->
    <div class="mt-4 p-4 bg-white shadow rounded-lg">
        <h3 class="text-lg font-semibold mb-2">Enlaces rápidos</h3>
        <a href="{{ route('reportes.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
            <i class="fas fa-chart-bar mr-2"></i> Acceso a Reportes
        </a>
    </div>
</div>
@endsection