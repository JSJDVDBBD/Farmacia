<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicamento extends Model
{
    protected $fillable = [
        'codigo_barras',
        'nombre_comercial',
        'nombre_generico',
        'fabricante',
        'presentacion',
        'concentracion',
        'categoria_id',
        'stock_actual',
        'stock_minimo',
        'precio_compra',
        'precio_venta',
        'fecha_caducidad',
        'lote',
        'ubicacion',
        'imagen',
        'estado',
    ];

    protected $casts = [
        'fecha_caducidad' => 'date',
        'stock_actual' => 'integer',
        'stock_minimo' => 'integer',
        'precio_compra' => 'decimal:2',
        'precio_venta' => 'decimal:2'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function detalleCompras()
    {
        return $this->hasMany(DetalleCompra::class);
    }

    public function detalleVentas()
    {
        return $this->hasMany(DetalleVenta::class);
    }

    public function alertas()
    {
        return $this->hasMany(Alerta::class);
    }

    public function getImagenUrlAttribute()
    {
        return $this->imagen 
            ? asset("storage/{$this->imagen}")
            : asset('images/medicamento-default.png');
    }
}