<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $fillable = [
        'fecha_compra', 'numero_factura', 'total', 'metodo_pago', 'estado', 'user_id'
    ];

    public function detalles()
    {
        return $this->hasMany(DetalleCompra::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
