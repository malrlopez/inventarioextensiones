@extends('layouts.app')

@section('title', 'Editar Extensión - Sistema de Inventario')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Editar Extensión</h1>
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
            
            <form action="{{ route('extensiones.update', $extension->id_extension) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="numero_extension" class="form-label">Número de Extensión *</label>
                        <input type="text" class="form-control @error('numero_extension') is-invalid @enderror" id="numero_extension" name="numero_extension" value="{{ old('numero_extension', $extension->numero_extension) }}" required>
                        @error('numero_extension')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="tecnologia" class="form-label">Tecnología *</label>
                        <select class="form-select @error('tecnologia') is-invalid @enderror" id="tecnologia" name="tecnologia" required>
                            <option value="">Seleccione...</option>
                            <option value="ip" {{ old('tecnologia', $extension->tecnologia) == 'ip' ? 'selected' : '' }}>IP</option>
                            <option value="digital" {{ old('tecnologia', $extension->tecnologia) == 'digital' ? 'selected' : '' }}>Digital</option>
                            <option value="analogica" {{ old('tecnologia', $extension->tecnologia) == 'analogica' ? 'selected' : '' }}>Analógica</option>
                        </select>
                        @error('tecnologia')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="puerto" class="form-label">Puerto *</label>
                        <input type="text" class="form-control @error('puerto') is-invalid @enderror" id="puerto" name="puerto" value="{{ old('puerto', $extension->puerto) }}" required>
                        @error('puerto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="cor" class="form-label">COR *</label>
                        <input type="text" class="form-control @error('cor') is-invalid @enderror" id="cor" name="cor" value="{{ old('cor', $extension->cor) }}" required>
                        @error('cor')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="id_empleado" class="form-label">Empleado Asignado *</label>
                        <select class="form-select @error('id_empleado') is-invalid @enderror" id="id_empleado" name="id_empleado" required>
                            <option value="">Seleccione un empleado...</option>
                            @foreach($empleados as $empleado)
                                <option value="{{ $empleado->id_empleado }}" {{ old('id_empleado', $extension->id_empleado) == $empleado->id_empleado ? 'selected' : '' }}>
                                    {{ $empleado->nombre }} {{ $empleado->apellido }} ({{ $empleado->codigo_marcacion }})
                                </option>
                            @endforeach
                        </select>
                        @error('id_empleado')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label for="id_ubicacion" class="form-label">Ubicación *</label>
                        <select class="form-select @error('id_ubicacion') is-invalid @enderror" id="id_ubicacion" name="id_ubicacion" required>
                            <option value="">Seleccione una ubicación...</option>
                            @foreach($ubicaciones as $ubicacion)
                                <option value="{{ $ubicacion->id_ubicacion }}" {{ old('id_ubicacion', $extension->id_ubicacion) == $ubicacion->id_ubicacion ? 'selected' : '' }}>
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
                                <option value="{{ $softphone->id_softphone }}" {{ old('id_softphone', $extension->id_softphone) == $softphone->id_softphone ? 'selected' : '' }}>
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
                    <a href="{{ route('extensiones.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Actualizar Extensión</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection