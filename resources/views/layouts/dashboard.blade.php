@extends('layouts.app')

@section('title', 'Dashboard - Sistema de Inventario de Extensiones')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Dashboard</h1>
    
    <div class="row">
        <!-- Tarjeta de Extensiones -->
        <div class="col-md-3 mb-4">
            <div class="card bg-primary text-white h-100">
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
            <div class="card bg-success text-white h-100">
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
            <div class="card bg-danger text-white h-100">
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
        <!-- Últimos Cambios -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Últimos Cambios Registrados</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
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
                                    <td>{{ date('d/m/Y H:i', strtotime($cambio->fecha_cambio)) }}</td>
                                    <td>{{ $cambio->extension->numero_extension }}</td>
                                    <td>{{ Str::limit($cambio->descripcion_cambio, 50) }}</td>
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
                <div class="card-footer text-end">
                    <a href="{{ route('historial-cambios.index') }}" class="btn btn-sm btn-primary">Ver todos</a>
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
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Sede</th>
                                    <th>Ubicaciones</th>
                                    <th>Dirección</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sedes as $sede)
                                <tr>
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
</div>
@endsection