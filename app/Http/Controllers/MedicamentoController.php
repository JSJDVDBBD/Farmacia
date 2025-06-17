<?php

namespace App\Http\Controllers;

use App\Models\Medicamento;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MedicamentoController extends Controller
{
    public function index()
    {
        $medicamentos = Medicamento::with('categoria')
                         ->orderBy('created_at', 'desc')
                         ->get();
        
        $categorias = Categoria::all();
        
        return view('medicamentos.index', compact('medicamentos', 'categorias'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo_barras' => 'required|unique:medicamentos|max:50',
            'nombre_comercial' => 'required|max:100',
            'nombre_generico' => 'nullable|max:100',
            'categoria_id' => 'required|exists:categorias,id',
            'fabricante' => 'nullable|max:100',
            'presentacion' => 'nullable|max:100',
            'concentracion' => 'nullable|max:50',
            'stock_actual' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'precio_compra' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'fecha_caducidad' => 'required|date|after:today',
            'ubicacion' => 'nullable|max:100',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'estado' => 'required|in:activo,inactivo'
        ]);

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('public/medicamentos');
            $validated['imagen'] = str_replace('public/', '', $path);
        }

        Medicamento::create($validated);

        return redirect()->route('medicamentos.index')
                        ->with('success', 'Medicamento creado correctamente');
    }

    public function edit(Medicamento $medicamento)
    {
        $categorias = Categoria::all();
        return view('medicamentos.edit', compact('medicamento', 'categorias'));
    }

    public function update(Request $request, Medicamento $medicamento)
    {
        $validated = $request->validate([
            'codigo_barras' => 'required|max:50|unique:medicamentos,codigo_barras,'.$medicamento->id,
            'nombre_comercial' => 'required|max:100',
            'nombre_generico' => 'nullable|max:100',
            'categoria_id' => 'required|exists:categorias,id',
            'fabricante' => 'nullable|max:100',
            'presentacion' => 'nullable|max:100',
            'concentracion' => 'nullable|max:50',
            'stock_actual' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'precio_compra' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'fecha_caducidad' => 'required|date',
            'lote' => 'nullable|max:50',
            'ubicacion' => 'nullable|max:100',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'estado' => 'required|in:activo,inactivo'
        ]);

        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existe
            if ($medicamento->imagen) {
                Storage::delete('public/'.$medicamento->imagen);
            }
            $validated['imagen'] = $request->file('imagen')->store('medicamentos', 'public');
        }

        $medicamento->update($validated);

        return redirect()->route('medicamentos.index')
                        ->with('success', 'Medicamento actualizado exitosamente.');
    }

    public function destroy(Medicamento $medicamento)
    {
        if ($medicamento->imagen) {
            Storage::delete('public/'.$medicamento->imagen);
        }
        
        $medicamento->delete();
        
        return redirect()->route('medicamentos.index')
                        ->with('success', 'Medicamento eliminado exitosamente.');
    }
}