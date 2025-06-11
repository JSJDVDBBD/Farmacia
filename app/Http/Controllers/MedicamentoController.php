<?php

namespace App\Http\Controllers;

use App\Models\Medicamento;
use Illuminate\Http\Request;

class MedicamentoController extends Controller
{
    public function index()
    {
        $medicamentos = Medicamento::all();
        return view('medicamentos.index', compact('medicamentos'));
    }

    public function create()
    {
        return view('medicamentos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'cantidad' => 'required|integer|min:0',
            'precio' => 'required|numeric|min:0',
            'fecha_caducidad' => 'required|date',
        ]);

        Medicamento::create($request->all());

        return redirect()->route('medicamentos.index')->with('success', 'Medicamento registrado.');
    }

    public function edit(Medicamento $medicamento)
    {
        return view('medicamentos.edit', compact('medicamento'));
    }

    public function update(Request $request, Medicamento $medicamento)
    {
        $request->validate([
            'nombre' => 'required',
            'cantidad' => 'required|integer|min:0',
            'precio' => 'required|numeric|min:0',
            'fecha_caducidad' => 'required|date',
        ]);

        $medicamento->update($request->all());

        return redirect()->route('medicamentos.index')->with('success', 'Medicamento actualizado.');
    }

    public function destroy(Medicamento $medicamento)
    {
        $medicamento->delete();

        return redirect()->route('medicamentos.index')->with('success', 'Medicamento eliminado.');
    }
}
