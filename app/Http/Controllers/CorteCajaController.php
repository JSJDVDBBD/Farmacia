<?php

namespace App\Http\Controllers;

use App\Models\CorteCaja;
use App\Models\Venta;
use Illuminate\Http\Request;

class CorteCajaController extends Controller
{
    public function index()
    {
        $cortes = CorteCaja::latest()->get();
        return view('corte-caja.index', compact('cortes'));
    }

    public function store()
    {
        $total_dia = Venta::whereDate('fecha_venta', today())->sum('total_venta');

        CorteCaja::create([
            'total_dia' => $total_dia,
            'fecha_corte' => today(),
        ]);

        return redirect()->route('corte-caja.index')->with('success', 'Corte de caja registrado.');
    }
}
