<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $titulo }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #333;
            font-size: 18px;
            margin-bottom: 5px;
        }
        .fecha {
            color: #666;
            font-size: 11px;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #666;
            padding: 10px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $titulo }}</h1>
        <div class="fecha">Generado el: {{ $fecha }}</div>
    </div>

    @if(count($datos) > 0)
        <table>
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Dispositivo</th>
                    <th>Versión</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datos as $softphone)
                    <tr>
                        <td>{{ $softphone->usuario ?? 'N/A' }}</td>
                        <td>{{ $softphone->dispositivo ?? 'N/A' }}</td>
                        <td>{{ $softphone->version ?? 'N/A' }}</td>
                        <td>{{ $softphone->estado ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No se encontraron softphones para mostrar.</p>
    @endif

    <div class="footer">
        Página {PAGENO} de {nb}
    </div>
</body>
</html>
