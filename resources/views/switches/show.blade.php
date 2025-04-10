@extends('layouts.app')

@section('title', 'Detalle de Switch - Sistema de Inventario')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Detalle del Switch: {{ $switchEquipo->marca }} {{ $switchEquipo->referencia }}</h1>
        <div>
            <a href="{{ route('switches.edit', $switchEquipo->id_switch) }}" class="btn btn-warning">
                <i class="fas fa-edit me-1"></i> Editar
            </a>
            <a href="{{ route('switches.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Volver
            </a>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Información del Switch</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 40%">ID:</th>
                            <td>{{ $switchEquipo->id_switch }}</td>
                        </tr>
                        <tr>
                            <th>Marca:</th>
                            <td>{{ $switchEquipo->marca }}</td>
                        </tr>
                        <tr>
                            <th>Referencia:</th>
                            <td>{{ $switchEquipo->referencia }}</td>
                        </tr>
                        <tr>
                            <th>Puerto Asignado:</th>
                            <td>{{ $switchEquipo->puerto_switche_asignado }}</td>
                        </tr>
                        <tr>
                            <th>VLAN:</th>
                            <td>{{ $switchEquipo->vlan }}</td>
                        </tr>
                        <tr>
                            <th>Total de Puertos:</th>
                            <td>{{ $switchEquipo->total_puertos }}</td>
                        </tr>
                        <tr>
                            <th>Puertos Disponibles:</th>
                            <td>{{ $switchEquipo->puertos_disponibles }}</td>
                        </tr>
                        <tr>
                            <th>Ocupación:</th>
                            <td>
                                @php
                                    $ocupacion = $switchEquipo->total_puertos - $switchEquipo->puertos_disponibles;
                                    $porcentaje = $switchEquipo->total_puertos > 0 ? ($ocupacion / $switchEquipo->total_puertos * 100) : 0;
                                @endphp
                                
                                <span class="{{ $porcentaje > 80 ? 'text-danger' : ($porcentaje > 60 ? 'text-warning' : 'text-success') }} fw-bold">
                                    {{ number_format($porcentaje, 0) }}%
                                </span>
                                <span class="ms-2">
                                    ({{ $ocupacion }} de {{ $switchEquipo->total_puertos }} puertos utilizados)
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Información del Rack</h5>
                </div>
                <div class="card-body">
                    @if(isset($switchEquipo->rack) && $switchEquipo->rack !== null)
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 30%">ID:</th>
                                <td>{{ $switchEquipo->rack->id_rack }}</td>
                            </tr>
                            <tr>
                                <th>Marca:</th>
                                <td>{{ $switchEquipo->rack->marca }}</td>
                            </tr>
                            <tr>
                                <th>Modelo:</th>
                                <td>{{ $switchEquipo->rack->modelo ?? 'No especificado' }}</td>
                            </tr>
                            <tr>
                                <th>Ubicación:</th>
                                <td>{{ $switchEquipo->rack->ubicacion ?? 'No especificada' }}</td>
                            </tr>
                            <tr>
                                <th>Estado:</th>
                                <td>{{ $switchEquipo->rack->estado ?? 'No especificado' }}</td>
                            </tr>
                        </table>
                        <div class="mt-2">
                            <a href="{{ route('racks.show', $switchEquipo->rack->id_rack) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye me-1"></i> Ver Rack
                            </a>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i> Este switch no está asignado a ningún rack.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Sección de dispositivos conectados -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Dispositivos Conectados</h5>
                </div>
                <div class="card-body">
                    @if(isset($dispositivosConectados) && $dispositivosConectados !== null && count($dispositivosConectados) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tipo</th>
                                        <th>Marca</th>
                                        <th>Modelo</th>
                                        <th>Puerto Utilizado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dispositivosConectados as $dispositivo)
                                        <tr>
                                            <td>{{ $dispositivo->id }}</td>
                                            <td>{{ $dispositivo->tipo }}</td>
                                            <td>{{ $dispositivo->marca }}</td>
                                            <td>{{ $dispositivo->modelo }}</td>
                                            <td>{{ $dispositivo->puerto_switch }}</td>
                                            <td>
                                                <a href="{{ route('dispositivos.show', $dispositivo->id) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i> No hay dispositivos conectados a este switch.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection