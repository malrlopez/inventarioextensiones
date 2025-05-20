<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $titulo }}</title>
    <style>
        @page {
            margin: 2cm;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #1F2937;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #4F46E5;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #4F46E5;
            font-size: 24px;
            margin-bottom: 10px;
        }
        .metadata {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #F3F4F6;
            border-radius: 4px;
        }
        .metadata-item {
            margin-bottom: 5px;
        }
        .metadata-label {
            font-weight: bold;
            color: #4B5563;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #FFFFFF;
        }
        th, td {
            border: 1px solid #E5E7EB;
            padding: 12px 8px;
            text-align: left;
            font-size: 11px;
        }
        th {
            background-color: #4F46E5;
            color: #FFFFFF;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
        }
        tr:nth-child(even) {
            background-color: #F9FAFB;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #6B7280;
            padding: 10px 0;
            border-top: 1px solid #E5E7EB;
        }
        .page-break {
            page-break-after: always;
        }
        .empty-message {
            text-align: center;
            padding: 40px;
            color: #6B7280;
            font-style: italic;
            background-color: #F9FAFB;
            border: 1px dashed #E5E7EB;
            border-radius: 4px;
        }
        .summary {
            margin-top: 20px;
            padding: 15px;
            background-color: #F3F4F6;
            border-radius: 4px;
        }
        .summary h2 {
            color: #4F46E5;
            font-size: 14px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $titulo }}</h1>
        <div class="fecha">Generado el: {{ $fecha }}</div>
    </div>

    @if(isset($filtros) && count($filtros) > 0)
    <div class="metadata">
        <h2 style="margin-top: 0; color: #4F46E5; font-size: 14px;">Filtros Aplicados</h2>
        @foreach($filtros as $label => $value)
            <div class="metadata-item">
                <span class="metadata-label">{{ ucfirst($label) }}:</span> {{ $value }}
            </div>
        @endforeach
    </div>
    @endif

    @if(count($datos) > 0)
        <table>
            <thead>
                <tr>
                    @foreach($columnas as $columna)
                        <th>{{ $columna }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($datos as $item)
                    <tr>
                        @foreach($campos as $campo)
                            <td>
                                @if(is_object($item->$campo) && method_exists($item->$campo, 'format'))
                                    {{ $item->$campo->format('d/m/Y H:i:s') }}
                                @else
                                    {{ $item->$campo ?? 'N/A' }}
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="summary">
            <h2>Resumen del Reporte</h2>
            <div class="metadata-item">
                <span class="metadata-label">Total de registros:</span> {{ count($datos) }}
            </div>
            @if(isset($totales))
                @foreach($totales as $label => $value)
                    <div class="metadata-item">
                        <span class="metadata-label">{{ $label }}:</span> {{ $value }}
                    </div>
                @endforeach
            @endif
        </div>
    @else
        <div class="empty-message">
            No se encontraron datos para mostrar en el reporte.
        </div>
    @endif

    <div class="footer">
        {{ config('app.name') }} - Página {PAGENO} de {nb}
    </div>
</body>
</html>
