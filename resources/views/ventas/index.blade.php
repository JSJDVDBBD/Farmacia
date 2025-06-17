@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Historial de Ventas</h1>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="min-w-full bg-white rounded shadow">
        <thead>
            <tr>
                <th class="text-left p-2">Folio</th>
                <th class="text-left p-2">Fecha</th>
                <th class="text-left p-2">Total</th>
                <th class="text-left p-2">Método</th>
                <th class="text-left p-2">Usuario</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ventas as $venta)
                <tr>
                    <td class="p-2">{{ $venta->folio }}</td>
                    <td class="p-2">{{ $venta->fecha_venta }}</td>
                    <td class="p-2">${{ number_format($venta->total, 2) }}</td>
                    <td class="p-2">{{ ucfirst($venta->metodo_pago) }}</td>
                    <td class="p-2">{{ $venta->usuario->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
