<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Medicamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function index()
    {
        $ventas = Venta::with('usuario')->latest()->get();
        return view('ventas.index', compact('ventas'));
    }

    public function create()
    {
        $medicamentos = Medicamento::where('stock_actual', '>', 0)->get();
        return view('ventas.create', compact('medicamentos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'metodo_pago' => 'required',
            'medicamentos.*.id' => 'required|exists:medicamentos,id',
            'medicamentos.*.cantidad' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $folio = 'V-' . strtoupper(uniqid());
            $venta = Venta::create([
                'folio' => $folio,
                'fecha_venta' => now(),
                'subtotal' => 0,
                'total' => 0,
                'metodo_pago' => $request->metodo_pago,
                'estado' => 'completada',
                'user_id' => auth()->id(),
            ]);

            $subtotal = 0;

            foreach ($request->medicamentos as $item) {
                $med = Medicamento::findOrFail($item['id']);

                if ($item['cantidad'] > $med->stock_actual) {
                    throw new \Exception("No hay suficiente stock de {$med->nombre_comercial}");
                }

                $importe = $item['cantidad'] * $med->precio_venta;
                $subtotal += $importe;

                DetalleVenta::create([
                    'venta_id' => $venta->id,
                    'medicamento_id' => $med->id,
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $med->precio_venta,
                    'descuento' => 0,
                    'importe' => $importe,
                ]);

                $med->stock_actual -= $item['cantidad'];
                $med->save();
            }

            $venta->subtotal = $subtotal;
            $venta->total = $subtotal;
            $venta->save();

            DB::commit();
            return redirect()->route('ventas.index')->with('success', 'Venta registrada.');
        } catch (\Throwable $e) {
            DB::rollback();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
