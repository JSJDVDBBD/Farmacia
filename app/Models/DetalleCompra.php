<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    protected $fillable = [
        'compra_id', 'medicamento_id', 'cantidad', 'precio_unitario', 'lote', 'fecha_caducidad'
    ];

    public function compra()
    {
        return $this->belongsTo(Compra::class);
    }

    public function medicamento()
    {
        return $this->belongsTo(Medicamento::class);
    }
}
