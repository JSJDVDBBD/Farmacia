@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Registrar Venta</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('ventas.store') }}">
        @csrf

        <div class="mb-4">
            <label>Método de pago</label>
            <select name="metodo_pago" class="w-full border p-2 rounded">
                <option value="efectivo">Efectivo</option>
                <option value="tarjeta">Tarjeta</option>
                <option value="transferencia">Transferencia</option>
            </select>
        </div>

        <h2 class="text-lg font-semibold mb-2">Medicamentos vendidos</h2>
        <div id="med-list"></div>
        <button type="button" onclick="agregarMedicamento()" class="bg-blue-500 text-white px-3 py-1 rounded mt-2">+ Medicamento</button>

        <button type="submit" class="mt-4 bg-green-600 text-white px-4 py-2 rounded">Registrar venta</button>
    </form>
</div>

<script>
let contador = 0;
function agregarMedicamento() {
    const div = document.createElement('div');
    div.classList.add('border', 'p-3', 'my-2', 'rounded');
    div.innerHTML = `
        <select name="medicamentos[${contador}][id]" class="w-full p-2 border rounded mb-2">
            <option value="">Selecciona medicamento</option>
            @foreach($medicamentos as $m)
                <option value="{{ $m->id }}">{{ $m->nombre_comercial }} (Stock: {{ $m->stock_actual }})</option>
            @endforeach
        </select>
        <input type="number" name="medicamentos[${contador}][cantidad]" placeholder="Cantidad" class="w-full p-2 border rounded mb-2" min="1">
    `;
    document.getElementById('med-list').appendChild(div);
    contador++;
}
</script>
@endsection
