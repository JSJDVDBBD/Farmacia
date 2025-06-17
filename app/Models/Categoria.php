<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $fillable = ['nombre', 'description'];

    public function medicamentos()
    {
        return $this->hasMany(Medicamento::class);
    }
}
