@extends('layouts.app')

@section('title', 'Editar Sede - Sistema de Inventario')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Editar Sede</h1>
        <a href="{{ route('sedes.index') }}" class="btn btn-secondary">
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
            
            <form action="{{ route('sedes.update', $sede->id_sede) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="nombre_sede" class="form-label">Nombre de la Sede *</label>
                    <input type="text" class="form-control @error('nombre_sede') is-invalid @enderror" id="nombre_sede" name="nombre_sede" value="{{ old('nombre_sede', $sede->nombre_sede) }}" required>
                    @error('nombre_sede')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="direccion" class="form-label">Dirección *</label>
                    <input type="text" class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" value="{{ old('direccion', $sede->direccion) }}" required>
                    @error('direccion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <a href="{{ route('sedes.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Actualizar Sede</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection