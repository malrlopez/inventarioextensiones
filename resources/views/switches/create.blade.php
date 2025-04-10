@extends('layouts.app')

@section('title', 'Crear Switch - Sistema de Inventario')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Crear Nuevo Switch</h1>
        <a href="{{ route('switches.index') }}" class="btn btn-secondary">
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
            
            <form action="{{ route('switches.store') }}" method="POST">
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
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="puerto_switche_asignado" class="form-label">Puerto Asignado *</label>
                        <input type="text" class="form-control @error('puerto_switche_asignado') is-invalid @enderror" id="puerto_switche_asignado" name="puerto_switche_asignado" value="{{ old('puerto_switche_asignado') }}" required>
                        @error('puerto_switche_asignado')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label for="vlan" class="form-label">VLAN *</label>
                        <input type="text" class="form-control @error('vlan') is-invalid @enderror" id="vlan" name="vlan" value="{{ old('vlan') }}" required>
                        @error('vlan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label for="id_rack" class="form-label">Rack *</label>
                        <select class="form-select @error('id_rack') is-invalid @enderror" id="id_rack" name="id_rack" required>
                            <option value="">Seleccione un rack...</option>
                            @foreach($racks as $rack)
                                <option value="{{ $rack->id_rack }}" {{ old('id_rack') == $rack->id_rack ? 'selected' : '' }}>
                                    {{ $rack->marca }} {{ $rack->referencia }} - 
                                    @if($rack->ubicacion)
                                        {{ optional($rack->ubicacion->sede)->nombre_sede ?? 'N/A' }}
                                    @else
                                        Sin ubicación
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        @error('id_rack')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="total_puertos" class="form-label">Total de Puertos *</label>
                        <input type="number" class="form-control @error('total_puertos') is-invalid @enderror" id="total_puertos" name="total_puertos" value="{{ old('total_puertos') }}" min="1" required>
                        @error('total_puertos')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="puertos_disponibles" class="form-label">Puertos Disponibles *</label>
                        <input type="number" class="form-control @error('puertos_disponibles') is-invalid @enderror" id="puertos_disponibles" name="puertos_disponibles" value="{{ old('puertos_disponibles') }}" min="0" required>
                        @error('puertos_disponibles')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <button type="reset" class="btn btn-outline-secondary">Limpiar</button>
                    <button type="submit" class="btn btn-primary">Guardar Switch</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
    // Script para validar que puertos disponibles <= total puertos
    document.getElementById('total_puertos').addEventListener('change', function() {
        const totalPuertos = parseInt(this.value) || 0;
        const puertosDisponibles = document.getElementById('puertos_disponibles');
        
        if (parseInt(puertosDisponibles.value) > totalPuertos) {
            puertosDisponibles.value = totalPuertos;
        }
        
        puertosDisponibles.max = totalPuertos;
    });
</script>
@endsection

@endsection