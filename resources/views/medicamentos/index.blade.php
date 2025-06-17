@extends('layouts.app')

@section('content')
<div class="flex gap-6 p-6">
    <!-- Panel izquierdo - Lista de medicamentos -->
    <div class="w-2/3">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Panel de Administración - Medicamentos</h1>

        <!-- Buscador mejorado -->
        <div class="mb-8 bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-blue-600 px-4 py-3">
                <h2 class="text-lg font-semibold text-white">Buscar Medicamento</h2>
            </div>
            <div class="p-4">
                <div class="relative mb-4">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" id="search-input" placeholder="Buscar por código, nombre o categoría..." 
                           class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>

                <!-- Resultados de búsqueda en tabla -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Comercial</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Genérico</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoría</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="search-results">
                            @foreach ($medicamentos as $med)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $med->codigo_barras }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $med->nombre_comercial }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $med->nombre_generico }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $med->categoria->nombre ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $med->stock_actual < ($med->stock_minimo ?? 10) ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                        {{ $med->stock_actual }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $med->estado == 'activo' ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-800' }}">
                                        {{ ucfirst($med->estado) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tabla completa de medicamentos -->
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="flex justify-between items-center px-6 py-4 bg-gray-50 border-b">
                <h2 class="text-lg font-semibold text-gray-800">Listado Completo de Medicamentos</h2>
            </div>
            <div class="overflow-x-auto">
                  <table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-gray-50">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Código</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Comercial</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Imagen</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Precio</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        @foreach($medicamentos as $med)
        <tr>
            <td class="px-6 py-4 whitespace-nowrap">{{ $med->codigo_barras }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ $med->nombre_comercial }}</td>
            <td class="px-6 py-4 whitespace-nowrap">
                <img src="{{ $med->imagen_url }}" alt="Imagen" class="h-12 w-12 object-cover rounded">
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                    {{ $med->stock_actual < $med->stock_minimo ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                    {{ $med->stock_actual }}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">${{ number_format($med->precio_venta, 2) }}</td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                    {{ $med->estado == 'activo' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                    {{ ucfirst($med->estado) }}
                </span>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
            </div>
        </div>
    </div>

    <!-- Panel derecho - Formulario para agregar medicamentos -->
    <div class="w-1/3">
        <div class="bg-white rounded-lg shadow-md overflow-hidden sticky top-6">
            <div class="bg-blue-600 px-4 py-3">
                <h2 class="text-lg font-semibold text-white">Agregar Medicamento</h2>
            </div>
            <div class="p-4">
                <form action="{{ route('medicamentos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Código de Barras</label>
                            <input name="codigo_barras" class="input-field" placeholder="7501001234567" required>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre Comercial</label>
                                <input name="nombre_comercial" class="input-field" placeholder="Tempra 500mg" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre Genérico</label>
                                <input name="nombre_generico" class="input-field" placeholder="Paracetamol">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Fabricante</label>
                            <input name="fabricante" class="input-field" placeholder="Fabricante">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Presentación</label>
                            <input name="presentacion" class="input-field" placeholder="Tabletas, Jarabe, etc.">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Stock Actual</label>
                                <input type="number" name="stock_actual" class="input-field" placeholder="80">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Stock Mínimo</label>
                                <input type="number" name="stock_minimo" class="input-field" placeholder="10">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Precio Compra</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">$</span>
                                    <input type="number" step="0.01" name="precio_compra" class="input-field pl-7" placeholder="0.00">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Precio Venta</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">$</span>
                                    <input type="number" step="0.01" name="precio_venta" class="input-field pl-7" placeholder="0.00">
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ubicación en almacén</label>
                            <input name="ubicacion" class="input-field" placeholder="Estante A, Nivel 2">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                            <div class="flex space-x-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="estado" value="activo" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="ml-2 text-sm text-gray-700">Activo</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="estado" value="inactivo" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="ml-2 text-sm text-gray-700">Inactivo</span>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Imagen</label>
                            <div class="mt-1 flex items-center">
                                <label for="imagen" class="cursor-pointer">
                                    <span class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Seleccionar archivo
                                    </span>
                                    <input id="imagen" name="imagen" type="file" class="sr-only">
                                </label>
                                <span class="ml-2 text-sm text-gray-500" id="file-name">Ningún archivo seleccionado</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" class="btn-secondary transform hover:-translate-y-0.5 transition-all duration-200">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Cancelar
                        </button>
                        <button type="submit" class="btn-primary transform hover:-translate-y-0.5 transition-all duration-200">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Mostrar nombre del archivo seleccionado
    document.getElementById('imagen').addEventListener('change', function(e) {
        const fileName = e.target.files[0] ? e.target.files[0].name : 'Ningún archivo seleccionado';
        document.getElementById('file-name').textContent = fileName;
    });

    // Búsqueda en tiempo real
    document.getElementById('search-input').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('#search-results tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });
</script>
@endpush

<style>
    .input-field {
        @apply block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm;
    }
    
    .btn-primary {
        @apply inline-flex items-center px-4 py-2.5 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200;
        box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3), 0 2px 4px -1px rgba(59, 130, 246, 0.1);
    }
    
    .btn-primary:hover {
        box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3), 0 4px 6px -2px rgba(59, 130, 246, 0.1);
        transform: translateY(-1px);
    }
    
    .btn-secondary {
        @apply inline-flex items-center px-4 py-2.5 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 hover:from-gray-100 hover:to-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    }
    
    .btn-secondary:hover {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transform: translateY(-1px);
    }
</style>
@endsection