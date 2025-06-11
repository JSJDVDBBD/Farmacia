@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-4">Dashboard</h1>

    <div class="grid grid-cols-4 gap-4 mb-6">
        <div class="bg-green-100 p-4 rounded">
            <p class="text-sm text-gray-600">Total medicamentos</p>
            <p class="text-2xl font-bold">{{ $total_medicamentos }}</p>
        </div>
        <div class="bg-yellow-100 p-4 rounded">
            <p class="text-sm text-gray-600">Productos a caducar</p>
            <p class="text-2xl font-bold">{{ $productos_a_caducar }}</p>
        </div>
        <div class="bg-red-100 p-4 rounded">
            <p class="text-sm text-gray-600">Productos con stock bajo</p>
            <p class="text-2xl font-bold">{{ $productos_stock_bajo }}</p>
        </div>
        <div class="bg-blue-100 p-4 rounded">
            <p class="text-sm text-gray-600">Ventas del día</p>
            <p class="text-2xl font-bold">${{ number_format($ventas_dia, 2) }} MXN</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded shadow mb-6">
        <h2 class="text-xl font-bold mb-4">Gráfico de ventas (últimos 7 días)</h2>
        <canvas id="ventasChart"></canvas>
    </div>

    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4">Últimas alertas</h2>
        <table class="min-w-full">
            <thead>
                <tr>
                    <th class="text-left">Medicamento</th>
                    <th class="text-left">Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ultimas_alertas as $alerta)
                    <tr>
                        <td>{{ $alerta->nombre }}</td>
                        <td>
                            @if ($alerta->cantidad < 10)
                                Stock bajo
                            @elseif ($alerta->fecha_caducidad <= now()->addDays(7))
                                Caduca en {{ $alerta->fecha_caducidad->diffInDays(now()) }} días
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('ventasChart').getContext('2d');
    const ventasChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($ventas_ultimos_7_dias->pluck('fecha')->toArray()) !!},
            datasets: [{
                label: 'Ventas (MXN)',
                data: {!! json_encode($ventas_ultimos_7_dias->pluck('total')->toArray()) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
    });
</script>
@endsection
