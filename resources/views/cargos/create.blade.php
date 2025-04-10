@extends('layouts.app')

@section('title', 'Crear Cargo - Sistema de Inventario')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Crear Nuevo Cargo</h1>
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
            
            <form action="{{ route('cargos.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="nombre_cargo" class="form-label">Nombre del Cargo *</label>
                    <input type="text" class="form-control @error('nombre_cargo') is-invalid @enderror" id="nombre_cargo" name="nombre_cargo" value="{{ old('nombre_cargo') }}" required>
                    @error('nombre_cargo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <button type="reset" class="btn btn-outline-secondary">Limpiar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cargo</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection