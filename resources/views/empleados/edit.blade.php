@extends('layouts.app')

@section('title', 'Editar Empleado - Sistema de Inventario')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Editar Empleado</h1>
        <a href="{{ route('empleados.index') }}" class="btn btn-secondary">
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
            
            <form action="{{ route('empleados.update', $empleado->id_empleado) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nombre" class="form-label">Nombre *</label>
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre', $empleado->nombre) }}" required>
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="apellido" class="form-label">Apellido *</label>
                        <input type="text" class="form-control @error('apellido') is-invalid @enderror" id="apellido" name="apellido" value="{{ old('apellido', $empleado->apellido) }}" required>
                        @error('apellido')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $empleado->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="codigo_marcacion" class="form-label">Código de Marcación *</label>
                        <input type="text" class="form-control @error('codigo_marcacion') is-invalid @enderror" id="codigo_marcacion" name="codigo_marcacion" value="{{ old('codigo_marcacion', $empleado->codigo_marcacion) }}" required>
                        @error('codigo_marcacion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="estado" class="form-label">Estado *</label>
                        <select class="form-select @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                            <option value="">Seleccione...</option>
                            <option value="Activo" {{ old('estado', $empleado->estado) == 'Activo' ? 'selected' : '' }}>Activo</option>
                            <option value="Inactivo" {{ old('estado', $empleado->estado) == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                        @error('estado')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="numero_cedula" class="form-label">Número de Cédula *</label>
                        <input type="text" class="form-control @error('numero_cedula') is-invalid @enderror" id="numero_cedula" name="numero_cedula" value="{{ old('numero_cedula', $empleado->numero_cedula) }}" required>
                        @error('numero_cedula')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="id_cargo" class="form-label">Cargo *</label>
                        <select class="form-select @error('id_cargo') is-invalid @enderror" id="id_cargo" name="id_cargo" required>
                            <option value="">Seleccione un cargo...</option>
                            @foreach($cargos as $cargo)
                                <option value="{{ $cargo->id_cargo }}" {{ old('id_cargo', $empleado->id_cargo) == $cargo->id_cargo ? 'selected' : '' }}>
                                    {{ $cargo->nombre_cargo }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_cargo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="id_sede" class="form-label">Sede *</label>
                        <select class="form-select @error('id_sede') is-invalid @enderror" id="id_sede" name="id_sede" required>
                            <option value="">Seleccione una sede...</option>
                            @foreach($sedes as $sede)
                                <option value="{{ $sede->id_sede }}" {{ old('id_sede', $empleado->id_sede) == $sede->id_sede ? 'selected' : '' }}>
                                    {{ $sede->nombre_sede }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_sede')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <a href="{{ route('empleados.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Actualizar Empleado</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection