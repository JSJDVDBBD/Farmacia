<?php
namespace App\Http\Controllers;

use App\Models\Medicamento;
use App\Models\Venta;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $total_medicamentos = Medicamento::count();

        $productos_a_caducar = Medicamento::where('fecha_caducidad', '<=', now()->addDays(7))->count();

        $productos_stock_bajo = Medicamento::where('cantidad', '<', 10)->count();

        $ventas_dia = Venta::whereDate('fecha_venta', today())->sum('total_venta');

        $ventas_ultimos_7_dias = Venta::selectRaw('DATE(fecha_venta) as fecha, SUM(total_venta) as total')
            ->where('fecha_venta', '>=', now()->subDays(6))
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();

        $ultimas_alertas = Medicamento::where('cantidad', '<', 10)
            ->orWhere('fecha_caducidad', '<=', now()->addDays(7))
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'total_medicamentos',
            'productos_a_caducar',
            'productos_stock_bajo',
            'ventas_dia',
            'ventas_ultimos_7_dias',
            'ultimas_alertas'
        ));
    }
}
