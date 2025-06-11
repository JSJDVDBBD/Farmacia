<?php

namespace App\Http\Controllers;

use App\Models\Medicamento;
use App\Models\Venta;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function create()
    {
        $medicamentos = Medicamento::where('cantidad', '>', 0)->get();
        return view('ventas.create', compact('medicamentos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'medicamento_id' => 'required|exists:medicamentos,id',
            'cantidad_vendida' => 'required|integer|min:1',
        ]);

        $medicamento = Medicamento::findOrFail($request->medicamento_id);

        if ($request->cantidad_vendida > $medicamento->cantidad) {
            return back()->withErrors(['cantidad_vendida' => 'Cantidad insuficiente en inventario.']);
        }

        $total = $medicamento->precio * $request->cantidad_vendida;

        Venta::create([
            'medicamento_id' => $medicamento->id,
            'cantidad_vendida' => $request->cantidad_vendida,
            'precio_unitario' => $medicamento->precio,
            'total_venta' => $total,
            'fecha_venta' => now(),
        ]);

        // Restar cantidad vendida del inventario
        $medicamento->cantidad -= $request->cantidad_vendida;
        $medicamento->save();

        return redirect()->route('dashboard')->with('success', 'Venta registrada correctamente.');
    }
}
