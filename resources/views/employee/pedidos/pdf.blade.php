<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Factura Pedido #{{ $pedido->Pedido_id }}</title>
    <style>
        body { font-family: sans-serif; margin: 0; padding: 20px; font-size: 14px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #4F46E5; padding-bottom: 10px;}
        .header h1 { color: #4F46E5; margin: 0; font-size: 28px; text-transform: uppercase; }
        
        .section-title { font-size: 15px; font-weight: bold; margin-top: 20px; margin-bottom: 10px; color: #4F46E5; border-left: 4px solid #4F46E5; padding-left: 10px; }

        /* Detalles Generales */
        .info-grid { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .info-grid td { padding: 8px 0; vertical-align: top; width: 50%; }
        .info-grid strong { color: #1f2937; }

        .address { border: 1px solid #ddd; padding: 10px; background-color: #f9f9f9; border-radius: 5px; }

        /* Tabla de Artículos */
        .items { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .items th, .items td { border: 1px solid #eee; padding: 12px 10px; font-size: 12px; }
        .items th { background-color: #f3f4f6; color: #374151; font-weight: bold; text-transform: uppercase; }
        
        /* Alineaciones */
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        
        /* Fila de Totales */
        .total-row td { text-align: right; font-weight: bold; padding: 15px 10px; border: none; }
        .grand-total { background-color: #4F46E5; color: white; font-size: 16px; border-radius: 0 0 5px 5px; }

        .status-badge { 
            padding: 4px 12px; border-radius: 12px; 
            font-weight: bold; font-size: 11px; text-transform: uppercase;
        }
        /* Clases de estado corregidas para que coincidan con los nombres de tu DB */
        .status-pendiente { background-color: #fef3c7; color: #92400e; }
        .status-completado { background-color: #d1fae5; color: #065f46; }
        .status-procesando { background-color: #dbeafe; color: #1e40af; }
        .status-enviado { background-color: #e0e7ff; color: #3730a3; }
        .status-cancelado { background-color: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>

    <div class="header">
        <h1>HATIL</h1>
        <p style="font-size: 16px; margin-top: 5px;">Factura de Pedido <strong>#{{ $pedido->Pedido_id }}</strong></p>
    </div>

    <table class="info-grid">
        <tr>
            <td>
                <strong>Facturado A:</strong><br>
                {{-- CORRECCIÓN: Se cambió 'cliente' por 'usuario' --}}
                {{ $pedido->usuario->name ?? 'Cliente Desconocido' }}<br>
                <span style="color: #666;">{{ $pedido->usuario->email ?? 'N/A' }}</span>
            </td>
            <td class="text-right">
                <strong>Detalles del Pedido:</strong><br>
                Fecha: {{ is_object($pedido->Fecha_pedido) ? $pedido->Fecha_pedido->format('d/m/Y H:i') : $pedido->Fecha_pedido }}<br>
                Pago: {{ $pedido->Metodo_pago ?? 'N/A' }}
            </td>
        </tr>
    </table>

    <p class="section-title">Dirección de Envío</p>
    <div class="address">
        {{ $pedido->Direccion_envio ?? 'Dirección no proporcionada' }}
    </div>

    <table class="items">
        <thead>
            <tr>
                <th class="text-left">Mueble</th>
                <th class="text-right">Precio Unitario</th>
                <th class="text-right">Cantidad</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pedido->detalles as $detalle)
                <tr>
                    <td class="text-left">
                        <strong>{{ $detalle->mueble->Nombre ?? 'Mueble Eliminado' }}</strong>
                        @if(isset($detalle->mueble->SKU))
                            <br><small style="color: #888;">SKU: {{ $detalle->mueble->SKU }}</small>
                        @endif
                    </td>
                    <td class="text-right">${{ number_format($detalle->Precio_Unitario, 2) }}</td>
                    <td class="text-right">{{ $detalle->Cantidad }}</td>
                    <td class="text-right">${{ number_format($detalle->Cantidad * $detalle->Precio_Unitario, 2) }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="3">TOTAL FINAL:</td>
                <td class="grand-total">${{ number_format($pedido->Total, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top: 40px; text-align: right;">
        <span style="margin-right: 10px; font-weight: bold;">Estado del Pedido:</span>
        @php 
            // Normalizamos el estado para la clase CSS (ej: "Pendiente" -> "status-pendiente")
            $statusClass = 'status-' . strtolower($pedido->Estado); 
        @endphp
        <span class="status-badge {{ $statusClass }}">{{ $pedido->Estado }}</span>
    </div>

    <div style="margin-top: 50px; font-size: 10px; color: #aaa; text-align: center; border-top: 1px solid #eee; padding-top: 10px;">
        Gracias por su compra en HATIL. Si tiene dudas sobre su pedido, contacte a nuestro soporte.
    </div>

</body>
</html>