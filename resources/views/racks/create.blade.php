@extends('layouts.app')

@section('title', 'Crear Rack - Sistema de Inventario')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Crear Nuevo Rack</h1>
        <a href="{{ route('racks.index') }}" class="btn btn-secondary">
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
            
            <form action="{{ route('racks.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="marca" class="form-label">Marca *</label>
                        <input type="text" class="form-control @error('marca') is-invalid @enderror" id="marca" name="marca" value="{{ old('marca') }}" required>
                        @error('marca')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="referencia" class="form-label">Referencia *</label>
                        <input type="text" class="form-control @error('referencia') is-invalid @enderror" id="referencia" name="referencia" value="{{ old('referencia') }}" required>
                        @error('referencia')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-3">
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
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <button type="reset" class="btn btn-outline-secondary">Limpiar</button>
                    <button type="submit" class="btn btn-primary">Guardar Rack</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection