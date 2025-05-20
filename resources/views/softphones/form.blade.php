@csrf

<div class="form-group mb-3">
    <label for="usuario" class="form-label">Usuario</label>
    <input type="text" class="form-control @error('usuario') is-invalid @enderror"
           id="usuario" name="usuario"
           value="{{ old('usuario', $softphone->usuario ?? '') }}" required>
    @error('usuario')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group mb-3">
    <label for="dispositivo" class="form-label">Dispositivo</label>
    <input type="text" class="form-control @error('dispositivo') is-invalid @enderror"
           id="dispositivo" name="dispositivo"
           value="{{ old('dispositivo', $softphone->dispositivo ?? '') }}" required>
    @error('dispositivo')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group mb-3">
    <label for="clave_softphone" class="form-label">Clave Softphone</label>
    <input type="text" class="form-control @error('clave_softphone') is-invalid @enderror"
           id="clave_softphone" name="clave_softphone"
           value="{{ old('clave_softphone', $softphone->clave_softphone ?? '') }}" required>
    @error('clave_softphone')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="text-end">
    <a href="{{ route('softphones.index') }}" class="btn btn-secondary">Cancelar</a>
    <button type="submit" class="btn btn-primary">{{ isset($softphone) ? 'Actualizar' : 'Crear' }}</button>
</div>
