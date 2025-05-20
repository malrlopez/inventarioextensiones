@extends('layouts.app')

@section('title', 'Reportes Unificados - Sistema de Inventario')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-chart-bar text-indigo-600 mr-3"></i>
                Reportes Unificados
            </h2>

            @if(session('warning'))
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6" role="alert">
                    <p>{{ session('warning') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <div class="mb-6">
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex flex-wrap items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900 mb-2 flex items-center">
                            <i class="fas fa-filter text-indigo-500 mr-2"></i>
                            Filtros de Búsqueda
                        </h3>
                        <button type="button" id="toggle-filters" class="mb-2 text-indigo-600 hover:text-indigo-800 text-sm flex items-center">
                            <i class="fas fa-chevron-down mr-1"></i> Mostrar/Ocultar Filtros
                        </button>
                    </div>
                    
                    <div id="filters-container" class="mt-3">
                        <form id="report-form" action="{{ route('reportes.generar') }}" method="POST" class="space-y-4">
                            @csrf

                            @if ($errors->any())
                                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                                    <ul class="list-disc list-inside">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- Tipo de Reporte -->
                                <div>
                                    <label for="tipo" class="block text-sm font-medium text-gray-700">
                                        Tipo de Entidad <span class="text-red-600">*</span>
                                    </label>
                                    <select name="tipo" id="tipo" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('tipo') border-red-500 @enderror"
                                        required>
                                        <option value="">Seleccione una entidad...</option>
                                        <option value="softphones" {{ old('tipo') == 'softphones' ? 'selected' : '' }}>Softphones</option>
                                        <option value="extensiones" {{ old('tipo') == 'extensiones' ? 'selected' : '' }}>Extensiones</option>
                                        <option value="dispositivos" {{ old('tipo') == 'dispositivos' ? 'selected' : '' }}>Dispositivos</option>
                                        <option value="empleados" {{ old('tipo') == 'empleados' ? 'selected' : '' }}>Empleados</option>
                                        <option value="ubicaciones" {{ old('tipo') == 'ubicaciones' ? 'selected' : '' }}>Ubicaciones</option>
                                        <option value="consolidado" {{ old('tipo') == 'consolidado' ? 'selected' : '' }}>Consolidado</option>
                                    </select>
                                </div>

                                <!-- Estado -->
                                <div>
                                    <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
                                    <select name="estado" id="estado" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Todos los estados</option>
                                        <option value="activo" {{ old('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                                        <option value="inactivo" {{ old('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                        <option value="mantenimiento" {{ old('estado') == 'mantenimiento' ? 'selected' : '' }}>En Mantenimiento</option>
                                        <option value="reservado" {{ old('estado') == 'reservado' ? 'selected' : '' }}>Reservado</option>
                                    </select>
                                </div>

                                <!-- Formato de Salida -->
                                <div>
                                    <label for="formato" class="block text-sm font-medium text-gray-700">
                                        Formato de Salida <span class="text-red-600">*</span>
                                    </label>
                                    <select name="formato" id="formato"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('formato') border-red-500 @enderror"
                                        required>
                                        <option value="html" {{ old('formato') == 'html' ? 'selected' : '' }}>Ver en Navegador</option>
                                        <option value="excel" {{ old('formato') == 'excel' ? 'selected' : '' }}>Excel</option>
                                        <option value="csv" {{ old('formato') == 'csv' ? 'selected' : '' }}>CSV</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                                <!-- Sede -->
                                <div>
                                    <label for="sede_id" class="block text-sm font-medium text-gray-700">Sede</label>
                                    <select name="sede_id" id="sede_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Todas las sedes</option>
                                        @foreach($sedes as $id => $nombre)
                                            <option value="{{ $id }}" {{ old('sede_id') == $id ? 'selected' : '' }}>{{ $nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Bloque -->
                                <div id="bloque-container">
                                    <label for="bloque_id" class="block text-sm font-medium text-gray-700">Bloque</label>
                                    <select name="bloque_id" id="bloque_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Todos los bloques</option>
                                        @foreach($bloques as $id => $nombre)
                                            <option value="{{ $id }}" {{ old('bloque_id') == $id ? 'selected' : '' }}>{{ $nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Ubicación -->
                                <div id="ubicacion-container">
                                    <label for="ubicacion_id" class="block text-sm font-medium text-gray-700">Ubicación</label>
                                    <select name="ubicacion_id" id="ubicacion_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Todas las ubicaciones</option>
                                        @foreach($ubicaciones as $id => $nombre)
                                            <option value="{{ $id }}" {{ old('ubicacion_id') == $id ? 'selected' : '' }}>{{ $nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                                <!-- Empleado -->
                                <div>
                                    <label for="empleado_id" class="block text-sm font-medium text-gray-700">Empleado</label>
                                    <select name="empleado_id" id="empleado_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Todos los empleados</option>
                                        @foreach($empleados as $id => $nombre)
                                            <option value="{{ $id }}" {{ old('empleado_id') == $id ? 'selected' : '' }}>{{ $nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Fecha Inicio -->
                                <div>
                                    <label for="fecha_inicio" class="block text-sm font-medium text-gray-700">Fecha Inicio</label>
                                    <input type="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" id="fecha_inicio" name="fecha_inicio" value="{{ old('fecha_inicio') }}">
                                </div>

                                <!-- Fecha Fin -->
                                <div>
                                    <label for="fecha_fin" class="block text-sm font-medium text-gray-700">Fecha Fin</label>
                                    <input type="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" id="fecha_fin" name="fecha_fin" value="{{ old('fecha_fin') }}">
                                </div>
                            </div>

                            <!-- Período Predefinido -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                <div class="flex items-center">
                                    <input id="usar_periodo" name="usar_periodo" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" {{ old('usar_periodo') ? 'checked' : '' }}>
                                    <label for="usar_periodo" class="ml-2 block text-sm text-gray-700">Usar período predefinido</label>
                                </div>
                                <div>
                                    <select id="periodo" name="periodo" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" {{ old('usar_periodo') ? '' : 'disabled' }}>
                                        <option value="hoy" {{ old('periodo') == 'hoy' ? 'selected' : '' }}>Hoy</option>
                                        <option value="ayer" {{ old('periodo') == 'ayer' ? 'selected' : '' }}>Ayer</option>
                                        <option value="semana_actual" {{ old('periodo') == 'semana_actual' ? 'selected' : '' }}>Semana actual</option>
                                        <option value="semana_anterior" {{ old('periodo') == 'semana_anterior' ? 'selected' : '' }}>Semana anterior</option>
                                        <option value="mes_actual" {{ old('periodo') == 'mes_actual' ? 'selected' : '' }}>Mes actual</option>
                                        <option value="mes_anterior" {{ old('periodo') == 'mes_anterior' ? 'selected' : '' }}>Mes anterior</option>
                                        <option value="año_actual" {{ old('periodo') == 'año_actual' ? 'selected' : '' }}>Año actual</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Campos de Búsqueda Adicionales -->
                            <div id="campos-adicionales" class="mt-4">
                                <!-- Se llenarán mediante JavaScript según el tipo seleccionado -->
                            </div>

                            <div class="flex justify-end mt-6 space-x-3">
                                <button type="button" id="reset-form" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                    <i class="fas fa-undo mr-1"></i> Limpiar Filtros
                                </button>
                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    <i class="fas fa-search mr-1"></i> Generar Reporte
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div id="data-display">
                <!-- Aquí se cargarán los datos del reporte cuando se use AJAX -->
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tipoSelect = document.getElementById('tipo');
        const formatoSelect = document.getElementById('formato');
        const usarPeriodoCheckbox = document.getElementById('usar_periodo');
        const periodoSelect = document.getElementById('periodo');
        const resetButton = document.getElementById('reset-form');
        const toggleFiltersButton = document.getElementById('toggle-filters');
        const filtersContainer = document.getElementById('filters-container');
        const camposAdicionalesContainer = document.getElementById('campos-adicionales');
        const reportForm = document.getElementById('report-form');

        // Campos específicos por tipo de entidad
        const camposPorTipo = {
            softphones: [
                { campo: 'usuario', label: 'Usuario' },
                { campo: 'dispositivo', label: 'Dispositivo' },
                { campo: 'version', label: 'Versión' },
                { campo: 'fabricante', label: 'Fabricante' }
            ],
            extensiones: [
                { campo: 'numero', label: 'Número' },
                { campo: 'tecnologia', label: 'Tecnología' }
            ],
            dispositivos: [
                { campo: 'nombre', label: 'Nombre' },
                { campo: 'tipo', label: 'Tipo' },
                { campo: 'marca', label: 'Marca' },
                { campo: 'modelo', label: 'Modelo' },
                { campo: 'serie', label: 'Número de Serie' }
            ],
            empleados: [
                { campo: 'nombre', label: 'Nombre' },
                { campo: 'apellido', label: 'Apellido' },
                { campo: 'email', label: 'Email' },
                { campo: 'cargo', label: 'Cargo' }
            ],
            ubicaciones: [
                { campo: 'nombre', label: 'Nombre' },
                { campo: 'piso', label: 'Piso' },
                { campo: 'oficina', label: 'Oficina' }
            ],
            consolidado: [
                { campo: 'tipo_equipo', label: 'Tipo de Equipo' },
                { campo: 'asignado', label: 'Asignado' }
            ]
        };

        // Mostrar/ocultar filtros adicionales
        toggleFiltersButton.addEventListener('click', function() {
            if (filtersContainer.style.display === 'none') {
                filtersContainer.style.display = 'block';
                toggleFiltersButton.innerHTML = '<i class="fas fa-chevron-up mr-1"></i> Ocultar Filtros';
            } else {
                filtersContainer.style.display = 'none';
                toggleFiltersButton.innerHTML = '<i class="fas fa-chevron-down mr-1"></i> Mostrar Filtros';
            }
        });

        // Actualizar campos adicionales cuando se cambia el tipo
        tipoSelect.addEventListener('change', function() {
            actualizarCamposAdicionales();
        });

        // Función para actualizar los campos adicionales
        function actualizarCamposAdicionales() {
            const tipo = tipoSelect.value;
            camposAdicionalesContainer.innerHTML = '';
            
            if (tipo && camposPorTipo[tipo]) {
                const campos = camposPorTipo[tipo];
                
                if (campos.length > 0) {
                    const divContainer = document.createElement('div');
                    divContainer.className = 'mt-4';
                    divContainer.innerHTML = `<h4 class="text-md font-medium text-gray-700 mb-2">Filtros Específicos</h4>`;
                    
                    const grid = document.createElement('div');
                    grid.className = 'grid grid-cols-1 md:grid-cols-3 gap-4';
                    
                    campos.forEach(campo => {
                        const div = document.createElement('div');
                        div.innerHTML = `
                            <label for="filtros[${campo.campo}]" class="block text-sm font-medium text-gray-700">${campo.label}</label>
                            <input type="text"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                   id="filtros[${campo.campo}]"
                                   name="filtros[${campo.campo}]"
                                   placeholder="Filtrar por ${campo.label.toLowerCase()}...">
                        `;
                        grid.appendChild(div);
                    });
                    
                    divContainer.appendChild(grid);
                    camposAdicionalesContainer.appendChild(divContainer);
                }
            }
        }

        // Habilitar/deshabilitar selector de período
        usarPeriodoCheckbox.addEventListener('change', function() {
            periodoSelect.disabled = !this.checked;
            if (this.checked) {
                document.getElementById('fecha_inicio').disabled = true;
                document.getElementById('fecha_fin').disabled = true;
            } else {
                document.getElementById('fecha_inicio').disabled = false;
                document.getElementById('fecha_fin').disabled = false;
            }
        });

        // Botón para reiniciar formulario
        resetButton.addEventListener('click', function() {
            reportForm.reset();
            periodoSelect.disabled = true;
            document.getElementById('fecha_inicio').disabled = false;
            document.getElementById('fecha_fin').disabled = false;
            actualizarCamposAdicionales();
        });

        // Inicializar campos adicionales
        actualizarCamposAdicionales();
        
        // Si ya hay un tipo seleccionado (por ejemplo, al volver atrás o por errores de validación)
        if (tipoSelect.value) {
            actualizarCamposAdicionales();
        }
        
        // Verificar estado de usar_periodo al cargar
        if (usarPeriodoCheckbox.checked) {
            document.getElementById('fecha_inicio').disabled = true;
            document.getElementById('fecha_fin').disabled = true;
            periodoSelect.disabled = false;
        }
    });
</script>
@endpush
@endsection
