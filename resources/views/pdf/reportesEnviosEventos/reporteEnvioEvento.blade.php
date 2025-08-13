<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Envío</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0 30px;
        }
        header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        header img {
            width: 100%;         
            height: auto;           
            max-height: 100px;       
            object-fit: contain;    
            display: block;
            margin: 0 auto;
        }



        header h2 {
            margin: 0;
            font-size: 20px;
        }
        .clear {
            clear: both;
        }
        h3 {
            margin-top: 30px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table, th, td {
            border: 1px solid #333;
        }
        th, td {
            padding: 8px;
            font-size: 12px;
            text-align: center;
        }
        footer {
            position: fixed;
            bottom: 0px;
            left: 30px;
            right: 30px;
            font-size: 11px;
            border-top: 1px solid #000;
            padding-top: 5px;
        }
        .section {
            margin-bottom: 20px;
        }
        .img-material {
            height: 60px;
        }
    </style>
</head>
<body>

    {{-- Encabezado --}}
    <header>
        <img src="https://tqi.co/wp-content/uploads/2018/02/Mesa-de-trabajo-1.png" alt="Logo">
      
    </header>

    {{-- Información del reporte --}}
    <div class="section">
        <h3>Detalle del reporte de envío</h3>
        <p><strong>Nombre del evento:</strong> {{ $reporte->nombre_evento }}</p>
        <p><strong>Dirección de entrega:</strong> {{ $reporte->direccion_entrega }}</p>
        <p><strong>Fecha de envío:</strong> {{ \Carbon\Carbon::parse($reporte->fecha_envio)->format('d/m/Y') }}</p>
        <p><strong>Observaciones:</strong> {{ $reporte->observaciones ?? 'Sin observaciones' }}</p>
        <p><strong>Destinatario:</strong> {{ $reporte->destinatario_nombre }} {{ $reporte->destinatario_apellido }}</p>
        <p><strong>Responsable:</strong> {{ $reporte->responsable_nombre }} {{ $reporte->responsable_apellido }}</p>
    </div>

    {{-- Materiales enviados --}}
    <div class="section">
        <h3>Materiales gráficos enviados</h3>
        <table>
            <thead>
                <tr>
                    <th>Material</th>
                    <th>Imagen</th>
                    <th>Cantidad enviada</th>
                </tr>
            </thead>
            <tbody>
                @forelse($materiales as $mat)
                    <tr>
                        <td>{{ $mat->material_nombre }}</td>
                        <td>
                            @if($mat->material_img)
                                <img src="{{ storage_path('app/public/' . $mat->material_img) }}" class="img-material" alt="Imagen">
                            @else
                                Sin imagen
                            @endif
                        </td>
                        <td>{{ $mat->cantidad_enviada }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No se registraron materiales.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Footer --}}
    <footer>
        <strong>Contáctanos:</strong><br>
        Teléfonos TQI: +57 (602) 695 9568 / +57 (602) 695 9567<br>
        e-Mail: info@tqi.co – Déjanos llamarte<br>
        <br>
        <strong>Visítanos en:</strong><br>
        Tratamientos Químicos Industriales<br>
        Carrera 36 # 15 – 97 Bodega 18<br>
        Centro Industrial y Comercial Panorama, Acopi, Yumbo-Colombia
    </footer>

</body>
</html>
