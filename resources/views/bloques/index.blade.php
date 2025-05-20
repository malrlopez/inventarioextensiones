@extends('layouts.app')

@section('title', 'Bloques - Sistema de Inventario')

@push('styles')
<style>
    /* Estilos para estabilizar el modal */
    .modal-dialog {
        position: fixed !important;
        top: 50% !important;
        left: 50% !important;
        transform: translate(-50%, -50%) !important;
        margin: 0 !important;
        animation: none !important;
        max-width: 500px;
        width: 95%;
    }

    .modal-backdrop {
        opacity: 0.5 !important;
    }

    /* Evitar que el contenido detrás del modal se mueva */
    body.modal-open {
        overflow: hidden;
        padding-right: 0 !important;
    }

    /* Asegurar que el modal esté por encima de otros elementos */
    .modal {
        z-index: 1050 !important;
    }

    /* Mejorar la apariencia del modal */
    .modal-content {
        border: none;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }

    .modal-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        padding: 1rem;
    }

    .modal-footer {
        background-color: #f8f9fa;
        border-top: 1px solid #dee2e6;
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
        padding: 1rem;
    }

    .modal-body {
        padding: 1.5rem;
    }

    /* Animación suave para el modal */
    .modal.fade .modal-dialog {
        transition: transform 0.2s ease-out !important;
    }

    /* Estilo para los botones del modal */
    .modal-footer .btn {
        min-width: 100px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Mensajes de Alerta -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Listado de Bloques</h1>
        <div class="d-flex gap-2">
            @if(Auth::user()->role !== 'viewer')
            <a href="{{ route('bloques.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Nuevo Bloque
            </a>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Sede</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bloques as $bloque)
                        <tr>
                            <td>{{ $bloque->id_bloque }}</td>
                            <td>{{ $bloque->nombre_bloque }}</td>
                            <td>{{ $bloque->sede->nombre_sede ?? 'N/A' }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('bloques.show', $bloque->id_bloque) }}" class="btn btn-sm btn-info" title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('bloques.edit', $bloque->id_bloque) }}" class="btn btn-sm btn-warning" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('bloques.destroy', $bloque->id_bloque) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Está seguro de que desea eliminar el bloque {{ $bloque->nombre_bloque }}? Esta acción no se puede deshacer.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">No hay bloques registrados</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
