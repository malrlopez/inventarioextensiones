@extends('layouts.app')

@section('title', 'Crear Ubicación - Sistema de Inventario')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Crear Nueva Ubicación</h1>
        <a href="{{ route('ubicaciones.index') }}" class="btn btn-secondary">
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
            
            <form action="{{ route('ubicaciones.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="id_sede" class="form-label">Sede *</label>
                        <select class="form-select @error('id_sede') is-invalid @enderror" id="id_sede" name="id_sede" required>
                            <option value="">Seleccione una sede...</option>
                            @foreach($sedes as $sede)
                                <option value="{{ $sede->id_sede }}" {{ old('id_sede') == $sede->id_sede ? 'selected' : '' }}>
                                    {{ $sede->nombre_sede }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_sede')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="id_bloque" class="form-label">Bloque *</label>
                        <select class="form-select @error('id_bloque') is-invalid @enderror" id="id_bloque" name="id_bloque" required>
                            <option value="">Seleccione un bloque...</option>
                            @foreach($bloques as $bloque)
                                <option value="{{ $bloque->id_bloque }}" data-sede="{{ $bloque->id_sede }}" {{ old('id_bloque') == $bloque->id_bloque ? 'selected' : '' }}>
                                    {{ $bloque->nombre_bloque }} ({{ $bloque->sede->nombre_sede ?? 'N/A' }})
                                </option>
                            @endforeach
                        </select>
                        @error('id_bloque')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="oficina" class="form-label">Oficina *</label>
                        <input type="text" class="form-control @error('oficina') is-invalid @enderror" id="oficina" name="oficina" value="{{ old('oficina') }}" required>
                        @error('oficina')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="planta_telefonica" class="form-label">Planta Telefónica</label>
                        <input type="text" class="form-control @error('planta_telefonica') is-invalid @enderror" id="planta_telefonica" name="planta_telefonica" value="{{ old('planta_telefonica') }}">
                        @error('planta_telefonica')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="cuarto_tecnico" class="form-label">Cuarto Técnico</label>
                        <input type="text" class="form-control @error('cuarto_tecnico') is-invalid @enderror" id="cuarto_tecnico" name="cuarto_tecnico" value="{{ old('cuarto_tecnico') }}">
                        @error('cuarto_tecnico')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="rack" class="form-label">Rack</label>
                        <input type="text" class="form-control @error('rack') is-invalid @enderror" id="rack" name="rack" value="{{ old('rack') }}">
                        @error('rack')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="patch_panel" class="form-label">Patch Panel</label>
                        <input type="text" class="form-control @error('patch_panel') is-invalid @enderror" id="patch_panel" name="patch_panel" value="{{ old('patch_panel') }}">
                        @error('patch_panel')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="faceplate" class="form-label">Faceplate</label>
                        <input type="text" class="form-control @error('faceplate') is-invalid @enderror" id="faceplate" name="faceplate" value="{{ old('faceplate') }}">
                        @error('faceplate')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <button type="reset" class="btn btn-outline-secondary">Limpiar</button>
                    <button type="submit" class="btn btn-primary">Guardar Ubicación</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
    // Script para filtrar bloques según la sede seleccionada
    document.getElementById('id_sede').addEventListener('change', function() {
        const sedeId = this.value;
        const bloqueSelect = document.getElementById('id_bloque');
        const bloqueOptions = bloqueSelect.querySelectorAll('option');
        
        // Mostrar u ocultar opciones según la sede seleccionada
        bloqueOptions.forEach(option => {
            if (option.value === '') {
                // No hacer nada con la opción "Seleccione un bloque..."
            } else {
                const bloqueSede = option.getAttribute('data-sede');
                
                if (sedeId === '' || sedeId === bloqueSede) {
                    option.style.display = 'block';
                } else {
                    option.style.display = 'none';
                    
                    // Deseleccionar si estaba seleccionado
                    if (option.selected) {
                        option.selected = false;
                    }
                }
            }
        });
        
        // Seleccionar la primera opción visible (que no sea la de "Seleccione un bloque...")
        let firstVisibleSelected = false;
        bloqueOptions.forEach(option => {
            if (!firstVisibleSelected && option.value !== '' && option.style.display !== 'none') {
                option.selected = true;
                firstVisibleSelected = true;
            }
        });
        
        // Si no hay opciones visibles, seleccionar la opción "Seleccione un bloque..."
        if (!firstVisibleSelected) {
            bloqueOptions[0].selected = true;
        }
    });
</script>
@endsection

@endsection