@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-4">Nuevo Medicamento</h1>

    <form action="{{ route('medicamentos.store') }}" method="POST" class="space-y-4 bg-white p-6 rounded shadow">
        @csrf

        <div>
            <label class="block text-gray-700">Nombre</label>
            <input type="text" name="nombre" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block text-gray-700">Cantidad</label>
            <input type="number" name="cantidad" min="0" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block text-gray-700">Precio</label>
            <input type="number" step="0.01" name="precio" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block text-gray-700">Fecha de caducidad</label>
            <input type="date" name="fecha_caducidad" class="w-full border rounded px-3 py-2" required>
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Guardar</button>
    </form>
</div>
@endsection
