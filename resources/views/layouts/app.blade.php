<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema de Inventario de Extensiones')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <style>
        .sidebar {
            min-height: calc(100vh - 56px);
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        .content {
            padding: 20px;
        }
        .nav-link {
            color: #333;
        }
        .nav-link:hover {
            background-color: #e9ecef;
        }
        .nav-link.active {
            background-color: #dce3e6;
            font-weight: bold;
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="fas fa-phone-alt me-2"></i>
                Inventario de Extensiones
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-user me-1"></i> Usuario
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 sidebar">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('dashboard*') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('extensiones*') ? 'active' : '' }}" href="{{ route('extensiones.index') }}">
                            <i class="fas fa-phone me-2"></i> Extensiones
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('empleados*') ? 'active' : '' }}" href="{{ route('empleados.index') }}">
                            <i class="fas fa-users me-2"></i> Empleados
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('sedes*') ? 'active' : '' }}" href="{{ route('sedes.index') }}">
                            <i class="fas fa-building me-2"></i> Sedes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('bloques*') ? 'active' : '' }}" href="{{ route('bloques.index') }}">
                            <i class="fas fa-cubes me-2"></i> Bloques
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('ubicaciones*') ? 'active' : '' }}" href="{{ route('ubicaciones.index') }}">
                            <i class="fas fa-map-marker-alt me-2"></i> Ubicaciones
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('racks*') ? 'active' : '' }}" href="{{ route('racks.index') }}">
                            <i class="fas fa-server me-2"></i> Racks
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('switches*') ? 'active' : '' }}" href="{{ route('switches.index') }}">
                            <i class="fas fa-network-wired me-2"></i> Switches
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('softphones*') ? 'active' : '' }}" href="{{ route('softphones.index') }}">
                            <i class="fas fa-headset me-2"></i> Softphones
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('cargos*') ? 'active' : '' }}" href="{{ route('cargos.index') }}">
                            <i class="fas fa-id-badge me-2"></i> Cargos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('historial*') ? 'active' : '' }}" href="{{ route('historial.index') }}">
                            <i class="fas fa-history me-2"></i> Historial
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-md-10 content">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap JS y Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    @yield('scripts')
</body>
</html>