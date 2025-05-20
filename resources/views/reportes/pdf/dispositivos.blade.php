<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Dispositivos</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .footer { text-align: center; font-size: 12px; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte de Dispositivos</h1>
        <p>Generado el: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Serie</th>
                <th>Estado</th>
                <th>Asignado a</th>
                <th>Última Actualización</th>
            </tr>
        </thead>
        <tbody>
            @foreach($datos as $dispositivo)
            <tr>
                <td>{{ $dispositivo->id }}</td>
                <td>{{ $dispositivo->nombre }}</td>
                <td>{{ $dispositivo->tipo }}</td>
                <td>{{ $dispositivo->marca }}</td>
                <td>{{ $dispositivo->modelo }}</td>
                <td>{{ $dispositivo->serie }}</td>
                <td>{{ $dispositivo->estado }}</td>
                <td>{{ $dispositivo->usuario ? $dispositivo->usuario->name : 'No asignado' }}</td>
                <td>{{ $dispositivo->updated_at->format('d/m/Y H:i:s') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Total de registros: {{ $datos->count() }}</p>
    </div>
</body>
</html>
