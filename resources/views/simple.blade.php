<!DOCTYPE html>
<html>
<head>
    <title>{{ $titulo ?? 'Dashboard' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Dashboard - Sistema de Inventario</h1>
        
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Extensiones</h5>
                        <p class="card-text display-4">{{ $totalExtensiones }}</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Empleados con Extensión</h5>
                        <p class="card-text display-4">{{ $empleadosConExtensiones }}/{{ $totalEmpleados }}</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h5 class="card-title">Sedes</h5>
                        <p class="card-text display-4">{{ $sedes->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <h5 class="card-title">Ubicaciones</h5>
                        <p class="card-text display-4">{{ $sedes->sum('ubicaciones_count') }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Últimos Cambios</div>
                    <div class="card-body">
                        @if(count($ultimosCambios) > 0)
                            <ul class="list-group">
                            @foreach($ultimosCambios as $cambio)
                                <li class="list-group-item">
                                    {{ date('d/m/Y', strtotime($cambio->fecha_cambio)) }} - 
                                    {{ $cambio->extension->numero_extension ?? 'N/A' }}:
                                    {{ \Illuminate\Support\Str::limit($cambio->descripcion_cambio, 50) }}
                                </li>
                            @endforeach
                            </ul>
                        @else
                            <p>No hay cambios registrados</p>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Sedes</div>
                    <div class="card-body">
                        @if(count($sedes) > 0)
                            <ul class="list-group">
                            @foreach($sedes as $sede)
                                <li class="list-group-item">
                                    {{ $sede->nombre_sede }} - 
                                    {{ $sede->ubicaciones_count }} ubicaciones - 
                                    {{ $sede->direccion }}
                                </li>
                            @endforeach
                            </ul>
                        @else
                            <p>No hay sedes registradas</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>