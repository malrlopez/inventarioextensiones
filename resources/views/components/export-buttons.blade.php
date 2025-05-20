@props(['tipo'])

<form action="{{ route('reportes.generar') }}" method="POST" class="me-2">
    @csrf
    <input type="hidden" name="tipo" value="{{ $tipo }}">
    <input type="hidden" name="formato" value="html">
    <button type="submit" class="btn btn-warning">
        <i class="fas fa-chart-bar me-1"></i> Generar Reporte
    </button>
</form>
