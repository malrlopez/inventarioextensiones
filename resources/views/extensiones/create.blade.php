@extends('layouts.app')

@section('title', 'Crear Extensión - Sistema de Inventario')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Crear Nueva Extensión</h1>
        <a href="{{ route('extensiones.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Volver
        </a>
    </div>
    
    <div class="card">
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
            
            <form action="{{ route('extensiones.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="numero_extension" class="form-label">Número de Extensión *</label>
                        <input type="text" class="form-control @error('numero_extension') is-invalid @enderror" id="numero_extension" name="numero_extension" value="{{ old('numero_extension') }}" required>
                        @error('numero_extension')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="tecnologia" class="form-label">Tecnología *</label>
                        <select class="form-select @error('tecnologia') is-invalid @enderror" id="tecnologia" name="tecnologia" required>
                            <option value="">Seleccione...</option>
                            <option value="ip" {{ old('tecnologia') == 'ip' ? 'selected' : '' }}>IP</option>
                            <option value="digital" {{ old('tecnologia') == 'digital' ? 'selected' : '' }}>Digital</option>
                            <option value="analogica" {{ old('tecnologia') == 'analogica' ? 'selected' : '' }}>Analógica</option>
                        </select>
                        @error('tecnologia')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="puerto" class="form-label">Puerto *</label>
                        <input type="text" class="form-control @error('puerto') is-invalid @enderror" id="puerto" name="puerto" value="{{ old('puerto') }}" required>
                        @error('puerto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="cor" class="form-label">COR *</label>
                        <input type="text" class="form-control @error('cor') is-invalid @enderror" id="cor" name="cor" value="{{ old('cor') }}" required>
                        @error('cor')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="buscar_documento" class="form-label">Buscar Empleado por Documento *</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="buscar_documento" placeholder="Ingrese número de documento">
                            <button class="btn btn-outline-secondary" type="button" id="buscar_empleado_btn">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                        <div class="form-text">Busque un empleado por su número de documento</div>
                        
                        <div id="resultado_busqueda" class="mt-2"></div>
                        
                        <input type="hidden" name="id_empleado" id="id_empleado" value="{{ old('id_empleado') }}" required>
                        @error('id_empleado')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label for="id_ubicacion" class="form-label">Ubicación *</label>
                        <select class="form-select @error('id_ubicacion') is-invalid @enderror" id="id_ubicacion" name="id_ubicacion" required>
                            <option value="">Seleccione una ubicación...</option>
                            @foreach($ubicaciones as $ubicacion)
                                <option value="{{ $ubicacion->id_ubicacion }}" {{ old('id_ubicacion') == $ubicacion->id_ubicacion ? 'selected' : '' }}>
                                    {{ optional($ubicacion->sede)->nombre_sede ?? 'N/A' }} - 
                                    {{ optional($ubicacion->bloque)->nombre_bloque ?? 'N/A' }} - 
                                    Oficina: {{ $ubicacion->oficina ?? 'N/A' }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_ubicacion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label for="id_softphone" class="form-label">Softphone *</label>
                        <select class="form-select @error('id_softphone') is-invalid @enderror" id="id_softphone" name="id_softphone" required>
                            <option value="">Seleccione un softphone...</option>
                            @foreach($softphones as $softphone)
                                <option value="{{ $softphone->id_softphone }}" {{ old('id_softphone') == $softphone->id_softphone ? 'selected' : '' }}>
                                    {{ $softphone->usuario }} ({{ $softphone->dispositivo }})
                                </option>
                            @endforeach
                        </select>
                        @error('id_softphone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <button type="reset" class="btn btn-outline-secondary">Limpiar</button>
                    <button type="submit" class="btn btn-primary">Guardar Extensión</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Buscador de empleados por documento
        $('#buscar_empleado_btn').click(function() {
            buscarEmpleado();
        });
        
        // Permitir buscar con Enter
        $('#buscar_documento').keypress(function(e) {
            if(e.which == 13) { // 13 es el código de tecla para Enter
                e.preventDefault();
                buscarEmpleado();
            }
        });
        
        function buscarEmpleado() {
            var documento = $('#buscar_documento').val().trim();
            if (documento === '') {
                $('#resultado_busqueda').html('<div class="alert alert-warning">Ingrese un número de documento para buscar</div>');
                return;
            }
            
            // Mostrar indicador de carga
            $('#resultado_busqueda').html('<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Buscando...</div>');
            
            // Realizar la búsqueda mediante AJAX
            $.ajax({
                url: '{{ route("empleados.buscar") }}',
                type: 'GET',
                data: { documento: documento },
                dataType: 'json',
                success: function(data) {
                    if (data.success && data.empleado) {
                        // Mostrar resultados y establecer el ID del empleado
                        $('#resultado_busqueda').html(
                            '<div class="alert alert-success empleado-seleccionado">' +
                                '<strong>Empleado encontrado:</strong> ' + data.empleado.numero_cedula + ' - ' + 
                                data.empleado.nombre + ' ' + data.empleado.apellido +
                                '<button type="button" class="btn-close float-end" aria-label="Close"></button>' +
                            '</div>'
                        );
                        $('#id_empleado').val(data.empleado.id_empleado);
                        
                        // Agregar evento para quitar la selección
                        $('.empleado-seleccionado .btn-close').click(function() {
                            $('#resultado_busqueda').empty();
                            $('#id_empleado').val('');
                            $('#buscar_documento').val('');
                        });
                    } else {
                        // Mostrar mensaje de error
                        $('#resultado_busqueda').html('<div class="alert alert-danger">No se encontró ningún empleado con ese documento</div>');
                        $('#id_empleado').val('');
                    }
                },
                error: function() {
                    $('#resultado_busqueda').html('<div class="alert alert-danger">Error al realizar la búsqueda</div>');
                    $('#id_empleado').val('');
                }
            });
        }
    });
</script>
@endsection