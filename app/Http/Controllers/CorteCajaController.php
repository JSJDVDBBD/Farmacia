<?php

namespace App\Http\Controllers;

use App\Models\CorteCaja;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CorteCajaController extends Controller
{
    public function index()
    {
        $cortes = CorteCaja::latest()->with('usuario')->get();
        $caja_abierta = CorteCaja::where('estado', 'abierto')->first();

        return view('corte-caja.index', compact('cortes', 'caja_abierta'));
    }

    public function abrir(Request $request)
    {
        $request->validate([
            'monto_inicial' => 'required|numeric|min:0'
        ]);

        if (CorteCaja::where('estado', 'abierto')->exists()) {
            return back()->withErrors(['error' => 'Ya hay una caja abierta.']);
        }

        CorteCaja::create([
            'fecha_apertura' => now(),
            'monto_inicial' => $request->monto_inicial,
            'user_id' => auth()->id(),
            'estado' => 'abierto',
        ]);

        return back()->with('success', 'Caja abierta correctamente.');
    }

    public function cerrar()
    {
        $caja = CorteCaja::where('estado', 'abierto')->first();
        if (!$caja) {
            return back()->withErrors(['error' => 'No hay caja abierta.']);
        }

        $ventas = Venta::whereBetween('fecha_venta', [$caja->fecha_apertura, now()])->get();

        $efectivo = $ventas->where('metodo_pago', 'efectivo')->sum('total');
        $tarjeta = $ventas->where('metodo_pago', 'tarjeta')->sum('total');
        $transferencia = $ventas->where('metodo_pago', 'transferencia')->sum('total');
        $total = $efectivo + $tarjeta + $transferencia;

        $caja->update([
            'fecha_cierre' => now(),
            'ventas_efectivo' => $efectivo,
            'ventas_tarjeta' => $tarjeta,
            'ventas_transferencia' => $transferencia,
            'total_ventas' => $total,
            'monto_final' => $total + $caja->monto_inicial,
            'diferencia' => 0,
            'estado' => 'cerrado',
        ]);

        return back()->with('success', 'Caja cerrada correctamente.');
    }
}
