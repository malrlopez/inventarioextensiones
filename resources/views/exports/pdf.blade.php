<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SISIPT - Exportación de Extensiones</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        th {
            background-color: #2D3436;
            color: white;
            padding: 10px 8px;
            text-align: left;
            font-size: 13px;
        }
        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #2D3436;
        }
        .header h2 {
            margin: 0 0 10px 0;
            color: #2D3436;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 10px;
            color: #666;
        }
        .meta-info {
            margin: 20px 0;
            font-size: 11px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>SISIPT</h2>
        <p>Reporte de Extensiones</p>
        <p>Fecha de exportación: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="meta-info">
        <p>Generado por: {{ Auth::user()->name }} ({{ Auth::user()->role }})</p>
        <p>Total de registros: {{ count($rows) }}</p>
    </div>

    <table>
        <thead>
            <tr>
                @foreach($headings as $heading)
                    <th>{{ $heading }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $row)
                <tr>
                    @foreach($row as $cell)
                        <td>{{ $cell }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Documento generado automáticamente por el sistema</p>
        <p>SISIPT - {{ now()->format('Y') }}</p>
    </div>
</body>
</html>
