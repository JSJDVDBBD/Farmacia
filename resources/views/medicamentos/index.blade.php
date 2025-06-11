@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-4">Medicamentos</h1>

    <a href="{{ route('medicamentos.create') }}" class="bg-green-600 text-white px-4 py-2 rounded mb-4 inline-block">+ Nuevo Medicamento</a>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-2 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <table class="min-w-full bg-white shadow rounded">
        <thead>
            <tr>
                <th class="text-left p-2">Nombre</th>
                <th class="text-left p-2">Cantidad</th>
                <th class="text-left p-2">Precio</th>
                <th class="text-left p-2">Fecha de caducidad</th>
                <th class="text-left p-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($medicamentos as $medicamento)
                <tr>
                    <td class="p-2">{{ $medicamento->nombre }}</td>
                    <td class="p-2">{{ $medicamento->cantidad }}</td>
                    <td class="p-2">${{ number_format($medicamento->precio, 2) }}</td>
                    <td class="p-2">{{ $medicamento->fecha_caducidad }}</td>
                    <td class="p-2">
                        <a href="{{ route('medicamentos.edit', $medicamento) }}" class="text-blue-600 hover:underline">Editar</a>
                        <form action="{{ route('medicamentos.destroy', $medicamento) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline ml-2" onclick="return confirm('¿Eliminar medicamento?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
