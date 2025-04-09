@extends('layouts.app')

@section('title', 'Editar Cargo - Sistema de Inventario')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Editar Cargo</h1>
        <a href="{{ route('cargos.index') }}" class="btn btn-secondary">
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
            
            <form action="{{ route('cargos.update', $cargo->id_cargo) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="nombre_cargo" class="form-label">Nombre del Cargo *</label>
                    <input type="text" class="form-control @error('nombre_cargo') is-invalid @enderror" id="nombre_cargo" name="nombre_cargo" value="{{ old('nombre_cargo', $cargo->nombre_cargo) }}" required>
                    @error('nombre_cargo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <a href="{{ route('cargos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Actualizar Cargo</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection