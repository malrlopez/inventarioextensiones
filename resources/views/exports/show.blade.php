@extends('layouts.app')

@section('title', $titulo ?? 'Visualización de Reporte - Sistema de Inventario')

@section('content')
<div class="container-fluid">
    <div class="report-header">
        <h1>{{ $titulo ?? 'Reporte de Datos' }}</h1>
        <div class="report-meta">
            Generado el: {{ now()->format('d/m/Y H:i:s') }}
        </div>
    </div>

    @if(isset($filtrosAplicados) && count($filtrosAplicados) > 0)
    <div class="applied-filters">
        <h6>Filtros aplicados:</h6>
        <ul>
            @foreach($filtrosAplicados as $filtro => $valor)
            <li>{{ ucfirst($filtro) }}: {{ $valor }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="table-responsive">
        <table class="report-table">
            <thead>
                <tr>
                    @foreach($encabezados as $encabezado)
                    <th>{{ $encabezado }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($datos as $fila)
                <tr>
                    @foreach($campos as $campo)
                    <td>
                        @if(isset($fila[$campo]))
                            @if($campo == 'estado')
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($fila[$campo] == 'activo') bg-green-100 text-green-800 border border-green-200
                                    @elseif($fila[$campo] == 'inactivo') bg-red-100 text-red-800 border border-red-200
                                    @elseif($fila[$campo] == 'mantenimiento') bg-yellow-100 text-yellow-800 border border-yellow-200
                                    @elseif($fila[$campo] == 'reservado') bg-blue-100 text-blue-800 border border-blue-200
                                    @else bg-gray-100 text-gray-800 border border-gray-200 @endif">
                                    <i class="@if($fila[$campo] == 'activo') fas fa-check-circle mr-1
                                        @elseif($fila[$campo] == 'inactivo') fas fa-times-circle mr-1
                                        @elseif($fila[$campo] == 'mantenimiento') fas fa-tools mr-1
                                        @elseif($fila[$campo] == 'reservado') fas fa-clock mr-1
                                        @else fas fa-circle mr-1 @endif"></i>
                                    {{ ucfirst($fila[$campo]) }}
                                </span>
                            @else
                                {{ $fila[$campo] }}
                            @endif
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
            @if(isset($totals))
            <tfoot>
                <tr>
                    @foreach($totals as $total)
                    <td>{{ $total }}</td>
                    @endforeach
                </tr>
            </tfoot>
            @endif
        </table>
    </div>

    @if($datos instanceof \Illuminate\Pagination\LengthAwarePaginator)
    <div class="report-pagination">
        {{ $datos->links() }}
    </div>
    @endif

    <div class="mt-4 d-flex justify-content-end">
        <div class="btn-group">
            <a href="{{ route('reportes.generar', array_merge(request()->all(), ['formato' => 'excel'])) }}" class="btn btn-success me-2">
                <i class="fas fa-file-excel me-1"></i> Excel
            </a>

            <button onclick="window.print()" class="btn btn-primary">
                <i class="fas fa-print me-1"></i> Imprimir
            </button>
        </div>
    </div>
</div>

@if(isset($grafico) && $grafico)
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Datos para el gráfico provenientes del controlador
    const datosGrafico = @json($datosGrafico ?? []);

    if (datosGrafico && datosGrafico.series) {
        // Configuración del gráfico
        const options = {
            chart: {
                type: '{{ $tipoGrafico ?? "bar" }}',
                height: 400,
                toolbar: {
                    show: true,
                    tools: {
                        download: true,
                        selection: true,
                        zoom: true,
                        zoomin: true,
                        zoomout: true,
                        pan: true,
                        reset: true
                    },
                },
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800,
                    animateGradually: {
                        enabled: true,
                        delay: 150
                    },
                    dynamicAnimation: {
                        enabled: true,
                        speed: 350
                    }
                }
            },
            series: datosGrafico.series,
            xaxis: {
                categories: datosGrafico.categorias,
                title: {
                    text: '{{ $ejeX ?? "Categoría" }}'
                },
                labels: {
                    style: {
                        fontSize: '12px',
                        fontFamily: '"Inter", sans-serif',
                    },
                    rotateAlways: false,
                }
            },
            yaxis: {
                title: {
                    text: '{{ $ejeY ?? "Cantidad" }}'
                },
                labels: {
                    style: {
                        fontSize: '12px',
                        fontFamily: '"Inter", sans-serif',
                    }
                }
            },
            title: {
                text: '{{ $tituloGrafico ?? "Distribución de datos" }}',
                align: 'center',
                style: {
                    fontSize: '16px',
                    fontWeight: 'bold',
                    fontFamily: '"Inter", sans-serif',
                }
            },
            colors: ['#4F46E5', '#10B981', '#F59E0B', '#EF4444', '#6B7280', '#8B5CF6'],
            dataLabels: {
                enabled: true,
                style: {
                    fontSize: '12px',
                    fontFamily: '"Inter", sans-serif',
                    fontWeight: 'normal',
                }
            },
            plotOptions: {
                bar: {
                    borderRadius: 6,
                    horizontal: false,
                    columnWidth: '70%',
                    distributed: false,
                    dataLabels: {
                        position: 'top'
                    },
                },
                pie: {
                    donut: {
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                showAlways: true,
                                label: 'Total',
                                fontSize: '14px',
                                fontFamily: '"Inter", sans-serif',
                            }
                        }
                    }
                }
            },
            stroke: {
                width: 2,
                curve: 'smooth'
            },
            tooltip: {
                y: {
                    formatter: function(value) {
                        return value;
                    }
                },
                theme: 'light',
                style: {
                    fontSize: '12px',
                    fontFamily: '"Inter", sans-serif',
                },
            },
            theme: {
                mode: 'light',
                palette: 'palette1',
            },
            legend: {
                show: true,
                position: 'bottom',
                horizontalAlign: 'center',
                fontSize: '13px',
                fontFamily: '"Inter", sans-serif',
                itemMargin: {
                    horizontal: 8,
                    vertical: 5
                },
            },
            responsive: [
                {
                    breakpoint: 768,
                    options: {
                        chart: {
                            height: 300
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            ]
        };

        const chart = new ApexCharts(document.querySelector("#grafico"), options);
        chart.render();
    }
});
</script>
@endpush
@endif

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Variables para la paginación
        let currentPage = 1;
        let pageSize = 10;
        let filteredData = [];
        let sortColumn = null;
        let sortDirection = 'asc';

        // Obtener datos de la tabla
        const tableRows = Array.from(document.querySelectorAll('#reporte-table-body tr'));
        const originalData = tableRows.map(row => {
            return {
                element: row,
                text: row.textContent.toLowerCase()
            };
        });
        filteredData = [...originalData];

        // Buscador
        const searchInput = document.getElementById('table-search');
        searchInput.addEventListener('input', function() {
            const searchText = this.value.toLowerCase().trim();

            if (searchText === '') {
                filteredData = [...originalData];
            } else {
                filteredData = originalData.filter(item => item.text.includes(searchText));
            }

            currentPage = 1; // Volver a la primera página al buscar
            renderTable();
        });

        // Cambiar tamaño de página
        const pageSizeSelect = document.getElementById('page-size');
        pageSizeSelect.addEventListener('change', function() {
            pageSize = parseInt(this.value);
            currentPage = 1; // Volver a la primera página al cambiar el tamaño
            renderTable();
        });

        // Navegación por páginas
        document.getElementById('prev-page').addEventListener('click', function() {
            if (currentPage > 1) {
                currentPage--;
                renderTable();
            }
        });

        document.getElementById('next-page').addEventListener('click', function() {
            const totalPages = Math.ceil(filteredData.length / pageSize);
            if (currentPage < totalPages) {
                currentPage++;
                renderTable();
            }
        });

        // Ordenar tabla
        window.sortTable = function(headerCell) {
            const headerIndex = Array.from(headerCell.parentNode.children).indexOf(headerCell);
            const currentSortIcon = headerCell.querySelector('i');

            // Reiniciar íconos de ordenamiento
            document.querySelectorAll('#reporte-table thead th i').forEach(icon => {
                icon.className = 'fas fa-sort ml-1 text-gray-300';
            });

            if (sortColumn === headerIndex) {
                // Cambiar dirección si ya estamos ordenando por esta columna
                sortDirection = sortDirection === 'asc' ? 'desc' : 'asc';
            } else {
                // Nueva columna de ordenamiento
                sortColumn = headerIndex;
                sortDirection = 'asc';
            }

            // Actualizar ícono
            currentSortIcon.className = `fas fa-sort-${sortDirection === 'asc' ? 'up' : 'down'} ml-1 text-indigo-600`;

            // Ordenar datos
            filteredData.sort((a, b) => {
                const cellsA = a.element.querySelectorAll('td');
                const cellsB = b.element.querySelectorAll('td');

                if (cellsA.length <= headerIndex || cellsB.length <= headerIndex) return 0;

                const valueA = cellsA[headerIndex].textContent.trim().toLowerCase();
                const valueB = cellsB[headerIndex].textContent.trim().toLowerCase();

                if (valueA < valueB) {
                    return sortDirection === 'asc' ? -1 : 1;
                }
                if (valueA > valueB) {
                    return sortDirection === 'asc' ? 1 : -1;
                }
                return 0;
            });

            renderTable();
        };

        // Función para renderizar la tabla con datos filtrados y paginados
        function renderTable() {
            const totalItems = filteredData.length;
            const totalPages = Math.ceil(totalItems / pageSize);

            // Calcular rango de elementos a mostrar
            const startIndex = (currentPage - 1) * pageSize;
            const endIndex = Math.min(startIndex + pageSize, totalItems);

            // Actualizar info de paginación
            document.getElementById('showing-start').textContent = totalItems > 0 ? startIndex + 1 : 0;
            document.getElementById('showing-end').textContent = endIndex;
            document.getElementById('total-items').textContent = totalItems;

            // Ocultar todas las filas
            tableRows.forEach(row => row.style.display = 'none');

            // Mostrar solo las filas de la página actual
            for (let i = startIndex; i < endIndex; i++) {
                filteredData[i].element.style.display = '';
            }

            // Generar números de página
            const paginationContainer = document.getElementById('pagination-numbers');
            paginationContainer.innerHTML = '';

            // Determinar rango de páginas a mostrar
            let startPage = Math.max(1, currentPage - 2);
            let endPage = Math.min(totalPages, startPage + 4);

            if (endPage - startPage < 4 && totalPages > 5) {
                startPage = Math.max(1, endPage - 4);
            }

            // Agregar botón para la primera página si no está en el rango
            if (startPage > 1) {
                addPageButton(1, paginationContainer);
                if (startPage > 2) {
                    addEllipsis(paginationContainer);
                }
            }

            // Agregar botones para el rango de páginas
            for (let i = startPage; i <= endPage; i++) {
                addPageButton(i, paginationContainer);
            }

            // Agregar botón para la última página si no está en el rango
            if (endPage < totalPages) {
                if (endPage < totalPages - 1) {
                    addEllipsis(paginationContainer);
                }
                addPageButton(totalPages, paginationContainer);
            }

            // Actualizar estados de los botones de navegación
            document.getElementById('prev-page').disabled = currentPage === 1;
            document.getElementById('prev-page').classList.toggle('opacity-50', currentPage === 1);
            document.getElementById('next-page').disabled = currentPage === totalPages;
            document.getElementById('next-page').classList.toggle('opacity-50', currentPage === totalPages);
        }

        // Función para agregar botón de página
        function addPageButton(pageNum, container) {
            const button = document.createElement('button');
            button.className = `relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium ${pageNum === currentPage ? 'text-indigo-600 bg-indigo-50 z-10 border-indigo-500' : 'text-gray-700 hover:bg-gray-50'}`;
            button.textContent = pageNum;
            button.addEventListener('click', function() {
                currentPage = pageNum;
                renderTable();
            });
            container.appendChild(button);
        }

        // Función para agregar puntos suspensivos
        function addEllipsis(container) {
            const span = document.createElement('span');
            span.className = 'relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700';
            span.textContent = '...';
            container.appendChild(span);
        }

        // Inicializar tabla
        renderTable();
    });
</script>
@endpush

@push('styles')
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .max-w-7xl, .max-w-7xl * {
            visibility: visible;
        }
        .max-w-7xl {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        #reporte-table {
            width: 100%;
            border-collapse: collapse;
        }
        #reporte-table th, #reporte-table td {
            border: 1px solid #e2e8f0;
            padding: 8px;
        }
        #reporte-table th {
            background-color: #f8fafc;
            font-weight: bold;
            text-align: left;
        }
        .no-print, .no-print * {
            display: none !important;
        }
    }

    /* Estilos personalizados para los botones */
    .flex-wrap a, .flex-wrap button {
        background-color: #2563eb !important; /* bg-blue-600 */
        color: white !important;
    }

    .flex-wrap a:hover, .flex-wrap button:hover {
        background-color: #1d4ed8 !important; /* bg-blue-700 */
    }

    .flex-wrap a:focus, .flex-wrap button:focus {
        background-color: #1d4ed8 !important; /* bg-blue-700 */
        outline: none !important;
        box-shadow: 0 0 0 2px #93c5fd !important; /* ring-2 ring-blue-500 */
    }

    .flex-wrap a:active, .flex-wrap button:active {
        background-color: #1e40af !important; /* bg-blue-800 */
    }
</style>
@endpush

@endsection
