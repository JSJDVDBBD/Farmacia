@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Corte de Caja</h1>

    @if(session('success'))
        <div class="bg-green-100 p-2 rounded mb-4 text-green-800">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 p-2 rounded mb-4 text-red-800">{{ $errors->first() }}</div>
    @endif

    @if(!$caja_abierta)
        <form method="POST" action="{{ route('corte-caja.abrir') }}" class="mb-6">
            @csrf
            <label>Monto inicial</label>
            <input type="number" name="monto_inicial" step="0.01" required class="w-full border rounded p-2 mb-2">
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Abrir caja</button>
        </form>
    @else
        <div class="bg-yellow-100 p-4 rounded mb-4">
            <p><strong>Caja abierta desde:</strong> {{ $caja_abierta->fecha_apertura }}</p>
            <p><strong>Monto inicial:</strong> ${{ number_format($caja_abierta->monto_inicial, 2) }}</p>
        </div>
        <form method="POST" action="{{ route('corte-caja.cerrar') }}">
            @csrf
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Cerrar caja</button>
        </form>
    @endif

    <hr class="my-6">

    <h2 class="text-xl font-semibold mb-4">Historial de cortes</h2>

    <table class="min-w-full bg-white shadow rounded">
        <thead>
            <tr>
                <th class="text-left p-2">Fecha Apertura</th>
                <th class="text-left p-2">Cierre</th>
                <th class="text-left p-2">Total ventas</th>
                <th class="text-left p-2">Efectivo</th>
                <th class="text-left p-2">Tarjeta</th>
                <th class="text-left p-2">Usuario</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cortes as $corte)
            <tr>
                <td class="p-2">{{ $corte->fecha_apertura }}</td>
                <td class="p-2">{{ $corte->fecha_cierre ?? '-' }}</td>
                <td class="p-2">${{ number_format($corte->total_ventas, 2) }}</td>
                <td class="p-2">${{ number_format($corte->ventas_efectivo, 2) }}</td>
                <td class="p-2">${{ number_format($corte->ventas_tarjeta, 2) }}</td>
                <td class="p-2">{{ $corte->usuario->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
