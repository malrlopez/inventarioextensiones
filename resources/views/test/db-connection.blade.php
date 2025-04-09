@extends('layouts.app')

@section('title', 'Prueba de Conexión a Base de Datos ')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Prueba de Conexión a la Base de Datos </h1>
    
    <div class="card">
        <div class="card-body">
            @if(isset($connectionInfo))
                <div class="alert alert-success">
                    <h4 class="alert-heading">
                        <i class="fas fa-check-circle me-2"></i>¡Conexión exitosa!
                    </h4>
                    <p>La conexión a la base de datos se ha establecido correctamente.</p>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-database me-2"></i>Información de la Base de Datos</h5>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item bg-transparent">
                                        <strong>Nombre:</strong> {{ $connectionInfo['database_name'] }}
                                    </li>
                                    <li class="list-group-item bg-transparent">
                                        <strong>Versión:</strong> {{ $connectionInfo['version'] }}
                                    </li>
                                    <li class="list-group-item bg-transparent">
                                        <strong>Total de tablas:</strong> {{ count($connectionInfo['tables']) }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <h5><i class="fas fa-table me-2"></i>Tablas encontradas</h5>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Nombre de la tabla</th>
                                <th>Cantidad de registros</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($connectionInfo['tables'] as $table)
                                <tr>
                                    <td>{{ $table['name'] }}</td>
                                    <td>{{ $table['record_count'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @elseif(isset($error))
                <div class="alert alert-danger">
                    <h4 class="alert-heading">
                        <i class="fas fa-times-circle me-2"></i>Error de conexión
                    </h4>
                    <p>No se pudo conectar a la base de datos:</p>
                    <hr>
                    <p class="mb-0"><strong>Error:</strong> {{ $error['message'] }}</p>
                    <p class="mb-0"><strong>Código:</strong> {{ $error['code'] }}</p>
                </div>
                
                <div class="alert alert-info">
                    <h5><i class="fas fa-info-circle me-2"></i>Sugerencias</h5>
                    <ul>
                        <li>Verifique que el servidor MySQL esté en ejecución</li>
                        <li>Verifique que el nombre de la base de datos sea correcto en el archivo .env</li>
                        <li>Verifique que el usuario y la contraseña sean correctos</li>
                        <li>Asegúrese de que la base de datos 'inventarioextensiones2' haya sido creada</li>
                    </ul>
                </div>
            @endif
        </div>
        <div class="card-footer">
            <a href="{{ url('/dashboard') }}" class="btn btn-primary">
                <i class="fas fa-home me-1"></i> Ir al Dashboard
            </a>
        </div>
    </div>
</div>
@endsection