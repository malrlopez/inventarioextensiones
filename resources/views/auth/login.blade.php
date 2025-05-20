<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Iniciar Sesión - Sistema de Telefonía</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-container {
            max-width: 450px;
            width: 100%;
        }
        
        .login-box {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 25px rgba(0,0,0,0.15);
            background-color: white;
            padding: 2rem 1.5rem;
            margin-bottom: 2rem;
        }
        
        .login-logo {
            display: flex;
            justify-content: center;
            margin-bottom: 1.5rem;
        }
        
        .login-logo img {
            height: auto;
            max-width: 100%;
            width: 180px; /* Tamaño base aumentado */
            max-height: 120px; /* Altura máxima */
            transition: all 0.3s ease;
        }
        
        /* Media queries para diseño responsive */
        @media (min-width: 576px) {
            .login-logo img {
                width: 200px;
            }
        }
        
        @media (min-width: 768px) {
            .login-logo img {
                width: 220px;
            }
        }

        .card {
            border: none;
            border-radius: 10px;
            overflow: hidden;
        }
        
        .card-header {
            background: linear-gradient(90deg, var(--primary-very-dark) 0%, var(--primary) 100%);
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 1.25rem;
            font-weight: 600;
            font-size: 1.25rem;
        }
        
        .card-body {
            padding: 2rem;
        }
        
        .form-control:focus {
            border-color: var(--primary-light);
            box-shadow: 0 0 0 0.25rem rgba(51, 51, 51, 0.25);
        }
        
        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        
        .btn-login {
            background: linear-gradient(90deg, var(--primary) 0%, var(--primary-dark) 100%);
            border: none;
            padding: 0.75rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-login:hover {
            background: linear-gradient(90deg, var(--primary-dark) 0%, var(--primary-very-dark) 100%);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="container login-container">
        <div class="login-box">
            <div class="login-logo">
                <img src="{{ asset('images/logo.svg') }}" alt="Logo Sistema de Telefonía">
            </div>
            
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user-lock me-2"></i> Inicio de Sesión
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-4">
                            <label for="email" class="form-label"><i class="fas fa-envelope me-2"></i>Correo Electrónico</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label"><i class="fas fa-lock me-2"></i>Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <div class="mb-4 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Recordarme</label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-login">
                                <i class="fas fa-sign-in-alt me-2"></i> Iniciar Sesión
                            </button>
                        </div>
                    </form>

                    <!-- Se ha eliminado el enlace de registro -->
                </div>
            </div>
        </div>
    </div>
</body>
</html>
