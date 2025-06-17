<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\Medicamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    /**
     * Muestra el listado de compras
     */
    public function index()
    {
        $compras = Compra::latest()->with('usuario')->get();
        return view('compras.index', compact('compras'));
    }

    /**
     * Muestra el formulario para crear una nueva compra
     */
    public function create()
    {
        $medicamentos = Medicamento::all();
        return view('compras.create', compact('medicamentos'));
    }

    /**
     * Almacena una nueva compra en la base de datos
     */
    public function store(Request $request)
    {
        $request->validate([
            'fecha_compra' => 'required|date',
            'medicamentos.*.id' => 'required|exists:medicamentos,id',
            'medicamentos.*.cantidad' => 'required|integer|min:1',
            'medicamentos.*.precio_unitario' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            // Crear la compra principal
            $compra = Compra::create([
                'fecha_compra' => $request->fecha_compra,
                'numero_factura' => $request->numero_factura,
                'metodo_pago' => $request->metodo_pago,
                'total' => 0, // Inicializamos en 0, se calculará después
                'user_id' => auth()->id(),
            ]);

            $total = 0;

            // Procesar cada medicamento en la compra
            foreach ($request->medicamentos as $item) {
                $medicamento = Medicamento::findOrFail($item['id']);
                $importe = $item['cantidad'] * $item['precio_unitario'];
                $total += $importe;

                // Crear detalle de compra
                DetalleCompra::create([
                    'compra_id' => $compra->id,
                    'medicamento_id' => $medicamento->id,
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio_unitario'],
                    'lote' => $item['lote'] ?? null,
                    'fecha_caducidad' => $item['fecha_caducidad'] ?? null,
                ]);

                // Actualizar stock y precio del medicamento
                $medicamento->stock_actual += $item['cantidad'];
                $medicamento->precio_compra = $item['precio_unitario'];
                $medicamento->save();
            }

            // Actualizar el total de la compra
            $compra->total = $total;
            $compra->save();

            DB::commit();
            return redirect()->route('compras.index')->with('success', 'Compra registrada exitosamente.');
        } catch (\Throwable $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Error al registrar la compra: ' . $e->getMessage()]);
        }
    }

    /**
     * Muestra una compra específica
     */
    public function show(Compra $compra)
    {
        $compra->load('detalles.medicamento', 'usuario');
        return view('compras.show', compact('compra'));
    }
}