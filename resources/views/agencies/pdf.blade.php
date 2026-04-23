<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Agencias</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #334155;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 10px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #2b96ee;
        }

        .subtitle {
            font-size: 14px;
            color: #64748b;
            margin-top: 5px;
        }

        .meta {
            font-size: 10px;
            color: #94a3b8;
            margin-top: 15px;
            text-align: right;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            background-color: #f8fafc;
            color: #64748b;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 12px;
            text-align: left;
            border-bottom: 2px solid #e2e8f0;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #f1f5f9;
        }

        .badge {
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .badge-cass {
            background-color: #eef2ff;
            color: #4f46e5;
        }

        .badge-nocass {
            background-color: #fff1f2;
            color: #f43f5e;
        }

        .badge-active {
            background-color: #ecfdf5;
            color: #10b981;
        }

        .badge-inactive {
            background-color: #f1f5f9;
            color: #94a3b8;
        }

        .code {
            background-color: #f8fafc;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: bold;
            color: #475569;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #94a3b8;
            padding: 10px 0;
            border-top: 1px solid #f1f5f9;
        }
    </style>
</head>

<body>

    <div class="header">
        <div class="logo">UNITEDFLOW</div>
        <div class="subtitle">Directorio Maestro de Agencias</div>
        <div class="meta">Fecha de Generación: {{ date('d/m/Y H:i') }} | Total registros: {{ $agencies->count() }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre / Razón Social</th>
                <th>Código Ref.</th>
                <th>Modalidad CASS</th>
                <th>Estado Operativo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($agencies as $agency)
                <tr>
                    <td style="color:#94a3b8;font-weight:bold;">#{{ $agency->id }}</td>
                    <td style="font-weight:bold;color:#0f172a;">{{ $agency->nombre }}</td>
                    <td>
                        @if($agency->codigo)
                            <span class="code">{{ $agency->codigo }}</span>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($agency->cass)
                            <span class="badge badge-cass">CASS (DTE Dir)</span>
                        @else
                            <span class="badge badge-nocass">NO CASS</span>
                        @endif
                    </td>
                    <td>
                        @if($agency->activo)
                            <span class="badge badge-active">Activa</span>
                        @else
                            <span class="badge badge-inactive">Inactiva</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        © {{ date('Y') }} United Flow Dashboard. Reporte Generado Automáticamente.
    </div>

</body>

</html>