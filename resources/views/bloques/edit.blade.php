@extends('layouts.app')

@section('title', 'Editar Bloque - Sistema de Inventario')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Editar Bloque</h1>
        <a href="{{ route('bloques.index') }}" class="btn btn-secondary">
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
            
            <form action="{{ route('bloques.update', $bloque->id_bloque) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="nombre_bloque" class="form-label">Nombre del Bloque *</label>
                    <input type="text" class="form-control @error('nombre_bloque') is-invalid @enderror" id="nombre_bloque" name="nombre_bloque" value="{{ old('nombre_bloque', $bloque->nombre_bloque) }}" required>
                    @error('nombre_bloque')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="id_sede" class="form-label">Sede *</label>
                    <select class="form-select @error('id_sede') is-invalid @enderror" id="id_sede" name="id_sede" required>
                        <option value="">Seleccione una sede...</option>
                        @foreach($sedes as $sede)
                            <option value="{{ $sede->id_sede }}" {{ old('id_sede', $bloque->id_sede) == $sede->id_sede ? 'selected' : '' }}>
                                {{ $sede->nombre_sede }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_sede')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <a href="{{ route('bloques.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Actualizar Bloque</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection