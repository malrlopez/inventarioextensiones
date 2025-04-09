<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
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
        </div>
        
        <div class="mt-4">
            <a href="{{ route('extensiones.index') }}" class="btn btn-primary">Ir a Extensiones</a>
            <a href="{{ route('empleados.index') }}" class="btn btn-primary">Ir a Empleados</a>
            <a href="{{ route('sedes.index') }}" class="btn btn-primary">Ir a Sedes</a>
            <a href="{{ route('test.db-connection') }}" class="btn btn-info">Probar Conexión BD</a>
        </div>
    </div>
</body>
</html>