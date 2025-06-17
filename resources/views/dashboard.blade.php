@extends('layouts.app')

@section('content')
<div class="p-6 space-y-6">
    <h1 class="text-3xl font-bold">Dashboard</h1>

    <!-- KPIs -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded shadow">
            <p class="text-sm text-gray-600">Medicamentos registrados</p>
            <p class="text-2xl font-bold">{{ $total_medicamentos }}</p>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <p class="text-sm text-gray-600">Alertas activas</p>
            <p class="text-2xl font-bold text-red-600">{{ $total_alertas_activas }}</p>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <p class="text-sm text-gray-600">Ventas hoy</p>
            <p class="text-2xl font-bold text-green-600">${{ number_format($ventas_hoy, 2) }}</p>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <p class="text-sm text-gray-600">Ventas este mes</p>
            <p class="text-2xl font-bold">${{ number_format($ventas_mes, 2) }}</p>
        </div>
    </div>

    <!-- Gráfico -->
    <div class="bg-white p-4 rounded shadow">
        <h2 class="text-xl font-bold mb-2">Ventas últimos 7 días</h2>
        <canvas id="ventasChart"></canvas>
    </div>

    <!-- Últimas alertas y ventas -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-white p-4 rounded shadow">
            <h2 class="text-xl font-bold mb-2">Últimas alertas</h2>
            <ul class="space-y-2">
                @forelse ($ultimas_alertas as $alerta)
                    <li class="border-l-4 pl-2 @if($alerta->tipo === 'stock_bajo') border-red-500 @else border-yellow-500 @endif">
                        {{ $alerta->tipo === 'stock_bajo' ? 'Stock bajo' : 'Caducidad próxima' }} - 
                        {{ $alerta->medicamento->nombre_comercial ?? 'Medicamento eliminado' }}
                    </li>
                @empty
                    <li class="text-gray-600">Sin alertas activas</li>
                @endforelse
            </ul>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <h2 class="text-xl font-bold mb-2">Últimas ventas</h2>
            <ul class="space-y-2">
                @foreach ($ultimas_ventas as $venta)
                    <li>
                        <strong>{{ $venta->folio }}</strong> - ${{ number_format($venta->total, 2) }} - {{ $venta->usuario->name }}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Últimos cortes -->
    <div class="bg-white p-4 rounded shadow">
        <h2 class="text-xl font-bold mb-2">Últimos cortes de caja</h2>
        <table class="w-full">
            <thead>
                <tr>
                    <th class="text-left">Apertura</th>
                    <th class="text-left">Cierre</th>
                    <th class="text-left">Total</th>
                    <th class="text-left">Usuario</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ultimos_cortes as $corte)
                    <tr>
                        <td>{{ $corte->fecha_apertura }}</td>
                        <td>{{ $corte->fecha_cierre ?? '—' }}</td>
                        <td>${{ number_format($corte->total_ventas, 2) }}</td>
                        <td>{{ $corte->usuario->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('ventasChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($ventas_ultimos_7_dias->pluck('fecha')) !!},
        datasets: [{
            label: 'Ventas',
            data: {!! json_encode($ventas_ultimos_7_dias->pluck('total')) !!},
            backgroundColor: 'rgba(59, 130, 246, 0.6)',
            borderColor: 'rgba(59, 130, 246, 1)',
            borderWidth: 1
        }]
    }
});
</script>
@endsection
