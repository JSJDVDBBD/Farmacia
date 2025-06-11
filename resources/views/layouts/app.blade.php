<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ config('app.name', 'Medic Storage') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-green-700 text-white flex flex-col">
        <div class="p-6 text-2xl font-bold border-b border-green-800">
            Medic Storage
        </div>
        <nav class="flex-1 p-4 space-y-2">
            <a href="{{ route('dashboard') }}" class="block px-2 py-2 rounded hover:bg-green-600">Dashboard</a>
            <a href="{{ route('medicamentos.index') }}" class="block px-2 py-2 rounded hover:bg-green-600">Medicamentos</a>
            <a href="{{ route('ventas.create') }}" class="block px-2 py-2 rounded hover:bg-green-600">Registrar Venta</a>
            <a href="{{ route('corte-caja.index') }}" class="block px-2 py-2 rounded hover:bg-green-600">Corte de Caja</a>
        </nav>
        <div class="p-4 border-t border-green-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full px-2 py-2 rounded bg-red-600 hover:bg-red-500 text-white">Cerrar sesión</button>
            </form>
        </div>
    </aside>

    <!-- Main content -->
    <main class="flex-1 overflow-y-auto p-6">
        @yield('content')
    </main>

</body>
</html>
