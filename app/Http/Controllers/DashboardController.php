<?php

namespace App\Http\Controllers;

use App\Models\Medicamento;
use App\Models\Venta;
use App\Models\Alerta;
use App\Models\CorteCaja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Totales
        $total_medicamentos = Medicamento::count();
        $total_alertas_activas = Alerta::where('estado', 'activa')->count();
        $ventas_hoy = Venta::whereDate('fecha_venta', today())->sum('total');
        $ventas_mes = Venta::whereMonth('fecha_venta', now()->month)->sum('total');

        // Últimas alertas
        $ultimas_alertas = Alerta::with('medicamento')
            ->where('estado', 'activa')
            ->latest()
            ->take(5)
            ->get();

        // Últimos cortes
        $ultimos_cortes = CorteCaja::latest()->take(5)->get();

        // Últimas ventas
        $ultimas_ventas = Venta::latest()->with('usuario')->take(5)->get();

        // Gráfico de ventas (últimos 7 días)
        $ventas_ultimos_7_dias = Venta::selectRaw('DATE(fecha_venta) as fecha, SUM(total) as total')
            ->where('fecha_venta', '>=', now()->subDays(6))
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();

        return view('dashboard', compact(
            'total_medicamentos',
            'total_alertas_activas',
            'ventas_hoy',
            'ventas_mes',
            'ultimas_alertas',
            'ultimas_ventas',
            'ultimos_cortes',
            'ventas_ultimos_7_dias'
        ));
    }
}
