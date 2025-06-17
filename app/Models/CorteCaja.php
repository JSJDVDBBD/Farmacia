<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CorteCaja extends Model
{
    protected $table = 'corte_caja';

    protected $fillable = [
        'fecha_apertura', 'fecha_cierre', 'monto_inicial', 'ventas_efectivo',
        'ventas_tarjeta', 'ventas_transferencia', 'total_ventas', 'monto_final',
        'diferencia', 'observaciones', 'user_id', 'estado'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}