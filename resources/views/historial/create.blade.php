@extends('layouts.app')

@section('title', 'Crear Registro de Historial - Sistema de Inventario')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Crear Nuevo Registro de Historial</h1>
        <div>
            <a href="{{ route('historial.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Volver
            </a>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Formulario de Registro</h5>
        </div>
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

            <form action="{{ route('historial.store') }}" method="POST">
                @csrf
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="usuario_id" class="form-label">Usuario</label>
                        <select name="usuario_id" id="usuario_id" class="form-select" required>
                            <option value="">Seleccionar usuario</option>
                            @foreach($usuarios ?? [] as $usuario)
                                <option value="{{ $usuario->id }}" {{ old('usuario_id') == $usuario->id ? 'selected' : '' }}>
                                    {{ $usuario->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="tabla" class="form-label">Tabla</label>
                        <input type="text" class="form-control" id="tabla" name="tabla" value="{{ old('tabla') }}" required>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="accion" class="form-label">Acción</label>
                        <select name="accion" id="accion" class="form-select" required>
                            <option value="">Seleccionar acción</option>
                            <option value="crear" {{ old('accion') == 'crear' ? 'selected' : '' }}>Crear</option>
                            <option value="actualizar" {{ old('accion') == 'actualizar' ? 'selected' : '' }}>Actualizar</option>
                            <option value="eliminar" {{ old('accion') == 'eliminar' ? 'selected' : '' }}>Eliminar</option>
                            <option value="consultar" {{ old('accion') == 'consultar' ? 'selected' : '' }}>Consultar</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="registro_id" class="form-label">ID de Registro</label>
                        <input type="number" class="form-control" id="registro_id" name="registro_id" value="{{ old('registro_id') }}" required>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="detalles" class="form-label">Detalles</label>
                    <textarea class="form-control" id="detalles" name="detalles" rows="4">{{ old('detalles') }}</textarea>
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Guardar
                    </button>
                    <a href="{{ route('historial.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-1"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection