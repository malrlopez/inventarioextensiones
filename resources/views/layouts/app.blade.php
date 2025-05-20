<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo.svg') }}">
    <link rel="alternate icon" href="{{ asset('images/logo.svg') }}" type="image/svg+xml">
    <link rel="mask-icon" href="{{ asset('images/logo.svg') }}" color="#005C8E">

    <title>@yield('title', 'Sistema de Telefonía')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Custom CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, var(--primary-very-dark) 0%, var(--primary-dark) 100%);
            padding-top: 20px;
            box-shadow: 2px 0 5px rgba(0,0,0,0.2);
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 100;
        }

        .nav-link {
            color: var(--secondary-light) !important;
            padding: 12px 20px;
            border-radius: 8px;
            margin: 5px 10px;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
            color: #ffffff !important;
        }

        .nav-link.active {
            background-color: var(--primary);
            color: #ffffff !important;
            font-weight: bold;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .nav-link i {
            width: 24px;
            text-align: center;
        }

        .navbar {
            background: linear-gradient(90deg, var(--primary-very-dark) 0%, var(--primary) 100%) !important;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .content {
            padding: 25px;
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
            margin: 20px;
            min-height: calc(100vh - 40px);
        }

        .card {
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            border-radius: 10px;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .navbar-brand {
            color: #ffffff !important;
            font-weight: bold;
            font-size: 1.5rem;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-radius: 8px;
        }

        .dropdown-item {
            padding: 8px 20px;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
            transform: translateX(5px);
        }

        .logo-img {
            height: 120px;
            margin-right: 20px;
            filter: drop-shadow(2px 2px 4px rgba(0,0,0,0.2));
        }

        .search-container {
            min-width: 300px;
        }

        .search-results-container {
            background: white;
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            max-height: 300px;
            overflow-y: auto;
        }

        .search-result-item {
            padding: 10px 15px;
            cursor: pointer;
            border-bottom: 1px solid #eee;
            transition: all 0.2s ease;
        }

        .search-result-item:hover {
            background-color: #f8f9fa;
            transform: translateX(5px);
        }

        .badge {
            padding: 5px 10px;
            border-radius: 6px;
            font-weight: 500;
        }

        .badge.bg-danger {
            background-color: #636E72 !important;
        }

        .badge.bg-primary {
            background-color: #B2BEC3 !important;
            color: #2D3436;
        }

        .badge.bg-info {
            background-color: #DFE6E9 !important;
            color: #2D3436;
        }

        .btn-outline-light:hover {
            background-color: #636E72;
            border-color: #636E72;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                left: -100%;
                transition: 0.3s;
                width: 250px;
                z-index: 1050;
                background: linear-gradient(180deg, #2D3436 0%, #636E72 100%);
                box-shadow: 2px 0 5px rgba(0,0,0,0.2);
                height: calc(100vh - 60px);
                top: 60px;
            }
            .sidebar.show {
                left: 0;
            }
            .content {
                margin: 10px;
                padding: 15px;
                width: 100%;
            }
            .nav-link {
                margin: 2px 5px;
            }
            .logo-img {
                height: 40px;
            }
            .navbar {
                padding: 0.5rem;
                min-height: 60px;
            }
            .navbar-brand {
                font-size: 1rem;
                padding: 0;
                max-width: 200px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            .navbar-collapse {
                background: linear-gradient(90deg, #2D3436 0%, #636E72 100%);
                padding: 1rem;
                position: fixed;
                top: 60px;
                left: 0;
                right: 0;
                z-index: 1040;
                max-height: calc(100vh - 60px);
                overflow-y: auto;
            }
            .navbar-collapse.show {
                display: flex;
                flex-direction: column;
            }
            .navbar-collapse .search-container {
                width: 100%;
                margin: 0.5rem 0;
            }
            .navbar-nav {
                margin-top: 0.5rem;
            }
            #menuToggle {
                padding: 0.25rem 0.75rem;
                font-size: 1.25rem;
                border: 1px solid rgba(255,255,255,0.1);
            }
            .search-results-container {
                position: fixed !important;
                top: auto !important;
                left: 0 !important;
                right: 0 !important;
                width: 100% !important;
                max-height: 50vh;
                z-index: 1060;
            }
        }

        @media (max-width: 480px) {
            .navbar-brand {
                max-width: 120px;
                font-size: 0.9rem;
            }
            .logo-img {
                height: 30px;
                margin-right: 8px;
            }
            .navbar {
                padding: 0.25rem 0.5rem;
                min-height: 50px;
            }
            #menuToggle, .navbar-toggler {
                padding: 0.2rem 0.4rem;
                font-size: 0.9rem;
            }
            .navbar > .container-fluid {
                padding-left: 2px;
                padding-right: 2px;
            }
            .navbar-collapse {
                top: 50px;
                max-height: calc(100vh - 50px);
            }
            .search-container .input-group {
                flex-wrap: nowrap;
            }
            .search-container .form-control {
                font-size: 0.9rem;
                padding: 0.375rem 0.5rem;
            }
            .search-container .btn {
                padding: 0.375rem 0.5rem;
                font-size: 0.9rem;
            }
        }

        /* Estilos para las tablas */
        .table {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            margin-bottom: 1.5rem;
        }

        .table thead {
            background: linear-gradient(90deg, #2D3436 0%, #636E72 100%);
            color: #ffffff;
        }

        .table thead th {
            border: none;
            padding: 15px;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .table thead th:first-child {
            border-top-left-radius: 8px;
        }

        .table thead th:last-child {
            border-top-right-radius: 8px;
        }

        .table tbody tr {
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            background-color: rgba(99, 110, 114, 0.05);
            transform: scale(1.01);
        }

        .table td {
            padding: 12px 15px;
            vertical-align: middle;
            border-color: #f1f1f1;
        }

        .table tbody tr:last-child td:first-child {
            border-bottom-left-radius: 8px;
        }

        .table tbody tr:last-child td:last-child {
            border-bottom-right-radius: 8px;
        }

        /* Estilos para botones en tablas */
        .table .btn {
            padding: 5px 10px;
            font-size: 0.875rem;
            margin: 0 3px;
            border-radius: 6px;
        }

        .table .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }

        /* Estilos para estados en tablas */
        .table .badge {
            font-size: 0.75rem;
            padding: 5px 10px;
            border-radius: 6px;
        }

        .table .badge-success {
            background-color: #2ecc71;
            color: white;
        }

        .table .badge-warning {
            background-color: #f1c40f;
            color: #2D3436;
        }

        .table .badge-danger {
            background-color: #e74c3c;
            color: white;
        }

        .table .badge-info {
            background-color: #3498db;
            color: white;
        }

        /* Estilos para tablas responsivas */
        @media (max-width: 768px) {
            .table-responsive {
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            }

            .table {
                margin-bottom: 0;
            }

            .table td {
                white-space: nowrap;
            }
        }

        /* Estilos para paginación */
        .pagination {
            margin-top: 1rem;
        }

        .page-item.active .page-link {
            background: linear-gradient(90deg, #2D3436 0%, #636E72 100%);
            border-color: #2D3436;
        }

        .page-link {
            color: #2D3436;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            margin: 0 2px;
        }

        .page-link:hover {
            background-color: #f1f1f1;
            color: #2D3436;
        }

        /* Estilos para el footer */
        .footer {
            background: linear-gradient(90deg, var(--primary-very-dark) 0%, var(--primary) 100%);
            color: #fff;
            padding: 15px 0;
            margin-top: 30px;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
        }

        .footer .text-muted {
            color: rgba(255, 255, 255, 0.8) !important;
            font-size: 0.85rem;
        }

        .footer-logo {
            height: 40px;
            filter: brightness(0) invert(1);
            margin-bottom: 0;
        }

        .footer-brand {
            font-weight: bold;
            font-size: 1rem;
            color: #ffffff;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
            margin-bottom: 0;
        }

        .social-icons {
            display: flex;
            justify-content: center;
            margin-top: 8px;
        }

        .social-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            margin: 0 5px;
        }

        .social-icon:hover {
            background-color: rgba(255, 255, 255, 0.2);
            color: #fff;
            transform: translateY(-3px);
        }
    </style>

    @yield('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <div class="d-flex align-items-center flex-grow-1">
                @auth
                <button class="navbar-toggler me-2" type="button" id="menuToggle">
                    <i class="fas fa-bars"></i>
                </button>
                @endauth
                <a class="navbar-brand me-auto" href="{{ route('dashboard') }}">
                    <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="logo-img">
                    <span class="d-none d-sm-inline">Sistema de Telefonía</span>
                    <span class="d-inline d-sm-none">SISIPT</span>
                </a>
            </div>

            @guest
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            @endauth

            <div class="collapse navbar-collapse" id="navbarNav">
                @auth
                <div class="search-container w-100 mb-2">
                    <div class="input-group">
                        <input type="text" id="searchInput" class="form-control" placeholder="Buscar extensiones, empleados...">
                        <button class="btn btn-outline-light" type="button" id="searchButton">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                @endauth

                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-1"></i> Iniciar Sesión
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="fas fa-user-plus me-1"></i> Registrarse
                            </a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-1"></i> {{ Auth::user()->name }}
                                @if(Auth::user()->isAdmin())
                                    <span class="badge bg-danger">Admin</span>
                                @elseif(Auth::user()->isUser())
                                    <span class="badge bg-primary">Usuario</span>
                                @elseif(Auth::user()->isViewer())
                                    <span class="badge bg-info">Visualizador</span>
                                @endif
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-1"></i> Cerrar Sesión
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row flex-nowrap">
            @auth
            <div class="col-auto col-md-2 px-0 sidebar">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('dashboard*') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                    </li>

                    <!-- Menu00fa reordenado seguu00fan la secuencia solicitada -->
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
                        <a class="nav-link {{ request()->is('switches*') ? 'active' : '' }}" href="{{ route('switches.index') }}">
                            <i class="fas fa-network-wired me-2"></i> Switches
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('racks*') ? 'active' : '' }}" href="{{ route('racks.index') }}">
                            <i class="fas fa-server me-2"></i> Racks
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('cargos*') ? 'active' : '' }}" href="{{ route('cargos.index') }}">
                            <i class="fas fa-briefcase me-2"></i> Cargos
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('empleados*') ? 'active' : '' }}" href="{{ route('empleados.index') }}">
                            <i class="fas fa-users me-2"></i> Empleados
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('softphones*') ? 'active' : '' }}" href="{{ route('softphones.index') }}">
                            <i class="fas fa-headset me-2"></i> Softphones
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('extensiones*') ? 'active' : '' }}" href="{{ route('extensiones.index') }}">
                            <i class="fas fa-phone me-2"></i> Extensiones
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('historial*') ? 'active' : '' }}" href="{{ route('historial.index') }}">
                            <i class="fas fa-history me-2"></i> Historial
                        </a>
                    </li>                   
                </ul>
            </div>
            <div class="col ps-md-2 pt-2">
                <div class="content">
            @else
            <div class="col-12">
                <div class="content">
            @endauth
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

    <!-- Footer -->
    <footer class="footer mt-auto">
        <div class="container-fluid">
            <div class="row align-items-center text-center">
                <div class="col-12 mb-2">
                    <a class="footer-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
                        <span>Sistema de Telefonía</span>
                    </a>
                </div>
                <div class="col-12">
                    <div class="social-icons">
                        <a href="https://facebook.com" target="_blank" class="social-icon">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com" target="_blank" class="social-icon">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://linkedin.com" target="_blank" class="social-icon">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="https://instagram.com" target="_blank" class="social-icon">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
                <div class="col-12 mt-2">
                    <span class="text-muted">&copy; {{ date('Y') }} Todos los derechos reservados.</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS y Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    @yield('scripts')

    <!-- Script para el buscador -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Controlador unificado del menú
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.querySelector('.sidebar');
        const navbarCollapse = document.getElementById('navbarNav');

        if (menuToggle && sidebar && navbarCollapse) {
            menuToggle.addEventListener('click', () => {
                sidebar.classList.toggle('show');
                navbarCollapse.classList.toggle('show');
            });

            // Cerrar menús al hacer clic fuera
            document.addEventListener('click', (e) => {
                if (!sidebar.contains(e.target) &&
                    !menuToggle.contains(e.target) &&
                    !navbarCollapse.contains(e.target) &&
                    window.innerWidth <= 768) {
                    sidebar.classList.remove('show');
                    navbarCollapse.classList.remove('show');
                }
            });
        }

        // Configuración de búsqueda
        const searchInput = document.getElementById('searchInput');
        const searchButton = document.getElementById('searchButton');
        let timeoutId;

        if (searchInput && searchButton) {
            function showResults(results) {
                const resultsContainer = document.createElement('div');
                resultsContainer.className = 'search-results-container position-absolute w-100 mt-1';
                resultsContainer.style.zIndex = '1000';

                if (!Array.isArray(results) || results.length === 0) {
                    resultsContainer.innerHTML = `
                        <div class="search-result-item">
                            No se encontraron resultados
                        </div>`;
                } else {
                    resultsContainer.innerHTML = results.map(item => {
                        let icon = 'fa-search';
                        switch(item.type) {
                            case 'extension': icon = 'fa-phone'; break;
                            case 'empleado': icon = 'fa-user'; break;
                            case 'softphone': icon = 'fa-headset'; break;
                        }
                        return `
                            <div class="search-result-item" data-url="${item.url}">
                                <i class="fas ${icon}"></i> ${item.text}
                            </div>`;
                    }).join('');
                }

                // Remover resultados anteriores
                const oldResults = searchInput.parentElement.parentElement.querySelector('.search-results-container');
                if (oldResults) oldResults.remove();

                // Agregar nuevos resultados
                searchInput.parentElement.parentElement.appendChild(resultsContainer);

                // Agregar eventos click
                resultsContainer.querySelectorAll('.search-result-item[data-url]').forEach(item => {
                    item.addEventListener('click', () => {
                        window.location.href = item.dataset.url;
                    });
                });
            }

            async function performSearch() {
                const query = searchInput.value.trim();
                if (query.length < 2) return;

                try {
                    const response = await fetch(`{{ url('/') }}/search?query=${encodeURIComponent(query)}`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });

                    if (!response.ok) throw new Error(`Error: ${response.status}`);
                    const data = await response.json();
                    showResults(data);
                } catch (error) {
                    console.error('Error:', error);
                    showResults([]);
                }
            }

            searchButton.addEventListener('click', performSearch);
            searchInput.addEventListener('input', () => {
                clearTimeout(timeoutId);
                timeoutId = setTimeout(performSearch, 300);
            });
            searchInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    performSearch();
                }
            });
        }

        // Cerrar resultados al hacer clic fuera
        document.addEventListener('click', (e) => {
            const searchContainer = document.querySelector('.search-container');
            if (searchContainer && !searchContainer.contains(e.target)) {
                const results = searchContainer.querySelector('.search-results-container');
                if (results) results.remove();
            }
        });
    });
    </script>

    <script>
        // Script mejorado para modales de confirmación
        document.addEventListener('DOMContentLoaded', function() {
            // Capturar los clics en los botones de eliminar dentro de los modales
            document.body.addEventListener('click', function(event) {
                const target = event.target;
                
                // Si es un botón de eliminación o su ícono interno
                if (target.classList.contains('btn-danger') || 
                    target.parentElement.classList.contains('btn-danger')) {
                    
                    const button = target.classList.contains('btn-danger') ? target : target.parentElement;
                    const form = button.closest('form');
                    
                    // Si está dentro de un formulario y es un botón de enviar
                    if (form && button.type === 'submit') {
                        // Prevenir el comportamiento predeterminado
                        event.preventDefault();
                        event.stopPropagation();
                        
                        // Cerrar manualmente el modal si existe
                        const modal = button.closest('.modal');
                        if (modal) {
                            const bsModal = bootstrap.Modal.getInstance(modal);
                            if (bsModal) {
                                bsModal.hide();
                            }
                        }
                        
                        // Enviar el formulario después de un breve retraso
                        setTimeout(function() {
                            form.submit();
                        }, 50);
                    }
                }
            });
        });
    </script>

    <script>
        // Script para forzar visibilidad del enlace de reportes
        setTimeout(function() {
            const reportesLinks = document.querySelectorAll('a[href*="reportes"]');
            if (reportesLinks.length > 0) {
                reportesLinks.forEach(link => {
                    // Remover cualquier estilo o clase que pueda estar ocultando el enlace
                    link.style.display = 'flex';
                    link.style.visibility = 'visible';
                    link.style.opacity = '1';
                    link.style.pointerEvents = 'auto';
                    link.classList.remove('d-none');
                    link.classList.add('d-flex');
                    
                    // Destacar el enlace para mayor visibilidad
                    link.style.backgroundColor = 'rgba(79, 70, 229, 0.2)';
                    link.style.fontWeight = 'bold';
                    
                    console.log('Enlace de reportes encontrado y forzado a ser visible:', link);
                });
            } else {
                console.log('No se encontraron enlaces de reportes para forzar visibilidad');
            }
        }, 500); // Dar tiempo para que el DOM se cargue completamente
    </script>
</body>
</html>
