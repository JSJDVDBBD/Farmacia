<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alerta extends Model
{
    protected $fillable = [
        'medicamento_id', 'tipo', 'nivel', 'mensaje', 'fecha_alerta',
        'fecha_resolucion', 'estado', 'user_id'
    ];

    public function medicamento()
    {
        return $this->belongsTo(Medicamento::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
