<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $fillable = [
        'venta_id', 'medicamento_id', 'cantidad', 'precio_unitario', 'descuento', 'importe'
    ];

    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }

    public function medicamento()
    {
        return $this->belongsTo(Medicamento::class);
    }
}
