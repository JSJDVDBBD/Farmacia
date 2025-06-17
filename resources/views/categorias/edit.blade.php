@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">{{ isset($categoria) ? 'Editar' : 'Nueva' }} Categoría</h1>

    <form method="POST" action="{{ isset($categoria) ? route('categorias.update', $categoria) : route('categorias.store') }}">
        @csrf
        @if(isset($categoria)) @method('PUT') @endif

        <div class="mb-4">
            <label>Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre', $categoria->nombre ?? '') }}" required class="w-full border p-2 rounded">
        </div>

        <div class="mb-4">
            <label>Descripción</label>
            <textarea name="description" class="w-full border p-2 rounded">{{ old('description', $categoria->description ?? '') }}</textarea>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
            {{ isset($categoria) ? 'Actualizar' : 'Crear' }}
        </button>
    </form>
</div>
@endsection
