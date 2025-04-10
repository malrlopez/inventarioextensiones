@extends('layouts.app')

@section('title', 'Editar Softphone - Sistema de Inventario')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Editar Softphone</h1>
        <a href="{{ route('softphones.index') }}" class="btn btn-secondary">
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
            
            <form action="{{ route('softphones.update', $softphone->id_softphone) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="usuario" class="form-label">Usuario *</label>
                        <input type="text" class="form-control @error('usuario') is-invalid @enderror" id="usuario" name="usuario" value="{{ old('usuario', $softphone->usuario) }}" required>
                        @error('usuario')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="dispositivo" class="form-label">Dispositivo *</label>
                        <select class="form-select @error('dispositivo') is-invalid @enderror" id="dispositivo" name="dispositivo" required>
                            <option value="">Seleccione...</option>
                            <option value="PC" {{ old('dispositivo', $softphone->dispositivo) == 'PC' ? 'selected' : '' }}>PC</option>
                            <option value="Movil" {{ old('dispositivo', $softphone->dispositivo) == 'Movil' ? 'selected' : '' }}>Móvil</option>
                            <option value="Tablet" {{ old('dispositivo', $softphone->dispositivo) == 'Tablet' ? 'selected' : '' }}>Tablet</option>
                            <option value="Otro" {{ old('dispositivo', $softphone->dispositivo) == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                        @error('dispositivo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="clave_softphone" class="form-label">Clave *</label>
                    <input type="password" class="form-control @error('clave_softphone') is-invalid @enderror" id="clave_softphone" name="clave_softphone" placeholder="Deje en blanco para mantener la clave actual">
                    <small class="form-text text-muted">Deje en blanco para mantener la clave actual</small>
                    @error('clave_softphone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <a href="{{ route('softphones.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Actualizar Softphone</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection